<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class PostsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function rules(): array
    {
        return [
            'id' => 'integer',
            'topic' => 'unique:posts,topic',
            'created_at' => 'string',
            'updated_at' => 'string',
            'sort' => 'in:id,topic,created_at,updated_at',
            'direction' => 'in:asc,desc',
            'limit' => 'integer|min:1',
            'page' => 'integer|min:1',
            'with' => 'string|in:comments'
        ];
    }

    protected function failedValidation(Validator $validator): void
    {
        throw new HttpResponseException(response()->json([
            'errors' => $validator->errors()
        ], 422));
    }
}
