<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class TokenException extends Exception
{

    public function __construct()
    {
        parent::__construct(
            __('token.not_found'),
            Response::HTTP_BAD_REQUEST
        );
    }

}
