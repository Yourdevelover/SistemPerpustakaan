<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    
    <div class="hidden lg:block mb-10">
        <h2 class="text-[28px] font-bold text-slate-900 tracking-tight leading-tight flex items-center gap-3">
            <i data-lucide="log-in" class="w-7 h-7 text-sky-600"></i>
            Masuk ke Akun
        </h2>
        <p class="text-slate-500 text-[15px] mt-2 leading-relaxed">Masukkan kredensial Anda untuk melanjutkan</p>
    </div>

    
    <?php if(session('status')): ?>
        <div class="mb-5 flex items-center gap-3 text-sm font-medium text-emerald-700 bg-emerald-50 border border-emerald-200 rounded-2xl px-5 py-3.5 animate-fade-in">
            <i data-lucide="circle-check" class="w-4 h-4 shrink-0"></i>
            <?php echo e(session('status')); ?>

        </div>
    <?php endif; ?>

    
    <?php if($errors->has('username')): ?>
        <div class="mb-5 flex items-center gap-3 text-sm font-medium text-rose-700 bg-rose-50 border border-rose-200 rounded-2xl px-5 py-3.5 animate-fade-in">
            <i data-lucide="circle-alert" class="w-4 h-4 shrink-0"></i>
            <?php echo e($errors->first('username')); ?>

        </div>
    <?php endif; ?>

    <form method="POST" action="<?php echo e(route('login')); ?>" class="space-y-5" id="loginForm">
        <?php echo csrf_field(); ?>

        
        <div class="animate-fade-in" style="animation-delay: 0.1s">
            <label for="username" class="block text-sm font-medium text-slate-700 mb-2.5">Username</label>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4.5 pointer-events-none transition-colors duration-200">
                    <!-- <i data-lucide="user" class="w-5 h-5 text-slate-400 group-focus-within:text-sky-600"></i> -->
                </span>
                <input
                    id="username" name="username" type="text"
                    value="<?php echo e(old('username')); ?>" required autofocus autocomplete="username"
                    placeholder="admin@perpustakaan.com"
                    class="input-field w-full pl-12 pr-4 py-3.5 text-[15px] border rounded-2xl bg-white text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                           <?php echo e($errors->has('username') ? 'border-red-400' : 'border-slate-200'); ?>"
                />
            </div>
            <?php $__errorArgs = ['username'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2.5 text-xs text-rose-500 flex items-center gap-1.5 font-medium">
                    <i data-lucide="circle-alert" class="w-3.5 h-3.5"></i>
                    <?php echo e($message); ?>

                </p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div class="animate-fade-in" style="animation-delay: 0.2s">
            <label for="password" class="block text-sm font-medium text-slate-700 mb-2.5">Password</label>
            <div class="relative group">
                <span class="absolute inset-y-0 left-0 flex items-center pl-4.5 pointer-events-none transition-colors duration-200">
                    <!-- <i data-lucide="lock" class="w-5 h-5 text-slate-400 group-focus-within:text-sky-600"></i> -->
                </span>
                <input
                    id="password" name="password" type="password"
                    required autocomplete="current-password"
                    placeholder="password123"
                    class="input-field w-full pl-12 pr-12 py-3.5 text-[15px] border rounded-2xl bg-white text-slate-900 placeholder-slate-400
                           focus:outline-none focus:ring-2 focus:ring-sky-500/20 focus:border-sky-500
                           <?php echo e($errors->has('password') ? 'border-red-400' : 'border-slate-200'); ?>"
                />
                <button type="button" onclick="togglePassword()"
                    class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-sky-600 transition-colors duration-200">
                    <i data-lucide="eye" id="eye-icon" class="w-5 h-5"></i>
                </button>
            </div>
            <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <p class="mt-2.5 text-xs text-rose-500 flex items-center gap-1.5 font-medium">
                    <i data-lucide="circle-alert" class="w-3.5 h-3.5"></i>
                    <?php echo e($message); ?>

                </p>
            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
        </div>

        
        <div class="flex items-center justify-between animate-fade-in" style="animation-delay: 0.3s">
            <label class="flex items-center gap-2.5 cursor-pointer group select-none">
                <div class="relative">
                    <input type="checkbox" name="remember" id="remember_me"
                        class="peer w-4.5 h-4.5 rounded border-slate-300 text-sky-600 focus:ring-sky-500/30 cursor-pointer transition-all duration-200 appearance-none
                               checked:bg-sky-600 checked:border-sky-600 hover:border-sky-400">
                    <svg class="absolute inset-0 w-4.5 h-4.5 text-white opacity-0 peer-checked:opacity-100 pointer-events-none transition-opacity duration-200"
                         viewBox="0 0 12 12" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="1.5 6 4.5 9 10.5 3"></polyline>
                    </svg>
                </div>
                <span class="text-sm text-slate-600 hover:text-slate-700 transition-colors font-normal">Ingat saya</span>
            </label>
            <?php if(Route::has('password.request')): ?>
                <a href="<?php echo e(route('password.request')); ?>"
                    class="text-sm text-sky-600 hover:text-sky-700 font-medium transition-all duration-200 inline-flex items-center gap-1.5 group/link">
                    Lupa password?
                    <i data-lucide="arrow-right" class="w-3.5 h-3.5 transition-transform duration-200 group-hover/link:translate-x-0.5"></i>
                </a>
            <?php endif; ?>
        </div>

        
        <button type="submit" id="submitBtn"
            class="btn-primary w-full flex items-center justify-center gap-2.5 px-4 py-3.5
                   text-white text-sm font-semibold rounded-2xl transition-all duration-200 focus:outline-none
                   focus:ring-2 focus:ring-sky-500/40 focus:ring-offset-2 hover:shadow-lg hover:shadow-sky-500/25 animate-fade-in"
            style="animation-delay: 0.4s">
            <i data-lucide="log-in" class="w-4 h-4" id="loginIcon"></i>
            <span id="btnText">Masuk</span>
        </button>

        <a href="<?php echo e(route('member.dashboard')); ?>"
            class="w-full flex items-center justify-center gap-2.5 px-4 py-3.5 mt-3
                   text-sm font-semibold rounded-2xl border border-emerald-200 bg-emerald-50 text-emerald-700
                   hover:bg-emerald-100 transition-all duration-200 animate-fade-in"
            style="animation-delay: 0.45s">
            <i data-lucide="play-circle" class="w-4 h-4"></i>
            <span>Demo Langsung</span>
        </a>

        <p class="text-center text-sm text-slate-500 pt-2 animate-fade-in" style="animation-delay: 0.5s">
            Gunakan akun yang sudah dibuat oleh sistem.
        </p>
    </form>

    <script>
        function togglePassword() {
            const input = document.getElementById("password");
            const icon  = document.getElementById("eye-icon");
            if (input.type === "password") {
                input.type = "text";
                icon.setAttribute("data-lucide", "eye-off");
            } else {
                input.type = "password";
                icon.setAttribute("data-lucide", "eye");
            }
            lucide.createIcons();
        }

        // Loading state on form submit
        document.getElementById('loginForm').addEventListener('submit', function() {
            const btn = document.getElementById('submitBtn');
            const btnText = document.getElementById('btnText');
            const icon = document.getElementById('loginIcon');
            
            btn.disabled = true;
            btn.style.cursor = 'not-allowed';
            btn.style.opacity = '0.8';
            btnText.textContent = 'Sedang masuk...';
            icon.setAttribute('data-lucide', 'loader-2');
            icon.classList.add('animate-spin');
            lucide.createIcons();
        });
    </script>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?><?php /**PATH C:\Users\xeean\Documents\Develover\sistem-perpustakaan\resources\views/auth/login.blade.php ENDPATH**/ ?>