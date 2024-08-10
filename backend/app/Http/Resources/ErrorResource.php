<?php

declare(strict_types=1);

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ErrorResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'code' => $this->resource['code'],
            'message' => $this->resource['message'],
            'errors' => $this->resource['errors'],
        ];
    }
}
