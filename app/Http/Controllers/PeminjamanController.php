<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Peminjaman;
use App\Models\Kendaraan;
use App\Models\Merek;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class PeminjamanController extends Controller
{
    public function index()
    {
        $users = User::where('role', 'staff')->get();
        $user = Auth::user();
        $merek = Merek::all();
        $kendaraan = Kendaraan::all();

        if (auth()->user()->role === 'admin') {
            $peminjaman = Peminjaman::with('kendaraan')->get();
        } else {
            $peminjaman = Peminjaman::with('kendaraan')
                ->where('id_user', auth()->user()->nama)
                ->get();
        }

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
                // Hanya set status 'Available' jika status sebelumnya bukan 'Perbaikan'
                if ($item->status_kendaraan !== 'Perbaikan' && $item->status_kendaraan !== 'Available') {
                    $item->status_kendaraan = 'Available';
                    $item->save();
                }
            }
        }
        

        // Ambil kembali kendaraan yang statusnya Available untuk form input
        $kendaraanTersedia = Kendaraan::where('status_kendaraan', 'Available')->get();

        return view('admin.pinjam-kendaraan', compact('users', 'user', 'merek', 'peminjaman', 'kendaraanTersedia', 'kendaraan'));
    }

    public function tambahMerek(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
        ]);

        Merek::create([
            'nama' => $request->nama,
        ]);

        return back()->with('success', 'Merek berhasil ditambahkan.');
    }

    public function hapusMerek($id)
    {
        $merek = Merek::findOrFail($id);
        $merek->delete();

        return back()->with('success', 'Merek berhasil dihapus.');
    }

    public function create($id)
    {
        $kendaraan = Kendaraan::findOrFail($id);
        $user = Auth::user();
        $merek = Merek::all();

        return view('admin.form-peminjaman', compact('kendaraan', 'user', 'merek'));
    }

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

    public function peminjamanSaya()
    {
        $user = Auth::user();

        $peminjamanSaya = Peminjaman::with('kendaraan')
            ->where('id_user', $user->id)  // Mengambil peminjaman yang terkait dengan user yang login
            ->orderBy('created_at', 'desc') // Mengurutkan data berdasarkan waktu pembuatan
            ->get();

        // Mengirimkan data peminjaman ke view
        return view('admin.peminjaman-saya', compact('peminjamanSaya', 'user'));
    }
}
