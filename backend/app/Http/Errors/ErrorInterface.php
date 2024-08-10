<?php

declare(strict_types=1);

namespace App\Http\Errors;

interface ErrorInterface
{
    public function code(): string;

    public function message(): string;
}
