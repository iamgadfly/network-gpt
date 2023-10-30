<?php

namespace App\Interfaces\V1;

interface NetworkInterface
{

    public function send(array $data, string $token);

}
