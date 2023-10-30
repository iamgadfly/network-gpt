<?php

namespace App\Services\V1;

//use App\Repositories\TestRepository;


use App\Repositories\V1\TestRepository;

class TestService
{

    public function __construct(
        protected TestRepository $repository,
    ) {
    }

}
