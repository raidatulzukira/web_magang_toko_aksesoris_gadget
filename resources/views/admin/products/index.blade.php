@extends('layouts.admin')

@section('title', 'Manajemen Produk')

@section('content')
    <div class="mb-8 flex justify-between items-center m-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-900">Data Produk</h1>
            <p class="text-slate-500 mt-1">Kelola stok dan harga aksesoris gadget kamu.</p>
        </div>
        <a href="{{ route('admin.products.create') }}"
            class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-2xl font-bold transition-all shadow-lg shadow-blue-200 flex items-center gap-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Produk
        </a>
    </div>

    <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 overflow-hidden m-8">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-8 py-5 font-bold">Produk</th>
                        <th class="px-6 py-5 font-bold">Varian Tipe</th>
                        <th class="px-6 py-5 font-bold">Harga</th>
                        <th class="px-6 py-5 font-bold text-center">Stok</th>
                        <th class="px-8 py-5 font-bold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @foreach ($products as $product)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="px-8 py-5">
                                <div class="flex items-center gap-4">
                                    <img src="{{ $product->image }}" class="w-14 h-14 rounded-2xl object-cover shadow-sm"
                                        alt="">
                                    <div>
                                        <p class="font-bold text-slate-900 text-base">{{ $product->name }}</p>
                                        <p class="text-slate-400 text-xs">ID: #PROD-{{ $product->id }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-5">
                                <span class="text-slate-600">
                                    {{ $product->variants ?? 'Universal (Tanpa Varian)' }}
                                </span>
                            </td>
                            <td class="px-6 py-5 font-bold text-slate-900 text-base text-sm">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </td>
                            <td class="px-6 py-5 text-center">
                                <span
                                    class="px-3 py-1 rounded-full font-bold {{ $product->stock <= 5 ? 'bg-red-100 text-red-600' : 'bg-blue-100 text-blue-600' }}">
                                    {{ $product->stock }} Pcs
                                </span>
                            </td>
                            <td class="px-8 py-5 text-center">
                                <div class="flex justify-center gap-2">
                                    <a href="{{ route('admin.products.show', $product->id) }}"
                                        class="p-2 text-slate-400 hover:text-blue-500 transition-colors"
                                        title="Lihat Detail">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                            </path>
                                        </svg>
                                    </a>

                                    <a href="{{ route('admin.products.edit', $product->id) }}"
                                        class="p-2 text-slate-400 hover:text-amber-500 transition-colors" title="Edit">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M11 5H6a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-5M16.5 3.5a2.121 2.121 0 013 3L7 19l-4 1 1-4L16.5 3.5z">
                                            </path>
                                        </svg>
                                    </a>

                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                                        onsubmit="return confirm('Hapus produk ini?')">
                                        @csrf @method('DELETE')
                                        <button class="p-2 text-slate-400 hover:text-red-500 transition-colors"
                                            title="Hapus">
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                </path>
                                            </svg>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
