<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Kendaraan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::where('role', 'staff')->get();
        $user = Auth::user();

        if (auth()->user()->role === 'admin') {
            $peminjaman = Peminjaman::with('kendaraan')->get();
        } else {
            $peminjaman = Peminjaman::with('kendaraan')
                ->where('id_user', auth()->user()->nama)
                ->get();
        }

        // Ambil semua kendaraan
        $kendaraan = Kendaraan::all();

        // Sinkronkan status kendaraan berdasarkan status peminjaman
        foreach ($kendaraan as $item) {
            $sedangDipinjam = Peminjaman::where('id_kendaraan', $item->id)
                ->where('status_peminjaman', 'Di Terima')
                ->exists();

            if ($sedangDipinjam) {
                if ($item->status_kendaraan !== 'Digunakan') {
                    $item->status_kendaraan = 'Digunakan';
                    $item->save();
                }
            } else {
                if ($item->status_kendaraan !== 'Available') {
                    $item->status_kendaraan = 'Available';
                    $item->save();
                }
            }
        }

        // Ambil kembali kendaraan yang statusnya Available untuk form input
        $kendaraanTersedia = Kendaraan::where('status_kendaraan', 'Available')->get();

        return view('admin.pinjam-kendaraan', compact('users', 'user', 'peminjaman', 'kendaraanTersedia', 'kendaraan'));
    }


    public function tambahkendaraan(request $request)
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

    public function editkendaraan(Request $request, $id)
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

        $kendaraan = Kendaraan::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($kendaraan->image) {
                Storage::disk('public')->delete($kendaraan->image);
            }
            $imagePath = $request->file('image')->store('kendaraan', 'public');
            $validatedData['image'] = $imagePath;
        }

        $kendaraan->update($validatedData);

        return response()->json(['message' => 'Kendaraan berhasil diperbarui']);
    }


    public function hapusKendaraan($id)
    {
        $kendaraan = Kendaraan::find($id);

        if (!$kendaraan) {
            return response()->json(['message' => 'Kendaraan tidak ditemukan'], 404);
        }

        try {
            // Hapus semua peminjaman yang terkait dengan kendaraan ini
            Peminjaman::where('id_kendaraan', $id)->delete();

            // Hapus gambar kendaraan jika ada
            if ($kendaraan->image) {
                Storage::disk('public')->delete($kendaraan->image);
            }

            // Hapus kendaraan
            $kendaraan->delete();

            return response()->json(['message' => 'Kendaraan dan peminjaman terkait berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }

    public function create($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $user = Auth::user();

        return view('admin.form-peminjaman', compact('kendaraan', 'user'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi data
        $request->validate([
            'id_kendaraan' => 'required|exists:kendaraan,id',
            'id_user' => 'required|exists:users,id',
            'tanggal_awal_peminjaman' => 'required|date',
            'tanggal_akhir_peminjaman' => 'required|date|after_or_equal:tanggal_awal_peminjaman',
            'tujuan_peminjaman' => 'required|string',
            'status_peminjaman' => 'required|string|in:Pending,Approved,Rejected',
        ]);

        try {
            // Simpan data ke database
            $peminjaman = Peminjaman::create([
                'id_kendaraan' => $request->id_kendaraan,
                'id_user' => $request->id_user,
                'tanggal_awal_peminjaman' => $request->tanggal_awal_peminjaman,
                'tanggal_akhir_peminjaman' => $request->tanggal_akhir_peminjaman,
                'tujuan_peminjaman' => $request->tujuan_peminjaman,
                'status_peminjaman' => $request->status_peminjaman,
            ]);

            // Redirect dengan SweetAlert
            return response()->json([
                'status' => 'success',
                'message' => 'Peminjaman berhasil diajukan!',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Terjadi kesalahan: ' . $e->getMessage(),
            ]);
        }
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
