<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CommentsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'id' => 'integer',
            'content' => 'unique:comments,content',
            'abbreviation' => 'string',
            'created_at' => 'date',
            'updated_at' => 'date',
            'sort' => 'in:id,topic,created_at,updated_at',
            'direction' => 'in:asc,desc',
            'limit' => 'integer|min:1',
            'page' => 'integer|min:1',
            'with' => 'string|in:post'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
