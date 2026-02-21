@extends('layouts.front')

@section('title', 'Katalog Semua Produk - GadgetStore')

@section('content')
    {{-- <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10"> --}}
    <div class="py-0 md:py-20 relative overflow-hidden">
        <div class="absolute inset-0 bg-grid-slate-800/[0.2] bg-[size:20px_20px]"></div>
        <div class="absolute top-0 right-0 -translate-y-12 translate-x-1/3">
            <div class="w-96 h-96 rounded-full blur-3xl"></div>
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 text-center" x-data="{ loaded: false }"
            x-init="setTimeout(() => loaded = true, 100)">
            <h1 class="font-display text-4xl md:text-5xl font-extrabold text-slate-700 mb-6 opacity-0 translate-y-6 transition-all duration-700"
                :class="loaded ? '!opacity-100 !translate-y-0' : ''">
                Eksplorasi Semua <span
                    class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-300">Produk</span>
            </h1>
            <p class="text-slate-400 text-lg max-w-2xl mx-auto opacity-0 translate-y-6 transition-all duration-700 delay-100"
                :class="loaded ? '!opacity-100 !translate-y-0' : ''">
                Temukan aksesoris gadget impianmu. Dari casing pelindung, kabel fast charging, hingga TWS premium dengan
                kualitas terjamin.
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 ml-10 mr-10">

        <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-3">
                <span class="font-heading text-sm font-bold text-slate-500 uppercase tracking-wider">Urutkan:</span>

                {{-- Jika kamu punya fitur pencarian (search), ini akan menjaga agar kata kunci tidak hilang saat diurutkan --}}
                @if (request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                {{-- Atribut onchange="this.form.submit()" akan langsung memuat ulang halaman saat opsi dipilih --}}
                <select name="sort" onchange="this.form.submit()"
                    class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 font-medium outline-none cursor-pointer hover:border-blue-300 transition-colors">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                </select>
            </form>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8 mb-12">
            @forelse($products as $product)
                <div
                    class="bg-white/90 backdrop-blur-sm border border-slate-400/60
                rounded-3xl overflow-hidden flex flex-col group
                shadow-lg shadow-slate-800/20
                hover:-translate-y-3 hover:shadow-2xl hover:shadow-slate-900/40
                transition-all duration-500 ease-out">

                    {{-- Image Area --}}
                    <div class="h-56 relative bg-slate-100 overflow-hidden">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}"
                            class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-110">

                        {{-- Gradient Overlay --}}
                        <div class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent">
                        </div>

                        {{-- Stock Badge --}}
                        <div
                            class="absolute top-4 right-4 bg-white/90 backdrop-blur px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-md">
                            <span
                                class="w-2 h-2 rounded-full {{ $product->stock > 5 ? 'bg-teal-500' : 'bg-amber-500' }}"></span>
                            <span class="text-slate-700 text-[11px] font-bold">
                                Sisa {{ $product->stock }}
                            </span>
                        </div>

                        {{-- Category --}}
                        <div class="absolute bottom-4 left-4">
                            <span
                                class="bg-blue-700 text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-md">
                                Gadget
                            </span>
                        </div>
                    </div>

                    {{-- Content Area --}}
                    <div class="p-6 flex flex-col flex-grow">

                        {{-- Title --}}
                        <h3
                            class="font-bold text-slate-900 text-base leading-tight line-clamp-1 mb-2 transition-all duration-300 group-hover:text-blue-700">
                            {{ $product->name }}
                        </h3>

                        {{-- Description --}}
                        <p class="text-slate-600 text-sm leading-relaxed line-clamp-2 flex-grow">
                            {{ $product->description }}
                        </p>

                        {{-- Price --}}
                        <div class="mt-4">
                            <p class="font-heading text-slate-400 text-xs uppercase tracking-wider mb-1">
                                Harga
                            </p>
                            <p class="font-extrabold text-slate-900 text-xl tracking-tight">
                                Rp {{ number_format($product->price, 0, ',', '.') }}
                            </p>
                        </div>

                        {{-- Button --}}
                        <a href="{{ route('front.product.show', $product->id) }}"
                            class="mt-5 block w-full text-center py-3 rounded-2xl
                      bg-[#19284C]/90 text-white font-bold text-sm tracking-wide
                      shadow-md shadow-[#19284C]/20
                      hover:bg-[#19284C] hover:shadow-lg hover:shadow-[#19284C]/30
                      active:scale-95
                      transition-all duration-300">
                            Detail →
                        </a>

                    </div>
                </div>
            @empty
                <div
                    class="col-span-full py-20 text-center bg-slate-50 rounded-[3rem] border-2 border-dashed border-slate-200">
                    <div class="text-6xl mb-4">📦</div>
                    <h3 class="font-display text-2xl font-bold text-slate-800 mb-2">Belum Ada Produk</h3>
                    <p class="text-slate-500">Admin belum menambahkan produk apapun ke dalam katalog.</p>
                </div>
            @endforelse
        </div>

        <div class="mt-8 flex justify-center">
            {{ $products->links() }}
        </div>

    </div>
@endsection
