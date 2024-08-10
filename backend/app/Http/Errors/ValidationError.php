<?php

declare(strict_types=1);

namespace App\Http\Errors;

enum ValidationError
{
    case FailedRequestValidation;

    public function code(): string
    {
        return match ($this) {
            self::FailedRequestValidation => 'failed-request-validation',
        };
    }

    public function message(): string
    {
        return match ($this) {
            self::FailedRequestValidation => 'Failed request validation.',
        };
    }
}
