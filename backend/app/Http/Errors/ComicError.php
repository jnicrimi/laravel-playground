<?php

declare(strict_types=1);

namespace App\Http\Errors;

enum ComicError: string implements ErrorInterface
{
    case ComicNotFound = 'comic-not-found';
    case ComicAlreadyExists = 'comic-already-exists';
    case ComicCannotBeDeleted = 'comic-cannot-be-deleted';

    public function code(): string
    {
        return $this->value;
    }

    public function message(): string
    {
        return match ($this) {
            self::ComicNotFound => 'Comic not found.',
            self::ComicAlreadyExists => 'Comic already exists.',
            self::ComicCannotBeDeleted => 'Comic cannot be deleted.',
        };
    }
}
