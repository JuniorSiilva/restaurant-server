<?php

namespace App\Models;

class OrderDish extends Model
{
    protected $fillable = [
        'description',
    ];

    protected $table = 'order_has_dishes';

    public function setPrice(float $price)
    {
        $this->price = $price;
    }

    public function dish()
    {
        return $this->belongsTo(Dish::class);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function dishOptionals()
    {
        return $this->belongsToMany(DishOptional::class, 'order_dish_has_dish_optionals');
    }
}
