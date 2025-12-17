<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        // Nếu chưa login -> redirect tới login (hoặc abort 401)
        if (! Auth::check()) {
            return redirect()->route('login');
            // hoặc: abort(401, 'Bạn cần đăng nhập.');
        }

        $user = Auth::user();

        // Nếu model User có method isAdmin() thì dùng, nếu không dùng trường role
        $isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : (strtolower((string)$user->role) === 'admin');

        if ($isAdmin) {
            return $next($request);
        }

        // Nếu không phải admin -> 403
        Log::warning('Unauthorized admin access attempt', [
            'user_id' => $user->id ?? null,
            'email' => $user->email ?? null,
            'uri' => $request->path(),
        ]);

        abort(403, 'Bạn không có quyền truy cập.');
    }
}
