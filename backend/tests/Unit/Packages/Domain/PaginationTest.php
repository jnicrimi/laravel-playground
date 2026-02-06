<?php

declare(strict_types=1);

test('get properties', function () {
    expect(createPagination())
        ->perPage->toBe(5)
        ->currentPage->toBe(1)
        ->lastPage->toBe(2)
        ->total->toBe(10)
        ->firstItem->toBe(1)
        ->lastItem->toBe(5);
});

test('to array', function () {
    expect(createPagination()->toArray())->toBe([
        'per_page' => 5,
        'current_page' => 1,
        'last_page' => 2,
        'total' => 10,
        'first_item' => 1,
        'last_item' => 5,
    ]);
});
