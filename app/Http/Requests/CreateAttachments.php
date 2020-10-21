<?php

namespace App\Http\Requests;

use App\Enums\AttachmentExtension;

class CreateAttachments extends Request
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'attachments' => ['required', 'array', 'min:1'],
            'attachments.*.file' => ['required', 'file', 'mimes:'.AttachmentExtension::availableMimeTypes()],
            'attachments.*.descriptions' => ['nullable', 'string', 'max:255'],
        ];
    }
}
