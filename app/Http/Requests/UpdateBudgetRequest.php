<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBudgetRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => [
                'sometimes',
                'integer',
                'exists:categories,id',
            ],

            'amount' => [
                'sometimes',
                'numeric',
                'min:0.01',
            ],

            'month' => [
                'sometimes',
                'date',
            ],
        ];
    }
}
