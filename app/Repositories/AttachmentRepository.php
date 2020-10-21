<?php

namespace App\Repositories;

use App\Models\Attachment;
use App\Repositories\Contracts\AttachmentRepositoryContract;

class AttachmentRepository extends Repository implements AttachmentRepositoryContract
{
    protected $model = Attachment::class;
}
