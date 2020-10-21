<?php

namespace App\Http\Requests;

class ResetPassword extends Request
{
    public function rules()
    {
        return [
            'token' => ['required'],
            'email' => ['required', 'email'],
            'password' => ['required', 'min:6', 'confirmed'],
        ];
    }
}
