@extends('layouts.admin')

@section('content')

<style>
.chart-card{
    background:#020617;
    padding:25px;
    border-radius:12px;
}

.chart-title{
    font-size:18px;
    font-weight:600;
    margin-bottom:20px;
}

canvas{
    max-height:400px;
}

.btn-back{
    display:inline-block;
    margin-bottom:15px;
    padding:10px 16px;
    background:#1e293b;
    color:#cbd5e1;
    text-decoration:none;
    border-radius:8px;
    transition:.2s;
}

.btn-back:hover{
    background:#334155;
    color:white;
}
</style>

<a href="{{ route('admin.report') }}" class="btn-back">
    ← Kembali
</a>

<div class="chart-card">

    <div class="chart-title">
        🎓 Jumlah Mahasiswa per Program Studi
    </div>

    <canvas id="chartProdi"></canvas>

</div>



<script>

const dataProdi = @json($mhsPerProdi);

new Chart(document.getElementById('chartProdi'), {

    type: 'bar',

    data: {

        labels: dataProdi.map(item => item.nama_prodi),

datasets: [{
    data: dataProdi.map(item => item.total),

    backgroundColor: [
        '#38bdf8', // Bisnis Digital (biru muda)
        '#22c55e', // Informatika (hijau)
        '#facc15', // Sains Data (kuning)
        '#ef4444'  // Sistem Informasi (merah)
    ],

    borderColor: [
        '#38bdf8',
        '#22c55e',
        '#facc15',
        '#ef4444'
    ],

    borderWidth: 1,
    maxBarThickness: 45,
    borderRadius: 8
}]
    },

    options: {

        responsive: true,

plugins: {
    legend: {
        display: false
    }
},

        scales: {

            y: {
                beginAtZero: true,

                suggestedMax:
                    Math.max(...dataProdi.map(item => item.total)) + 10,

                ticks: {
                    stepSize: 5,
                    color: '#94a3b8'
                },

                grid: {
                    color: 'rgba(255,255,255,0.05)'
                }
            },

            x: {

                ticks: {
                    color: '#94a3b8'
                },

                grid: {
                    display: false
                }

            }

        }

    }

});

</script>

@endsection