<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Store;

use Packages\UseCase\RequestInterface;

class ComicStoreRequest implements RequestInterface
{
    public function __construct(
        public readonly string $key,
        public readonly string $name,
        public readonly string $status
    ) {}
}
