<?php

namespace App\Http\Requests;

class RequestDish extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'dish.id' => ['required', 'integer', 'exists:dishes,id'],
            'description' => ['nullable', 'string', 'max:500'],
            'optionals' => ['nullable', 'array'],
            'optionals.*.id' => ['required', 'integer', 'exists:dish_optionals,id'],
        ];
    }
}
