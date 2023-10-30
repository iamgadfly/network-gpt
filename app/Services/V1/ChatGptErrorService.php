<?php

namespace App\Services\V1;

use App\Enums\V1\ChatGptEnum;
use App\Enums\V1\StatusWorkEnum;

class ChatGptErrorService
{

    public function check($api_key, $status_code, $body)
    {
        if ($status_code === 401) {
            $api_key->status = StatusWorkEnum::BROKEN;
            $api_key->save();
        }

        return match ($status_code) {
            401 => ChatGptEnum::ERROR_401,
            429 => ChatGptEnum::ERROR_429,
            500 => ChatGptEnum::ERROR_500,
            503 => ChatGptEnum::ERROR_503,
            default => $body->error->message ?? null,
        };
    }

}
