<?php

declare(strict_types=1);

namespace Packages\UseCase;

interface ResponseInterface
{
    public function build(): array;
}
