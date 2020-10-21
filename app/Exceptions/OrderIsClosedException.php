<?php

namespace App\Exceptions;

class OrderIsClosedException extends AppException
{
    protected $message = 'A operação não foi permitida porque o pedido encontra-se fechado.';
}
