<?php

namespace App\Models;

use App\Traits\LogsActivity;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    use LogsActivity;

    protected static $logAttributes = ['*'];

    protected static $logOnlyDirty = true;
}
