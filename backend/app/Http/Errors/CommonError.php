<?php

declare(strict_types=1);

namespace App\Http\Errors;

enum CommonError: string implements ErrorInterface
{
    case InternalServerError = 'internal-server-error';

    public function code(): string
    {
        return $this->value;
    }

    public function message(): string
    {
        return match ($this) {
            self::InternalServerError => 'Internal server error.',
        };
    }
}
