<?php

namespace App\Http\Requests;

class CreateCategory extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:50', 'unique:categories,name'],
            'description' => ['nullable', 'string', 'max:150'],
        ];
    }
}
