<?php

declare(strict_types=1);

namespace Database\Factories;

use App\Models\Comic;
use Illuminate\Database\Eloquent\Factories\Factory;
use Packages\Domain\Comic\ComicStatus;

/**
 * @extends Factory<Comic>
 */
class ComicFactory extends Factory
{
    /**
     * @var class-string<Comic>
     */
    protected $model = Comic::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'key' => $this->faker->uuid(),
            'name' => $this->faker->md5(),
            'status' => current($this->faker->shuffle(ComicStatus::values())),
        ];
    }
}
