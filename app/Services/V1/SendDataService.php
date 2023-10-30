<?php

namespace App\Services\V1;

use App\Models\Proxy;

class SendDataService
{

    public function send(
        string $url,
        string $auth_token,
        string $message,
        array|null $data,
        Proxy|null|array $proxy = []
    ): mixed {
        $curl = curl_init();
        curl_setopt_array(
            $curl,
            $this->getCurlOptions(
                $url,
                $message,
                $auth_token,
                $proxy,
                $data
            ),
        );

        $response = json_decode(curl_exec($curl));
        $httpcode = curl_getinfo($curl, CURLINFO_RESPONSE_CODE);
        curl_close($curl);


        return ['resp' => $response, 'code' => $httpcode];
    }


    private function getCurlOptions(
        $url,
        $message,
        $auth_token,
        $proxy,
        $data
    ): array {
        if ( ! is_null($proxy)) {
            return array_merge(
                $this->getDefaultCurl(
                    $url,
                    $message,
                    $auth_token,
                    $data
                ),
                [
                    \CURLOPT_PROXY        => $proxy->ip,
                    \CURLOPT_PROXYAUTH    => \CURLAUTH_BASIC,
                    \CURLOPT_PROXYTYPE    => \CURLPROXY_SOCKS5,
                    \CURLOPT_PROXYUSERPWD => $proxy->login.":".$proxy->password,
                ]
            );
        }

        return $this->getDefaultCurl(
            $url,
            $message,
            $auth_token,
            $data,
        );
    }

    private function getDefaultCurl(
        $url,
        $message,
        $auth_token,
        $data
    ): array {
        return [
            CURLOPT_URL            => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING       => '',
            CURLOPT_MAXREDIRS      => 10,
            CURLOPT_TIMEOUT        => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION   => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_POSTFIELDS     => $this->getBodyForRequestText(
                $message,
                $data
            ),
            CURLOPT_HTTPHEADER     => $this->getHeadersForRequestText(
                $auth_token
            ),
        ];
    }

    /**
     * @param   string  $auth_token
     *
     * @return array
     */
    private function getHeadersForRequestText(string $auth_token): array
    {
        return [
            'Content-Type: application/json',
            "Authorization: Bearer $auth_token",
        ];
    }

    private function getBodyForRequestText(
        $message,
        $data
    ): string {
        if (is_array($data)) {
            unset($data['message']);
            unset($data['is_synchronous']);
            unset($data['callback_url']);
        }

        return json_encode(
            array_merge([
                'model'    => 'gpt-3.5-turbo',
                'messages' => [
                    [
                        'role'    => 'user',
                        'content' => $message,
                    ],
                ],
            ], $data),
            true
        );
    }

}
