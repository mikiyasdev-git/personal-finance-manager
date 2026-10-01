<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        $categoryId = $this->route('category');

        return [
            'name' => [
                'sometimes',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->where('user_id', $this->user()->id)
                    ->where('type', $this->input('type'))
                    ->ignore($categoryId),
            ],

            'type' => [
                'sometimes',
                'string',
                Rule::in(['income', 'expense']),
            ],
        ];
    }
}
