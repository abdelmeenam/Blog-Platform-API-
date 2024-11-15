<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;

class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $validCategories =[
            'technology',
            'lifestyle',
            'health',
            'travel',
            'food',
            'sports',
            'fashion',
            'education',
            'politics',
            'entertainment',
        ];

        return [
            'title' => 'required|string',
            'content' => 'required|string',
            'category' => 'required|string|in:' . implode(',', $validCategories),
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            apiResponse(422, $validator->errors())
        );
    }

    public function messages()
    {
        return [
            'category.in' => 'The selected category is invalid. Please choose from the predefined categories.',
        ];
    }
}
