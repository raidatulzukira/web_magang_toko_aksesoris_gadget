<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'GadgetStore - Aksesoris Premium')</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@500;600;700;800&display=swap"
        rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        :root {
            --electric: #3b82f6;
            --electric-glow: rgba(59, 130, 246, 0.35);
            --teal: #14b8a6;
            --teal-glow: rgba(20, 184, 166, 0.3);
            /* Warna Body diubah ke Biru Dongker Gelap */
            --bg-base: #f2f9ff;
            --bg-card: rgba(255, 255, 255, 0.03);
            --border: rgba(255, 255, 255, 0.07);
        }

        * {
            box-sizing: border-box;
        }

        body {
            background: var(--bg-base);
            font-family: 'Inter', sans-serif;
            color: #e2e8f0;
            overflow-x: hidden;
        }

        .font-display {
            font-family: 'Plus Jakarta Sans', sans-serif;
            letter-spacing: -0.01em;
        }

        .font-heading {
            font-family: 'Plus Jakarta Sans', sans-serif;
        }

        /* ── KODINGAN ANIMASI ASLI DIKEMBALIKAN ── */
        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 256 256' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.9' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: 0.6;
        }

        .ambient-blob {
            position: fixed;
            border-radius: 50%;
            filter: blur(120px);
            pointer-events: none;
            z-index: 0;
            animation: floatBlob 12s ease-in-out infinite;
        }

        .blob-1 {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(59, 130, 246, 0.12), transparent 70%);
            top: -150px;
            right: -150px;
            animation-delay: 0s;
        }

        .blob-2 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(20, 184, 166, 0.10), transparent 70%);
            bottom: 10%;
            left: -100px;
            animation-delay: -6s;
        }

        .blob-3 {
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(99, 102, 241, 0.09), transparent 70%);
            top: 40%;
            left: 40%;
            animation-delay: -3s;
        }

        @keyframes floatBlob {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -40px) scale(1.05);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.97);
            }
        }

        .glass-nav {
            background: rgba(38, 62, 108, 0.6);
            /* Dongker transparan */
            backdrop-filter: blur(24px) saturate(180%);
            -webkit-backdrop-filter: blur(24px) saturate(180%);
            border: 1px solid rgba(255, 255, 255, 0.06);
        }

        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes scaleIn {
            from {
                opacity: 0;
                transform: scale(0.92);
            }

            to {
                opacity: 1;
                transform: scale(1);
            }
        }

        @keyframes slideRight {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes shimmer {
            0% {
                background-position: -200% center;
            }

            100% {
                background-position: 200% center;
            }
        }

        @keyframes spin-slow {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        @keyframes pulse-ring {

            0%,
            100% {
                transform: scale(1);
                opacity: 0.6;
            }

            50% {
                transform: scale(1.15);
                opacity: 0.2;
            }
        }

        @keyframes ticker {
            0% {
                transform: translateX(0);
            }

            100% {
                transform: translateX(-50%);
            }
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-12px);
            }
        }

        @keyframes cardReveal {
            from {
                opacity: 0;
                transform: translateY(60px) scale(0.95);
            }

            to {
                opacity: 1;
                transform: translateY(0) scale(1);
            }
        }

        .anim-hero-badge {
            animation: slideRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) both;
        }

        .anim-hero-h1 {
            animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.15s both;
        }

        .anim-hero-p {
            animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.28s both;
        }

        .anim-hero-cta {
            animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.4s both;
        }

        .anim-hero-stats {
            animation: fadeUp 0.9s cubic-bezier(0.16, 1, 0.3, 1) 0.52s both;
        }

        .anim-hero-img {
            animation: scaleIn 1.1s cubic-bezier(0.16, 1, 0.3, 1) 0.2s both;
        }

        .gradient-text {
            background: linear-gradient(135deg, #60a5fa 0%, #818cf8 40%, #34d399 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .product-img-wrap {
            overflow: hidden;
        }

        .product-img-wrap img {
            transition: transform 0.7s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .group:hover .product-img-wrap img {
            transform: scale(1.08);
        }

        .btn-primary {
            position: relative;
            overflow: hidden;
            background: linear-gradient(135deg, #3b82f6, #6366f1);
            transition: all 0.3s ease;
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(135deg, #60a5fa, #818cf8);
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        .btn-primary:hover::before {
            opacity: 1;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 20px 60px rgba(59, 130, 246, 0.4);
        }

        .btn-primary span {
            position: relative;
            z-index: 1;
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid rgba(255, 255, 255, 0.12);
            transition: all 0.3s ease;
        }

        .btn-secondary:hover {
            background: rgba(255, 255, 255, 0.06);
            border-color: rgba(255, 255, 255, 0.25);
            transform: translateY(-2px);
        }

        .hero-img-grid {
            position: relative;
        }

        .hero-img-card {
            border-radius: 1.5rem;
            overflow: hidden;
            border: 1px solid rgba(255, 255, 255, 0.07);
            position: relative;
        }

        .hero-img-card::after {
            content: '';
            position: absolute;
            inset: 0;
            background: linear-gradient(to bottom, transparent 50%, rgba(11, 20, 38, 0.6) 100%);
        }

        .hero-img-card img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.8s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .hero-img-card:hover img {
            transform: scale(1.06);
        }

        .ring-deco {
            position: absolute;
            border-radius: 50%;
            border: 1px dashed rgba(59, 130, 246, 0.2);
            animation: spin-slow 25s linear infinite;
        }

        .ring-deco-2 {
            animation-direction: reverse;
            animation-duration: 18s;
            border-color: rgba(20, 184, 166, 0.15);
        }

        .ticker-wrap {
            overflow: hidden;
            white-space: nowrap;
        }

        .ticker-inner {
            display: inline-flex;
            animation: ticker 20s linear infinite;
        }

        .stat-pill {
            background: rgba(255, 255, 255, 0.04);
            border: 1px solid rgba(255, 255, 255, 0.08);
            border-radius: 9999px;
            transition: all 0.3s;
        }

        .stat-pill:hover {
            background: rgba(59, 130, 246, 0.1);
            border-color: rgba(59, 130, 246, 0.25);
        }

        .card-stagger {
            opacity: 0;
            animation: cardReveal 0.7s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .card-stagger:nth-child(1) {
            animation-delay: 0.05s;
        }

        .card-stagger:nth-child(2) {
            animation-delay: 0.15s;
        }

        .card-stagger:nth-child(3) {
            animation-delay: 0.25s;
        }

        .card-stagger:nth-child(4) {
            animation-delay: 0.35s;
        }

        .footer-glow {
            background: linear-gradient(135deg, rgba(59, 130, 246, 0.06), rgba(20, 184, 166, 0.04));
            border-top: 1px solid rgba(255, 255, 255, 0.05);
        }

        ::-webkit-scrollbar {
            width: 4px;
        }

        ::-webkit-scrollbar-track {
            background: transparent;
        }

        ::-webkit-scrollbar-thumb {
            background: rgba(59, 130, 246, 0.3);
            border-radius: 9999px;
        }

        .nav-link {
            position: relative;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.8rem;
            font-weight: 600;
            letter-spacing: 0.05em;
            color: rgba(255, 255, 255, 0.5);
            transition: color 0.3s;
        }

        .nav-link::after {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: linear-gradient(90deg, #3b82f6, #6366f1);
            transition: width 0.3s;
        }

        .nav-link:hover {
            color: #fff;
        }

        .nav-link:hover::after {
            width: 100%;
        }

        .hero-badge {
            background: rgba(59, 130, 246, 0.1);
            border: 1px solid rgba(59, 130, 246, 0.25);
            border-radius: 9999px;
        }

        .img-overlay-text {
            position: absolute;
            bottom: 16px;
            left: 16px;
            z-index: 10;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 700;
            color: white;
        }

        .float-badge {
            animation: float 4s ease-in-out infinite;
        }
    </style>
</head>

{{-- <body x-data="{ modalLogin: {{ session('success') ? 'true' : 'false' }}, modalRegister: false, modalLogout: false, showToast: {{ session('success') ? 'true' : 'false' }} }"> --}}
{{-- <body x-data="{ modalLogin: false, modalRegister: false, modalLogout: false, showToast: {{ session('success') ? 'true' : 'false' }} }"> --}}
{{-- <body x-data="{ modalLogin: {{ session('showLogin') ? 'true' : 'false' }}, modalRegister: false, modalLogout: false, showToast: {{ session('success') ? 'true' : 'false' }} }"> --}}
<body x-data="{
    modalLogin: {{ session('showLogin') || ($errors->any() && !$errors->has('name') && !old('name')) ? 'true' : 'false' }},
    modalRegister: {{ $errors->has('name') || old('name') ? 'true' : 'false' }},
    modalLogout: false,
    showToast: {{ session('success') ? 'true' : 'false' }}
}">

    {{-- Ambient blobs asli --}}
    <div class="ambient-blob blob-1"></div>
    <div class="ambient-blob blob-2"></div>
    <div class="ambient-blob blob-3"></div>

    {{-- ─────────────────── NAV ─────────────────── --}}
    <div class="sticky top-4 z-50 px-4 sm:px-6 lg:px-8 mx-auto max-w-7xl">
        <nav class="glass-nav rounded-full px-6 py-3.5 flex justify-between items-center">
            <a href="{{ route('home') }}" class="flex items-center gap-3 group">
                <div
                    class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center font-display text-white text-lg shadow-lg shadow-blue-500/30 group-hover:scale-110 transition-transform">
                    G</div>
                <span class="font-heading font-extrabold text-white text-lg tracking-tight">GadgetStore</span>
            </a>

            <div class="hidden md:flex items-center gap-8">
                <a href="{{ route('front.katalog') }}" class="nav-link">Produk</a>
                {{-- <a href="#" class="nav-link">Promo</a> --}}
                <a href="{{ route('tentang') }}" class="nav-link">Tentang</a>
            </div>

            {{-- <div class="flex items-center gap-3">
                @auth
                    @if (auth()->user()->role === 'admin')
                        <a href="{{ url('/dashboard') }}" class="nav-link">Dashboard Admin</a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="nav-link">Pesanan Saya</a>
                    @endif

                @endauth
            </div> --}}
            <div class="flex items-center space-x-3 sm:space-x-4">
                @auth
                    {{-- @php
                    $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                @endphp
                <a href="{{ route('cart.index') }}" class="relative p-2 text-slate-600 hover:text-blue-600 transition-colors mr-2">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                    @if ($cartCount > 0)
                        <span class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-1 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full">
                            {{ $cartCount }}
                        </span>
                    @endif
                </a> --}}

                    @if (auth()->user()->role === 'admin')
                        <a href="{{ route('dashboard') }}"
                            class="text-slate-600 hover:text-blue-600 font-bold text-sm transition-colors">Dasbor Admin</a>
                    @else
                        <a href="{{ url('/dashboard') }}" class="nav-link">Pesanan Saya</a>
                    @endif

                    @php
                        $cartCount = \App\Models\Cart::where('user_id', auth()->id())->sum('quantity');
                    @endphp
                    <a href="{{ route('cart.index') }}"
                        class="relative p-2 text-slate-600 hover:text-blue-600 transition-colors mr-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                            </path>
                        </svg>
                        @if ($cartCount > 0)
                            <span
                                class="absolute top-0 right-0 inline-flex items-center justify-center px-1.5 py-1 text-[10px] font-bold leading-none text-white transform translate-x-1/4 -translate-y-1/4 bg-red-500 rounded-full">
                                {{ $cartCount }}
                            </span>
                        @endif
                    </a>

                    {{-- <form method="POST" action="{{ route('logout') }}" class="ml-2 m-0 p-0">
                    @csrf
                    <button type="submit" class="bg-slate-100 text-slate-600 hover:bg-red-500 hover:text-white hover:shadow-lg hover:shadow-red-500/30 px-5 py-2 rounded-full text-sm font-bold transition-all duration-300 transform hover:-translate-y-0.5">Logout</button>
                </form> --}}
                {{-- @else
                    <button @click="modalLogin = true"
                        class="text-slate-600 hover:text-blue-600 font-bold px-4 py-2 text-sm transition-colors">Masuk</button>
                    <button @click="modalRegister = true"
                        class="bg-blue-600 text-white px-6 py-2.5 rounded-full hover:bg-indigo-600 hover:shadow-lg hover:shadow-blue-500/30 text-sm font-bold transition-all duration-300 transform hover:-translate-y-0.5">Daftar</button> --}}
                @endauth
            </div>



            <div class="flex items-center gap-3">
                @auth
                    {{-- Dropdown Profil Alpine.js --}}
                    <div class="relative" x-data="{ dropdownOpen: false }">
                        <button @click="dropdownOpen = !dropdownOpen" @click.away="dropdownOpen = false"
                            class="flex items-center gap-2.5 hover:opacity-80 transition-opacity focus:outline-none">
                            <div
                                class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center text-white font-display font-bold shadow-md">
                                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                            </div>
                            <svg class="w-4 h-4 text-white/70" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                            </svg>
                        </button>

                        {{-- Menu Dropdown --}}
                        <div x-show="dropdownOpen" x-transition:enter="transition ease-out duration-200"
                            x-transition:enter-start="opacity-0 translate-y-2"
                            x-transition:enter-end="opacity-100 translate-y-0"
                            x-transition:leave="transition ease-in duration-150"
                            x-transition:leave-start="opacity-100 translate-y-0"
                            x-transition:leave-end="opacity-0 translate-y-2"
                            class="absolute right-0 mt-4 w-64 bg-white rounded-2xl shadow-[0_20px_40px_-15px_rgba(0,0,0,0.15)] border border-slate-100 overflow-hidden"
                            style="display: none;">

                            {{-- Info Akun --}}
                            <div class="px-5 py-4 border-b border-slate-100 bg-slate-50/50">
                                <p class="font-display font-bold text-slate-900 text-sm truncate">
                                    {{ auth()->user()->name }}
                                </p>
                                <p class="text-xs text-slate-500 truncate mt-0.5">{{ auth()->user()->email }}</p>
                                <div
                                    class="mt-2 inline-flex items-center gap-1 px-2 py-0.5 rounded-md bg-amber-50 border border-amber-200 text-amber-600 text-[9px] font-bold tracking-widest uppercase">
                                    👑 Member
                                </div>
                            </div>

                            {{-- Link Menu --}}
                            <div class="p-2">
                                @if (auth()->user()->role === 'admin')
                                    <a href="{{ url('/dashboard') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-heading font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors">
                                        <span>📊</span> Dashboard Admin
                                    </a>
                                @else
                                    {{-- <a href="{{ url('/dashboard') }}" class="flex items-center gap-3 px-4 py-2.5 text-sm font-heading font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors">
                                        <span>📦</span> Pesanan Saya
                                    </a>
                                    <a href="#" class="flex items-center gap-3 px-4 py-2.5 text-sm font-heading font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors">
                                        <span>❤️</span> Wishlist
                                    </a> --}}
                                    <a href="{{ route('profile.edit') }}"
                                        class="flex items-center gap-3 px-4 py-2.5 text-sm font-heading font-semibold text-slate-600 hover:bg-blue-50 hover:text-blue-600 rounded-xl transition-colors">
                                        <span>👥</span> Profil Saya
                                    </a>
                                @endif
                            </div>

                            {{-- Tombol Logout --}}
                            <div class="p-2 border-t border-slate-100">
                                <button @click="modalLogout = true" type="button"
                                    class="w-full flex items-center gap-3 px-4 py-2.5 text-sm font-heading font-semibold text-red-500 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors text-left">
                                    <span>🚪</span> Keluar
                                </button>
                            </div>
                        </div>
                    </div>
                @else
                    <button @click="modalLogin = true" class="nav-link px-1">Masuk</button>
                    <button @click="modalRegister = true"
                        class="btn-primary text-white px-6 py-2.5 rounded-full text-xs font-heading font-bold tracking-wide mr-10">
                        <span>Daftar</span>
                    </button>
                @endauth
            </div>



        </nav>
    </div>

    <main class="min-h-screen -mt-20 pt-20 relative z-10">
        @yield('content')
    </main>

    {{-- ─────────────────── FOOTER (Dark Navy) ─────────────────── --}}
    <footer class="footer pt-20 pb-10 relative z-10 bg-[#0B1426]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 pb-16 border-b border-white/5">
                <div class="md:col-span-2 space-y-5">
                    <div class="flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-indigo-600 flex items-center justify-center font-display text-white text-xl">
                            G</div>
                        <span class="font-heading font-extrabold text-white text-xl">GadgetStore</span>
                    </div>
                    <p class="text-slate-400 text-sm leading-relaxed max-w-xs">
                        Destinasi utama untuk menemukan aksesoris gadget premium. Tingkatkan produktivitas dan gayamu
                        sekarang.
                    </p>
                    <div class="flex gap-3 pt-2">
                        <div class="stat-pill px-4 py-2 text-xs font-heading font-semibold text-white/60">500+ Produk
                        </div>
                        <div class="stat-pill px-4 py-2 text-xs font-heading font-semibold text-white/60">10k+
                            Pelanggan
                        </div>
                    </div>
                </div>

                <div>
                    <h4 class="font-heading font-bold text-white text-sm tracking-wide mb-5 uppercase">Navigasi</h4>
                    <ul class="space-y-3">
                        <li><a href="#"
                                class="text-slate-400 hover:text-blue-400 text-sm transition-colors duration-200">Semua
                                Produk</a></li>
                        <li><a href="#"
                                class="text-slate-400 hover:text-blue-400 text-sm transition-colors duration-200">Promo
                                Terbaru</a></li>
                        <li><a href="#"
                                class="text-slate-400 hover:text-blue-400 text-sm transition-colors duration-200">Cara
                                Pembelian</a></li>
                        <li><a href="#"
                                class="text-slate-400 hover:text-blue-400 text-sm transition-colors duration-200">Garansi
                                & Retur</a></li>
                    </ul>
                </div>

                <div>
                    <h4 class="font-heading font-bold text-white text-sm tracking-wide mb-5 uppercase">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="flex items-center gap-3 text-slate-400 text-sm"><span
                                class="text-blue-400">✉</span> support@gadgetstore.com</li>
                        <li class="flex items-center gap-3 text-slate-400 text-sm"><span
                                class="text-blue-400">📱</span> +62 812-3456-7890</li>
                        <li class="flex items-center gap-3 text-slate-400 text-sm"><span
                                class="text-blue-400">📍</span> Jakarta, Indonesia</li>
                    </ul>
                </div>
            </div>

            <div class="pt-8 flex flex-col md:flex-row justify-between items-center gap-4">
                <p class="text-slate-500 text-xs font-heading">&copy; {{ date('Y') }} GadgetStore. Dibuat dengan
                    Laravel & Tailwind CSS.</p>
                <div class="flex gap-6">
                    <a href="#"
                        class="text-slate-500 hover:text-slate-300 text-xs font-heading transition-colors">Privacy
                        Policy</a>
                    <a href="#"
                        class="text-slate-500 hover:text-slate-300 text-xs font-heading transition-colors">Terms of
                        Service</a>
                </div>
            </div>
        </div>
    </footer>

    @include('components.modal-login-register')
    {{-- ─────────────────── MODAL KONFIRMASI LOGOUT ─────────────────── --}}
    <div x-show="modalLogout" style="display: none;"
        class="fixed inset-0 z-[100] flex items-center justify-center p-4">

        {{-- Background Gelap (Backdrop) --}}
        <div x-show="modalLogout" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0" @click="modalLogout = false"
            class="absolute inset-0 bg-[#0B1426]/60 backdrop-blur-sm"></div>

        {{-- Kotak Modal --}}
        <div x-show="modalLogout" x-transition:enter="transition ease-out duration-300"
            x-transition:enter-start="opacity-0 scale-95 translate-y-4"
            x-transition:enter-end="opacity-100 scale-100 translate-y-0"
            x-transition:leave="transition ease-in duration-200"
            x-transition:leave-start="opacity-100 scale-100 translate-y-0"
            x-transition:leave-end="opacity-0 scale-95 translate-y-4"
            class="relative bg-white rounded-3xl p-8 max-w-sm w-full shadow-2xl text-center">

            {{-- Ikon --}}
            <div
                class="w-16 h-16 bg-red-50 text-red-500 rounded-2xl flex items-center justify-center text-3xl mx-auto mb-5 shadow-inner">
                🚪
            </div>

            <h3 class="font-display font-extrabold text-slate-900 text-xl mb-2">Konfirmasi Keluar</h3>
            <p class="text-slate-500 text-sm mb-8 leading-relaxed">
                Apakah kamu yakin ingin keluar dari akun GadgetStore? Kamu harus masuk kembali untuk melihat pesananmu.
            </p>

            {{-- Tombol Aksi --}}
            <div class="flex gap-3">
                <button @click="modalLogout = false" type="button"
                    class="flex-1 px-4 py-3.5 rounded-xl font-bold text-slate-600 bg-slate-50 hover:bg-slate-100 border border-slate-200 transition-colors text-sm">
                    Batal
                </button>

                {{-- Form Logout Sebenarnya --}}
                <form method="POST" action="{{ route('logout') }}" class="flex-1">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-3.5 rounded-xl font-bold text-white bg-red-500 hover:bg-red-600 shadow-lg shadow-red-500/30 transition-all hover:-translate-y-0.5 text-sm">
                        Ya, Keluar
                    </button>
                </form>
            </div>
        </div>
    </div>

</body>

</html>
