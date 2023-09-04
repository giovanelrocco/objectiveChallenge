<?php

namespace App\Exceptions;

use Exception;

class TransacoesException extends Exception
{
    public function render($message)
    {
        return response($this->getMessage(), 404);
    }
}
