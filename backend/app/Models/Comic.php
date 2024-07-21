<?php

declare(strict_types=1);

namespace App\Models;

use Database\Factories\ComicFactory;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comic extends Model
{
    use HasFactory;
    use SoftDeletes;

    /**
     * @var array<int, string>
     */
    protected $fillable = [
        'key',
        'name',
        'status',
    ];

    public function scopeKey(Builder $query, string $key): Builder
    {
        if (strlen($key)) {
            $query->where('key', $key);
        }

        return $query;
    }

    public function scopeLikeName(Builder $query, string $name): Builder
    {
        if (strlen($name)) {
            $query->where('name', 'like', "%{$name}%");
        }

        return $query;
    }

    public function scopeStatus(Builder $query, array $status): Builder
    {
        if (count($status) > 0) {
            $query->whereIn('status', $status);
        }

        return $query;
    }

    protected static function newFactory(): Factory
    {
        return ComicFactory::new();
    }
}
