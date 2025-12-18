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
     * @param  mixed ...$roles
     */
    public function handle(Request $request, Closure $next): Response
    {
        //  Định nghĩa các role được phép truy cập
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        $userRole = Auth::user()->role;

        if (empty($roles)) {
            $roles = ['admin', 'manager', 'trainer'];
        }

        // Kiểm tra xem role của user
        if (in_array($userRole, $roles)) {
            return $next($request);
        }
        
        abort(403, 'Bạn không có quyền truy cập chức năng này.');
    }
}