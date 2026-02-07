<?php

declare(strict_types=1);

namespace Packages\UseCase\Comic\Index;

use Illuminate\Database\Eloquent\Builder;

interface ComicSearchQueryBuilderInterface
{
    public function setKey(?string $key): static;

    public function setName(?string $name): static;

    public function setStatus(?array $status): static;

    public function build(): Builder;
}
