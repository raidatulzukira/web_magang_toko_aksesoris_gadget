@extends('layouts.front')

@section('title', 'GadgetStore — Aksesoris Gadget Premium')

@section('content')

    {{-- ══════════════════════════════════════
     HERO SECTION (Tetap Dark Navy)
══════════════════════════════════════ --}}
    <section class="relative min-h-screen flex items-center pt-20 pb-4 overflow-hidden p-10">
        {{-- Grid pattern overlay --}}
        <div class="absolute inset-0 opacity-[0.025]"
            style="background-image: linear-gradient(rgba(255,255,255,0.3) 1px, transparent 1px), linear-gradient(90deg, rgba(255,255,255,0.3) 1px, transparent 1px); background-size: 60px 60px;">
        </div>

        {{-- Rotating decorative rings --}}
        <div class="ring-deco" style="width:700px;height:700px;top:50%;left:55%;transform:translate(-50%,-50%);"></div>
        <div class="ring-deco ring-deco-2" style="width:500px;height:500px;top:50%;left:55%;transform:translate(-50%,-50%);">
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">

                {{-- ── LEFT COPY ── --}}
                <div class="space-y-8">
                    <div class="anim-hero-badge">
                        <span
                            class="hero-badge inline-flex items-center gap-2 px-4 py-2 text-xs font-heading font-bold text-blue-400 tracking-widest uppercase">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-400"
                                style="animation: pulse-ring 2s ease-in-out infinite; display:inline-block;"></span>
                            Premium Gadget Accessories
                        </span>
                    </div>

                    <div class="anim-hero-h1 space-y-1">
                        <h1 class="font-display text-5xl md:text-6xl lg:text-7xl font-extrabold leading-[1.1] text-black">
                            TEMUKAN</h1>
                        <h1
                            class="font-display text-5xl md:text-6xl lg:text-7xl font-extrabold leading-[1.1] gradient-text">
                            AKSESORIS</h1>
                        <h1
                            class="font-display text-5xl md:text-6xl lg:text-7xl font-extrabold leading-[1.1] bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-500">
                            TERBAIK</h1>
                    </div>

                    <p class="anim-hero-p text-slate-400 text-base md:text-lg leading-relaxed max-w-md">
                        Nikmati kemudahan mencari perlengkapan gadget premium. Casing, kabel data, hingga TWS terbaik —
                        semuanya ada di sini.
                    </p>

                    <div class="anim-hero-cta flex flex-wrap gap-4 pt-2">
                        <a href="#produk"
                            class="btn-primary inline-flex items-center gap-3 text-white px-8 py-4 rounded-full text-sm font-heading font-bold tracking-wide">
                            <span>Belanja Sekarang</span>
                            <svg class="w-4 h-4 relative z-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                    d="M14 5l7 7m0 0l-7 7m7-7H3" />
                            </svg>
                        </a>
                        {{-- <a href="#" class="btn-secondary inline-flex items-center gap-3 text-white/60 hover:text-white px-8 py-4 rounded-full text-sm font-heading font-semibold tracking-wide">Lihat Promo</a> --}}
                    </div>

                    <div class="anim-hero-stats flex flex-wrap gap-3 pt-4">
                        <div class="stat-pill px-5 py-2.5 flex items-center gap-2.5">
                            <span class="font-heading font-extrabold text-black/70 text-lg">500+</span>
                            <span class="text-slate-500 text-xs">Produk</span>
                        </div>
                        <div class="stat-pill px-5 py-2.5 flex items-center gap-2.5">
                            <span class="font-heading font-extrabold text-black/70 text-lg">10k+</span>
                            <span class="text-slate-500 text-xs">Pelanggan</span>
                        </div>
                    </div>
                </div>

                {{-- ── RIGHT IMAGE GRID ── --}}
                <div class="anim-hero-img hero-img-grid hidden lg:grid grid-cols-2 grid-rows-3 gap-4 h-[580px]">
                    <div class="hero-img-card col-span-1 row-span-2" style="animation: float 6s ease-in-out infinite;">
                        <img src="https://i.pinimg.com/736x/4f/e2/b5/4fe2b5cb2640f5f10610f426595ee2ab.jpg"
                            alt="Gadget Setup">
                        <div class="img-overlay-text">
                            <p class="text-xs text-white/50 mb-0.5">Best Seller</p>
                            <p class="text-sm text-white">Gadget Setup</p>
                        </div>
                    </div>
                    <div class="hero-img-card col-span-1 row-span-1"
                        style="animation: float 5s ease-in-out infinite; animation-delay: -2s;">
                        <img src="https://images.unsplash.com/photo-1617350142147-7403b8fb9889?q=80&w=1974&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D"
                            alt="TWS Earbuds">
                        <div class="img-overlay-text">
                            <p class="text-sm text-white">TWS Premium</p>
                        </div>
                    </div>
                    <div class="hero-img-card col-span-1 row-span-1"
                        style="animation: float 7s ease-in-out infinite; animation-delay: -4s;">
                        <img src="https://i.pinimg.com/1200x/99/64/a2/9964a202c67115b1f40714082848c312.jpg"
                            alt="Charger Cable">
                        <div class="img-overlay-text">
                            <p class="text-sm text-white">Kabel Data</p>
                        </div>
                    </div>
                    <div class="hero-img-card col-span-2 row-span-1">
                        <img src="https://i.pinimg.com/736x/c7/7d/ac/c77dac446cf810d8b3771302be89d93f.jpg"
                            alt="Tech Lifestyle">
                        <div class="img-overlay-text">
                            <p class="text-sm text-white">Lifestyle Tech ✦</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- KOTAK PUTIH UNTUK KONTEN DI BAWAHNYA --}}
    <div class="relative z-20 pb-0 mr-10 ml-10">

        {{-- TICKER / MARQUEE --}}
        <div class="relative py-6 border-b border-slate-200 overflow-hidden">
            <div class="ticker-wrap">
                <div class="ticker-inner">
                    @php $items = ['✦ Casing Premium', '✦ Kabel Data Fast Charging', '✦ TWS Pro Series', '✦ Power Bank Ultra', '✦ Screen Protector', '✦ Wireless Charger', '✦ Pop Socket']; @endphp
                    @foreach (array_merge($items, $items) as $item)
                        <span
                            class="inline-flex items-center font-heading font-semibold text-sm text-slate-400 mx-8 hover:text-blue-600 transition-colors cursor-default">{{ $item }}</span>
                    @endforeach
                </div>
            </div>
        </div>

        {{-- PRODUCTS SECTION (Cerah) --}}
        <section id="produk" class="relative z-10 py-24">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

                <div class="flex flex-col md:flex-row md:items-end justify-between mb-14 gap-6">
                    <div class="space-y-4">
                        <div
                            class="inline-flex items-center gap-2 font-heading text-xs font-bold tracking-widest uppercase text-blue-600 px-4 py-2 bg-blue-100 rounded-full">
                            <span class="w-1.5 h-1.5 rounded-full bg-blue-600"
                                style="animation: pulse-ring 2s ease-in-out infinite;"></span>
                            Koleksi Kami
                        </div>
                        <h2 class="font-display text-4xl md:text-5xl font-extrabold text-slate-900 leading-none">
                            PRODUK<br>
                            <span
                                class="bg-clip-text text-transparent bg-gradient-to-r from-blue-600 to-indigo-500">TERBARU</span>
                        </h2>
                    </div>
                    <p class="text-slate-500 text-sm max-w-xs leading-relaxed md:text-right">
                        Temukan ratusan pilihan aksesoris gadget premium yang kami kurasi khusus untuk kamu.
                    </p>
                </div>

                <div class="h-px bg-gradient-to-r from-transparent via-slate-300 to-transparent mb-14"></div>

                {{-- Product Grid (Teks Gelap, Animasi Tetap) --}}
                {{-- Product Grid Premium Version --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-8">

                    @foreach ($products->sortByDesc('created_at')->take(4) as $product)
                        <div
                            class="bg-white/90 backdrop-blur-sm border border-slate-400/60
                rounded-3xl overflow-hidden flex flex-col group
                shadow-lg shadow-slate-800/20
                hover:-translate-y-3 hover:shadow-2xl hover:shadow-slate-900/40
                transition-all duration-500 ease-out">

                            {{-- Image --}}
                            <div class="h-56 relative bg-slate-100 overflow-hidden">
                                <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover
                        transition-transform duration-700
                        group-hover:scale-110">

                                {{-- Gradient Overlay --}}
                                <div
                                    class="absolute inset-0 bg-gradient-to-t from-slate-900/60 via-transparent to-transparent">
                                </div>

                                {{-- Stock Badge --}}
                                <div
                                    class="absolute top-4 right-4 bg-white/90 backdrop-blur
                        px-3 py-1.5 rounded-full flex items-center gap-1.5 shadow-md">
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
                                        {{ $product->category->icon ?? '📦' }}
                                        {{ $product->category->name ?? 'No Categories' }}
                                    </span>
                                </div>
                            </div>

                            {{-- Content --}}
                            <div class="p-6 flex flex-col flex-grow">

                                {{-- Title --}}
                                <h3
                                    class="font-bold text-slate-900 text-base leading-tight
                       line-clamp-1 mb-2
                       transition-all duration-300
                       group-hover:text-blue-700">
                                    {{ $product->name }}
                                </h3>

                                {{-- Description --}}
                                <p
                                    class="text-slate-600 text-sm leading-relaxed
                      line-clamp-2 flex-grow">
                                    {{ $product->description }}
                                </p>

                                {{-- Price --}}
                                <div class="mt-6">
                                    {{-- <p class="text-slate-400 text-xs uppercase tracking-wider mb-1">
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
                    @endforeach

                </div>


                {{-- Button Lihat Semua --}}
                <div class="mt-12 text-center">
                    <a href="{{ url('/katalog') }}"
                        class="inline-flex items-center gap-2
              bg-blue-900 text-white
              hover:bg-blue-800
              px-10 py-4
              rounded-full text-sm font-bold tracking-wide
              shadow-lg shadow-blue-900/30
              hover:shadow-xl hover:-translate-y-1
              active:scale-95
              transition-all duration-300">
                        Lihat Semua Produk
                        <svg class="w-5 h-5 ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                        </svg>
                    </a>
                </div>


                {{-- <div class="mt-14 text-center">
                <a href="#" class="inline-flex items-center gap-2 border border-slate-300 text-slate-600 hover:bg-slate-100 px-8 py-4 rounded-full text-sm font-heading font-bold tracking-wide transition-all">
                    Lihat Semua Produk
                </a>
            </div> --}}
            </div>
        </section>

        {{-- FEATURE STRIPS (Cerah) --}}
        <section class="relative z-10 py-6">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @php
                        $features = [
                            [
                                'icon' => '🚀',
                                'title' => 'Pengiriman Cepat',
                                'desc' => 'Estimasi 1–3 hari kerja ke seluruh Indonesia.',
                                'bg' => 'bg-blue-50',
                                'border' => 'border-blue-100',
                            ],
                            [
                                'icon' => '🛡️',
                                'title' => 'Garansi Produk',
                                'desc' => 'Garansi resmi untuk semua produk yang kami jual.',
                                'bg' => 'bg-teal-50',
                                'border' => 'border-teal-100',
                            ],
                            [
                                'icon' => '💎',
                                'title' => 'Kualitas Premium',
                                'desc' => 'Setiap produk dikurasi dengan standar kualitas tinggi.',
                                'bg' => 'bg-indigo-50',
                                'border' => 'border-indigo-100',
                            ],
                        ];
                    @endphp

                    @foreach ($features as $f)
                        <div
                            class="bg-white rounded-2xl p-7 space-y-4 shadow-lg shadow-black-200/50 border {{ $f['border'] }} hover:-translate-y-1 transition-transform">
                            <div
                                class="w-14 h-14 rounded-full {{ $f['bg'] }} flex items-center justify-center text-2xl shadow-sm">
                                {{ $f['icon'] }}</div>
                            <h3 class="font-heading font-bold text-slate-900 text-lg">{{ $f['title'] }}</h3>
                            <p class="text-slate-600 text-sm leading-relaxed">{{ $f['desc'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- CTA BAND --}}
        <section class="relative z-10 py-8 mb-20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div
                    class="relative rounded-3xl overflow-hidden p-12 md:p-16 text-center shadow-2xl bg-gradient-to-br from-[#0B1426] to-blue-900 border border-blue-800">
                    <div
                        class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-96 h-32 bg-blue-500/30 blur-[80px] pointer-events-none">
                    </div>
                    <div class="relative z-10 space-y-6">
                        <div
                            class="inline-flex items-center gap-2 font-heading text-xs font-bold tracking-widest uppercase text-blue-300 px-4 py-2 bg-blue-900/50 rounded-full border border-blue-700/50">
                            Bergabung Sekarang</div>
                        <h2 class="font-display text-4xl md:text-6xl font-extrabold text-white">
                            DAPATKAN<br>
                            <span class="text-blue-400">DISKON 20%</span>
                        </h2>
                        <p class="text-blue-100 text-sm max-w-sm mx-auto leading-relaxed">
                            Daftar sekarang dan nikmati berbagai promo eksklusif untuk member baru GadgetStore.
                        </p>
                        {{-- <button @click="modalRegister = true"
                            class="bg-white text-blue-700 hover:bg-slate-100 px-10 py-4 rounded-full text-sm font-heading font-bold tracking-wide mt-4 shadow-xl transition-transform hover:scale-105">
                            Mulai Belanja
                        </button> --}}
                    </div>
                </div>
            </div>
        </section>

    </div> {{-- Penutup Kotak Putih --}}

@endsection
