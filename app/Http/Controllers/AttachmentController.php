<?php

namespace App\Http\Controllers;

use App\Services\Contracts\AttachmentServiceContract;

class AttachmentController extends Controller
{
    /**
     * @var \App\Services\AttachmentService
     */
    protected $attachmentService = AttachmentServiceContract::class;

    public function remove(int $id)
    {
        $attachmentId = $this->attachmentService->remove($id);

        return custom_response(['id' => $attachmentId])->do();
    }
}
