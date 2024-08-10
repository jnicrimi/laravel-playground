<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Comic;

use App\Http\Requests\ApiFormRequest;
use App\Rules\Comic\ComicKeyFormatRule;
use Illuminate\Support\Facades\Route;
use Illuminate\Validation\Rules\Enum;
use Packages\Domain\Comic\ComicKey;
use Packages\Domain\Comic\ComicName;
use Packages\Domain\Comic\ComicStatus;

class UpdateFormRequest extends ApiFormRequest
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
            'comic_id' => [
                'required',
                'integer',
                'gt:0',
            ],
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

    /**
     * @return array
     */
    public function validationData()
    {
        return array_merge($this->all(), [
            'comic_id' => Route::input('comicId'),
        ]);
    }
}
