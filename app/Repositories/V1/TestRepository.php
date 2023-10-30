<?php

namespace App\Repositories\V1;


use App\Models\User;
use App\Repositories\Repository;

class TestRepository extends Repository
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

}
