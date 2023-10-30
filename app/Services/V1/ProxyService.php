<?php

namespace App\Services\V1;


use App\Models\Proxy;
use App\Repositories\V1\ProxyRepository;

class ProxyService
{

    public function __construct(
        protected ProxyRepository $proxyRepository,
    ) {
    }

    /**
     * @param   array  $data
     *
     * @return \App\Models\Proxy
     */
    public function create(array $data): Proxy
    {
        return $this->proxyRepository->create($data);
    }

    public function update(Proxy $proxy, array $data)
    {
        $proxy->update(array_filter($data));

        return $proxy;
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function makeRelation($data)
    {
        return $this->proxyRepository->makeRelation($data);
    }

}
