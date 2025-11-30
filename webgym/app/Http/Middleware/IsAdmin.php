<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

use Illuminate\Support\Facades\Auth;

class IsAdmin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        //  Định nghĩa các role được phép truy cập
        $allowedRoles = ['admin', 'manager', 'trainer'];

        // Kiểm tra xem role của user
        if ( ! in_array(Auth::user()->role, $allowedRoles) ) {
            abort(403,'Bạn không có quyền truy cập.');

        }
        return $next($request);
    }
}