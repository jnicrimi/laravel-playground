<?php

declare(strict_types=1);

namespace App\Http\Requests\V1\Comic;

use App\Http\Requests\ApiFormRequest;
use Illuminate\Support\Facades\Route;

class ShowFormRequest extends ApiFormRequest
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
