<?php

namespace App\Http\Requests;

use App\Rules\PwdCurrent;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUserPassword extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'current-password' => [new PwdCurrent],
            'new-password'     => ['required', 'min:6', 'confirmed', 'unique:users,password'],
        ];
    }
}
