<?php

namespace App\Shared\Domain\Exception;

use DomainException as BaseDomainException;

abstract class DomainException extends BaseDomainException
{
    public function __construct()
    {
        parent::__construct($this->errorMessage());
    }

    abstract public function errorCode(): string;

    abstract protected function errorMessage(): string;
}
