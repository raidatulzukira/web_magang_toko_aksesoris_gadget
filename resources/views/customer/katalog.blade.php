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

            {{-- TOMBOL FILTER KATEGORI BERANIMASI --}}
            <div class="flex flex-wrap justify-center gap-3 md:gap-4 mt-10 opacity-0 translate-y-8 transition-all duration-700 delay-200"
                :class="loaded ? '!opacity-100 !translate-y-0' : ''">

                {{-- Tombol "Semua Produk" --}}
                <a href="{{ url('/katalog') }}"
                    class="{{ !request('category') ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/40 ring-4 ring-blue-500/20' : 'bg-white/60 backdrop-blur-md text-slate-600 border border-slate-200 hover:border-blue-400 hover:text-blue-600 hover:bg-white shadow-sm' }}
                    px-6 py-3 rounded-full text-sm font-bold transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-2 cursor-pointer relative overflow-hidden group">
                    <span class="relative z-10 flex items-center gap-2">🌟 Semua</span>
                    @if (!request('category'))
                        <div
                            class="absolute inset-0 bg-gradient-to-r from-blue-400/0 via-white/20 to-blue-400/0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]">
                        </div>
                    @endif
                </a>

                {{-- Looping Tombol Kategori Dinamis --}}
                @foreach ($categories as $category)
                    <a href="{{ url('/katalog?category=' . $category->slug) }}"
                        class="{{ request('category') == $category->slug ? 'bg-blue-600 text-white shadow-lg shadow-blue-500/40 ring-4 ring-blue-500/20' : 'bg-white/60 backdrop-blur-md text-slate-600 border border-slate-200 hover:border-blue-400 hover:text-blue-600 hover:bg-white shadow-sm' }}
                        px-6 py-3 rounded-full text-sm font-bold transition-all duration-300 transform hover:-translate-y-1 flex items-center gap-2 cursor-pointer relative overflow-hidden group">
                        <span class="relative z-10 flex items-center gap-2">{{ $category->icon }}
                            {{ $category->name }}</span>
                        @if (request('category') == $category->slug)
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-400/0 via-white/20 to-blue-400/0 -translate-x-full group-hover:animate-[shimmer_1.5s_infinite]">
                            </div>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-6 ml-10 mr-10">

        {{-- <div class="flex flex-col md:flex-row justify-between items-center mb-10 gap-4">
            <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-3">
                <span class="font-heading text-sm font-bold text-slate-500 uppercase tracking-wider">Urutkan:</span>

                {{-- Jika kamu punya fitur pencarian (search), ini akan menjaga agar kata kunci tidak hilang saat diurutkan --}
                @if (request('search'))
                    <input type="hidden" name="search" value="{{ request('search') }}">
                @endif

                {{-- Menjaga kategori agar tidak hilang saat di-sort --}
                @if (request('category'))
                    <input type="hidden" name="category" value="{{ request('category') }}">
                @endif

                {{-- Atribut onchange="this.form.submit()" akan langsung memuat ulang halaman saat opsi dipilih --}
                <select name="sort" onchange="this.form.submit()"
                    class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 font-medium outline-none cursor-pointer hover:border-blue-300 transition-colors">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                </select>
            </form>
        </div> --}}

        {{-- KONTROL PENCARIAN & PENGURUTAN --}}
        <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">

            {{-- KIRI: Dropdown Urutkan --}}
            <form action="{{ url()->current() }}" method="GET" class="flex items-center gap-3 w-full md:w-auto">
                <span class="font-heading text-sm font-bold text-slate-500 uppercase tracking-wider shrink-0">Urutkan:</span>

                {{-- Titip data search & category agar tidak hilang saat ganti sort --}}
                @if (request('search')) <input type="hidden" name="search" value="{{ request('search') }}"> @endif
                @if (request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif

                <select name="sort" onchange="this.form.submit()"
                    class="bg-slate-50 border border-slate-200 text-slate-700 text-sm rounded-xl focus:ring-blue-500 focus:border-blue-500 block p-2.5 font-medium outline-none cursor-pointer hover:border-blue-300 transition-colors w-full md:w-auto shadow-sm">
                    <option value="terbaru" {{ request('sort') == 'terbaru' ? 'selected' : '' }}>Terbaru</option>
                    <option value="termurah" {{ request('sort') == 'termurah' ? 'selected' : '' }}>Harga Termurah</option>
                    <option value="termahal" {{ request('sort') == 'termahal' ? 'selected' : '' }}>Harga Termahal</option>
                </select>
            </form>

            {{-- KANAN: Search Bar --}}
            <form action="{{ url()->current() }}" method="GET" class="w-full md:w-80 relative">
                {{-- Titip data sort & category agar tidak hilang saat mencari --}}
                @if (request('sort')) <input type="hidden" name="sort" value="{{ request('sort') }}"> @endif
                @if (request('category')) <input type="hidden" name="category" value="{{ request('category') }}"> @endif

                <div class="relative group">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama atau deskripsi..."
                        class="w-full bg-white border border-slate-200 text-slate-900 text-sm rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 block pl-5 pr-12 py-3 shadow-sm outline-none transition-all placeholder:text-slate-400 group-hover:border-blue-300">
                    <button type="submit" class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 hover:text-blue-600 transition-colors">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                    </button>
                </div>
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
                                class="bg-indigo-600/90 backdrop-blur-sm text-white text-[10px] font-bold px-3 py-1.5 rounded-full uppercase tracking-wider shadow-md flex items-center gap-1">
                                {{ $product->category->icon ?? '📦' }} {{ $product->category->name ?? 'No Categories' }}
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
                        <div class="mt-6">
                            {{-- <p class="font-heading text-slate-400 text-xs uppercase tracking-wider mb-1">
                                Harga
                            </p> --}}
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
