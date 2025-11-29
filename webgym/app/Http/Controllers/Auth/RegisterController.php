<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(RegisterRequest $request)
    {
        $data = $request->validated();

        // xử lý ảnh nếu có
        $imageUrl = null;
        if ($request->hasFile('image')) {
            // tạo storage link: php artisan storage:link (nếu chưa)
            $file = $request->file('image');
            $filename = Str::slug($data['full_name'] . '-' . time()) . '.' . $file->getClientOriginalExtension();
            $path = $file->storeAs('users', $filename, 'public'); // lưu vào storage/app/public/users
            $imageUrl = 'storage/' . $path; // readable url: /storage/users/...
        }

        $user = User::create([
            'full_name' => $data['full_name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'birth_date' => $data['birth_date'] ?? null,
            'gender' => $data['gender'] ?? null,
            'address' => $data['address'] ?? null,
            'image_url' => $imageUrl,
            'role' => 'user',
            'status' => 'active',
        ]);

        // đăng nhập tự động sau khi đăng ký
        Auth::login($user);

        return redirect()->route('home')->with('success', 'Đăng ký thành công. Chào mừng ' . $user->full_name);
    }
}
