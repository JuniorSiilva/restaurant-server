<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateCategory extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:50', Rule::unique('categories', 'name')->ignore($this->route('id'))],
            'description' => ['nullable', 'string', 'max:150'],
        ];
    }
}
