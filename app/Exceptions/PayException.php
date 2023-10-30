<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class PayException extends Exception
{

    public function __construct()
    {
        parent::__construct(
            __('user.balance_is_null'),
            Response::HTTP_BAD_REQUEST
        );
    }

}
