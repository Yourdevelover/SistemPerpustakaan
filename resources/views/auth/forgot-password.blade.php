<x-guest-layout>
    {{-- Desktop Header --}}
    <div class="hidden lg:block mb-8">
        <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-tight flex items-center gap-3">
            <i data-lucide="key" class="w-7 h-7 text-sky-600"></i>
            Lupa Password
        </h2>
        <p class="text-slate-500 text-[15px] mt-2 leading-relaxed">Masukkan email Anda untuk menerima tautan reset password</p>
    </div>

    {{-- Session Status --}}
    @if (session('status'))
        <div class="mb-5 flex items-center gap-3 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-3.5 animate-fade-in">
            <i data-lucide="circle-check" class="w-4 h-4 shrink-0"></i>
            {{ session('status') }}
        </div>
    @endif

    <form method="POST" action="{{ route('password.email') }}" class="space-y-6" id="forgotForm">
        @csrf

        {{-- Email --}}
        <div class="animate-fade-in" style="animation-delay: 0.1s">
            <label for="email" class="block text-sm font-medium text-slate-700 mb-2">Email</label>
            <div class="relative">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4 pointer-events-none">
                    <i data-lucide="mail" class="w-4 h-4 text-slate-400"></i>
                </span>
                <input
                    id="email" name="email" type="email"
                    value="{{ old('email') }}" required autofocus
                    placeholder="Masukkan email terdaftar"
                    class="input-field w-full pl-11 pr-4 py-3.5 text-[15px] border rounded-2xl bg-white text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                           {{ $errors->has('email') ? 'border-red-400' : 'border-slate-200' }}"
                />
            </div>
            @error('email')
                <p class="mt-2 text-xs text-rose-500 flex items-center gap-1.5">
                    <i data-lucide="circle-alert" class="w-3.5 h-3.5"></i>
                    {{ $message }}
                </p>
            @enderror
        </div>

        {{-- Submit --}}
        <button type="submit" id="submitBtn"
            class="btn-primary w-full flex items-center justify-center gap-2.5 px-4 py-3.5
                   text-white text-sm font-semibold rounded-2xl transition-all duration-150 focus:outline-none
                   focus:ring-2 focus:ring-sky-500/40 focus:ring-offset-2 animate-fade-in"
            style="animation-delay: 0.2s">
            <i data-lucide="send" class="w-4 h-4" id="forgotIcon"></i>
            <span id="btnText">Kirim Tautan Reset</span>
        </button>

        {{-- Link ke Login --}}
        <p class="text-center text-sm text-slate-500 animate-fade-in" style="animation-delay: 0.3s">
            <a href="{{ route('login') }}" class="text-sky-600 hover:text-sky-700 font-semibold transition-colors inline-flex items-center gap-1">
                <i data-lucide="arrow-left" class="w-3 h-3"></i> Kembali ke login
            </a>
        </p>
    </form>

    <script>
        // Loading state on form submit
        document.getElementById('forgotForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const icon = document.getElementById('forgotIcon');
            
            btn.disabled = true;
            btn.style.cursor = 'not-allowed';
            btn.style.opacity = '0.8';
            btnText.textContent = 'Mengirim...';
            icon.setAttribute('data-lucide', 'loader-2');
            icon.classList.add('animate-spin');
            lucide.createIcons();
        });
    </script>
</x-guest-layout>