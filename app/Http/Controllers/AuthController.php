<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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

            // Ambil URL avatar dari Google
            $avatarUrl = str_replace('http://', 'https://', $googleUser->getAvatar());
            $localAvatarPath = null;

            // Simpan avatar ke storage lokal
            try {
                $imageContents = file_get_contents($avatarUrl);
                $fileName = 'avatars/' . $googleUser->getId() . '.jpg';
                Storage::disk('public')->put($fileName, $imageContents);
                $localAvatarPath = '/storage/' . $fileName;
            } catch (\Exception $e) {
                // Jika gagal simpan, pakai URL Google langsung sebagai fallback
                $localAvatarPath = $avatarUrl;
            }

            if (!$user) {
                $user = User::create([
                    'name' => $googleUser->getName(),
                    'email' => $googleUser->getEmail(),
                    'password' => Hash::make('password'),
                    'google_id' => $googleUser->getId(),
                    'google_avatar' => $localAvatarPath,
                ]);
            } else {
                // Update avatar tiap kali login ulang
                $user->update([
                    'google_avatar' => $localAvatarPath,
                ]);
            }

            Auth::login($user, true);

            return redirect('/dashboard');
        } catch (\Exception $e) {
            return redirect()->route('login.form')->withErrors([
                'google' => 'Login Google gagal, coba lagi. ' . $e->getMessage(),
            ]);
        }
    }
}
