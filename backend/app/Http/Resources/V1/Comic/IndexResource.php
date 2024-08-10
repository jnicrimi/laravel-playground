<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Comic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class IndexResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'comics' => $this->resource['comics'],
            ],
            'pagination' => $this->resource['pagination'],
        ];
    }
}
