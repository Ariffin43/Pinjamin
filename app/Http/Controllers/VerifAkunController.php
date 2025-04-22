<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerifAkunController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'staff')->get();
        $user = Auth::user();

        $pendingUsers = User::where('status', 'pending')->get();
        return view('admin.permohonan-verifikasi', compact('pendingUsers', 'user'));
    }

    // Fungsi untuk mengubah status user menjadi aktif
    public function verifikasi($id)
    {
        $user = User::findOrFail($id);
        $user->status = 'aktif';
        $user->save();

        return redirect()->back()->with('success', 'Akun berhasil diverifikasi!');
    }

    public function reject($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return redirect()->back()->with('success', 'Akun berhasil ditolak!');
    }

}
