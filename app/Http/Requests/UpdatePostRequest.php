<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class UpdatePostRequest extends FormRequest
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
            'title' => 'sometimes|string|max:255',
            'content' => 'sometimes|string',
            'category' => ['sometimes', 'string', Rule::in($validCategories)],
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
