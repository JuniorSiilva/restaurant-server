<?php

namespace App\Http\Requests;

use Illuminate\Validation\Rule;

class UpdateTable extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'identification' => ['required', 'string', 'max:10', Rule::unique('tables', 'identification')->ignore($this->route('id'))],
        ];
    }
}
