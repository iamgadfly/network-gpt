<?php

namespace App\Exceptions;

use Exception;
use Symfony\Component\HttpFoundation\Response;

class ChatGptException extends Exception
{

    public function __construct()
    {
        parent::__construct(
            __('network.something_do_wrong'),
            Response::HTTP_BAD_REQUEST
        );
    }

}
