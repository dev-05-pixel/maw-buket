<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Session;

class AdminAuth
{
    public function handle($request, Closure $next)
    {
        if (!Session::has('admin_uid')) {
            return redirect('/admin/login');
        }

        return $next($request);
    }
}
