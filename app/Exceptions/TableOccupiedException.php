<?php

namespace App\Exceptions;

class TableOccupiedException extends BusinessException
{
    protected $message = 'A mesa não pode ser utilizada porque encontra-se ocupada.';
}
