<?php

namespace App\Services\V1;


use App\Enums\V1\ChatGptEnum;
use App\Exceptions\ApiKeyNotFoundException;
use App\Exceptions\ChatGptException;
use App\Exceptions\PayException;
use App\Exceptions\TokenException;
use App\Interfaces\V1\NetworkInterface;
use App\Jobs\V1\TextChatGptJob;
use App\Models\Proxy;
use App\Repositories\V1\ApiKeyRepository;
use App\Repositories\V1\NetworkRepository;
use App\Repositories\V1\ProxyRepository;
use App\Repositories\V1\RequestRepository;
use App\Repositories\V1\TokenRepository;

class ChatGptService implements NetworkInterface
{

    public function __construct(
        protected TokenRepository $tokenRepository,
        protected NetworkRepository $networkRepository,
        protected RequestRepository $requestRepository,
        protected RequestService $requestService,
        protected ProxyRepository $proxyRepository,
        protected ApiKeyRepository $apiKeyRepository,
        protected SendDataService $sendCurlService,
        protected ChatGptErrorService $chatGptErrorService,
    ) {
    }

    /**
     * @param   array   $data
     * @param   string  $token
     *
     * @return array|array[]
     * @throws \App\Exceptions\ChatGptException
     * @throws \App\Exceptions\PayException
     * @throws \App\Exceptions\TokenException
     * @throws \App\Exceptions\ApiKeyNotFoundException
     */
    public function send(array $data, string $token): array
    {
        $token = $this->tokenRepository->getTokenByHash($token) ??
            throw new TokenException;

        $user = $token->user;
        if ($user->balance === 0) {
            throw new PayException;
        }

        --$user->balance;
        $user->save();

        $req     = $this->requestService->create($token->id, 1);
        $api_key = $this->apiKeyRepository->getApiKeyByNetworkId(
            ChatGptEnum::CHAT_V_3_ID
        );

        if (is_null($api_key)) {
            throw new ApiKeyNotFoundException;
        }

        $this->apiKeyRepository->addReq($api_key);
        $proxy = $this->proxyRepository->getProxyByApiKeyId($api_key->id);

        if ($data['is_synchronous']) {
            $resp_data = $this->sendCurlService->send(
                $api_key->url,
                $api_key->value,
                $data['message'],
                array_filter($data),
                $proxy
            );
            $check     = $this->chatGptErrorService->check(
                $api_key,
                $resp_data['code'],
                $resp_data['resp']
            );

            if ( ! is_null($check)) {
                $this->requestService->updateStatus($req, $check, 'error');

                return ['is_error' => true, 'message' => $check];
            }

            $text   = $resp_data['resp']->choices[0]->message->content ?? null;
            $length = strlen($text);
            $this->requestService->updateStatus($req, $text);


            return [
                'text' => $text
                //                'string_length' => $length,
                //                'string_pay'    => $this->calculatePrice($length),
            ];
        } else {
            dispatch(
                new TextChatGptJob(
                    $api_key,
                    $proxy,
                    $req,
                    $data['message'],
                    $data['callback_url'],
                    array_filter($data)
                )
            );

            return [
                'request_id' => $req->id,
            ];
        }
    }

    /**
     * @param   int  $length
     *
     * @return float|int
     */
    private function calculatePrice(int $length): float|int
    {
        return $length / 11;
    }

}
