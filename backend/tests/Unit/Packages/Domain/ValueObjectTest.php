<?php

declare(strict_types=1);

use Packages\Domain\ValueObject;

test('get value', function () {
    expect(createValueObject('default')->getValue())->toBe('default');
});

test('equals', function (mixed $expected, mixed $value) {
    $valueObjectA = createValueObject('default');
    $valueObjectB = createValueObject($value ?? 'default');
    expect($valueObjectA->equals($valueObjectB))->toBe($expected);
})->with([
    [true, null],
    [false, 'dummy'],
]);

function createValueObject(string $value): ValueObject
{
    return new class($value) extends ValueObject
    {
        protected function validate(): bool
        {
            return true;
        }
    };
}
