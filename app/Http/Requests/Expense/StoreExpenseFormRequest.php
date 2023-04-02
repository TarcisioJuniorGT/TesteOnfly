<?php

namespace App\Http\Requests\Expense;

use App\Models\User;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreExpenseFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'id_user' => [
                'required',
                function ($attribute, $value, $fail) {
                    if (!User::find($value)) {
                        return $fail('User not registered.');
                    }
                }
            ],
            'description' => 'string|max:191',
            'date' => 'required|date|before_or_equal:today',
            'value' => 'required|numeric|min:0',
            'email' => 'required|email'
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(response()->json([
            'status' => 'error',
            'message' => $validator->errors(),
        ], 422));
    }
}
