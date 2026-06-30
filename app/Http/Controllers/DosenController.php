<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use App\Models\Profiledosen;
use App\Models\Prodi;

class DosenController extends Controller
{
    // ================= DASHBOARD =================
public function dashboard()
{
    $user = Auth::user();
    $prodi = Prodi::where('kode_prodi', $user->kode_prodi)->first();

    // Tambahkan ini untuk mengambil nama lengkap dari tabel profiledosen
    // Pakai firstOrCreate supaya kalau data profil belum ada, otomatis dibuatkan (mencegah error)
    $profile = Profiledosen::firstOrCreate(
        ['nip' => $user->nip],
        ['nama_lengkap' => 'Dosen '.$user->nip]
    );

    return view('dosen.dashboard', compact('user', 'prodi', 'profile'));
}

    // ================= PROFILE =================
    public function profile()
    {
        $user = Auth::user();

        $profile = Profiledosen::firstOrCreate(
            ['nip' => $user->nip],
            ['nama_lengkap' => 'Dosen '.$user->nip]
        );

        $prodi = Prodi::where('kode_prodi', $user->kode_prodi)->first();

        return view('dosen.profile', compact('profile','prodi'));
    }

    // ================= UPDATE PROFILE =================
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'nama_lengkap' => 'nullable|string|max:255',
            'nomor_wa'     => 'nullable|string|max:20',
            'email_kampus' => 'nullable|email|max:255',
            'alamat'       => 'nullable|string',
            'foto'         => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $profile = Profiledosen::where('nip', $user->nip)->first();

        if(!$profile){
            return back()->with('error','Profil tidak ditemukan');
        }

        // ===== FOTO =====
        $namaFile = $profile->foto_profil;

        if($request->hasFile('foto')){
            $file = $request->file('foto');
            $ext  = $file->getClientOriginalExtension();
            $namaFile = 'dosen_'.$user->nip.'_'.time().'.'.$ext;

if (app()->environment('production')) {
    $path = dirname(base_path()) . '/uploads/profile';
} else {
    $path = public_path('uploads/profile');
}

            if(!File::exists($path)){
                File::makeDirectory($path, 0755, true);
            }

            if($profile->foto_profil && File::exists($path.'/'.$profile->foto_profil)){
                File::delete($path.'/'.$profile->foto_profil);
            }

            $file->move($path, $namaFile);
        }

        $profile->update([
            'nama_lengkap' => $request->nama_lengkap,
            'nomor_wa'     => $request->nomor_wa,
            'alamat'       => $request->alamat,
            'foto_profil'  => $namaFile
        ]);

        return back()->with('success','Profil berhasil diperbarui');
    }

    // ================= LIST FEEDBACK PER PRODI =================
public function feedback()
{
    $user = auth()->user();

    $prodi = Prodi::where(
        'kode_prodi',
        $user->kode_prodi
    )->first();

    return view('dosen.feedback', compact('prodi'));
}

public function feedbackSaya()
{
    $user = Auth::user();

    $feedback = DB::table('feedback')
        ->where('kategori', 'dosen')
        ->where('nip', $user->nip)
        ->orderByDesc('tanggal')
        ->get();

    return view('dosen.feedback_list', [
        'title' => 'Feedback Untuk Anda',
        'feedback' => $feedback
    ]);
}

public function feedbackProdi()
{
    $user = Auth::user();

    $feedback = DB::table('feedback')
        ->where('kode_prodi', $user->kode_prodi)
        ->orderByDesc('tanggal')
        ->get();

    return view('dosen.feedback_list', [
        'title' => 'Semua Feedback Prodi',
        'feedback' => $feedback
    ]);
}

public function feedbackPengajaran()
{
    $user = Auth::user();

    $feedback = DB::table('feedback')
        ->where('kategori', 'pengajaran')
        ->where('nip', $user->nip)
        ->orderByDesc('tanggal')
        ->get();

    return view('dosen.feedback_list', [
        'title' => 'Feedback Pengajaran',
        'feedback' => $feedback
    ]);
}

public function feedbackFasilitas()
{
    $feedback = DB::table('feedback')
        ->where('kategori', 'fasilitas')
        ->orderByDesc('tanggal')
        ->get();

    return view('dosen.feedback_list', [
        'title' => 'Feedback Fasilitas',
        'feedback' => $feedback
    ]);
}

public function feedbackSemua()
{
    $feedback = DB::table('feedback')
        ->orderByDesc('tanggal')
        ->get();

    return view('dosen.feedback_list', [
        'title' => 'Semua Feedback',
        'feedback' => $feedback
    ]);
}

    // ================= DETAIL FEEDBACK =================
    public function detailFeedback($npm)
    {
        $user = Auth::user();

        // 🔒 VALIDASI PRODI
        $cek = DB::table('users')
            ->where('npm', $npm)
            ->where('kode_prodi', $user->kode_prodi)
            ->first();

        if(!$cek){
            return back()->with('error','Tidak diizinkan');
        }

        $feedback = DB::table('feedback')
            ->where('npm', $npm)
            ->get();

        return view('dosen.feedback_detail', compact('feedback','npm'));
    }

    
    // ================= APPROVE KRS =================
    public function approveKrs()
    {
        $user = Auth::user();

        $prodi = DB::table('prodi')
            ->where('kode_prodi', $user->kode_prodi)
            ->first();

        $krs = DB::table('krs')
            ->join('users', 'krs.npm', '=', 'users.npm')
            ->join('matkul', 'krs.kode_matkul', '=', 'matkul.kode_matkul')
            ->select(
                'krs.npm',
                DB::raw('SUM(matkul.sks) as total_sks'),
                DB::raw("
                    CASE
                        WHEN SUM(CASE WHEN krs.status='ditolak' THEN 1 ELSE 0 END) > 0
                        THEN 'ditolak'

                        WHEN SUM(CASE WHEN krs.status='disetujui' THEN 1 ELSE 0 END) =
                             COUNT(*)
                        THEN 'disetujui'

                        ELSE 'menunggu'
                    END as status
                ")
            )
            ->where('users.kode_prodi', $user->kode_prodi)
            ->groupBy('krs.npm')
            ->get();

        return view('dosen.approve_krs', compact('krs','prodi'));
    }

    // ================= DETAIL KRS =================
    public function detailKrs($npm)
    {
        $user = Auth::user();

        $cek = DB::table('users')
            ->where('npm', $npm)
            ->where('kode_prodi', $user->kode_prodi)
            ->first();

        if(!$cek){
            return back()->with('error','Tidak diizinkan');
        }

        $krs = DB::table('krs')
            ->join('matkul', 'krs.kode_matkul', '=', 'matkul.kode_matkul')
            ->select(
                'krs.*',
                'matkul.nama_matkul',
                'matkul.sks',
                'matkul.hari',
                'matkul.jam_mulai',
                'matkul.jam_selesai'
            )
            ->where('krs.npm', $npm)
            ->get();

        $totalSks = DB::table('krs')
            ->join('matkul', 'krs.kode_matkul', '=', 'matkul.kode_matkul')
            ->where('krs.npm', $npm)
            ->sum('matkul.sks');

        return view('dosen.detail_krs', compact(
            'krs',
            'npm',
            'totalSks'
        ));
    }

    // ================= SETUJUI =================
    public function setujuiKrs($id)
    {
        DB::table('krs')
            ->where('id', $id)
            ->update([
                'status' => 'disetujui',
                'nip' => Auth::user()->nip
            ]);

        return back()->with('success','KRS disetujui');
    }

    // ================= TOLAK =================
    public function tolakKrs($id)
    {
        DB::table('krs')
            ->where('id', $id)
            ->update([
                'status' => 'ditolak',
                'nip' => Auth::user()->nip
            ]);

        return back()->with('success','KRS ditolak');
    }

    // ================= RESET =================
    public function resetKrs($id)
    {
        DB::table('krs')
            ->where('id', $id)
            ->update([
                'status' => 'menunggu',
                'nip' => null
            ]);

        return back()->with('success','Status dikembalikan');
    }

}