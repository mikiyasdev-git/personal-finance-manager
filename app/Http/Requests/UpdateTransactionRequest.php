<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'account_id' => [
                'sometimes',
                'integer',
                'exists:accounts,id',
            ],

            'category_id' => [
                'sometimes',
                'integer',
                'exists:categories,id',
            ],

            'type' => [
                'sometimes',
                'string',
                Rule::in(['income', 'expense']),
            ],

            'amount' => [
                'sometimes',
                'numeric',
                'decimal:0,2',
                'gt:0',
            ],

            'description' => [
                'sometimes',
                'nullable',
                'string',
                'max:1000',
            ],

            'transaction_date' => [
                'sometimes',
                'date',
            ],
        ];
    }
}
