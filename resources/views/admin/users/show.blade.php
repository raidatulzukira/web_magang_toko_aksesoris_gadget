@extends('layouts.admin')
@section('title', 'Detail User - ' . $user->name)

@section('content')
<div class="max-w-5xl mx-auto">

    {{-- Header --}}
    <div class="mb-8 flex items-center justify-between">
        <div class="flex items-center gap-4">
            <a href="{{ route('admin.users.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-600 transition-colors shadow-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
            </a>
            <h1 class="font-display text-2xl font-extrabold text-slate-900">Detail Pengguna</h1>
        </div>

        <div class="flex gap-2">
            <a href="{{ route('admin.users.edit', $user->id) }}" class="px-5 py-2.5 bg-amber-50 text-amber-600 hover:bg-amber-500 hover:text-white rounded-xl font-bold text-sm transition-colors shadow-sm flex items-center gap-2">
                ✏️ Edit Data
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: ID Card Profile --}}
        <div class="md:col-span-1">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 text-center relative overflow-hidden">
                <div class="absolute top-0 inset-x-0 h-32 bg-gradient-to-br from-slate-800 to-slate-900"></div>

                <div class="relative z-10 mt-6">
                    <div class="w-32 h-32 mx-auto bg-white rounded-full p-1.5 shadow-xl mb-6">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff&size=200"
                             class="w-full h-full rounded-full object-cover">
                    </div>

                    <h2 class="font-black text-2xl text-slate-900 mb-1">{{ $user->name }}</h2>
                    <p class="text-slate-500 font-medium mb-6">{{ $user->email }}</p>

                    @if($user->role === 'admin')
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-purple-100 border border-purple-200 text-purple-700 text-xs font-black tracking-widest uppercase rounded-full shadow-sm">
                            🛡️ Administrator
                        </span>
                    @else
                        <span class="inline-flex items-center gap-1.5 px-4 py-2 bg-slate-100 border border-slate-200 text-slate-600 text-xs font-black tracking-widest uppercase rounded-full shadow-sm">
                            👤 Customer
                        </span>
                    @endif
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Informasi Sistem & Log --}}
        <div class="md:col-span-2 space-y-6">

            {{-- Kartu Info Pendaftaran --}}
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
                <h3 class="font-bold text-slate-900 text-lg mb-6 flex items-center gap-2 border-b border-slate-100 pb-4">
                    <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                    Informasi Akun
                </h3>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Tanggal Bergabung</p>
                        <p class="font-bold text-slate-800">{{ $user->created_at->format('d F Y, H:i') }} WIB</p>
                        <p class="text-xs text-slate-500 mt-1">{{ $user->created_at->diffForHumans() }}</p>
                    </div>
                    <div>
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-1.5">Pembaruan Terakhir</p>
                        <p class="font-bold text-slate-800">{{ $user->updated_at->format('d F Y, H:i') }} WIB</p>
                    </div>
                </div>

                {{-- Status Pendaftaran (Daftar Sendiri vs Admin) --}}
                <div class="mt-8 pt-6 border-t border-slate-100">
                    <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3">Sumber Pendaftaran Akun</p>

                    @if($user->created_by)
                        <div class="flex items-center gap-4 bg-blue-50/50 p-4 rounded-2xl border border-blue-100">
                            <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-lg">
                                👨‍💻
                            </div>
                            <div>
                                <p class="text-sm text-slate-600">Didaftarkan secara manual oleh Admin:</p>
                                <p class="font-bold text-blue-700">{{ $user->creator->name ?? 'Admin (Dihapus)' }}</p>
                            </div>
                        </div>
                    @else
                        <div class="flex items-center gap-4 bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100">
                            <div class="w-10 h-10 bg-emerald-100 text-emerald-600 rounded-full flex items-center justify-center text-lg">
                                🌐
                            </div>
                            <div>
                                <p class="text-sm text-slate-600">Akun ini terdaftar melalui:</p>
                                <p class="font-bold text-emerald-700">Registrasi Mandiri (Sistem Web)</p>
                            </div>
                        </div>
                    @endif
                </div>

                {{-- Riwayat Perubahan Role (Hanya Muncul Jika Pernah Diubah) --}}
                @if($user->role_changed_by)
                    <div class="mt-8 pt-6 border-t border-slate-100">
                        <p class="text-[11px] font-bold text-slate-400 uppercase tracking-widest mb-3 flex items-center gap-2">
                            <span class="w-2 h-2 rounded-full bg-amber-500 animate-pulse"></span>
                            Riwayat Perubahan Akses
                        </p>

                        <div class="flex items-start gap-4 bg-amber-50/50 p-4 rounded-2xl border border-amber-100 relative overflow-hidden">
                            <div class="absolute right-0 top-0 w-24 h-24 bg-amber-500 rounded-full mix-blend-multiply filter blur-3xl opacity-10"></div>

                            <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-full flex items-center justify-center text-lg shrink-0 relative z-10">
                                🔄
                            </div>
                            <div class="relative z-10">
                                <p class="text-sm text-slate-600 leading-relaxed">
                                    Hak akses akun ini telah diubah dari <span class="font-bold text-slate-800 uppercase text-xs tracking-wider bg-white px-2 py-0.5 rounded shadow-sm">{{ $user->previous_role }}</span> menjadi <span class="font-bold text-amber-700 uppercase text-xs tracking-wider bg-white px-2 py-0.5 rounded shadow-sm">{{ $user->role }}</span>.
                                </p>
                                <div class="mt-3 flex flex-wrap gap-x-4 gap-y-1 text-xs text-slate-500">
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                                        Oleh: <strong class="text-slate-700">{{ $user->roleChanger->name ?? 'Admin (Dihapus)' }}</strong>
                                    </span>
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                        Pada: <strong class="text-slate-700">{{ \Carbon\Carbon::parse($user->role_changed_at)->format('d M Y, H:i') }}</strong>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>

        </div>

    </div>
</div>
@endsection
