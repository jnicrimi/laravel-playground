<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Destroy;

use Packages\UseCase\RequestInterface;

class ComicDestroyRequest implements RequestInterface
{
    public function __construct(
        public readonly int $id
    ) {}
}
