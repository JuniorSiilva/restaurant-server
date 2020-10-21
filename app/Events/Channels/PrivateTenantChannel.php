<?php

namespace App\Events\Channels;

use App\Facades\Tenant;
use Illuminate\Broadcasting\PrivateChannel;

class PrivateTenantChannel extends PrivateChannel
{
    /**
     * Create a new channel instance.
     *
     * @param  string  $name
     * @return void
     */
    public function __construct($name)
    {
        parent::__construct(Tenant::get()->getSlugCompany().'.'.$name);
    }
}
