<?php

namespace App\Repositories\V1;


use App\Models\Yookassa;
use App\Repositories\Repository;

class YookassaRepository extends Repository
{

    public function __construct(Yookassa $model)
    {
        parent::__construct($model);
    }

    public function getLastLink($user_id)
    {
        return $this->model::where('user_id', $user_id)->latest()->first();
    }

}
