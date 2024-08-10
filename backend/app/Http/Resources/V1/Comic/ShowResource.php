<?php

declare(strict_types=1);

namespace App\Http\Resources\V1\Comic;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ShowResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'data' => [
                'comic' => $this->resource['comic'],
            ],
        ];
    }
}
