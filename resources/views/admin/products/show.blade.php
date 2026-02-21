@extends('layouts.admin')

@section('title', 'Detail Produk: ' . $product->name)

@section('content')
<div class="max-w-4xl mx-auto transition-all duration-500 transform opacity-0 translate-y-4 bg-white rounded-xl shadow-md border border-slate-300 p-6 mt-6 mb-6"

     x-data="{ loaded: false }"
     x-init="setTimeout(() => loaded = true, 100)"
     :class="loaded ? '!opacity-100 !translate-y-0' : ''">

    <div class="mb-6 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
        <div>
            <div class="flex items-center gap-2 text-sm text-slate-500 mb-1">
                <a href="{{ route('admin.products.index') }}" class="hover:text-blue-600 font-medium transition-colors">Produk</a>
                <span>/</span>
                <span class="font-medium">Detail</span>
            </div>
            <h1 class="text-2xl md:text-3xl font-extrabold text-slate-900 flex items-center gap-3">
                {{ $product->name }}
                <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold {{ $product->stock > 5 ? 'bg-emerald-100 text-emerald-700' : 'bg-red-100 text-red-700' }}">
                    {{ $product->stock > 5 ? 'Stok Aman' : 'Stok Menipis' }}
                </span>
            </h1>
        </div>

        <div class="flex items-center gap-3 shrink-0">
            <a href="{{ route('admin.products.edit', $product->id) }}" class="inline-flex items-center gap-2 bg-white border border-slate-300 text-slate-700 hover:border-blue-500 hover:text-blue-600 hover:bg-blue-50 px-5 py-2.5 rounded-xl font-bold text-sm transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg>
                Edit Produk
            </a>
            <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus produk ini secara permanen?');">
                @csrf @method('DELETE')
                <button type="submit" class="inline-flex items-center gap-2 bg-red-50 border border-red-100 text-red-600 hover:bg-red-500 hover:text-white px-5 py-2.5 rounded-xl font-bold text-sm transition-all shadow-sm">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                    Hapus
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-md border border-slate-300 overflow-hidden grid grid-cols-12">


        <div class="col-span-12 lg:col-span-5 bg-slate-50 border-b lg:border-b-0 lg:border-r border-slate-200 p-8 flex items-center justify-center relative">

            <div class="absolute inset-0 bg-grid-slate-100 [mask-image:linear-gradient(0deg,#fff,rgba(255,255,255,0.6))]"></div>

            <div class="relative w-full max-w-sm mx-auto rounded-2xl overflow-hidden shadow-md border border-slate-200 bg-white p-2 z-10">
                <div class="h-[400px] relative rounded-lg overflow-hidden bg-slate-200">

                    <img src="{{ $product->image }}" alt="{{ $product->name }}" class="absolute inset-0 w-full h-full object-cover hover:scale-110 transition-transform duration-700">
                </div>
                 <div class="absolute top-4 left-4 bg-slate-900/80 backdrop-blur text-white text-[10px] font-bold px-3 py-1.5 rounded-lg tracking-wider shadow-sm">
                    #PROD-{{ $product->id }}
                </div>
            </div>
        </div>

        <div class="col-span-12 lg:col-span-7 p-6 md:p-10 space-y-8">

            <div class="bg-blue-50 rounded-xl p-5 border border-blue-200 flex flex-wrap items-center justify-between gap-6 shadow-sm">

                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Harga Jual</label>
                    <div class="text-3xl font-extrabold text-blue-700">

                        <span class="text-xl font-bold text-blue-400 mr-1">Rp</span>{{ number_format($product->price, 0, ',', '.') }}
                    </div>
                </div>
                <div class="h-16 w-px bg-slate-200 hidden sm:block"></div>
                <div>
                    <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Stok Tersedia</label>
                    <div class="flex items-center gap-3 font-black text-2xl">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold shadow-sm
{{ $product->stock > 5 ? 'bg-emerald-500 text-white' : 'bg-red-500 text-white' }}">


                            {{ $product->stock }}
                        </span>
                        <span class="text-base font-bold text-slate-400">Unit</span>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8 border-t border-slate-100 pt-8">
                <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"></path></svg>
                        Varian / Tipe
                    </h3>
                    @if($product->variants)
                        <div class="flex flex-wrap gap-2">
                            @foreach(explode(',', $product->variants) as $variant)
                                <span class="inline-block bg-white border border-slate-200 text-slate-700 text-sm px-4 py-2 rounded-xl font-bold shadow-sm hover:border-blue-400 hover:text-blue-600 transition-colors cursor-default">
                                    {{ trim($variant) }}
                                </span>
                            @endforeach
                        </div>
                    @else
                        <span class="inline-block bg-slate-100 text-slate-500 px-4 py-2 rounded-xl text-sm font-medium italic">
                            Produk Universal
                        </span>
                    @endif
                </div>

                 <div>
                    <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                        <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                        Riwayat Data
                    </h3>
                    <div class="space-y-3 text-sm text-slate-500 bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <div class="flex justify-between items-center text-xs">
                            <span>Ditambahkan:</span>
                            <span class="font-bold text-slate-800">{{ $product->created_at->format('d M Y') }}</span>
                        </div>
                        <div class="flex justify-between items-center border-t border-slate-200 pt-2 text-xs">
                            <span>Update Terakhir:</span>
                            <span class="font-bold text-slate-800">{{ $product->updated_at->format('d M Y') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-slate-100 pt-8">
                <h3 class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-4 flex items-center gap-2">
                    <svg class="w-4 h-4 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16m-7 6h7"></path></svg>
                    Deskripsi Lengkap
                </h3>
                <div class="bg-slate-100 rounded-xl p-5 text-slate-700 leading-relaxed text-sm whitespace-pre-line border border-slate-200">

                    {{ $product->description ?: 'Tidak ada deskripsi yang ditambahkan untuk produk ini.' }}
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
