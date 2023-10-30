<?php

namespace App\Services\V1;


use App\Models\ApiKey;
use App\Models\Proxy;
use App\Repositories\V1\ApiKeyRepository;

class ApiKeyService
{

    public function __construct(
        private ApiKeyRepository $repository,
    ) {
    }

    /**
     * @param   array  $data
     *
     * @return \App\Models\ApiKey
     */
    public function create(array $data): ApiKey
    {
        return $this->repository->create($data);
    }

    public function update(ApiKey $apiKey, array $data): ApiKey
    {
        $apiKey->update(array_filter($data));

        return $apiKey;
    }


}
