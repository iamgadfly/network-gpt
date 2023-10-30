<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\GetByIdRequest;
use App\Services\V1\RequestService;
use App\Models\Request;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request as HttpRequest;
use Laravel\Socialite\Contracts\User;


class RequestController extends Controller
{

    public function __construct(
        protected RequestService $requestService,
    ) {
    }

    /**
     * @param   string|int                $req_id
     * @param   \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @lrd:start
     * Получение запроса по id
     * @lrd:end*
     */
    public function get(string|int $req_id, HttpRequest $request): JsonResponse
    {
        $data = $this->requestService->get(
            $req_id,
            $request->header('User-Token'),
        );

        if ($data) {
            return $this->success($data);
        } else {
            return $this->error('request not found', 400);
        }
    }

}
