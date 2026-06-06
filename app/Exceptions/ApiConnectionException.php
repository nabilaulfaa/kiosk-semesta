<?php

namespace App\Exceptions;

use Exception;

class ApiConnectionException extends Exception
{
    public function __construct(string $message = 'Koneksi ke server gagal. Periksa koneksi internet.')
    {
        parent::__construct($message);
    }
}