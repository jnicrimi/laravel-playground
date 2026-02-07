<?php

declare(strict_types=1);

namespace Packages\Infrastructure\QueryBuilder\Comic\Index;

use App\Models\Comic;
use Illuminate\Database\Eloquent\Builder;
use Packages\Infrastructure\QueryBuilder\QueryBuilder;
use Packages\Infrastructure\QueryBuilder\QueryBuilderInterface;
use Packages\UseCase\Comic\Index\ComicSearchQueryBuilderInterface;

class ComicSearchQueryBuilder extends QueryBuilder implements ComicSearchQueryBuilderInterface, QueryBuilderInterface
{
    private ?string $key;

    private ?string $name;

    private ?array $status;

    public function setKey(?string $key): static
    {
        $this->key = $key;

        return $this;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function setStatus(?array $status): static
    {
        $this->status = $status;

        return $this;
    }

    public function build(): Builder
    {
        $query = Comic::query();
        if ($this->key !== null) {
            $query->key($this->key);
        }
        if ($this->name !== null) {
            $query->likeName($this->name);
        }
        if ($this->status !== null) {
            $query->status($this->status);
        }

        return $query;
    }
}
