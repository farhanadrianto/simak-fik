<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mahasiswa - SIMAK</title>

    <style>
        /* GLOBAL FIX */
        *{
            box-sizing:border-box;
        }

        html{
            background: #0b1220; 
            overflow-y: auto;
        }

        body {
            margin:0;
            display:flex;
            font-family:sans-serif;
            background:#0b1220;
            color:white;
            min-height: 100vh;
            /* FIX: Gunakan width 100% agar mentok kanan */
            width: 100%;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width:240px;
            min-width:240px;
            background:#020617;
            min-height:100vh;
            display:flex;
            flex-direction:column;
            padding:20px;
            position: sticky;
            top: 0;
            left: 0;
            z-index: 99;
            border-right: 1px solid #1e293b;
        }

        .logo{
            margin-bottom:30px;
        }

        .logo-title{
            font-size:22px;
            font-weight:800;
            letter-spacing:1px;
            color: #10b981; /* Hijau Emerald */
        }

        .logo-sub{
            font-size:11px;
            color:#64748b;
            margin-top:4px;
            letter-spacing:1px;
        }

        .menu {
            display:flex;
            flex-direction:column;
            gap:10px;
        }

        .menu a {
            display:flex;
            align-items:center;
            gap:12px;
            padding:12px;
            border-radius:10px;
            text-decoration:none;
            color:#9ca3af;
            transition:0.2s;
            font-size: 14px;
        }

        .menu a:hover {
            background:#1e293b;
            color:white;
        }

        .menu a.active {
            background:linear-gradient(90deg,#065f46,#064e3b);
            color:#34d399;
            font-weight: 600;
            /* Anti Spam Click */
            pointer-events: none;
            cursor: default;
        }

        /* ===== MAIN AREA ===== */
        .main{
            flex:1;
            display:flex;
            flex-direction:column;
            min-width: 0; 
            width: 100%; /* FIX: Paksa main mengisi sisa layar */
        }

        /* ===== HEADER STRIP ===== */
        .header-strip{
            background:#020617;
            padding: 0 30px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-shrink:0;
            border-bottom:1px solid #1e293b;
            width: 100%; /* FIX: Garis mengikuti lebar main */
        }

        .badge-mhs{
            display:inline-block;
            background:rgba(16,185,129,0.15);
            color:#34d399;
            padding:8px 18px;
            border-radius:999px;
            font-weight:600;
            font-size:13px;
            border:1px solid rgba(16,185,129,0.3);
            white-space:nowrap;
        }

        .date-info {
            font-size: 13px;
            color: #94a3b8;
        }

        /* ===== CONTENT ===== */
        .content{
            flex:1;
            padding:30px;
            width: 100%;
        }

        /* LOGOUT */
        .bottom {
            margin-top:auto;
            padding-bottom:20px;
        }

        .logout {
            width:100%;
            padding:12px;
            border-radius:10px;
            text-align:center;
            background:#3f1d1d;
            color:#fca5a5;
            border:1px solid #7f1d1d;
            cursor:pointer;
            transition: 0.3s;
            font-weight: 600;
        }

        .logout:hover {
            background: #7f1d1d;
            color: white;
        }

    </style>
</head>

<body>

    <!-- SIDEBAR -->
    <div class="sidebar">
        <div class="logo">
            <div class="logo-title">SIMAK</div>
            <div class="logo-sub">FAKULTAS ILMU KOMPUTER</div>
        </div>

        <div class="menu">
            {{-- Beranda --}}
            @if(request()->is('mhs/dashboard'))
                <a class="active">🏠 Beranda</a>
            @else
                <a href="/mhs/dashboard">🏠 Beranda</a>
            @endif

            {{-- Feedback --}}
            @if(request()->is('mhs/feedback*'))
                <a class="active">💬 Feedback</a>
            @else
                <a href="{{ route('mhs.feedback') }}">💬 Feedback</a>
            @endif

            {{-- Mata Kuliah Reguler --}}
            @if(request()->is('mhs/matkul'))
                <a class="active">📚 Mata Kuliah Reguler</a>
            @else
                <a href="{{ route('mhs.matkul') }}">📚 Mata Kuliah Reguler</a>
            @endif

            {{-- Mata Kuliah Umum --}}
            @if(request()->is('mhs/mku'))
                <a class="active">🎓 Mata Kuliah Umum</a>
            @else
                <a href="{{ route('mhs.mku') }}">🎓 Mata Kuliah Umum</a>
            @endif

            {{-- KRS Saya --}}
            @if(request()->routeIs('mhs.krs'))
                <a class="active">📋 KRS Saya</a>
            @else
                <a href="{{ route('mhs.krs') }}">📋 KRS Saya</a>
            @endif

            {{-- Profil Saya --}}
            @if(request()->routeIs('mhs.profile'))
                <a class="active">👤 Profil Saya</a>
            @else
                <a href="{{ route('mhs.profile') }}">👤 Profil Saya</a>
            @endif
        </div>

        <div class="bottom">
            {{-- Tombol Logout hanya di dashboard --}}
            @if(request()->is('mhs/dashboard'))
                <form action="{{ route('logout') }}" method="POST">
                    @csrf
                    <button type="submit" class="logout">🚪 Keluar</button>
                </form>
            @endif
        </div>
    </div>

    <!-- MAIN AREA -->
    <div class="main">
        <!-- HEADER -->
        <div class="header-strip">
            <div class="badge-mhs">SIMAK FIK 2026</div>
            <div class="date-info">
    {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, DD MMMM YYYY') }}
</div>
        </div>

        <!-- CONTENT -->
        <div class="content">
            @yield('content')
        </div>
    </div>

</body>
</html>