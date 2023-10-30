<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\CreatePaymentRequest;
use App\Services\V1\PaymentService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PaymentController extends Controller
{

    public function __construct(
        private PaymentService $service,
    ) {
    }

    /**
     * @lrd:start
     * Создание ссылки на оплату
     * @lrd:end*
     *
     * @param   \App\Http\Requests\CreatePaymentRequest  $request
     *
     * @return JsonResponse
     */
    public function createPayment(CreatePaymentRequest $request): JsonResponse
    {
        return $this->success(
            $this->service->createPayment($request->validated(), auth()->id())
        );
    }

    /**
     * @lrd:start
     * Получение статуса заказа пользователя от юкассы
     * @lrd:end*
     *
     * @param   \Illuminate\Http\Request  $request
     *
     * @return \Illuminate\Http\JsonResponse
     */
    protected function status(Request $request): JsonResponse
    {
        return $this->success(
            $this->service->status($request->all())
        );
    }

}
