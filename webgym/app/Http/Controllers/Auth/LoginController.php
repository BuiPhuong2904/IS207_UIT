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

    public function showLoginForm(Request $request) {
        // Log session trước khi xóa để biết key nào tồn tại
        Log::info('ShowLoginForm - session before forget', session()->all());

        // đảm bảo xóa các key lỗi
        $request->session()->forget(['google_error', 'error', 'error_message']);

        // Log lại sau khi forget để kiểm chứng
        Log::info('ShowLoginForm - session after forget', session()->all());

        return view('auth.login');
        }

}
