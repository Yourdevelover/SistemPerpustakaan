<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Perpustakaan') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/lucide@latest"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        /* Soft color palette */
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
            --color-slate-900: #0f172a;
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { 
            font-family: 'Inter', system-ui, -apple-system, sans-serif; 
            -webkit-font-smoothing: antialiased; 
            -moz-osx-font-smoothing: grayscale; 
            background: linear-gradient(135deg, #f1f5f9 0%, #e2e8f0 100%);
        }

        /* Background pattern for left panel */
        .bg-pattern {
            background-image: 
                radial-gradient(circle at 100px 100px, rgba(14, 165, 233, 0.1) 0%, transparent 0%),
                radial-gradient(circle at 400px 300px, rgba(14, 165, 233, 0.05) 0%, transparent 0%);
        }

        .form-card {
            background: #fff;
            border-radius: 24px;
            padding: 48px;
            width: 100%;
            max-width: 440px;
            border: 1px solid var(--color-slate-200);
            box-shadow: 0 25px 50px -12px rgba(15, 23, 42, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 32px 64px -12px rgba(15, 23, 42, 0.12);
        }

        .input-field {
            transition: all 0.2s ease-in-out;
            border: 1.5px solid var(--color-slate-200);
            background: #fff;
        }
        .input-field:focus {
            border-color: var(--color-primary-500);
            box-shadow: 0 0 0 4px rgba(14, 165, 233, 0.12);
            outline: none;
        }
        .input-field::placeholder {
            color: var(--color-slate-400);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--color-primary-600) 0%, var(--color-primary-700) 100%);
            transition: all 0.2s ease-in-out;
            font-weight: 500;
            position: relative;
            overflow: hidden;
        }
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--color-primary-700) 0%, #0369a1 100%);
            transform: translateY(-1px);
            box-shadow: 0 10px 25px -5px rgba(2, 132, 199, 0.3);
        }
        .btn-primary:active {
            transform: translateY(0);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.2), transparent);
            transition: left 0.5s;
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        /* Animation for form elements */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        .animate-fade-in {
            animation: fadeInUp 0.6s ease-out forwards;
        }

        .animate-delay-100 { animation-delay: 0.1s; }
        .animate-delay-200 { animation-delay: 0.2s; }
        .animate-delay-300 { animation-delay: 0.3s; }

        .animate-float {
            animation: float 3s ease-in-out infinite;
        }
    </style>
</head>
<body class="bg-slate-50">
    <div class="min-h-screen flex">

        {{-- Left Panel: Branding --}}
        <div class="hidden lg:flex lg:w-1/2 bg-slate-900 flex-col justify-between p-14 relative overflow-hidden bg-pattern">
            {{-- Background decoration --}}
            <div class="absolute top-0 right-0 w-96 h-96 bg-sky-600 rounded-full opacity-5 blur-3xl"></div>
            <div class="absolute bottom-0 left-0 w-80 h-80 bg-sky-400 rounded-full opacity-5 blur-3xl"></div>
            
            <div class="relative z-10">
                {{-- Logo & brand --}}
                <div class="pb-8 animate-fade-in">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-sky-600 rounded-2xl flex items-center justify-center shadow-lg shadow-sky-600/25">
                            <i data-lucide="book-open" class="w-6 h-6 text-white"></i>
                        </div>
                        <span class="text-white font-bold text-2xl tracking-tight">
                            {{ config('app.name', 'Perpustakaan') }}
                        </span>
                    </div>
                </div>

                {{-- Center tagline --}}
                <div class="max-w-lg animate-fade-in animate-delay-100">
                    <h1 class="text-[3.2rem] font-extrabold text-white leading-[1.15] tracking-tight mb-6">
                        Kelola Perpustakaan<br>
                        Lebih Cerdas
                    </h1>
                    <p class="text-slate-300 text-base leading-relaxed">
                        Platform digital untuk mengelola koleksi buku, anggota, dan transaksi peminjaman secara efisien dan terintegrasi.
                    </p>
                </div>
            </div>

            {{-- Feature list --}}
            <div class="space-y-4 relative z-10">
                <div class="flex items-start gap-4 animate-fade-in animate-delay-200">
                    <div class="w-12 h-12 rounded-xl bg-slate-800/50 backdrop-blur-sm flex items-center justify-center flex-shrink-0 border border-slate-700/50">
                        <i data-lucide="book" class="w-5 h-5 text-sky-400"></i>
                    </div>
                    <div class="pt-2">
                        <p class="text-white text-base font-semibold">1.200+ Koleksi Buku</p>
                        <p class="text-slate-400 text-sm mt-0.5">Dari berbagai kategori dan genre</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 animate-fade-in animate-delay-300">
                    <div class="w-12 h-12 rounded-xl bg-slate-800/50 backdrop-blur-sm flex items-center justify-center flex-shrink-0 border border-slate-700/50">
                        <i data-lucide="users" class="w-5 h-5 text-sky-400"></i>
                    </div>
                    <div class="pt-2">
                        <p class="text-white text-base font-semibold">340+ Anggota Aktif</p>
                        <p class="text-slate-400 text-sm mt-0.5">Siswa, guru, dan staf sekolah</p>
                    </div>
                </div>
                <div class="flex items-start gap-4 animate-fade-in" style="animation-delay: 0.4s">
                    <div class="w-12 h-12 rounded-xl bg-slate-800/50 backdrop-blur-sm flex items-center justify-center flex-shrink-0 border border-slate-700/50">
                        <i data-lucide="trending-up" class="w-5 h-5 text-sky-400"></i>
                    </div>
                    <div class="pt-2">
                        <p class="text-white text-base font-semibold">98% Kepuasan Pengguna</p>
                        <p class="text-slate-400 text-sm mt-0.5">Berdasarkan survei tahunan</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- Right Panel: Form --}}
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-gradient-to-br from-slate-50 to-slate-100">
            <div class="w-full max-w-sm">
                {{-- Mobile brand --}}
                <div class="lg:hidden mb-10 animate-fade-in">
                    <div class="flex items-center justify-center gap-3 mb-6">
                        <div class="w-11 h-11 bg-sky-600 rounded-xl flex items-center justify-center shadow-lg shadow-sky-600/20">
                            <i data-lucide="book-open" class="w-5 h-5 text-white"></i>
                        </div>
                        <span class="text-slate-900 font-bold text-xl tracking-tight">
                            {{ config('app.name', 'Perpustakaan') }}
                        </span>
                    </div>
                    <h1 class="text-[28px] font-bold text-slate-900 text-center mb-2">Selamat Datang Kembali</h1>
                    <p class="text-slate-500 text-[15px] text-center">Masuk ke akun Anda untuk melanjutkan</p>
                </div>

                {{-- Card form --}}
                <div class="form-card animate-fade-in" style="animation-delay: 0.1s">
                    {{ $slot }}
                </div>
            </div>
        </div>

    </div>

    <script>
        lucide.createIcons();
        
        // Add input focus animations
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('.input-field');
            inputs.forEach(input => {
                input.addEventListener('focus', function() {
                    this.parentElement.parentElement.classList.add('scale-105');
                });
                input.addEventListener('blur', function() {
                    this.parentElement.parentElement.classList.remove('scale-105');
                });
            });
        });
    </script>
</body>
</html>