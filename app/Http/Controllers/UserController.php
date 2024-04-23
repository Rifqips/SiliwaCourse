<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class UserController extends Controller
{
    public function login()
    {
        return view('auth.user.login');
    }

    public function google()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleProviderCallback(Request $request)
    {
        // Validasi callback dari Google
        $callback = Socialite::driver('google')->stateless()->user();

        // Periksa apakah email ada
        if (!$callback->getEmail()) {
            return redirect()->route('login')->with('error', 'Email tidak tersedia.');
        }

        // Periksa apakah pengguna sudah ada di database
        $user = User::where('email', $callback->getEmail())->first();

        if (!$user) {
            // Jika tidak, buat pengguna baru
            $user = new User([
                'name' => $callback->getName(),
                'email' => $callback->getEmail(),
                'avatar' => $callback->getAvatar(),
                'email_verified_at' => now(), // Gunakan waktu sekarang
            ]);

            $user->save();
        }

        // Login pengguna
        Auth::login($user, true);

        return redirect()->route('welcome');
    }
}

