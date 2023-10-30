<?php

namespace App\Repositories\V1;

use App\Models\User;
use App\Repositories\Repository;

class UserRepository extends Repository
{

    public function __construct(User $model)
    {
        parent::__construct($model);
    }

    public function checkPhone($phone)
    {
        return empty($this->model::where('phone_number', $phone)->first());
    }

}
