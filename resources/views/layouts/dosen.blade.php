<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dosen - SIMAK</title>

    <style>
        /* GLOBAL FIX */
        * {
            box-sizing: border-box;
        }

        html {
            background: #0b1220;
            overflow-y: auto;
        }

        body {
            margin: 0;
            display: flex;
            font-family: sans-serif;
            background: #0b1220;
            color: white;
            min-height: 100vh;
            /* Perbaikan agar lebar konsisten */
            width: 100%;
            overflow-x: hidden;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 240px;
            min-width: 240px;
            background: #020617;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            padding: 20px;
            position: sticky;
            top: 0;
            left: 0;
            z-index: 99;
            border-right: 1px solid #1e293b;
        }

        .logo {
            margin-bottom: 30px;
        }

        .logo-title {
            font-size: 22px;
            font-weight: 800;
            letter-spacing: 1px;
            color: #3b82f6; /* Biru Dosen */
        }

        .logo-sub {
            font-size: 11px;
            color: #64748b;
            margin-top: 4px;
            letter-spacing: 1px;
        }

        .menu {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .menu a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px;
            border-radius: 10px;
            text-decoration: none;
            color: #9ca3af;
            transition: 0.2s;
            font-size: 14px;
        }

        .menu a:hover {
            background: #1e293b;
            color: white;
        }

        .menu a.active {
            background: linear-gradient(90deg, #1e3a8a, #1e40af);
            color: #93c5fd;
            font-weight: 600;
            /* Anti Spam Click */
            pointer-events: none;
            cursor: default;
        }

        /* ===== MAIN AREA ===== */
        .main {
            flex: 1;
            display: flex;
            flex-direction: column;
            min-width: 0;
            width: 100%; /* Memaksa main mengisi sisa layar */
        }

        /* ===== HEADER STRIP (MENTOK KANAN) ===== */
        .header-strip {
            background: #020617;
            padding: 0 30px;
            height: 70px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-bottom: 1px solid #1e293b;
            width: 100%; /* Garis akan mengikuti lebar main */
        }

        .badge-dosen {
            display: inline-block;
            background: rgba(59, 130, 246, 0.15);
            color: #60a5fa;
            padding: 8px 18px;
            border-radius: 999px;
            font-weight: 600;
            font-size: 13px;
            border: 1px solid rgba(59, 130, 246, 0.3);
            white-space: nowrap;
        }

        .date-info {
            font-size: 13px;
            color: #94a3b8;
        }

        /* ===== CONTENT AREA ===== */
        .content {
            flex: 1;
            padding: 30px;
            width: 100%;
        }

        /* LOGOUT */
        .bottom {
            margin-top: auto;
            padding-bottom: 20px;
        }

        .logout {
            width: 100%;
            padding: 12px;
            border-radius: 10px;
            text-align: center;
            background: #3f1d1d;
            color: #fca5a5;
            border: 1px solid #7f1d1d;
            cursor: pointer;
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
            @if(request()->routeIs('dosen.dashboard'))
                <a class="active">🏠 Beranda</a>
            @else
                <a href="{{ route('dosen.dashboard') }}">🏠 Beranda</a>
            @endif

            {{-- Feedback Mahasiswa --}}
            @if(request()->is('dosen/feedback*'))
                <a class="active">💬 Feedback Mahasiswa</a>
            @else
                <a href="{{ route('dosen.feedback') }}">💬 Feedback Mahasiswa</a>
            @endif

            {{-- Approve KRS --}}
            @if(request()->is('dosen/approve-krs*'))
                <a class="active">📋 Approve KRS</a>
            @else
                <a href="{{ route('dosen.approve') }}">📋 Approve KRS</a>
            @endif

            {{-- Profil Saya --}}
            @if(request()->routeIs('dosen.profile'))
                <a class="active">👤 Profil Saya</a>
            @else
                <a href="{{ route('dosen.profile') }}">👤 Profil Saya</a>
            @endif
        </div>

        <div class="bottom">
            {{-- Logout hanya di Dashboard --}}
            @if(request()->routeIs('dosen.dashboard'))
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
            <div class="badge-dosen">SIMAK FIK 2026</div>
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