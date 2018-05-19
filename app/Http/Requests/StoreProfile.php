<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Rules\ValidatePassword;

class StoreProfile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'username' => 'required',
            'email' => 'required',
            'old_password' => ['nullable', 'min:8', new ValidatePassword],
            'new_password' => 'nullable|same:confirm_password|min:8',
            'confirm_password' => 'nullable|required_with:old_password|min:8',
            'credit_card' => 'nullable|numeric',
            'account' => 'nullable|numeric'
        ];
    }
}
