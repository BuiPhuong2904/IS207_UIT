<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\SendResetRequest;
use App\Http\Requests\Auth\ResetPasswordRequest;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

class ForgotPasswordController extends Controller
{
    public function show()
    {
        return view('auth.forget-password');
    }

    public function send(SendResetRequest $request)
    {
        $email = $request->input('email');

        $status = Password::sendResetLink(['email' => $email]);

        if ($status === Password::RESET_LINK_SENT) {
            return back()->with('status', __('Liên kết đặt lại mật khẩu đã được gửi tới :email.', ['email' => $email]));
        }

        return back()->withErrors(['email' => __($status)]);
    }

    public function showResetForm(string $token)
    {
        $email = request()->query('email');

        return view('auth.reset-password', [
            'token' => $token,
            'email' => $email,
        ]);
    }

    public function reset(ResetPasswordRequest $request)
    {
        $data = $request->only('email', 'password', 'password_confirmation', 'token');

        $status = Password::reset(
            $data,
            function (User $user, string $password) {
                $user->password = Hash::make($password);
                $user->save();
            }
        );

        if ($status === Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('status', __('Đặt lại mật khẩu thành công. Vui lòng đăng nhập bằng mật khẩu mới.'));
        }

        return back()->withErrors(['email' => __($status)]);
    }
}
