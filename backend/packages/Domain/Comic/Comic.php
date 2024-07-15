<?php

declare(strict_types=1);

namespace Packages\Domain\Comic;

use Carbon\Carbon;
use Packages\Domain\AbstractEntity;
use Packages\Domain\EntityInterface;

class Comic extends AbstractEntity implements EntityInterface
{
    public function __construct(
        private ?ComicId $id,
        private ComicKey $key,
        private ComicName $name,
        private ComicStatus $status,
        private ?Carbon $createdAt = null,
        private ?Carbon $updatedAt = null
    ) {}

    /**
     * @throws ComicIdIsNotSetException
     */
    public function getId(): ComicId
    {
        if ($this->id === null) {
            throw new ComicIdIsNotSetException();
        }

        return $this->id;
    }

    public function getKey(): ComicKey
    {
        return $this->key;
    }

    public function getName(): ComicName
    {
        return $this->name;
    }

    public function getStatus(): ComicStatus
    {
        return $this->status;
    }

    public function getCreatedAt(): ?Carbon
    {
        return $this->createdAt;
    }

    public function getUpdatedAt(): ?Carbon
    {
        return $this->updatedAt;
    }

    public function changeKey(ComicKey $key): void
    {
        $this->key = $key;
    }

    public function changeName(ComicName $name): void
    {
        $this->name = $name;
    }

    public function changeStatus(ComicStatus $status): void
    {
        $this->status = $status;
    }

    public function canDelete(): bool
    {
        return $this->getStatus()->equals(ComicStatus::CLOSED);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->getId()->getValue(),
            'key' => $this->getKey()->getValue(),
            'name' => $this->getName()->getValue(),
            'status' => $this->getStatus()->value,
            'created_at' => $this->getCreatedAt()?->format(self::DATE_FORMAT),
            'updated_at' => $this->getUpdatedAt()?->format(self::DATE_FORMAT),
        ];
    }
}
