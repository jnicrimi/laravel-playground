<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Comic;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Validation\Rule;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicStatus;

class IndexFormRequest extends ApiFormRequest
{
    /**
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'key' => [
                'string',
                sprintf('max:%d', ComicKey::MAX_LENGTH),
            ],
            'name' => [
                'string',
                sprintf('max:%d', ComicName::MAX_LENGTH),
            ],
            'status' => [
                'array',
                sprintf('between:0,%d', count(ComicStatus::cases())),
                Rule::in(ComicStatus::values()),
            ],
        ];
    }
}
