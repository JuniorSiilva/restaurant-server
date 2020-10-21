<?php

namespace App\Http\Requests;

class DefaultListRequest extends Request
{
    public function rules()
    {
        return [
            'search' => ['nullable', 'string'],
            'take' => ['nullable', 'integer', 'max:100'],
            'paginate' => ['nullable', 'boolean'],
        ];
    }
}
