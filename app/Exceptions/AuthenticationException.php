<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class AuthenticationException extends Exception
{

    public function __construct()
    {
        parent::__construct(
            __('users.roles.no_rights'),
            Response::HTTP_BAD_REQUEST
        );
    }

}
