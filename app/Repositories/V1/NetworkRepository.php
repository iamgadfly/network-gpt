<?php

namespace App\Repositories\V1;


use App\Models\Network;
use App\Repositories\Repository;

class NetworkRepository extends Repository
{

    public function __construct(Network $model)
    {
        parent::__construct($model);
    }

}
