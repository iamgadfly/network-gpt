<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\SendDataChatGptRequest;
use App\Interfaces\V1\NetworkInterface;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ChatGptController extends Controller
{

    public function __construct(
        protected NetworkInterface $network
    ) {
    }

    /**
     * @param   \App\Http\Requests\SendDataChatGptRequest  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @lrd:start
     * Отправка сообщения в Chat Gpt
     * @lrd:end*
     */
    public function send(SendDataChatGptRequest $request): JsonResponse
    {
        $data = $this->network->send(
            $request->validated(),
            $request->header('User-token')
        );

        if (isset($data['is_error'])) {
            return $this->error($data['message'], 400);
        }

        return $this->success(
            $data,
            Response::HTTP_OK
        );
    }

}
