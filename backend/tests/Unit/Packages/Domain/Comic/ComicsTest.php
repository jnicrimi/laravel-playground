<?php

declare(strict_types=1);

namespace Tests\Unit\Packages\Domain\Comic;

use Carbon\Carbon;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Arr;
use Packages\Domain\Comic\Comic;
use Packages\Domain\Comic\ComicId;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\Comics;
use Packages\Domain\Comic\ComicStatus;
use Tests\TestCase;
use TypeError;

class ComicsTest extends TestCase
{
    use RefreshDatabase;

    private array $defaultAttributes = [
        'id' => 1,
        'key' => 'key',
        'name' => 'name',
        'status' => 'published',
        'created_at' => '2023-01-01 00:00:00',
        'updated_at' => '2023-12-31 23:59:59',
    ];

    public function testCreateInstanceSuccess(): void
    {
        $comics = new Comics;
        $comics[] = $this->createEntity($this->defaultAttributes);
        $comics[] = $this->createEntity(array_merge($this->defaultAttributes, ['id' => 2]));
        $this->assertInstanceOf(Comics::class, $comics);
    }

    public function testCreateInstanceFailure(): void
    {
        $this->expectException(TypeError::class);
        $comics = new Comics;
        $comics[] = $this->createEntity($this->defaultAttributes);
        $comics[] = null;
    }

    private function createEntity(array $attributes): Comic
    {
        return new Comic(
            new ComicId(Arr::get($attributes, 'id')),
            new ComicKey(Arr::get($attributes, 'key')),
            new ComicName(Arr::get($attributes, 'name')),
            ComicStatus::from(Arr::get($attributes, 'status')),
            Carbon::parse(Arr::get($attributes, 'created_at')),
            Carbon::parse(Arr::get($attributes, 'updated_at'))
        );
    }
}
