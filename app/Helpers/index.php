<?php

use App\Helpers\Response;
use App\Services\Contracts\AuthServiceContract;

if (! function_exists('custom_response')) {
    function custom_response($content = '', $status = 200, array $headers = [])
    {
        return new Response($content, $status, $headers);
    }
}

if (! function_exists('current_user')) {
    function current_user()
    {
        return app(AuthServiceContract::class)->authenticatedUser();
    }
}

if (! function_exists('current_user_id')) {
    function current_user_id()
    {
        return app(AuthServiceContract::class)->authenticatedUserId();
    }
}
