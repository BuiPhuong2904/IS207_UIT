<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

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
            // Use stateful flow so Socialite validates the OAuth state stored in session
            $googleUser = Socialite::driver('google')->user();

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

            // Login the user and log helpful info for debugging
            Auth::login($user, true);
            Log::info('User logged in via Google', ['user_id' => $user->id, 'email' => $user->email, 'session_id' => session()->getId()]);

            // Use intended to respect any prior intended URL, fallback to named route 'home'
            return redirect()->intended(route('home'));
        } catch (\Exception $e) {
            Log::error('Google OAuth callback error: ' . $e->getMessage(), ['exception' => $e]);

            if (config('app.debug')) {
                return redirect()->route('login')->with('error', 'Google login failed: ' . $e->getMessage());
            }

            return redirect()->route('login')->with('error', 'Không thể đăng nhập bằng Google. Vui lòng thử lại.');
        }
    }
}
