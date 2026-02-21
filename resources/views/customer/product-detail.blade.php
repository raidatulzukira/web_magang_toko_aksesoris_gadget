@extends('layouts.front')

@section('title', $product->name . ' - GadgetStore')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10"
     x-data="{
        qty: 1,
        maxStok: {{ $product->stock }},
        selectedVariant: null,
        loaded: false
     }"
     x-init="setTimeout(() => loaded = true, 100)">

    <nav class="flex text-sm text-slate-500 mb-8 opacity-0 translate-y-4 transition-all duration-700" :class="loaded ? '!opacity-100 !translate-y-0' : ''">
        <ol class="inline-flex items-center space-x-1 md:space-x-3">
            <li class="inline-flex items-center">
                <a href="{{ route('home') }}" class="hover:text-blue-600 font-medium transition-colors">Beranda</a>
            </li>
            <li>
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-slate-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <a href="{{ route('home') }}#produk" class="hover:text-blue-600 font-medium transition-colors">Produk</a>
                </div>
            </li>
            <li aria-current="page">
                <div class="flex items-center">
                    <svg class="w-4 h-4 text-slate-400 mx-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                    <span class="text-slate-800 font-bold line-clamp-1">{{ $product->name }}</span>
                </div>
            </li>
        </ol>
    </nav>

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-12 lg:gap-16">

        <div class="lg:col-span-5 opacity-0 translate-y-8 transition-all duration-700 delay-100" :class="loaded ? '!opacity-100 !translate-y-0' : ''">
            <div class="sticky top-32">
                <div class="bg-white rounded-[2.5rem] p-4 shadow-xl shadow-slate-200/40 border border-slate-100 relative group overflow-hidden">
                    <div class="absolute inset-0 bg-gradient-to-tr from-blue-50 to-slate-50 opacity-50"></div>

                    <div class="relative w-full aspect-square rounded-[2rem] overflow-hidden bg-slate-100">
                        <img src="{{ $product->image }}" alt="{{ $product->name }}" class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-1000 ease-out">
                    </div>

                    <div class="absolute top-8 left-8">
                        @if($product->stock > 0)
                            <span class="bg-white/90 backdrop-blur-md text-slate-900 font-black text-xs px-4 py-2 rounded-full shadow-lg border border-white">
                                Sisa {{ $product->stock }} Unit
                            </span>
                        @else
                            <span class="bg-red-500/90 backdrop-blur-md text-white font-black text-xs px-4 py-2 rounded-full shadow-lg border border-red-400">
                                Habis Terjual
                            </span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="lg:col-span-7 opacity-0 translate-y-8 transition-all duration-700 delay-200" :class="loaded ? '!opacity-100 !translate-y-0' : ''">

            <h1 class="text-4xl md:text-5xl font-extrabold text-slate-900 mb-4 leading-tight">
                {{ $product->name }}
            </h1>

            <div class="flex items-end gap-4 mb-8">
                <span class="text-4xl md:text-5xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">
                    Rp {{ number_format($product->price, 0, ',', '.') }}
                </span>
            </div>

            <p class="text-slate-600 text-lg leading-relaxed mb-10 border-b border-slate-100 pb-10">
                {{ $product->description ?: 'Temukan pengalaman terbaik dengan produk unggulan kami. Didesain untuk kenyamanan dan durabilitas maksimal.' }}
            </p>

            <form action="{{ route('cart.store') }}" method="POST" class="space-y-8">
                @csrf
                <input type="hidden" name="product_id" value="{{ $product->id }}">
                <input type="hidden" name="variant" :value="selectedVariant">
                <input type="hidden" name="quantity" :value="qty">

                @if($product->variants)
                <div>
                    <h3 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wider">Pilih Varian</h3>
                    <div class="flex flex-wrap gap-3">
                        @foreach(explode(',', $product->variants) as $variant)
                            <button type="button"
                                    @click="selectedVariant = '{{ trim($variant) }}'"
                                    :class="selectedVariant === '{{ trim($variant) }}' ? 'bg-slate-900 text-white border-slate-900 shadow-md transform scale-105' : 'bg-white text-slate-600 border-slate-200 hover:border-slate-400'"
                                    class="px-6 py-3 rounded-2xl border-2 font-bold text-sm transition-all duration-200">
                                {{ trim($variant) }}
                            </button>
                        @endforeach
                    </div>
                    <p x-show="!selectedVariant" class="text-amber-500 text-xs font-bold mt-2 flex items-center gap-1 animate-pulse">
                        * Silakan pilih varian terlebih dahulu
                    </p>
                </div>
                @endif

                <div class="flex flex-col sm:flex-row gap-5">
                    <div class="w-full sm:w-1/3">
                        <h3 class="text-sm font-bold text-slate-900 mb-4 uppercase tracking-wider">Jumlah</h3>
                        <div class="flex items-center justify-between bg-slate-50 border border-slate-200 rounded-2xl p-2">
                            <button type="button" @click="if(qty > 1) qty--" class="w-12 h-12 flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-white rounded-xl transition-all shadow-sm disabled:opacity-50">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M20 12H4"></path></svg>
                            </button>

                            <span class="text-xl font-black text-slate-900 w-12 text-center" x-text="qty"></span>

                            <button type="button" @click="if(qty < maxStok) qty++" class="w-12 h-12 flex items-center justify-center text-slate-500 hover:text-slate-900 hover:bg-white rounded-xl transition-all shadow-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M12 4v16m8-8H4"></path></svg>
                            </button>
                        </div>
                    </div>

                    <div class="w-full sm:w-2/3 flex items-end">
                        @if($product->stock > 0)
                            @auth
                                <div class="w-full flex gap-3">
                                    <button type="submit"
                                            formaction="{{ route('cart.store') }}"
                                            :disabled="{{ $product->variants ? '!selectedVariant' : 'false' }}"
                                            class="w-1/2 h-[60px] bg-blue-50 text-blue-600 hover:bg-blue-100 border border-blue-200 rounded-2xl font-bold text-sm flex items-center justify-center gap-2 transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
                                        Keranjang
                                    </button>

                                    <button type="submit"
                                            formaction="{{ route('checkout.direct') }}"
                                            :disabled="{{ $product->variants ? '!selectedVariant' : 'false' }}"
                                            class="w-1/2 h-[60px] bg-blue-600 hover:bg-blue-700 text-white rounded-2xl font-bold text-sm flex items-center justify-center gap-2 transition-all shadow-lg shadow-blue-600/30 transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                                        Beli Sekarang
                                    </button>
                                </div>
                            @else
                                <button type="button"
                                        @click="modalLogin = true"
                                        class="w-full h-[60px] bg-slate-800 hover:bg-slate-900 text-white rounded-2xl font-bold text-lg flex items-center justify-center gap-3 transition-all shadow-lg transform hover:-translate-y-1">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M11 16l-4-4m0 0l4-4m-4 4h14m-5 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h7a3 3 0 013 3v1"></path></svg>
                                    Login untuk Membeli
                                </button>
                            @endauth
                        @else
                            <button type="button" disabled class="w-full h-[60px] bg-slate-200 text-slate-500 rounded-2xl font-bold text-lg flex items-center justify-center cursor-not-allowed">
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>

                <div class="grid grid-cols-2 gap-4 pt-8 mt-8 border-t border-slate-100">
                    <div class="flex items-center gap-3 text-slate-600">
                        <div class="bg-blue-50 text-blue-600 p-2.5 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg></div>
                        <span class="text-sm font-bold">100% Original</span>
                    </div>
                    <div class="flex items-center gap-3 text-slate-600">
                        <div class="bg-blue-50 text-blue-600 p-2.5 rounded-xl"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg></div>
                        <span class="text-sm font-bold">Pembayaran Aman</span>
                    </div>
                </div>

            </form>
        </div>
    </div>

    @if(session('success') || session('error'))
    <div x-data="{ show: true }"
         x-show="show"
         x-init="setTimeout(() => show = false, 4000)"
         x-transition:enter="ease-out duration-500 transition-all"
         x-transition:enter-start="opacity-0 translate-y-10"
         x-transition:enter-end="opacity-100 translate-y-0"
         x-transition:leave="ease-in duration-300"
         x-transition:leave-start="opacity-100"
         x-transition:leave-end="opacity-0 translate-y-10"
         class="fixed bottom-8 right-8 z-[200] {{ session('success') ? 'bg-slate-900' : 'bg-red-600' }} text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 border {{ session('success') ? 'border-slate-700' : 'border-red-500' }}">

        <div class="bg-white/20 p-2 rounded-xl">
            @if(session('success'))
                <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            @else
                <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            @endif
        </div>
        <span class="font-bold text-sm md:text-base">{{ session('success') ?? session('error') }}</span>
        <button @click="show = false" class="text-white/70 hover:text-white transition-colors ml-2">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
        </button>
    </div>
    @endif
</div>
@endsection
