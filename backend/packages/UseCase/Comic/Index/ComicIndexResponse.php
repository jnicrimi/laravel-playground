<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Index;

use Packages\Domain\Comic\Comics;
use Packages\UseCase\ResponseInterface;

class ComicIndexResponse implements ResponseInterface
{
    public function __construct(private readonly Comics $comics) {}

    public function build(): array
    {
        return [
            'comics' => $this->buildComics(),
            'pagination' => $this->comics->count() ? $this->comics->getPagination()->toArray() : [],
        ];
    }

    private function buildComics(): array
    {
        $comics = [];
        foreach ($this->comics as $comic) {
            $comics[] = [
                'id' => $comic->getId()->getValue(),
                'key' => $comic->getKey()->getValue(),
                'name' => $comic->getName()->getValue(),
                'status' => [
                    'value' => $comic->getStatus()->value,
                    'description' => $comic->getStatus()->description(),
                ],
            ];
        }

        return $comics;
    }
}
