<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /** Handle login POST request */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        $remember = (bool) $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            $user = Auth::user();
            
            // 1. Nếu là Admin/Trainer thì về dashboard
            if ($user->role === 'admin' || $user->role === 'trainer') {
                return redirect()->route('admin.dashboard'); 
            }

            // 2. Kiểm tra tham số 'return_url' (được gửi từ JS thêm giỏ hàng)
            $returnUrl = $request->input('return_url');
            if ($returnUrl) {
                return redirect($returnUrl);
            }

            // 3. Về trang chủ hoặc trang dự định truy cập trước đó
            return redirect()->intended(route('home'));
        }

        return back()->withInput($request->only('email'))->with('error', 'Thông tin đăng nhập không đúng.');
    }

    /** Optional logout helper */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('home');
    }
}
