<?php

declare(strict_types=1);

namespace Packages\Domain;

use InvalidArgumentException;

abstract class ValueObject implements ValueObjectInterface
{
    /**
     * @throws InvalidArgumentException
     */
    public function __construct(protected readonly mixed $value)
    {
        if (! $this->validate()) {
            throw new InvalidArgumentException('Invalid argument');
        }
    }

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function equals(ValueObjectInterface $valueObject): bool
    {
        return $this->value === $valueObject->getValue() && static::class === $valueObject::class;
    }

    final protected function isUnsignedInt(): bool
    {
        return is_int($this->value) && $this->value >= 0;
    }

    final protected function isNaturalNumber(): bool
    {
        return is_int($this->value) && $this->value > 0;
    }

    /**
     * @throws InvalidArgumentException
     */
    final protected function isWithinRange(int $min, int $max): bool
    {
        if ($min > $max) {
            throw new InvalidArgumentException('Invalid range');
        }
        if (is_int($this->value)) {
            return $this->value >= $min && $this->value <= $max;
        } elseif (is_string($this->value)) {
            return mb_strlen($this->value) >= $min && mb_strlen($this->value) <= $max;
        } elseif (is_array($this->value)) {
            return count($this->value) >= $min && count($this->value) <= $max;
        }

        throw new InvalidArgumentException('Invalid argument type');
    }

    abstract protected function validate(): bool;
}
