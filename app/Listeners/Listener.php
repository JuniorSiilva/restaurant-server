<?php

namespace App\Listeners;

use App\Traits\InitializationServicesAndRepositories;

abstract class Listener
{
    use InitializationServicesAndRepositories;

    public function __construct()
    {
        $this->bootInitializationServices();
    }
}
