<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Laravel\Socialite\Facades\Socialite;


class AuthController extends Controller
{
    // === Login Email & Password ===
    public function tampil_login()
    {
        return view('authenticate.login', [
            'title' => 'Login'
        ]);
    }
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('/dashboard');
        }

        return back()->withErrors(['email' => 'Email atau password salah']);
    }

    // === Redirect ke Google ===
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    // === Handle Callback dari Google ===
    public function handleGoogleCallback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
            // Cek apakah user sudah ada
            $user = User::where('email', $googleUser->getEmail())->first();

            if (!$user) {
                // Jika belum ada, buat user baru
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make('password'),
                    'google_id' => $googleUser->getId(),
                    'google_avatar' => $googleUser->getAvatar(),
                ]);
            }

            Auth::login($user);
            return redirect('/dashboard');
        } catch (\Exception $e) {
            dd($e->getMessage());
            return redirect()->route('login.form')->withErrors(['google' => 'Login Google gagal, coba lagi.']);
        }
    }
}
