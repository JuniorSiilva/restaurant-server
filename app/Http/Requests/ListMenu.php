<?php

namespace App\Http\Requests;

class ListMenu extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'search' => ['nullable', 'string'],
            'categories' => ['nullable', 'array'],
            'categories.*' => ['required', 'integer', 'exists:categories,id'],
        ];
    }
}
