<?php

namespace App\Http\Controllers;

use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DaftarPermohonanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'staff')->get();
        $user = Auth::user();
        $peminjaman = Peminjaman::with(['user', 'kendaraan'])
        ->where('status_peminjaman', 'Pending')
        ->get();
        
        return view('admin.daftar-permohonan', compact('users', 'user', 'peminjaman'));
    }

    public function accept($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_peminjaman = 'Di Terima';
        $peminjaman->save();

        return response()->json(['message' => 'Permohonan berhasil diterima!']);
    }

    public function reject($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->status_peminjaman = 'Di Tolak';
        $peminjaman->save();

        return response()->json(['message' => 'Permohonan berhasil ditolak!']);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
