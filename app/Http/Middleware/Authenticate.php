<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Support\Facades\Route;

class Authenticate extends Middleware
{
    protected $user_routes = 'user.login';
    protected $owner_routes = 'owner.login';
    protected $admin_routes = 'admin.login';
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return string|null
     */
    protected function redirectTo($request)
    {
        // apiとして使われていなければ
        if (!$request->expectsJson()) {
            if (Route::is('owner.*')) {
                return route($this->owner_routes);
            } elseif (Route::is('admin.*')) {
                return route($this->admin_routes);
            } else {
                return route($this->user_routes);
            }
        }
    }
}
