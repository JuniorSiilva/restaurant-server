<?php

namespace App\Exceptions;

use Symfony\Component\HttpFoundation\Response;

class CustomerNotFoundException extends AppException
{
    /**
     * The http status code that will be sent in response.
     * 400 Bad Request | The server cannot or will not process the request due to an apparent client error (e.g., malformed request syntax, size too large, invalid request message framing, or deceptive request routing).
     *
     * @var int
     */
    protected $code = Response::HTTP_NOT_FOUND;

    protected $message = 'Não foi possível identificar o cliente informado.';
}
