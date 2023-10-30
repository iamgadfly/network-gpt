<?php

namespace App\Services\V1;

use App\Enums\V1\YoukassaEnum;
use App\Http\Resources\V1\YoukassaResource;
use App\Repositories\V1\TransactionRepository;
use App\Repositories\V1\UserRepository;
use App\Repositories\V1\YookassaRepository;
use Fiks\YooKassa\YooKassaApi;
use Illuminate\Http\JsonResponse;
use  \Illuminate\Http\Request;

class PaymentService
{

    public function __construct(
        private YookassaRepository $yookassaRepository,
        private UserRepository $userRepository,
        private TransactionRepository $transactionRepository,
    ) {
    }

    /**
     * @param $data
     * @param $user_id
     * @param $youkassa
     *
     * @return \App\Http\Resources\V1\YoukassaResource
     * @throws \YooKassa\Common\Exceptions\ApiException
     * @throws \YooKassa\Common\Exceptions\BadApiRequestException
     * @throws \YooKassa\Common\Exceptions\ExtensionNotFoundException
     * @throws \YooKassa\Common\Exceptions\ForbiddenException
     * @throws \YooKassa\Common\Exceptions\InternalServerError
     * @throws \YooKassa\Common\Exceptions\NotFoundException
     * @throws \YooKassa\Common\Exceptions\ResponseProcessingException
     * @throws \YooKassa\Common\Exceptions\TooManyRequestsException
     * @throws \YooKassa\Common\Exceptions\UnauthorizedException
     */
    public function createPayment(
        $data,
        $user_id,
        $youkassa = new YooKassaApi()
    ) {
        $youkassa->createPayment(
            floatval($data['sum']),
            'RUB',
            'replenishment',
            $user_id
        );

        return new YoukassaResource(
            $this->yookassaRepository->getLastLink($user_id)
        );
    }

    /**
     * @param   array  $data
     *
     * @return bool
     */
    public function status(array $data): bool
    {
        $youkassa = $this->yookassaRepository->whereFirst(
            ['payment_id' => $data['object']['id']]
        );

        $status = $this->getStatus($data['event']);

        $youkassa->status = $status;
        if ($status === 'succeeded') {
            $youkassa->paid = true;

            $user          = $this->userRepository->getById($youkassa->user_id);
            $user->balance += $youkassa->sum;

            $this->transactionRepository->create([
                'user_id'     => $user->id,
                'amount'      => $youkassa->sum,
                'type'        => 'deposit',
                'yookassa_id' => $youkassa->id,
            ]);
            $user->save();
        }
        $youkassa->save();

        return true;
    }

    /**
     * @param   string  $status
     *
     * @return string
     */
    private function getStatus(string $status): string
    {
        return match ($status) {
            'payment.pending' => YoukassaEnum::PENDING,
            'payment.waiting_for_capture' => YoukassaEnum::WAITING_FOR_CAPTURE,
            'payment.canceled' => YoukassaEnum::CANCELED,
            'payment.succeeded' => YoukassaEnum::SUCCEESED,
        };
    }

}
