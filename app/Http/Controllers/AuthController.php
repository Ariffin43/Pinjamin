<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        // Validasi input
        $credentials = $request->validate([
            'nip' => 'required|string',
            'password' => 'required|string',
        ]);

        // Cek apakah ada pengguna dengan NIP tersebut
        $user = User::where('nip', $request->nip)->first();

        if ($user && Auth::attempt($credentials)) {
            // Periksa status pengguna
            if ($user->status === 'pending') {
                Auth::logout(); // Logout otomatis
                return back()->withErrors([
                    'nip' => 'Akun Anda belum dikonfirmasi oleh admin.',
                ]);
            }

            // Jika statusnya aktif, lanjutkan login
            $request->session()->regenerate();
            return redirect()->intended($user->role === 'admin' ? '/dashboard' : '/dashboard');
        }

        // Jika kredensial tidak valid
        return back()->withErrors([
            'nip' => 'NIP atau Password salah.',
        ]);
    }


    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('login');
    }
}
