<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Packages\Domain\AbstractValueObject;
use PHPUnit\Framework\Attributes\DataProvider;
use Tests\TestCase;

class AbstractValueObjectTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @var string
     */
    public const DEFAULT_VALUE = 'default';

    public function testGetValue(): void
    {
        $valueObject = $this->createValueObject();
        $actual = $valueObject->getValue();
        $expected = self::DEFAULT_VALUE;
        $this->assertSame($actual, $expected);
    }

    #[DataProvider('provideEquals')]
    public function testEquals(mixed $expected, mixed $value): void
    {
        $valueObjectA = $this->createValueObject();
        $valueObjectB = $this->createValueObject($value);
        $actual = $valueObjectA->equals($valueObjectB);
        $this->assertSame($expected, $actual);
    }

    public static function provideEquals(): array
    {
        return [
            [true, null],
            [false, 'dummy'],
        ];
    }

    /**
     * @param  mixed  $value
     */
    private function createValueObject($value = null): AbstractValueObject
    {
        if ($value === null) {
            $value = self::DEFAULT_VALUE;
        }

        return new class($value) extends AbstractValueObject
        {
            protected function validate(): bool
            {
                return true;
            }
        };
    }
}
