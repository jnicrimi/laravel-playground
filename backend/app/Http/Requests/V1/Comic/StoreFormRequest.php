<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Comic;

use App\Http\Requests\ApiFormRequest;
use App\Rules\Comic\ComicKeyFormatRule;
use Illuminate\Validation\Rules\Enum;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicStatus;

class StoreFormRequest extends ApiFormRequest
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
                'required',
                'string',
                sprintf('min:%d', ComicKey::MIN_LENGTH),
                sprintf('max:%d', ComicKey::MAX_LENGTH),
                new ComicKeyFormatRule,
            ],
            'name' => [
                'required',
                'string',
                sprintf('min:%d', ComicName::MIN_LENGTH),
                sprintf('max:%d', ComicName::MAX_LENGTH),
            ],
            'status' => [
                'required',
                'string',
                new Enum(ComicStatus::class),
            ],
        ];
    }
}
