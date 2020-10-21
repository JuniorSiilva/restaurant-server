<?php

namespace App\Http\Requests;

use App\Rules\Decimal;

class CreateOrUpdateDishOptional extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(CreateAttachments $createAttachments)
    {
        return array_merge(
            [
                'name' => ['required', 'string', 'max:255'],
                'description' => ['nullable', 'string', 'max:1000'],
                'price' => ['required', 'numeric', new Decimal],
            ],

            $createAttachments->rules()
        );
    }
}
