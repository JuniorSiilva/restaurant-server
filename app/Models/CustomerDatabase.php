<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CustomerDatabase extends Model
{
    protected $connection = 'root';

    protected $fillable = [
        'name',
        'host',
        'port',
        'user',
        'password',
        'driver',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function getDriver()
    {
        return $this->driver;
    }

    public function getHost()
    {
        return $this->host;
    }

    public function getPort()
    {
        return $this->port;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getUser()
    {
        return $this->user;
    }

    public function getPassword()
    {
        return $this->password;
    }
}
