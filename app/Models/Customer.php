<?php

namespace App\Models;

use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class Customer extends Model
{
    use Notifiable;

    protected $connection = 'root';

    protected $fillable = [
        'name',
        'cnpj',
        'company',
        // 'domain',
        // 'slug_company',
        'email',
        'phone',
        'password',
    ];

    public function getCompany()
    {
        return $this->company;
    }

    public function getName()
    {
        return $this->name;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function getSlugCompany()
    {
        return $this->slug_company;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setCompanyAttribute(string $value)
    {
        $slug = Str::of($value)->slug();

        $this->attributes['company'] = $value;

        $this->attributes['slug_company'] = $slug;

        $this->attributes['domain'] = "$slug.".config('tenant.domain.suffix');
    }

    public function cryptPassword()
    {
        $this->attributes['password'] = bcrypt($this->attributes['password']);
    }

    public function database()
    {
        return $this->hasOne(CustomerDatabase::class);
    }
}
