<x-guest-layout>
    {{-- Header --}}
    <div class="mb-8">
        <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Reset Password</h2>
        <p class="text-slate-500 text-sm mt-1">Buat password baru untuk akun Anda</p>
    </div>

    <form method="POST" action="{{ route('password.store') }}" class="space-y-5">
        @csrf

        {{-- Token --}}
        <input type="hidden" name="token" value="{{ $request->route('token') }}">

        {{-- Email --}}
        <div>
            <label for="email" class="block text-sm font-medium text-slate-700 mb-1.5">Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="mail" class="w-4 h-4 text-slate-400"></i>
                </span>
                <input
                    id="email" name="email" type="email"
                    value="{{ old('email', $request->email) }}" required autofocus autocomplete="username"
                    placeholder="Masukkan email"
                    class="w-full pl-10 pr-4 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                           {{ $errors->has('email') ? 'border-red-400' : 'border-slate-300' }}"
                />
            </div>
            @error('email')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                    <i data-lucide="circle-alert" class="w-3 h-3"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Password Baru --}}
        <div>
            <label for="password" class="block text-sm font-medium text-slate-700 mb-1.5">Password Baru</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="lock" class="w-4 h-4 text-slate-400"></i>
                </span>
                <input
                    id="password" name="password" type="password"
                    required autocomplete="new-password"
                    placeholder="Minimal 8 karakter"
                    class="w-full pl-10 pr-10 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                           {{ $errors->has('password') ? 'border-red-400' : 'border-slate-300' }}"
                />
                <button type="button" onclick="togglePassword('password', 'eye-icon-pw')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                    <i data-lucide="eye" id="eye-icon-pw" class="w-4 h-4"></i>
                </button>
            </div>
            @error('password')
                <p class="mt-1.5 text-xs text-red-500 flex items-center gap-1">
                    <i data-lucide="circle-alert" class="w-3 h-3"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Konfirmasi Password --}}
        <div>
            <label for="password_confirmation" class="block text-sm font-medium text-slate-700 mb-1.5">Konfirmasi Password Baru</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                    <i data-lucide="lock" class="w-4 h-4 text-slate-400"></i>
                </span>
                <input
                    id="password_confirmation" name="password_confirmation" type="password"
                    required autocomplete="new-password"
                    placeholder="Ulangi password baru"
                    class="w-full pl-10 pr-10 py-2.5 text-sm border rounded-lg bg-white text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-transparent
                           border-slate-300"
                />
                <button type="button" onclick="togglePassword('password_confirmation', 'eye-icon-conf')"
                    class="absolute inset-y-0 right-0 flex items-center pr-3 text-slate-400 hover:text-slate-600">
                    <i data-lucide="eye" id="eye-icon-conf" class="w-4 h-4"></i>
                </button>
            </div>
        </div>

        {{-- Submit --}}
        <button type="submit"
            class="w-full flex items-center justify-center gap-2 px-4 py-2.5 bg-blue-600 hover:bg-blue-700
                   text-white text-sm font-semibold rounded-lg transition-colors duration-150 focus:outline-none
                   focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            <i data-lucide="key-round" class="w-4 h-4"></i>
            Reset Password
        </button>
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
    </script>
</x-guest-layout>