<?php

declare(strict_types=1);

namespace Packages\Domain;

class Pagination
{
    public function __construct(
        public readonly int $perPage,
        public readonly int $currentPage,
        public readonly int $lastPage,
        public readonly int $total,
        public readonly int $firstItem,
        public readonly int $lastItem
    ) {}

    public function toArray(): array
    {
        return [
            'per_page' => $this->perPage,
            'current_page' => $this->currentPage,
            'last_page' => $this->lastPage,
            'total' => $this->total,
            'first_item' => $this->firstItem,
            'last_item' => $this->lastItem,
        ];
    }
}
