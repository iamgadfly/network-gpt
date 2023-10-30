<?php

namespace App\Repositories\V1;


use App\Models\Request;
use App\Repositories\Repository;

class RequestRepository extends Repository
{

    public function __construct(Request $model)
    {
        parent::__construct($model);
    }

}
