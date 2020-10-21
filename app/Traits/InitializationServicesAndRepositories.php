<?php

namespace App\Traits;

use ReflectionClass;

trait InitializationServicesAndRepositories
{
    protected function bootInitializationServices()
    {
        $reflection = new ReflectionClass($this);

        $props = $reflection->getProperties();

        $props = preg_grep('/Service$|Repository$/', array_column($props, 'name'));

        foreach ($props as $prop) {
            if (! empty($prop)) {
                $this->{$prop} = app($this->{$prop});
            }
        }
    }
}
