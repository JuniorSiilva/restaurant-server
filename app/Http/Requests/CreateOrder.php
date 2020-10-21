<?php

namespace App\Http\Requests;

class CreateOrder extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'cpf' => ['nullable', 'cpf'],
            'count_people' => ['nullable', 'integer'],
            'table.id' => ['required', 'integer', 'exists:tables,id'],
        ];
    }
}
