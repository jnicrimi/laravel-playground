<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Models\Comic;
use Illuminate\Database\Seeder;

class ComicSeeder extends Seeder
{
    /**
     * @var int
     */
    public const CREATE_COUNT = 10;

    /**
     * @var array
     */
    public const DEFAULT_ATTRIBUTES = [
        [
            'key' => 'default-key-1',
            'name' => 'default_name_1',
            'status' => 'published',
        ],
        [
            'key' => 'default-key-2',
            'name' => 'default_name_2',
            'status' => 'draft',
        ],
        [
            'key' => 'default-key-3',
            'name' => 'default_name_3',
            'status' => 'closed',
        ],
    ];

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        foreach (self::DEFAULT_ATTRIBUTES as $attributes) {
            Comic::create($attributes);
        }
        Comic::factory()
            ->count(self::CREATE_COUNT)
            ->create();
    }
}
