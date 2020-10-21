<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Builder;

class Order extends Model
{
    protected $observables = [
        'closed',
    ];

    protected $fillable = [
        'cpf',
        'count_people',
    ];

    public function getStatus()
    {
        return $this->status;
    }

    public function table()
    {
        return $this->belongsTo(Table::class);
    }

    public function dishes()
    {
        return $this->hasMany(OrderDish::class);
    }

    public function scopeIsOpen(Builder $builder)
    {
        $builder->where('status', OrderStatus::ABERTO);
    }

    public function close()
    {
        $this->status = OrderStatus::FINALIZADO;

        $this->save();

        $this->fireModelEvent('closed', false);
    }
}
