<?php

namespace App\Http\Controllers;

use App\Models\Kendaraan;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TimelineController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $user = Auth::user();
        $kendaraan = Kendaraan::all();
        // Ambil semua user staff untuk keperluan tampilan (misalnya dropdown)
        $users = User::where('role', 'staff')->get();

        // Cek role untuk menentukan data peminjaman
        if ($user->role === 'admin') {
            // Admin bisa lihat semua peminjaman
            $peminjaman = Peminjaman::with('user')->get();
        } else {
            // Staff hanya bisa lihat miliknya sendiri
            $peminjaman = Peminjaman::with('user')->where('id_user', $user->id)->get();
        }

        return view('admin.timeline-peminjaman', compact('users', 'user', 'peminjaman', 'kendaraan'));
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
    public function edit($id)
    {
        $peminjaman = Peminjaman::with('kendaraan.merek')->findOrFail($id);
        return view('admin.timeline-peminjaman', compact('peminjaman'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'merek' => 'required|string|max:255',  // Hanya validasi yang diperlukan
            'seri' => 'required|string|max:255',
            'tanggal_awal_peminjaman' => 'required|date',
            'tanggal_akhir_peminjaman' => 'required|date',
            'tujuan_peminjaman' => 'required|string',
        ]);        
        
        // Update data
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->update($validated);

        return response()->json(['success' => true]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $peminjaman = Peminjaman::findOrFail($id);
        $peminjaman->delete();

        return redirect()->route('timeline-peminjaman')->with('success', 'Data peminjaman berhasil dihapus.');
    }

}
