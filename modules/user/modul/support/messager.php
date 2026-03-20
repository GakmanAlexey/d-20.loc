<?php

namespace Modules\User\Modul\Support;

class Massager
{
    private array $errors = [];

    public function addError(string $error)
    {
        $this->errors[] = $error;
        return $this;
    }
    public function addErrors(array $errors)
    {
        foreach ($errors as $error) {
            $this->addError($error);
        }
        return $this;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function hasErrors(): bool
    {
        return !empty($this->errors);
    }

    public function clearErrors(): void
    {
        $this->errors = [];
    }
}