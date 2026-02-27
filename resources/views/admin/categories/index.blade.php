@extends('layouts.admin')
@section('title', 'Manajemen Kategori')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="font-display text-3xl font-extrabold text-slate-900">Kategori Produk</h1>
        <p class="text-slate-500 mt-1">Kelompokkan produkmu agar lebih mudah dicari pelanggan.</p>
    </div>
    <a href="{{ route('admin.categories.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition-colors shadow-lg shadow-blue-500/30 flex items-center gap-2">
        + Tambah Kategori
    </a>
</div>

@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl mb-6 font-bold flex items-center gap-3">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 font-bold flex items-center gap-3">❌ {{ session('error') }}</div>
@endif

<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <table class="w-full text-left border-collapse">
        <thead>
            <tr class="bg-slate-50/50 border-b border-slate-100 text-xs uppercase tracking-widest text-slate-400 font-bold">
                <th class="p-6">Ikon & Nama Kategori</th>
                <th class="p-6">URL Slug</th>
                <th class="p-6 text-center">Jumlah Produk</th>
                <th class="p-6 text-right">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-slate-100 text-sm">
            @forelse($categories as $category)
                <tr class="hover:bg-slate-50/50 transition-colors">
                    <td class="p-6 flex items-center gap-4">
                        <div class="w-12 h-12 bg-blue-50 text-blue-600 rounded-xl flex items-center justify-center text-2xl shadow-inner border border-blue-100">
                            {{ $category->icon ?? '📦' }}
                        </div>
                        <p class="font-bold text-slate-900 text-base">{{ $category->name }}</p>
                    </td>
                    <td class="p-6 text-slate-500 font-mono text-xs">{{ $category->slug }}</td>
                    <td class="p-6 text-center">
                        <span class="px-3 py-1 bg-slate-100 text-slate-700 font-black rounded-lg">{{ $category->products_count }}</span>
                    </td>
                    <td class="p-6 text-right flex justify-end gap-2">
                        <a href="{{ route('admin.categories.edit', $category->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-500 hover:text-white transition-colors">✏️</a>
                        <form action="{{ route('admin.categories.destroy', $category->id) }}" method="POST" onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-colors">🗑️</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="4" class="p-10 text-center text-slate-500">Belum ada kategori yang ditambahkan.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
