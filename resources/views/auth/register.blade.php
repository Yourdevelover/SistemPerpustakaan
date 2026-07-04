<x-guest-layout>
    {{-- Desktop Header --}}
    <div class="hidden lg:block mb-8">
        <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-tight flex items-center gap-3">
            <i data-lucide="user-plus" class="w-7 h-7 text-sky-600"></i>
            Daftar Akun Baru
        </h2>
        <p class="text-slate-500 text-[15px] mt-2 leading-relaxed">Isi data diri untuk menjadi anggota perpustakaan</p>
    </div>

    <form method="POST" action="{{ route('register') }}" class="space-y-6" id="registerForm">
        @csrf

        {{-- Nama Lengkap --}}
        <div class="animate-fade-in" style="animation-delay: 0.1s">
            <label for="nama_lengkap" class="block text-sm font-medium text-slate-700 mb-2.5">Nama Lengkap</label>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4.5 pointer-events-none transition-colors duration-200">
                    <i data-lucide="user" class="w-5 h-5 text-slate-400 group-focus-within:text-sky-600"></i>
                </span>
                <input
                    id="nama_lengkap" name="nama_lengkap" type="text"
                    value="{{ old('nama_lengkap') }}" required autofocus autocomplete="name"
                    placeholder="Masukkan nama lengkap"
                    class="input-field w-full pl-12 pr-4 py-3.5 text-[15px] border rounded-2xl bg-white text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                           {{ $errors->has('nama_lengkap') ? 'border-red-400' : 'border-slate-200' }}"
                />
            </div>
            @error('nama_lengkap')
                <p class="mt-2.5 text-xs text-rose-500 flex items-center gap-1.5 font-medium">
                    <i data-lucide="circle-alert" class="w-3.5 h-3.5"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Username --}}
        <div class="animate-fade-in" style="animation-delay: 0.2s">
            <label for="username" class="block text-sm font-medium text-slate-700 mb-2.5">Username</label>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4.5 pointer-events-none transition-colors duration-200">
                    <i data-lucide="at-sign" class="w-5 h-5 text-slate-400 group-focus-within:text-sky-600"></i>
                </span>
                <input
                    id="username" name="username" type="text"
                    value="{{ old('username') }}" required autocomplete="username"
                    placeholder="Pilih username"
                    class="input-field w-full pl-12 pr-4 py-3.5 text-[15px] border rounded-2xl bg-white text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                           {{ $errors->has('username') ? 'border-red-400' : 'border-slate-200' }}"
                />
            </div>
            @error('username')
                <p class="mt-2.5 text-xs text-rose-500 flex items-center gap-1.5 font-medium">
                    <i data-lucide="circle-alert" class="w-3.5 h-3.5"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Email --}}
        <div class="animate-fade-in" style="animation-delay: 0.3s">
            <label for="email" class="block text-sm font-medium text-slate-700 mb-2.5">Email</label>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4.5 pointer-events-none transition-colors duration-200">
                    <i data-lucide="mail" class="w-5 h-5 text-slate-400 group-focus-within:text-sky-600"></i>
                </span>
                <input
                    id="email" name="email" type="email"
                    value="{{ old('email') }}" required autocomplete="email"
                    placeholder="contoh@email.com"
                    class="input-field w-full pl-12 pr-4 py-3.5 text-[15px] border rounded-2xl bg-white text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                           {{ $errors->has('email') ? 'border-red-400' : 'border-slate-200' }}"
                />
            </div>
            @error('email')
                <p class="mt-2.5 text-xs text-rose-500 flex items-center gap-1.5 font-medium">
                    <i data-lucide="circle-alert" class="w-3.5 h-3.5"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password --}}
        <div class="animate-fade-in" style="animation-delay: 0.4s">
            <label for="password" class="block text-sm font-medium text-slate-700 mb-2.5">Password</label>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4.5 pointer-events-none transition-colors duration-200">
                    <i data-lucide="lock" class="w-5 h-5 text-slate-400 group-focus-within:text-sky-600"></i>
                </span>
                <input
                    id="password" name="password" type="password"
                    required autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    onkeyup="checkPassword(this.value)"
                    class="input-field w-full pl-12 pr-12 py-3.5 text-[15px] border rounded-2xl bg-white text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                           {{ $errors->has('password') ? 'border-red-400' : 'border-slate-200' }}"
                />
                <button type="button" onclick="togglePassword('password', 'eye-icon-pw')"
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-sky-600 transition-colors duration-200">
                    <i data-lucide="eye" id="eye-icon-pw" class="w-5 h-5"></i>
                </button>
            </div>
            
            {{-- Password Strength Indicator --}}
            <div id="passwordStrength" class="hidden mt-3">
                <div class="flex items-center gap-2 mb-1.5">
                    <div class="flex-1 h-1.5 bg-slate-200 rounded-full overflow-hidden">
                        <div id="strengthBar" class="h-full rounded-full transition-all duration-300 w-0"></div>
                    </div>
                    <span id="strengthText" class="text-xs font-medium text-slate-500 w-16 text-right"></span>
                </div>
                <p id="strengthHint" class="text-xs text-slate-500"></p>
            </div>
            
            @error('password')
                <p class="mt-2.5 text-xs text-rose-500 flex items-center gap-1.5 font-medium">
                    <i data-lucide="circle-alert" class="w-3.5 h-3.5"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div class="animate-fade-in" style="animation-delay: 0.5s">
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-2.5">Konfirmasi Password</label>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4.5 pointer-events-none transition-colors duration-200">
                    <i data-lucide="lock" class="w-5 h-5 text-slate-400 group-focus-within:text-sky-600"></i>
                </span>
                <input
                    id="password_confirmation" name="password_confirmation" type="password"
                    required autocomplete="new-password"
                    placeholder="Ulangi password"
                    onkeyup="checkConfirmPassword(this.value)"
                    class="input-field w-full pl-12 pr-12 py-3.5 text-[15px] border rounded-2xl bg-white text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                           {{ $errors->has('password_confirmation') ? 'border-red-400' : 'border-slate-200' }}"
                />
                <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-conf')"
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-sky-600 transition-colors duration-200">
                    <i data-lucide="eye" id="eye-icon-conf" class="w-5 h-5"></i>
                </button>
            </div>
            <p id="confirmHint" class="mt-2 text-xs hidden">
                <span id="confirmText"></span>
            </p>
            @error('password_confirmation')
                <p class="mt-2.5 text-xs text-rose-500 flex items-center gap-1.5 font-medium">
                    <i data-lucide="circle-alert" class="w-3.5 h-3.5"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" id="submitBtn"
            class="btn-primary w-full flex items-center justify-center gap-2.5 px-4 py-3.5
                   text-white text-sm font-semibold rounded-2xl transition-all duration-200 focus:outline-none
                   focus:ring-2 focus:ring-sky-500/40 focus:ring-offset-2 hover:shadow-lg hover:shadow-sky-500/25 animate-fade-in"
            style="animation-delay: 0.6s">
            <i data-lucide="user-plus" class="w-4 h-4" id="registerIcon"></i>
            <span id="btnText">Daftar Sekarang</span>
        </button>

        {{-- Link ke Login --}}
        <p class="text-center text-sm text-slate-500 pt-2 animate-fade-in" style="animation-delay: 0.7s">
            Sudah punya akun?
            <a href="{{ route('login') }}" class="text-sky-600 hover:text-sky-700 font-semibold transition-all duration-200 inline-flex items-center gap-1 group/r">
                Masuk di sini
                <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform duration-200 group-hover/r:translate-x-0.5"></i>
            </a>
        </p>
    </form>

    <script>
        function togglePassword(inputId, iconId) {
            const input = document.getElementById(inputId);
            const icon  = document.getElementById(iconId);
            if (input.type === 'password') {
                input.type = 'text';
                icon.setAttribute('data-lucide', 'eye-off');
            } else {
                input.type = 'password';
                icon.setAttribute('data-lucide', 'eye');
            }
            lucide.createIcons();
        }

        // Password strength checker
        function checkPassword(password) {
            const strengthContainer = document.getElementById('passwordStrength');
            const strengthBar = document.getElementById('strengthBar');
            const strengthText = document.getElementById('strengthText');
            const strengthHint = document.getElementById('strengthHint');
            
            if (password.length === 0) {
                strengthContainer.classList.add('hidden');
                return;
            }
            
            strengthContainer.classList.remove('hidden');
            
            let strength = 0;
            let hint = '';
            
            if (password.length >= 8) strength += 1;
            if (password.match(/[a-z]/)) strength += 1;
            if (password.match(/[A-Z]/)) strength += 1;
            if (password.match(/[0-9]/)) strength += 1;
            if (password.match(/[^a-zA-Z0-9]/)) strength += 1;
            
            const colors = ['bg-red-500', 'bg-orange-500', 'bg-yellow-500', 'bg-emerald-500', 'bg-green-500'];
            const texts = ['Lemah', 'Sedang', 'Kuat', 'Sangat Kuat', 'Sangat Kuat'];
            const hints = [
                'Tambahkan huruf besar, angka, dan simbol',
                'Tambahkan angka dan simbol untuk keamanan lebih baik',
                'Password cukup kuat',
                'Password sangat kuat',
                'Password sangat kuat'
            ];
            
            strengthBar.className = 'h-full rounded-full transition-all duration-300 ' + colors[strength - 1] || 'w-0';
            strengthBar.style.width = (strength * 25) + '%';
            strengthText.textContent = texts[strength - 1] || '';
            strengthHint.textContent = hints[strength - 1] || '';
        }

        // Confirm password checker
        function checkConfirmPassword(confirmPassword) {
            const password = document.getElementById('password').value;
            const hint = document.getElementById('confirmHint');
            const text = document.getElementById('confirmText');
            
            if (confirmPassword.length === 0) {
                hint.classList.add('hidden');
                return;
            }
            
            hint.classList.remove('hidden');
            
            if (password === confirmPassword && password.length > 0) {
                hint.className = 'mt-2 text-xs text-emerald-600 flex items-center gap-1';
                text.innerHTML = '<i data-lucide="check" class="w-3.5 h-3.5"></i> Password cocok';
            } else {
                hint.className = 'mt-2 text-xs text-rose-500 flex items-center gap-1';
                text.innerHTML = '<i data-lucide="x" class="w-3.5 h-3.5"></i> Password tidak cocok';
            }
            lucide.createIcons();
        }

        // Loading state on form submit
        document.getElementById('registerForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const icon = document.getElementById('registerIcon');
            
            btn.disabled = true;
            btn.style.cursor = 'not-allowed';
            btn.style.opacity = '0.8';
            btnText.textContent = 'Sedang mendaftar...';
            icon.setAttribute('data-lucide', 'loader-2');
            icon.classList.add('animate-spin');
            lucide.createIcons();
        });
    </script>
</x-guest-layout>