<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log; 

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
        // tránh session fixation
        $request->session()->regenerate();

        $user = Auth::user();

        Log::info('User logged in', [
            'id' => $user->id,
            'email' => $user->email,
            'role' => $user->role,
        ]);

        // Kiểm tra admin: ưu tiên method isAdmin() nếu có
        $isAdmin = method_exists($user, 'isAdmin') ? $user->isAdmin() : (strtolower((string) $user->role) === 'admin');

        if ($isAdmin) {
            return redirect()->intended(route('admin.dashboard'));
        }

        return redirect()->intended(route('home')); // hoặc route('home') nếu muốn
    }

    return back()->withInput($request->only('email'))->with('error', 'Thông tin đăng nhập không đúng.');
}
}
