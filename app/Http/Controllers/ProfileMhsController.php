<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Profilemhs;
use App\Models\Prodi;

class ProfileMhsController extends Controller
{
    /**
     * Tampilkan halaman profil
     */
// ProfileMhsController.php
public function index()
{
    $user = Auth::user();

    // Langsung ambil, karena sudah pasti dibuat saat login
    $profile = Profilemhs::where('npm', $user->npm)->first();
    $prodi = Prodi::where('kode_prodi', $user->kode_prodi)->first();

    return view('mhs.profile', compact('profile', 'prodi'));
}

    /**
     * Update profil + upload foto SEKALIGUS
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // 🔥 VALIDASI
        $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'nomor_wa'     => 'nullable|string|max:15',
            'alamat'       => 'nullable|string',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $profile = Profilemhs::where('npm', $user->npm)->first();

        if (!$profile) {
            return back()->with('error', 'Profil tidak ditemukan');
        }

        // 🔥 UPDATE BIODATA
        $profile->nama_lengkap = $request->nama_lengkap;
        $profile->nomor_wa     = $request->nomor_wa;
        $profile->alamat       = $request->alamat;

        // 🔥 HANDLE FOTO (kalau upload baru)
        if ($request->hasFile('foto')) {

            $file = $request->file('foto');
            $ext  = $file->getClientOriginalExtension();

            // format nama file
            $namaFile = 'mhs_' . $profile->npm . '_' . time() . '.' . $ext;

if (app()->environment('production')) {
    $path = dirname(base_path()) . '/uploads/profile';
} else {
    $path = public_path('uploads/profile');
}

            // buat folder kalau belum ada
            if (!File::exists($path)) {
                File::makeDirectory($path, 0755, true);
            }

            // hapus foto lama
            if ($profile->foto_profil && File::exists($path.'/'.$profile->foto_profil)) {
                File::delete($path.'/'.$profile->foto_profil);
            }

            // simpan file baru
            $file->move($path, $namaFile);

            // simpan ke DB
            $profile->foto_profil = $namaFile;
        }

        // 🔥 SAVE
        $profile->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}