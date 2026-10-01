<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')
                    ->where('user_id', $this->user()->id)
                    ->where('type', $this->input('type')),
            ],

            'type' => [
                'required',
                'string',
                Rule::in(['income', 'expense']),
            ],
        ];
    }
}
