<?php

declare(strict_types=1);

namespace Packages\Domain;

use ArrayAccess;
use ArrayIterator;
use Countable;
use InvalidArgumentException;
use IteratorAggregate;
use Traversable;

abstract class AbstractEntities implements ArrayAccess, Countable, IteratorAggregate
{
    protected array $entities = [];

    protected Pagination $pagination;

    public function offsetExists(mixed $offset): bool
    {
        return isset($this->entities[$offset]);
    }

    public function offsetGet(mixed $offset): mixed
    {
        return $this->entities[$offset] ?? null;
    }

    public function offsetSet(mixed $offset, mixed $value): void
    {
        if (get_class($value) !== $this->getEntityClass()) {
            throw new InvalidArgumentException('Invalid entity');
        }

        if ($offset === null) {
            $this->entities[] = $value;
        } else {
            $this->entities[$offset] = $value;
        }
    }

    public function offsetUnset(mixed $offset): void
    {
        unset($this->entities[$offset]);
    }

    public function count(): int
    {
        return count($this->entities);
    }

    public function setPagination(Pagination $pagination): self
    {
        $this->pagination = $pagination;

        return $this;
    }

    public function getPagination(): Pagination
    {
        return $this->pagination;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->entities);
    }

    public function toArray(): array
    {
        $entities = [];
        foreach ($this->entities as $entity) {
            $entities[] = $entity->toArray();
        }

        return $entities;
    }

    abstract protected function getEntityClass(): string;
}
