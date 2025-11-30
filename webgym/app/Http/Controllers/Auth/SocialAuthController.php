<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class SocialAuthController extends Controller
{
    // Redirect to Google OAuth
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // Handle Google callback
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->stateless()->user();

            // Find existing user by email
            $user = User::where('email', $googleUser->getEmail())->first();

            if (! $user) {
                // Create new user
                $user = User::create([
                    'full_name' => $googleUser->getName() ?? $googleUser->getNickname() ?? 'Google User',
                    'email' => $googleUser->getEmail(),
                    'password' => bcrypt(Str::random(16)),
                    'image_url' => $googleUser->getAvatar() ?? null,
                    'role' => 'user',
                    'status' => 'active',
                ]);
            }

            // Login the user
            Auth::login($user, true);

            return redirect()->route('home');
        } catch (\Exception $e) {
            return redirect()->route('login')->with('error', 'Không thể đăng nhập bằng Google. Vui lòng thử lại.');
        }
    }
}
