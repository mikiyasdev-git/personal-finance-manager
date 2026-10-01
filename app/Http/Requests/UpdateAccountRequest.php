<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAccountRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user() !== null;
    }

    public function rules(): array
    {
        return [
            'name' => [
                'sometimes',
                'required',
                'string',
                'max:100',
                Rule::unique('accounts', 'name')
                    ->where(fn ($query) => $query->where(
                        'user_id',
                        $this->user()->id
                    ))
                    ->ignore($this->route('account')),
            ],

            'type' => [
                'sometimes',
                'required',
                Rule::in([
                    'bank',
                    'cash',
                    'wallet',
                    'savings',
                ]),
            ],

            'currency' => [
                'sometimes',
                'string',
                'size:3',
                'alpha',
            ],
        ];
    }
}
