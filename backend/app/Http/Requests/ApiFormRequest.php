<?php

declare(strict_types=1);

namespace App\Http\Requests;

use App\Http\Errors\ValidationError;
use App\Http\Resources\ErrorResource;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class ApiFormRequest extends FormRequest
{
    protected function failedValidation(Validator $validator): ErrorResource
    {
        $response['code'] = ValidationError::FailedRequestValidation->code();
        $response['message'] = ValidationError::FailedRequestValidation->message();
        $response['errors'] = $validator->errors()->toArray();

        throw new HttpResponseException(
            response()->json($response, Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
