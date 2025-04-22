<?php

namespace App\Http\Controllers;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class RegisterController extends Controller
{
    public function index()
    {
        return view('register');
    }

    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'role' => 'required|string',
            'nip' => 'required|numeric|unique:users,nip',
            'nama' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'no_hp' => 'required|numeric|digits:12',
            'foto_ktp' => 'required|image|mimes:jpg,png,jpeg,gif',
            'prodi' => 'required|string',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        // Simpan foto KTP
        $fotoKtpPath = $request->file('foto_ktp')->store('public/ktp');

        User::create([
            'role' => $request->role,
            'nip' => $request->nip,
            'nama' => $request->nama,
            'email' => $request->email,
            'no_hp' => $request->no_hp,
            'foto_ktp' => $fotoKtpPath,
            'prodi' => $request->prodi,
            'password' => Hash::make($request->password),
            'status' => 'pending',
        ]);

        return redirect('/login')->with('success', 'Akun berhasil dibuat. Tunggu konfirmasi dari admin!');
    }

}