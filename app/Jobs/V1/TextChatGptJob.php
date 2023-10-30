<?php

namespace App\Jobs\V1;

use App\Services\V1\ChatGptErrorService;
use App\Services\V1\ChatGptService;
use App\Services\V1\RequestService;
use App\Services\V1\SendDataService;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;

class TextChatGptJob implements ShouldQueue
{

    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $message;

    protected $req;

    protected $callback_url;

    protected $api_key;

    protected $proxy;

    protected $data;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(
        $api_key,
        $proxy,
        $req,
        $message,
        $callback_url,
        $data
    ) {
        $this->req          = $req;
        $this->message      = $message;
        $this->callback_url = $callback_url;
        $this->api_key      = $api_key;
        $this->proxy        = $proxy;
        $this->data         = $data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle(
        SendDataService $service,
        RequestService $requestService,
        ChatGptErrorService $chatGptErrorService
    ) {
        $resp_data = $service->send(
            $this->api_key->url,
            $this->api_key->value,
            $this->message,
            $this->data,
            $this->proxy,
        );

        $check = $chatGptErrorService->check(
            $this->api_key,
            $resp_data['code'],
            $resp_data['resp']
        );

        if ($resp_data['code'] === 401 || $resp_data['code'] === 503) {
            $this->release(5);
        }

        if ( ! is_null($check)) {
            $requestService->updateStatus($this->req, $check, 'error');
        }

        $requestService->updateStatus(
            $this->req,
            $resp_data['resp']->choices[0]->message->content
        );

        if ( ! is_null($this->callback_url)) {
            Http::post($this->callback_url, [
                $resp_data['resp']->choices[0]->message->content,
            ]);
        }
    }

}
