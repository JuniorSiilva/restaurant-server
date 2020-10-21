<?php

namespace App\Models;

class Attachment extends Model
{
    protected $fillable = [
        'uniqid',
        'name',
        'type',
        'url',
        'descriptions',
    ];

    public function attachmentable()
    {
        return $this->morphTo();
    }
}
