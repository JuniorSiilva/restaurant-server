<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    protected $fillable = [
        'name',
        'description',
    ];

    public function dishs()
    {
        return $this->belongsToMany(Dish::class, 'dish_has_categories');
    }

    public function scopeMostRequesteds(Builder $builder)
    {
        $builder->selectRaw('categories.*, COUNT(order_has_dishes.*) requesteds');

        $builder->leftJoin('dish_has_categories', 'dish_has_categories.category_id', '=', 'categories.id');

        $builder->leftJoin('dishes', 'dishes.id', '=', 'dish_has_categories.dish_id');

        $builder->leftJoin('order_has_dishes', 'dishes.id', '=', 'order_has_dishes.dish_id');

        $builder->groupBy('categories.id');

        $builder->orderByRaw('requesteds DESC');
    }
}
