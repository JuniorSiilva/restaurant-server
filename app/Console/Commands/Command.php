<?php

namespace App\Console\Commands;

use Illuminate\Console\Command as BaseCommand;
use App\Traits\InitializationServicesAndRepositories;

abstract class Command extends BaseCommand
{
    use InitializationServicesAndRepositories;

    public function __construct()
    {
        parent::__construct();

        $this->bootInitializationServices();
    }
}
