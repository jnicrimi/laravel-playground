<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Store;

use Packages\Domain\Comic\Comic;
use Packages\UseCase\ResponseInterface;

class ComicStoreResponse implements ResponseInterface
{
    public function __construct(private readonly Comic $comic) {}

    public function build(): array
    {
        return [
            'comic' => $this->buildComic(),
        ];
    }

    private function buildComic(): array
    {
        return [
            'id' => $this->comic->getId()->getValue(),
            'key' => $this->comic->getKey()->getValue(),
            'name' => $this->comic->getName()->getValue(),
            'status' => [
                'value' => $this->comic->getStatus()->value,
                'description' => $this->comic->getStatus()->description(),
            ],
        ];
    }
}
