<?php

declare(strict_types=1);

namespace App\Services\V1;

use App\Http\Resources\V1\RequestResource;
use App\Repositories\V1\RequestRepository;
use App\Repositories\V1\TokenRepository;

class RequestService
{

    public function __construct(
        private RequestRepository $requestRepository,
        private TokenRepository $tokenRepository,
    ) {
    }

    public function create($network_id, $token_id, $type = 'string')
    {
        return $this->requestRepository->create([
            'network_id' => $network_id,
            'token_id'   => $token_id,
            'type'       => $type,
        ]);
    }

    public function updateStatus($req, $data, $stauts = 'success')
    {
        $req->status = $stauts;
        $req->resp   = $data;
        $req->save();

        return $req;
    }

    public function get(int|string $req_id, $user_token)
    {
        $req = $this->requestRepository->getById((int)$req_id);

        if (is_null($req)) {
            return false;
        }

        $token = $this->tokenRepository->getById($req->token_id);

        if ($token->token !== $user_token) {
            return 'Its not your request';
        }

        return new RequestResource($req);
    }

}
