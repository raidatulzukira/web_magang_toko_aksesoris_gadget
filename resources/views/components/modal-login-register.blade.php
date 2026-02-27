<div x-show="modalLogin" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;">
    <div x-show="modalLogin" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="modalLogin = false"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="modalLogin" x-transition:enter="ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-12 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-12 scale-95"
            class="relative w-full max-w-4xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row">

            <button @click="modalLogin = false"
                class="absolute top-6 right-6 z-10 w-10 h-10 bg-slate-100 hover:bg-red-100 hover:text-red-600 rounded-full flex items-center justify-center text-slate-500 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div class="hidden md:block w-1/2 relative bg-slate-100">
                <img src="{{ asset('images/login-bg.jpg') }}" alt="Login Cover"
                    class="absolute inset-0 w-full h-full object-cover">
                <div
                    class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent flex flex-col justify-end p-10 text-white">
                    <h3 class="text-3xl font-bold mb-2">Selamat Datang Kembali!</h3>
                    <p class="text-slate-200">Masuk untuk mengakses dasbor dan melihat status pesananmu.</p>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-white">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Masuk Akun</h2>
                <p class="text-slate-500 mb-8">Lanjutkan pengalaman belanjamu.</p>

                {{-- Notifikasi Sukses Daftar --}}
                @if (session('showLogin'))
                    <div
                        class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-2 rounded-xl mb-2 font-bold text-sm flex items-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        {{ session('showLogin') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-slate-50 border border-slate-300 px-5 py-3.5 rounded-2xl focus:ring-1 focus:ring-blue-700 focus:border-blue-800 transition-all text-slate-700"
                            placeholder="customer@gmail.com">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                        <input type="password" name="password" required
                            class="w-full bg-slate-50 border border-slate-300 px-5 py-3.5 rounded-2xl focus:ring-1 focus:ring-blue-700 focus:border-blue-800 transition-all text-slate-700"
                            placeholder="••••••••">

                        {{-- Penampil Error Login --}}
                        @if ($errors->any() && !$errors->has('name') && !old('name'))
                            <p class="text-red-500 text-xs font-bold mt-2 flex items-center gap-1">
                                <span>⚠️</span> Email atau Password salah.
                            </p>
                        @endif
                    </div>

                    {{-- Tampilkan Error Login (Kombinasi Email/Password Salah) --}}
                    {{-- @error('email')
                            @if (!request()->routeIs('register'))
                                <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                            @endif
                        @enderror --}}
            {{-- </div> --}}

            <div class="flex items-center justify-between text-sm">
                <label class="flex items-center gap-2 cursor-pointer text-slate-600">
                    <input type="checkbox" name="remember"
                        class="rounded border-slate-300 text-blue-600 focus:ring-blue-600">
                    Ingat Saya
                </label>
                @if (Route::has('password.request'))
                    <a href="{{ route('password.request') }}" class="text-blue-600 hover:underline font-medium">Lupa
                        Password?</a>
                @endif
            </div>

            <button type="submit"
                class="w-full bg-slate-600 hover:bg-slate-700 text-white font-bold py-4 rounded-2xl transition-colors shadow-lg shadow-slate-200">
                Masuk Sekarang
            </button>
            </form>

            <p class="text-center text-sm text-slate-500 mt-8">
                Belum punya akun? <button @click="modalLogin = false; setTimeout(() => modalRegister = true, 300)"
                    class="text-blue-600 font-bold hover:underline">DAFTAR DISINI</button>
            </p>
        </div>
    </div>
</div>
</div>


<div x-show="modalRegister" class="fixed inset-0 z-[100] overflow-y-auto" style="display: none;">
    <div x-show="modalRegister" x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0"
        x-transition:enter-end="opacity-100" x-transition:leave="ease-in duration-200"
        x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
        class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm" @click="modalRegister = false"></div>

    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="modalRegister" x-transition:enter="ease-out duration-500"
            x-transition:enter-start="opacity-0 translate-y-12 scale-95"
            x-transition:enter-end="opacity-100 translate-y-0 scale-100" x-transition:leave="ease-in duration-200"
            x-transition:leave-start="opacity-100 translate-y-0 scale-100"
            x-transition:leave-end="opacity-0 translate-y-12 scale-95"
            class="relative w-full max-w-4xl bg-white rounded-[2.5rem] shadow-2xl overflow-hidden flex flex-col md:flex-row-reverse">

            <button @click="modalRegister = false"
                class="absolute top-6 right-6 z-10 w-10 h-10 bg-white/50 backdrop-blur hover:bg-red-100 hover:text-red-600 rounded-full flex items-center justify-center text-slate-700 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>

            <div class="hidden md:block w-1/2 relative bg-slate-100">
                <img src="{{ asset('images/register-bg.jpg') }}" alt="Register Cover"
                    class="absolute inset-0 w-full h-full object-cover">
                <div
                    class="absolute inset-0 bg-gradient-to-t from-slate-900/80 to-transparent flex flex-col justify-end p-10 text-white">
                    <h3 class="text-3xl font-bold mb-2">Mulai Perjalananmu.</h3>
                    <p class="text-slate-200">Bergabunglah dan dapatkan penawaran khusus untuk member baru.</p>
                </div>
            </div>

            <div class="w-full md:w-1/2 p-8 md:p-12 flex flex-col justify-center bg-slate-50/50">
                <h2 class="text-3xl font-extrabold text-slate-900 mb-2">Buat Akun Baru</h2>
                <p class="text-slate-500 mb-8">Lengkapi data diri di bawah ini.</p>

                <form method="POST" action="{{ route('register') }}" class="space-y-4">
                    @csrf

                    {{-- <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama
                            Lengkap</label>
                        <input type="text" name="name" required
                            class="w-full bg-white border border-slate-300 px-5 py-3 rounded-2xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-slate-700"
                            placeholder="Cth: Budi Santoso">
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" required
                            class="w-full bg-white border border-slate-300 px-5 py-3 rounded-2xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-slate-700"
                            placeholder="nama@email.com">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full bg-white border border-slate-300 px-5 py-3 rounded-2xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-slate-700">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full bg-white border border-slate-300 px-5 py-3 rounded-2xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-slate-700">
                        </div>
                    </div> --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama
                            Lengkap</label>
                        <input type="text" name="name" value="{{ old('name') }}" required
                            class="w-full bg-white border border-slate-300 px-5 py-3 rounded-2xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-slate-700"
                            placeholder="Cth: Budi Santoso">
                        @error('name')
                            <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <div>
                        <label
                            class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email</label>
                        <input type="email" name="email" value="{{ old('email') }}" required
                            class="w-full bg-white border border-slate-300 px-5 py-3 rounded-2xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-slate-700"
                            placeholder="nama@email.com">
                        @if ($errors->has('email') && (old('name') || $errors->has('name')))
                            <p class="text-red-500 text-xs font-bold mt-1">{{ $errors->first('email') }}</p>
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password</label>
                            <input type="password" name="password" required
                                class="w-full bg-white border border-slate-300 px-5 py-3 rounded-2xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-slate-700">
                        </div>
                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi</label>
                            <input type="password" name="password_confirmation" required
                                class="w-full bg-white border border-slate-300 px-5 py-3 rounded-2xl focus:ring-1 focus:ring-blue-600 focus:border-blue-600 text-slate-700">
                        </div>
                    </div>
                    @error('password')
                        <p class="text-red-500 text-xs font-bold -mt-2">{{ $message }}</p>
                    @enderror
                    {{-- Tampilkan Error Password/Email saat Register --}}
                    {{-- @error('password')
                        <p class="text-red-500 text-xs font-bold -mt-2">{{ $message }}</p>
                    @enderror
                    @error('email')
                        @if (request()->routeIs('register'))
                            <p class="text-red-500 text-xs font-bold -mt-2">{{ $message }}</p>
                        @endif
                    @enderror --}}

                    <button type="submit"
                        class="w-full bg-slate-600 hover:bg-slate-700 text-white font-bold py-4 rounded-2xl transition-colors shadow-lg shadow-teal-500/30 mt-4">
                        Daftar Sekarang
                    </button>
                </form>

                <p class="text-center text-sm text-slate-500 mt-6">
                    Sudah punya akun? <button @click="modalRegister = false; setTimeout(() => modalLogin = true, 300)"
                        class="text-blue-600 font-bold hover:underline">MASUK DISINI</button>
                </p>
            </div>
        </div>
    </div>
</div>
