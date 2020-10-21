<?php

namespace App\Http\Middleware;

use App\Traits\InitializationServicesAndRepositories;

class Middleware
{
    use InitializationServicesAndRepositories;

    public function __construct()
    {
        $this->bootInitializationServices();
    }
}
