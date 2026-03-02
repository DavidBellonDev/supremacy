<?php
namespace App\Exceptions;
use RuntimeException;

class ValidationException extends RuntimeException{
    protected array $errors;

    public function __construct(array $errors, int $code = 400)
    {
        parent::__construct('Erro de validação', $code);
        $this->errors = $errors;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}