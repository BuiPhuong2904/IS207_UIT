<?php
namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Auth\Events\PasswordReset;

class ForgotPasswordController extends Controller
{
    public function show()
    {
        return view('auth.forget-password');
    }

    public function send(Request $request)
    {
        // Validate
        $request->validate(
            ['email' => 'required|email'],
            ['email.required' => 'Vui lòng nhập email.', 'email.email' => 'Email không đúng định dạng.']
        );

        $status = Password::sendResetLink($request->only('email'));

        return $status === Password::RESET_LINK_SENT
            ? back()->with('success', 'Đã gửi liên kết đặt lại mật khẩu vào email của bạn!')
            : back()->withErrors(['email' => 'Không tìm thấy người dùng với địa chỉ email này.']); 
    }

    public function showResetForm($token)
    {
        $email = request()->query('email');
        return view('auth.reset-password', ['token' => $token, 'email' => $email]);
    }

    public function reset(Request $request)
    {
        $request->validate([
            'token' => 'required',
            'email' => 'required|email',
            'password' => 'required|confirmed|min:8',
        ], [
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.'
        ]);

        $status = Password::reset(
            $request->only('email', 'password', 'password_confirmation', 'token'),
            function (User $user, $password) {
                $user->password = Hash::make($password);
                // $user->setRememberToken(Str::random(60)); 
                $user->save();
                
                // Kích hoạt event (để gửi mail thông báo đổi pass thành công)
                // event(new PasswordReset($user)); 
            }
        );

        return $status === Password::PASSWORD_RESET
            ? redirect()->route('login')->with('success', 'Đặt lại mật khẩu thành công! Vui lòng đăng nhập.')
            : back()->withErrors(['email' => 'Lỗi: Token không hợp lệ hoặc đã hết hạn.']);
    }
}