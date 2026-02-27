@extends('layouts.admin')
@section('title', 'Edit Kategori - ' . $category->name)

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:shadow-md transition-all">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        </a>
        <div>
            <h1 class="font-display text-2xl font-extrabold text-slate-900">Edit Kategori</h1>
            <p class="text-slate-500 text-sm mt-1">Ubah nama atau ikon untuk kategori <span class="font-bold text-slate-700">{{ $category->name }}</span></p>
        </div>
    </div>

    <form action="{{ route('admin.categories.update', $category->id) }}" method="POST" class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ikon (Emoji)</label>
            <div class="relative">
                <input type="text" name="icon" value="{{ old('icon', $category->icon) }}" placeholder="Contoh: 🛡️" class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 outline-none text-xl transition-all">
            </div>
            <p class="text-xs text-slate-400 mt-2 flex items-center gap-1">
                <span>💡</span> Gunakan tombol <kbd class="bg-slate-100 px-1 py-0.5 rounded border border-slate-300 font-mono text-[10px]">Win</kbd> + <kbd class="bg-slate-100 px-1 py-0.5 rounded border border-slate-300 font-mono text-[10px]">.</kbd> untuk membuka panel emoji.
            </p>
        </div>

        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Kategori</label>
            <input type="text" name="name" value="{{ old('name', $category->name) }}" required placeholder="Contoh: Casing & Pelindung" class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 outline-none font-bold text-slate-700 transition-all">
            @error('name')
                <p class="text-red-500 text-xs mt-2 font-bold flex items-center gap-1">
                    <span>⚠️</span> {{ $message }}
                </p>
            @enderror
        </div>

        <div class="pt-4 border-t border-slate-100 mt-8">
            <button type="submit" class="w-full bg-amber-500 hover:bg-amber-600 text-white font-bold py-4 rounded-2xl shadow-lg shadow-amber-500/30 transition-all hover:-translate-y-1">
                Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection
