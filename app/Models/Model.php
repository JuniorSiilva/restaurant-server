<?php

namespace App\Models;

use App\Traits\LogsActivity;
use App\Traits\PrimaryKeyUuid;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model as Eloquent;

abstract class Model extends Eloquent
{
    use LogsActivity, PrimaryKeyUuid, SoftDeletes;

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;

    public function getClass(): string
    {
        return __CLASS__;
    }
}
