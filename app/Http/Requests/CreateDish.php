<?php

namespace App\Http\Requests;

use App\Rules\Decimal;

class CreateDish extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'name' => ['required', 'string', 'max:255', 'unique:dishes,name'],
            'description' => ['nullable', 'string', 'max:1000'],
            'price' => ['required', 'numeric', new Decimal],
            'categories' => ['required', 'array', 'min:1'],
            'categories.*.id' => ['required', 'integer', 'exists:categories,id'],
        ];
    }
}
