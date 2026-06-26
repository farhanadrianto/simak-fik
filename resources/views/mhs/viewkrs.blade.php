@extends('layouts.mhs')

@section('content')

<style>
    /* ===== SECTION TITLES ===== */
    .section-title { color: #059669; font-size: 13px; font-weight: 700; letter-spacing: 1.5px; margin-bottom: 6px; text-transform: uppercase; }
    .main-heading { color: #0f172a; font-size: 32px; font-weight: 800; margin: 0 0 8px 0; }
    .sub-heading { color: #64748b; margin: 0 0 30px 0; font-size: 15px; font-weight: 500; }

    /* ===== MAIN WRAPPER ===== */
    .krs-wrapper { display: flex; flex-direction: column; min-height: calc(100vh - 220px); gap: 30px; }

    /* ===== TABLE CONTAINER ===== */
    .table-wrapper { width: 100%; background: #ffffff; border-radius: 16px; border: 1px solid #e2e8f0; box-shadow: 0 4px 12px rgba(148, 163, 184, 0.05); overflow: hidden; }
    .table-krs { width: 100%; border-collapse: collapse; text-align: left; }
    .table-krs th { background: #f8fafc; color: #475569; padding: 16px; font-size: 12px; font-weight: 700; border-bottom: 2px solid #e2e8f0; }
    .table-krs td { padding: 16px; border-bottom: 1px solid #f1f5f9; color: #334155; font-size: 14px; }
    .table-krs tr:hover { background: #f8fafc; }

    /* ===== STATUS BADGES ===== */
    .badge { padding: 6px 14px; border-radius: 999px; font-size: 12px; font-weight: 700; display: inline-block; }
    .badge-menunggu { background: #fff7ed; color: #c2410c; }
    .badge-disetujui { background: #ecfdf5; color: #047857; }
    .badge-ditolak { background: #fef2f2; color: #b91c1c; }

    /* ===== ACTION BUTTON ===== */
    .btn-hapus { padding: 6px 14px; border-radius: 8px; background: #fff5f5; color: #e53e3e; border: 1px solid rgba(229, 62, 62, 0.2); cursor: pointer; font-weight: 600; font-size: 12px; }

    /* ===== SUMMARY FOOTER ===== */
    .summary { margin-top: auto; background: #ffffff; border: 1px solid #e2e8f0; border-radius: 16px; padding: 24px; box-shadow: 0 4px 12px rgba(148, 163, 184, 0.05); }
    .progress-bar { flex: 1; height: 10px; background: #f1f5f9; border-radius: 999px; overflow: hidden; }
    .progress-fill { height: 100%; background: #10b981; border-radius: 999px; }

    /* ===== MODAL ===== */
    .modal-delete { position: fixed; inset: 0; background: rgba(15, 23, 42, 0.4); display: none; align-items: center; justify-content: center; z-index: 9999; }
    .modal-box { width: 400px; background: #ffffff; border-radius: 16px; padding: 30px; text-align: center; }
    .btn-batal { background: #f1f5f9; padding: 10px 20px; border-radius: 8px; cursor: pointer; }
    .btn-ya { background: #ef4444; color: white; padding: 10px 20px; border-radius: 8px; cursor: pointer; }
</style>

<div class="section-title">Ringkasan Rencana</div>
<h1 class="main-heading">Kartu Rencana Studi (KRS)</h1>
<p class="sub-heading">Kelola mata kuliah dan pantau status persetujuan Anda.</p>

<div class="krs-wrapper">
    <div class="table-wrapper">
        <table class="table-krs">
            <thead>
                <tr>
                    <th>NO</th><th>KODE</th><th>MATA KULIAH</th><th>SKS</th><th>KELAS</th><th>STATUS</th><th style="text-align: center;">AKSI</th>
                </tr>
            </thead>
            <tbody>
                @forelse($krs as $i => $row)
                    <tr>
                        <td>{{ $i+1 }}</td>
                        <td>{{ $row->kode_matkul }}</td>
                        <td>{{ $row->nama_matkul }}</td>
                        <td>{{ $row->sks }}</td>
                        <td>{{ $row->kelas }}</td>
                        <td><span class="badge badge-{{ $row->status }}">{{ ucfirst($row->status) }}</span></td>
                        <td style="text-align: center;">
                            <form action="{{ route('mhs.krs.delete', $row->id) }}" method="POST" class="form-hapus">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn-hapus">✕ Hapus</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr><td colspan="7" style="text-align:center; padding: 40px;">Belum ada mata kuliah yang diambil.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="summary">
        <div style="display: flex; justify-content: space-between; align-items: center; gap: 20px;">
            <div>
                <h3 style="margin: 0 0 8px 0;">📊 Total Beban SKS</h3>
                <p style="margin: 0; color: #64748b; font-size: 14px;">Total diambil: <b>{{ $totalSks }}</b> dari {{ $maxSks }} SKS</p>
                <p style="margin: 6px 0 0 0; color: #64748b; font-size: 13px;">Sisa kuota: <b style="color: #059669; font-weight: 600;">{{ $maxSks - $totalSks }} SKS</b></p>
            </div>
            <div style="display: flex; align-items: center; gap: 14px; width: 320px;">
                <div class="progress-bar"><div class="progress-fill" style="width: {{ $maxSks > 0 ? min(($totalSks / $maxSks) * 100, 100) : 0 }}%"></div></div>
                <span>{{ $maxSks > 0 ? round(($totalSks / $maxSks) * 100, 1) : 0 }}%</span>
            </div>
        </div>
    </div>
</div>

<div class="modal-delete" id="modalDelete">
    <div class="modal-box">
        <h3>Hapus Mata Kuliah?</h3>
        <p>Anda yakin ingin menghapus mata kuliah ini dari KRS?</p>
        <div style="display: flex; justify-content: center; gap: 12px;">
            <button class="btn-batal" id="btnBatal">Kembali</button>
            <button class="btn-ya" id="btnYa">Ya, Hapus</button>
        </div>
    </div>
</div>

<script>
    let formDelete = null;
    document.querySelectorAll(".form-hapus").forEach(form => {
        form.addEventListener("submit", function(e) { e.preventDefault(); formDelete = this; document.getElementById("modalDelete").style.display = "flex"; });
    });
    document.getElementById("btnBatal").onclick = () => document.getElementById("modalDelete").style.display = "none";
    document.getElementById("btnYa").onclick = () => { if(formDelete) formDelete.submit(); };
</script>
@endsection