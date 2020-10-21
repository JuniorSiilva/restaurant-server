<?php

namespace App\Http\Requests;

class CreateCustomer extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'phone' => ['required', 'string', 'digits_between:9,12'],
            'cnpj' => ['required', 'cnpj', 'unique:root.customers'],
            'company' => ['required', 'string', 'regex:/^[a-zA-Z0-9\s]+$/', 'unique:root.customers'],
        ];
    }
}
