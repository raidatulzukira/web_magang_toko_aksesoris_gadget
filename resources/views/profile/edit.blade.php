@extends('layouts.front')
@section('title', 'Pengaturan Akun - GadgetStore')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">

    {{-- Header --}}
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('dashboard') }}" class="w-12 h-12 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-600 hover:shadow-md transition-all">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="font-display text-3xl font-extrabold text-slate-900">Pengaturan Akun</h1>
            <p class="text-slate-500 text-sm mt-1">Kelola informasi pribadi dan keamanan akunmu.</p>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ── KOLOM KIRI (Profil Singkat & Zona Bahaya) ── --}}
        <div class="lg:col-span-1 space-y-8">
            {{-- Kartu Profil --}}
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 text-center relative overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-br from-blue-600 to-indigo-800"></div>
                <div class="relative w-32 h-32 mx-auto mb-4 mt-12 z-10">
                    <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=ffffff&color=0D8ABC&size=200"
                         class="rounded-full border-4 border-white shadow-xl w-full h-full object-cover bg-white">
                </div>
                <div class="px-6 pb-8">
                    <h3 class="font-display font-black text-2xl text-slate-900">{{ auth()->user()->name }}</h3>
                    <p class="text-slate-500 font-medium mb-5">{{ auth()->user()->email }}</p>
                    <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-amber-50 border border-amber-200 text-amber-600 text-[10px] font-black tracking-widest uppercase rounded-full shadow-sm">
                        👑 Member Aktif
                    </span>
                </div>
            </div>

            {{-- Zona Bahaya --}}
            <div class="bg-red-50 rounded-[2rem] p-8 border border-red-100">
                <h3 class="font-bold text-red-700 text-lg mb-2 flex items-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                    Zona Bahaya
                </h3>
                <p class="text-red-600/80 text-sm mb-6 leading-relaxed">Sekali akun dihapus, semua data pesanan dan riwayat tidak dapat dikembalikan lagi.</p>

                {{-- Tombol Buka Modal Hapus --}}
                <div x-data="{ confirmDelete: false }">
                    <button @click="confirmDelete = true" type="button" class="w-full bg-white border-2 border-red-200 text-red-600 hover:bg-red-600 hover:border-red-600 hover:text-white font-bold py-3.5 rounded-2xl transition-all shadow-sm">
                        Hapus Akun Permanen
                    </button>

                    {{-- Pop-Up Konfirmasi Hapus Akun --}}
                    <div x-show="confirmDelete" class="fixed inset-0 z-[100] flex items-center justify-center bg-slate-900/60 backdrop-blur-sm" style="display: none;" x-transition>
                        <div @click.away="confirmDelete = false" class="bg-white p-8 md:p-10 rounded-[2.5rem] max-w-md w-full shadow-2xl mx-4 relative">
                            <button @click="confirmDelete = false" class="absolute top-6 right-6 text-slate-400 hover:text-red-500"><svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg></button>
                            <h3 class="font-display font-black text-2xl text-slate-900 mb-2">Yakin Hapus Akun?</h3>
                            <p class="text-slate-500 text-sm mb-6">Masukkan password kamu untuk mengonfirmasi. Semua datamu akan dimusnahkan.</p>

                            <form method="post" action="{{ route('profile.destroy') }}">
                                @csrf @method('delete')
                                <input type="password" name="password" required placeholder="Masukkan passwordmu..." class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-red-500 focus:border-red-500 mb-4 transition-all">
                                @error('password', 'userDeletion')
                                    <p class="text-red-500 text-xs font-bold mb-4 -mt-2">{{ $message }}</p>
                                @enderror
                                <div class="flex gap-3">
                                    <button type="button" @click="confirmDelete = false" class="flex-1 bg-slate-100 hover:bg-slate-200 text-slate-700 font-bold py-3.5 rounded-2xl transition-colors">Batal</button>
                                    <button type="submit" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3.5 rounded-2xl transition-colors shadow-lg shadow-red-600/30">Ya, Hapus!</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- ── KOLOM KANAN (Formulir Update) ── --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Update Profil --}}
            <div class="bg-white rounded-[2rem] p-8 md:p-10 shadow-sm border border-slate-100">
                <div class="flex justify-between items-start mb-8">
                    <h3 class="font-display font-bold text-2xl text-slate-900 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center text-xl shadow-inner border border-blue-100">👤</div>
                        Informasi Pribadi
                    </h3>
                    @if (session('status') === 'profile-updated')
                        <span x-data="{ show: true }" x-show="show" x-transition.duration.500ms x-init="setTimeout(() => show = false, 3000)" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-lg border border-emerald-100">
                            ✅ Berhasil disimpan
                        </span>
                    @endif
                </div>

                <form method="post" action="{{ route('profile.update') }}" class="space-y-6">
                    @csrf @method('patch')
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', auth()->user()->name) }}" required class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all font-bold text-slate-700">
                            @error('name') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Alamat Email</label>
                            <input type="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all font-bold text-slate-700">
                            @error('email') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                    </div>
                    <div class="text-right pt-4">
                        <button type="submit" class="w-full md:w-auto bg-slate-900 hover:bg-blue-600 text-white font-bold py-3.5 px-8 rounded-2xl transition-all shadow-lg shadow-slate-900/20 hover:-translate-y-1">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>
            </div>

            {{-- Update Password --}}
            <div class="bg-white rounded-[2rem] p-8 md:p-10 shadow-sm border border-slate-100">
                <div class="flex justify-between items-start mb-8">
                    <h3 class="font-display font-bold text-2xl text-slate-900 flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-600 flex items-center justify-center text-xl shadow-inner border border-slate-200">🔒</div>
                        Keamanan Akun
                    </h3>
                    @if (session('status') === 'password-updated')
                        <span x-data="{ show: true }" x-show="show" x-transition.duration.500ms x-init="setTimeout(() => show = false, 3000)" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-50 text-emerald-600 text-xs font-bold rounded-lg border border-emerald-100">
                            ✅ Password diperbarui
                        </span>
                    @endif
                </div>

                <form method="post" action="{{ route('password.update') }}" class="space-y-6">
                    @csrf @method('put')
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Saat Ini</label>
                        <input type="password" name="current_password" placeholder="••••••••" class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all font-bold text-slate-700">
                        @error('current_password', 'updatePassword') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Password Baru</label>
                            <input type="password" name="password" placeholder="Minimal 8 karakter" class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all font-bold text-slate-700">
                            @error('password', 'updatePassword') <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p> @enderror
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Konfirmasi Password Baru</label>
                            <input type="password" name="password_confirmation" placeholder="Ulangi password baru" class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 focus:border-blue-600 transition-all font-bold text-slate-700">
                        </div>
                    </div>

                    <div class="text-right pt-4 border-t border-slate-100">
                        <button type="submit" class="w-full md:w-auto bg-white border-2 border-slate-200 hover:border-blue-600 hover:text-blue-600 text-slate-600 font-bold py-3 px-8 rounded-2xl transition-all shadow-sm">
                            Perbarui Password
                        </button>
                    </div>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection
