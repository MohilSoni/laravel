<?php

namespace App\Http\Middleware;

use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Authenticate extends Middleware
{
    /**
     * Get the path the user should be redirected to when they are not authenticated.
     */
    protected function redirectTo(Request $request): ?string
    {
        if ($request->is('admin/*')) {
            return $request->expectsJson() ? null : route('admin');
        } else if ($request->is('user/*')) {
            return $request->expectsJson() ? null : route('user');
        } else {
            return $request->expectsJson() ? null : route('user');
        }
    }
}
