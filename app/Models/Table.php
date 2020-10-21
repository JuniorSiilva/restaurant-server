<?php

namespace App\Models;

class Table extends Model
{
    protected $fillable = [
        'identification',
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class)->isOpen();
    }
}
