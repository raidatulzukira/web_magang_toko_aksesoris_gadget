@extends('layouts.admin')
@section('title', 'Tambah Kategori')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.categories.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors">←</a>
        <h1 class="font-display text-2xl font-extrabold text-slate-900">Tambah Kategori Baru</h1>
    </div>

    <form action="{{ route('admin.categories.store') }}" method="POST" class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 space-y-6">
        @csrf
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Ikon (Emoji)</label>
            <input type="text" name="icon" placeholder="Contoh: 🛡️ atau ⚡" class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 outline-none text-xl">
            <p class="text-xs text-slate-400 mt-2">Gunakan Emoji Windows (Tombol `Win` + `.`) atau copy-paste dari internet.</p>
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Kategori</label>
            <input type="text" name="name" required placeholder="Contoh: Casing & Pelindung" class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 outline-none font-bold text-slate-700">
            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg mt-4">Simpan Kategori</button>
    </form>
</div>
@endsection
