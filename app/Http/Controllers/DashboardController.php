<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Hash;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    
    public function index()
    {
        $available = Kendaraan::where('status_kendaraan', 'Available')->count();
        $used = Kendaraan::where('status_kendaraan', 'Digunakan')->count();
        $repair = Kendaraan::where('status_kendaraan', 'Perbaikan')->count();

        $users = User::where('role', 'staff')->get();
        $user = Auth::user();

        return view('admin.index', compact('users', 'user', 'available', 'used', 'repair'));
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'nama'       => 'required|string|max:255',
            'nip'        => 'required|string|max:20|unique:users,nip',
            'email'      => 'required|email|unique:users,email',
            'password'   => 'required|string|min:6',
            'foto_ktp'   => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'jabatan'    => 'nullable|string|max:255',
            'departemen' => 'nullable|string|max:255',
            'role'       => 'required|in:admin,peminjam'
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        // Upload foto KTP jika ada
        $fotoKtpPath = null;
        if ($request->hasFile('foto_ktp')) {
            $fotoKtpPath = $request->file('foto_ktp')->store('ktp_images', 'public');
        }

        // Simpan user baru
        $user = User::create([
            'nama'       => $request->nama,
            'nip'        => $request->nip,
            'email'      => $request->email,
            'password'   => $request->password,
            'foto_ktp'   => $fotoKtpPath,
            'jabatan'    => $request->jabatan,
            'departemen' => $request->departemen,
            'role'       => $request->role,
        ]);

        return response()->json(['message' => 'User berhasil ditambahkan!', 'user' => $user], 201);
    }
}
