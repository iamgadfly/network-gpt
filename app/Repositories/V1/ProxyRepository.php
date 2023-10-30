<?php

namespace App\Repositories\V1;


use App\Models\ApiProxyRelations;
use App\Models\Proxy;
use App\Repositories\Repository;
use Illuminate\Support\Facades\DB;

class ProxyRepository extends Repository
{

    public function __construct(Proxy $model)
    {
        parent::__construct($model);
    }

    public function getProxyByApiKeyId(string|int $api_key_id): ?Proxy
    {
        return Proxy::whereHas(
            'api_keys',
            function ($query) use ($api_key_id) {
                return $query->where('api_key_id', $api_key_id);
            }
        )
            ->where('is_active', true)
            ->first();
    }

    /**
     * @param $data
     *
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model
     */
    public function makeRelation($data)
    {
        return ApiProxyRelations::query()->updateOrCreate($data, $data);
    }

}
