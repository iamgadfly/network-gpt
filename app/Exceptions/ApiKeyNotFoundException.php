<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ApiKeyNotFoundException extends Exception
{

    public function __construct()
    {
        parent::__construct(
            __('api_keys.does_not_exist'),
            Response::HTTP_BAD_REQUEST
        );
    }

}
