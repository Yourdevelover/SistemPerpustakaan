<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ $title }} — {{ config('app.name') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --color-primary-500: #0ea5e9;
            --color-primary-600: #0284c7;
            --color-primary-700: #0369a1;
            --color-slate-50: #f8fafc;
            --color-slate-100: #f1f5f9;
            --color-slate-200: #e2e8f0;
            --color-slate-300: #cbd5e1;
            --color-slate-400: #94a3b8;
            --color-slate-500: #64748b;
            --color-slate-600: #475569;
            --color-slate-700: #334155;
            --color-slate-800: #1e293b;
            --color-slate-900: #0f172a;
        }

        body {
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }

        .sidebar {
            width: 240px;
            min-height: 100vh;
            background: #0f172a;
            display: flex;
            flex-direction: column;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 9px 14px;
            border-radius: 8px;
            font-size: 13.5px;
            font-weight: 500;
            color: #94a3b8;
            transition: all .15s ease-in-out;
            text-decoration: none;
            margin: 1px 0;
        }

        .nav-item:hover {
            background: #1e293b;
            color: #e2e8f0;
        }

        .nav-item.active {
            background: var(--color-primary-600);
            color: #fff;
        }

        .nav-item i {
            width: 16px;
            height: 16px;
            flex-shrink: 0;
        }

        .nav-section {
            font-size: 10px;
            font-weight: 600;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: .08em;
            padding: 16px 14px 6px;
        }

        /* Soft table styles */
        .table-soft thead {
            background: var(--color-slate-25);
        }
    </style>
</head>

<body class="bg-slate-50 antialiased">
    <div class="flex min-h-screen">

        {{-- SIDEBAR --}}
        <aside class="sidebar fixed top-0 left-0 h-full z-30 flex flex-col">
            {{-- Brand --}}
            <div class="flex items-center gap-3 px-5 py-5 border-b border-slate-800">
                <div class="w-8 h-8 bg-sky-600 rounded-lg flex items-center justify-center flex-shrink-0">
                    <i data-lucide="book-open" class="w-4 h-4 text-white"></i>
                </div>
                <div>
                    <p class="text-white text-sm font-semibold leading-tight">{{ config('app.name') }}</p>
                    <p class="text-slate-500 text-xs">Admin Panel</p>
                </div>
            </div>

            {{-- Nav --}}
            <nav class="flex-1 px-3 py-4 overflow-y-auto">
                <div class="nav-section">Utama</div>
                <a href="{{ route('admin.dashboard') }}" class="nav-item {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i data-lucide="layout-dashboard"></i> Dashboard
                </a>

                <div class="nav-section">Koleksi</div>
                <a href="{{ route('admin.buku.index') }}" class="nav-item {{ request()->routeIs('admin.buku*') ? 'active' : '' }}">
                    <i data-lucide="book"></i> Manajemen Buku
                </a>
                <a href="{{ route('admin.kategori.index') }}" class="nav-item {{ request()->routeIs('admin.kategori*') ? 'active' : '' }}">
                    <i data-lucide="tag"></i> Kategori Buku
                </a>

                <div class="nav-section">Sirkulasi</div>
                <a href="{{ route('admin.peminjaman.index') }}" class="nav-item {{ request()->routeIs('admin.peminjaman*') ? 'active' : '' }}">
                    <i data-lucide="arrow-left-right"></i> Peminjaman
                </a>
                <a href="{{ route('admin.pengembalian.index') }}" class="nav-item {{ request()->routeIs('admin.pengembalian*') ? 'active' : '' }}">
                    <i data-lucide="rotate-ccw"></i> Pengembalian
                </a>
                <a href="{{ route('admin.denda.index') }}" class="nav-item {{ request()->routeIs('admin.denda*') ? 'active' : '' }}">
                    <i data-lucide="receipt"></i> Denda
                </a>

                <div class="nav-section">Anggota</div>
                <a href="{{ route('admin.anggota.index') }}" class="nav-item {{ request()->routeIs('admin.anggota*') ? 'active' : '' }}">
                    <i data-lucide="users"></i> Data Anggota
                </a>

                <div class="nav-section">Laporan</div>
                <a href="{{ route('admin.laporan.index') }}" class="nav-item {{ request()->routeIs('admin.laporan*') ? 'active' : '' }}">
                    <i data-lucide="bar-chart-2"></i> Laporan & Statistik
                </a>
            </nav>

            {{-- User Info --}}
            <div class="p-3 border-t border-slate-800">
                <div class="flex items-center gap-3 px-2 py-2">
                    <div class="w-8 h-8 rounded-full bg-sky-600 flex items-center justify-center text-white text-xs font-bold flex-shrink-0">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->username, 0, 2)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-slate-200 text-xs font-medium truncate">{{ Auth::user()->nama_lengkap ?? Auth::user()->username }}</p>
                        <p class="text-slate-500 text-xs truncate">Administrator</p>
                    </div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="text-slate-500 hover:text-red-400 transition-colors" title="Logout">
                            <i data-lucide="log-out" class="w-4 h-4"></i>
                        </button>
                    </form>
                </div>
            </div>
        </aside>

        {{-- MAIN CONTENT --}}
        <div class="flex-1 flex flex-col" style="margin-left: 240px;">
            {{-- Topbar --}}
            <header class="bg-white border-b border-slate-200 px-6 py-4 flex items-center justify-between sticky top-0 z-20">
                <div>
                    <h1 class="text-base font-semibold text-slate-900">{{ $title }}</h1>
                    <p class="text-xs text-slate-400 mt-0.5">{{ $subtitle ?: 'Selamat datang kembali' }}</p>
                </div>
                <div class="flex items-center gap-3">
                    <button class="w-8 h-8 flex items-center justify-center rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 transition-colors">
                        <i data-lucide="bell" class="w-4 h-4"></i>
                    </button>
                    <div class="w-8 h-8 rounded-full bg-sky-600 flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(Auth::user()->nama_lengkap ?? Auth::user()->username, 0, 2)) }}
                    </div>
                </div>
            </header>

            {{-- Page Content --}}
            <main class="flex-1 p-6">
                {{ $slot }}
            </main>
        </div>
    </div>

    <script>
        lucide.createIcons();
    </script>
</body>

</html>