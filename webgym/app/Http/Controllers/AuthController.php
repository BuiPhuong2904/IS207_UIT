<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function register()
    {
        return view('auth.register');
    }

    public function postRegister(RegisterRequest $request)
    {
        $data = $request->validated();

        // xử lý file upload (nếu có)
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('avatars', 'public');
            $data['image_url'] = '/storage/' . $path;
        }

        $user = User::create([
            'full_name' => $data['full_name'],
            'email'     => $data['email'],
            'password'  => Hash::make($data['password']),
            'role'      => User::ROLE_USER ?? 'user',
            'status'    => 'active',
            'phone'     => $data['phone'] ?? null,
            'birth_date'=> $data['birth_date'] ?? null,
            'gender'    => $data['gender'] ?? null,
            'address'   => $data['address'] ?? null,
            'image_url' => $data['image_url'] ?? null,
        ]);

        return redirect()->route('login')->with('success', 'Đăng ký thành công. Vui lòng đăng nhập.');
    }

    public function login()
    {
        return view('auth.login');
    }

    public function postLogin(LoginRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $remember = (bool) $request->boolean('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();
            return redirect()->intended(route('home'));
        }

        return back()->withInput($request->only('email'))->with('error', 'Thông tin đăng nhập không đúng.');
    }
}
