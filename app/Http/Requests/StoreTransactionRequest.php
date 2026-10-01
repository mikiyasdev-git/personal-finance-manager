<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreTransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'account_id' => [
                'required',
                'integer',
                'exists:accounts,id',
            ],

            'category_id' => [
                'required',
                'integer',
                'exists:categories,id',
            ],

            'type' => [
                'required',
                'string',
                Rule::in(['income', 'expense']),
            ],

            'amount' => [
                'required',
                'numeric',
                'decimal:0,2',
                'gt:0',
            ],

            'description' => [
                'nullable',
                'string',
                'max:1000',
            ],

            'transaction_date' => [
                'required',
                'date',
            ],
        ];
    }
}
