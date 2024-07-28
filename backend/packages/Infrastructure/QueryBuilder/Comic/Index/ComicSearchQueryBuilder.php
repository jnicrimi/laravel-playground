<?php

declare(strict_types=1);

namespace Packages\Infrastructure\QueryBuilder\Comic\Index;

use App\Models\Comic;
use Illuminate\Database\Eloquent\Builder;
use Packages\Infrastructure\QueryBuilder\AbstractQueryBuilder;
use Packages\Infrastructure\QueryBuilder\QueryBuilderInterface;

class ComicSearchQueryBuilder extends AbstractQueryBuilder implements QueryBuilderInterface
{
    private ?string $key;

    private ?string $name;

    private ?array $status;

    public function setKey(?string $key): self
    {
        $this->key = $key;

        return $this;
    }

    public function setName(?string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function setStatus(?array $status): self
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
