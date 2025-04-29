<?php

namespace App\Http\Controllers;

use Illuminate\Validation\ValidationException;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Models\Kendaraan;
use App\Models\Merek;
use App\Models\Peminjaman;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class DaftarKendaraanController extends Controller
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
        try {
            $validated = $request->validate([
                'jenis_kendaraan' => 'required',
                'id_merek' => 'required|integer|exists:merek,id',
                'atas_nama' => 'required',
                'seri' => 'required',
                'no_plat' => 'required|unique:kendaraan,no_plat',
                'detail_kendaraan' => 'required',
                'status_kendaraan' => 'required',
                'latitude' => 'required',
                'longitude' => 'required',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ]);

            $lokasiAwal = $request->latitude . ',' . $request->longitude;

            $imagePath = null;
            if ($request->hasFile('image')) {
                $imagePath = $request->file('image')->store('kendaraan', 'public');
            }

            Kendaraan::create([
                'jenis_kendaraan' => $request->jenis_kendaraan,
                'id_merek' => $request->id_merek,
                'atas_nama' => $request->atas_nama,
                'seri' => $request->seri,
                'no_plat' => $request->no_plat,
                'detail_kendaraan' => $request->detail_kendaraan,
                'status_kendaraan' => $request->status_kendaraan,
                'lokasi_awal' => $lokasiAwal,
                'image' => $imagePath,
            ]);

            return response()->json(['message' => 'Kendaraan berhasil ditambahkan.'], 200);

        } catch (ValidationException $e) {
            // Tangani error validasi dan kirim detail error
            return response()->json(['errors' => $e->errors()], 422);
        } catch (\Exception $e) {
            Log::error('Error storing kendaraan: ' . $e->getMessage());
            return response()->json(['error' => 'Terjadi kesalahan, silakan coba lagi.'], 500);
        }
    }

    
    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'id_merek' => 'required|exists:merek,id',
            'atas_nama' => 'required|string|max:255',
            'seri' => 'required|string|max:100',
            'no_plat' => 'required|string|max:50',
            'jenis_kendaraan' => 'required|in:Mobil,Motor,Bus',
            'detail_kendaraan' => 'required|string',
            'status_kendaraan' => 'required|in:Available,Perbaikan,Digunakan',
            'latitude' => 'required|string',
            'longitude' => 'required|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $kendaraan = Kendaraan::findOrFail($id);

        // Gabungkan latitude dan longitude jadi satu string
        $validatedData['lokasi_awal'] = $request->latitude . ',' . $request->longitude;

        unset($validatedData['latitude'], $validatedData['longitude']);

        if ($request->hasFile('image')) {
            if ($kendaraan->image) {
                Storage::disk('public')->delete($kendaraan->image);
            }
            $imagePath = $request->file('image')->store('kendaraan', 'public');
            $validatedData['image'] = $imagePath;
        }

        $kendaraan->update($validatedData);

        return redirect()->back()->with('success', 'Data kendaraan berhasil diperbarui.');
    }



    public function destroy($id)
    {
        $kendaraan = Kendaraan::find($id);

        if (!$kendaraan) {
            return response()->json(['message' => 'Kendaraan tidak ditemukan'], 404);
        }

        try {
            Peminjaman::where('id_kendaraan', $id)->delete();

            if ($kendaraan->image) {
                Storage::disk('public')->delete($kendaraan->image);
            }

            $kendaraan->delete();

            return response()->json(['message' => 'Kendaraan dan peminjaman terkait berhasil dihapus']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Error: ' . $e->getMessage()], 500);
        }
    }
}
