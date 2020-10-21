<?php

namespace App\Models;

use App\Models\Contracts\Attachmentable;
use Illuminate\Database\Eloquent\Builder;

class Dish extends Model implements Attachmentable
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

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'dish_has_categories');
    }

    public function optionals()
    {
        return $this->hasMany(DishOptional::class);
    }

    public function orders()
    {
        return $this->hasMany(OrderDish::class);
    }

    public function scopeMostRequesteds(Builder $builder)
    {
        $builder->selectRaw('dishes.*, COUNT(order_has_dishes.*) requesteds');

        $builder->leftJoin('order_has_dishes', 'dishes.id', '=', 'order_has_dishes.dish_id');

        $builder->groupBy('dishes.id');

        $builder->orderByRaw('requesteds DESC');
    }
}
