<?php

namespace App\Repositories\V1;


use App\Enums\V1\StatusWorkEnum;
use App\Models\ApiKey;
use App\Repositories\Repository;

class ApiKeyRepository extends Repository
{

    public function __construct(ApiKey $model)
    {
        parent::__construct($model);
    }

    public function getApiKeyByNetworkId(string|int $network_id): ?ApiKey
    {
        $id = $this->model::where(
            'status',
            StatusWorkEnum::WORKED,
        )->orWhere(
            'status',
            StatusWorkEnum::NOT_WORKED,
        )->where('network_id', $network_id)->orderBy('current_requests', 'asc')
            ->value(
                'id'
            );

        return $this->model::find($id);
    }

    /**
     * @param   \App\Models\ApiKey  $api_key
     *
     * @return void
     */
    public function addReq(ApiKey $api_key): void
    {
        $api_key->current_requests = $api_key->current_requests + 1;
        $api_key->save();
    }

}
