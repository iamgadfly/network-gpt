<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class UserNotFoundException extends Exception
{

    public function __construct()
    {
        parent::__construct(
            __('users.user_not_found'),
            Response::HTTP_BAD_REQUEST
        );
    }

}
