<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\Pagination;
use Tests\TestCase;

class PaginationTest extends TestCase
{
    use RefreshDatabase;

    public function testGetProperties(): void
    {
        $pagination = $this->createPagination();
        $this->assertSame(5, $pagination->perPage);
        $this->assertSame(1, $pagination->currentPage);
        $this->assertSame(2, $pagination->lastPage);
        $this->assertSame(10, $pagination->total);
        $this->assertSame(1, $pagination->firstItem);
        $this->assertSame(5, $pagination->lastItem);
    }

    public function testToArray(): void
    {
        $pagination = $this->createPagination();
        $this->assertSame([
            'per_page' => 5,
            'current_page' => 1,
            'last_page' => 2,
            'total' => 10,
            'first_item' => 1,
            'last_item' => 5,
        ], $pagination->toArray());
    }

    private function createPagination(): Pagination
    {
        $perPage = 5;
        $currentPage = 1;
        $lastPage = 2;
        $total = 10;
        $firstItem = 1;
        $lastItem = 5;

        return new Pagination(
            $perPage,
            $currentPage,
            $lastPage,
            $total,
            $firstItem,
            $lastItem
        );
    }
}
