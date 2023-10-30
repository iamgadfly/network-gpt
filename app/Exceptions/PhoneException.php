<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PhoneException extends Exception
{

    public function __construct()
    {
        parent::__construct(
            __('users.phone_number.already_was'),
            Response::HTTP_BAD_REQUEST
        );
    }

}
