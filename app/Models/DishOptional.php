<?php

namespace App\Models;

use App\Models\Contracts\Attachmentable;

class DishOptional extends Model implements Attachmentable
{
    protected $fillable = [
        'name',
        'description',
        'price',
    ];

    public function getPrice()
    {
        return $this->price;
    }

    public function attachments()
    {
        return $this->morphMany(Attachment::class, 'attachmentable');
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }
}
