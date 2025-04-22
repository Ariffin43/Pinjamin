<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Kendaraan;
use Illuminate\Support\Facades\Storage;

class DaftarKendaraanControllerN extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'peminjam')->get();
        $user = Auth::user();
        $kendaraans = Kendaraan::all();

        return view('admin.daftar-kendaraan', compact('users', 'user', 'kendaraans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'merk' => 'required|string|max:100',
            'seri' => 'required|string|max:100',
            'no_plat' => 'required|string|max:50',
            'jenis_kendaraan' => 'required|string|max:50',
            'detail_kendaraan' => 'required|string',
            'status_kendaraan' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('kendaraan', 'public');
            $validatedData['image'] = $imagePath;
        }

        Kendaraan::create($validatedData);

        return response()->json(['message' => 'Kendaraan berhasil ditambahkan']);
    }

    public function update(Request $request, Kendaraan $kendaraan)
    {
        $validatedData = $request->validate([
            'merk' => 'required|string|max:100',
            'seri' => 'required|string|max:100',
            'no_plat' => 'required|string|max:50',
            'jenis_kendaraan' => 'required|string|max:50',
            'detail_kendaraan' => 'required|string',
            'status_kendaraan' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        if ($request->hasFile('image')) {
            if ($kendaraan->image) {
                Storage::disk('public')->delete($kendaraan->image);
            }
            $imagePath = $request->file('image')->store('kendaraan', 'public');
            $validatedData['image'] = $imagePath;
        }

        $kendaraan->update($validatedData);

        return response()->json(['message' => 'Kendaraan berhasil diupdate']);
    }

    public function destroy(Kendaraan $kendaraan)
    {
        if ($kendaraan->image) {
            Storage::disk('public')->delete($kendaraan->image);
        }

        $kendaraan->delete();
        return response()->json(['message' => 'Kendaraan berhasil dihapus']);
    }
}
