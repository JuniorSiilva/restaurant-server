<?php

namespace App\Http\Requests;

class CreateTable extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'identification' => ['required', 'string', 'max:10', 'unique:tables,identification'],
        ];
    }
}
