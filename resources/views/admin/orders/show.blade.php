@extends('layouts.admin')
@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- --- HEADER: JUDUL & STATUS BADGES --- --}}
        <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <a href="{{ route('admin.orders.index') }}"
                    class="group w-12 h-12 bg-white border-2 border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-600 transition-all shadow-sm hover:shadow-md">
                    <svg class="w-6 h-6 transform group-hover:-translate-x-1 transition-transform" fill="none"
                        stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <p class="text-sm font-bold text-slate-500 uppercase tracking-wider flex items-center gap-2">
                        Detail Pesanan &bull; {{ $order->order_number }}
                    </p>
                    <h1 class="font-display text-2xl md:text-3xl font-black text-slate-900 mt-1">
                        @if ($order->items->count() > 0 && $order->items->first()->product)
                            {{ $order->items->first()->product->name }}
                            @if ($order->items->count() > 1)
                                <span class="text-lg font-bold text-slate-500 ml-2">(+{{ $order->items->count() - 1 }}
                                    produk lainnya)</span>
                            @endif
                        @else
                            Pesanan Tanpa Produk
                        @endif
                    </h1>
                </div>
            </div>

            {{-- Status Badges yang Menonjol --}}
            <div class="flex flex-wrap gap-3">
                {{-- Badge Pembayaran --}}
                @if ($order->payment_status === 'paid')
                    <span
                        class="px-5 py-2.5 rounded-xl text-sm font-black bg-emerald-100 text-emerald-700 border border-emerald-200 flex items-center gap-2 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        LUNAS
                    </span>
                @elseif($order->payment_status === 'unpaid' || $order->payment_status === 'pending')
                    <span
                        class="px-5 py-2.5 rounded-xl text-sm font-black bg-amber-100 text-amber-700 border border-amber-200 flex items-center gap-2 shadow-sm animate-pulse">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                        BELUM LUNAS
                    </span>
                @else
                    <span
                        class="px-5 py-2.5 rounded-xl text-sm font-black bg-red-100 text-red-700 border border-red-200 flex items-center gap-2 shadow-sm">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                            </path>
                        </svg>
                        DIBATALKAN
                    </span>
                @endif

                {{-- Badge Pengiriman --}}
                @php
                    $statusStyles = [
                        'pending' => 'bg-slate-100 text-slate-700 border-slate-200',
                        'processing' => 'bg-blue-100 text-blue-700 border-blue-200',
                        'shipped' => 'bg-indigo-100 text-indigo-700 border-indigo-200',
                        'completed' => 'bg-emerald-100 text-emerald-700 border-emerald-200',
                    ];
                    $statusIcons = [
                        'pending' =>
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h.01M12 12h.01M19 12h.01M6 12a1 1 0 01-1-1V7a5 5 0 0110 0v4a1 1 0 01-1 1h-8z"></path></svg>',
                        'processing' =>
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z"></path></svg>',
                        'shipped' =>
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0 2 2 0 00-4 0zm10 0a2 2 0 104 0 2 2 0 00-4 0z"></path></svg>',
                        'completed' =>
                            '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>',
                    ];
                    $statusLabels = [
                        'pending' => 'MENUNGGU',
                        'processing' => 'DIPROSES',
                        'shipped' => 'DIKIRIM',
                        'completed' => 'SELESAI',
                    ];
                @endphp
                <span
                    class="px-5 py-2.5 rounded-xl text-sm font-black border flex items-center gap-2 shadow-sm uppercase {{ $statusStyles[$order->order_status] }}">
                    {!! $statusIcons[$order->order_status] !!}
                    {{ $statusLabels[$order->order_status] }}
                </span>
            </div>
        </div>


        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- --- KOLOM KIRI: ISI UTAMA --- --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Card 1: Informasi Pelanggan (Aksen Biru) --}}
                <div
                    class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden border-t-4 border-t-blue-500">
                    <div class="p-6 md:p-8 bg-blue-50/30 border-b border-blue-100 flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-2xl flex items-center justify-center text-blue-600 shadow-sm">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-extrabold text-slate-900">Informasi Pengiriman</h3>
                    </div>

                    <div class="p-6 md:p-8 grid grid-cols-1 md:grid-cols-2 gap-8">
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                                Penerima
                            </p>
                            <p class="text-lg font-bold text-slate-900">{{ $order->user->name ?? 'User Tidak Diketahui' }}
                            </p>
                        </div>
                        <div class="space-y-1">
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                    </path>
                                </svg>
                                Telepon
                            </p>
                            <p class="text-lg font-bold text-slate-900">{{ $order->phone ?? '-' }}</p>
                        </div>
                        <div class="md:col-span-2 space-y-2">
                            <p class="text-xs font-bold text-blue-600 uppercase tracking-wider flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                    </path>
                                </svg>
                                Alamat Lengkap & Metode
                            </p>
                            <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                                <p class="text-slate-700 leading-relaxed font-medium">{{ $order->address }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Card 2: Produk yang Dipesan (Aksen Indigo) --}}
                <div
                    class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden border-t-4 border-t-indigo-500">
                    <div class="p-6 md:p-8 bg-indigo-50/30 border-b border-indigo-100 flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div
                                class="w-12 h-12 bg-indigo-100 rounded-2xl flex items-center justify-center text-indigo-600 shadow-sm">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg>
                            </div>
                            <h3 class="text-xl font-extrabold text-slate-900">Item Pesanan</h3>
                        </div>
                        <span class="px-4 py-2 bg-indigo-100 text-indigo-700 rounded-full font-bold text-sm">
                            {{ $order->items->sum('quantity') }} Barang
                        </span>
                    </div>

                    <div class="p-6 md:p-8 space-y-6">
                        @foreach ($order->items as $item)
                            {{-- Item Card Minimalis dengan Gambar Besar --}}
                            <div
                                class="flex flex-col sm:flex-row items-start sm:items-center gap-6 bg-white p-4 rounded-2xl border border-slate-100 hover:border-indigo-200 transition-all shadow-sm hover:shadow-md">

                                {{-- WADAH GAMBAR (DIPERBESAR & DIPASTIKAN TAMPIL) --}}
                                <div
                                    class="w-full sm:w-28 h-28 shrink-0 bg-slate-100 rounded-xl border border-slate-200 overflow-hidden relative group">
                                    @if ($item->product && $item->product->image)
                                        @php
                                            // Cek pintar: Apakah gambar dari internet (http) atau dari folder lokal (storage)?
                                            $imagePath = Str::startsWith($item->product->image, ['http://', 'https://'])
                                                ? $item->product->image
                                                : asset('storage/' . str_replace('public/', '', $item->product->image));
                                        @endphp
                                        {{-- Gambar Produk --}}
                                        <img src="{{ $imagePath }}"
                                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                            alt="{{ $item->product->name }}">
                                    @else
                                        {{-- Fallback jika tidak ada gambar --}}
                                        <div class="flex items-center justify-center h-full text-slate-300">
                                            <svg class="w-10 h-10" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="flex-1 space-y-1">
                                    <h4 class="text-lg font-extrabold text-slate-900">
                                        {{ $item->product->name ?? 'Produk Dihapus' }}</h4>
                                    <p class="text-sm font-bold text-slate-500">
                                        {{ $item->quantity }} unit x Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                <div class="text-right sm:text-left">
                                    <p class="text-xs font-bold text-slate-400 uppercase tracking-wider mb-1">Subtotal</p>
                                    <p class="text-xl font-black text-indigo-600">
                                        Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    {{-- Total Footer --}}
                    <div class="bg-slate-50 p-6 md:p-8 border-t border-slate-200 flex justify-between items-center">
                        <p class="text-lg font-bold text-slate-600 uppercase tracking-wider">Total Grand</p>
                        <p class="text-3xl font-black text-slate-900">Rp
                            {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                </div>
            </div>


            {{-- --- KOLOM KANAN: PANEL KONTROL (Sticky) --- --}}
            <div class="lg:col-span-1">
                <div
                    class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 p-6 md:p-8 sticky top-8 z-10">
                    <h3 class="text-xl font-extrabold text-slate-900 mb-8 flex items-center gap-3">
                        <div
                            class="w-10 h-10 rounded-xl bg-slate-900 flex items-center justify-center text-white shadow-md">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4">
                                </path>
                            </svg>
                        </div>
                        Panel Kontrol
                    </h3>

                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- Kontrol Pembayaran --}}
                        <div
                            class="bg-slate-50 p-5 rounded-2xl border {{ $order->payment_status == 'paid' ? 'border-emerald-200 bg-emerald-50/30' : ($order->payment_status == 'cancelled' ? 'border-red-200 bg-red-50/30' : 'border-amber-200 bg-amber-50/30') }}">
                            <label
                                class="block text-xs font-black uppercase tracking-wider mb-3 flex items-center gap-2 {{ $order->payment_status == 'paid' ? 'text-emerald-600' : ($order->payment_status == 'cancelled' ? 'text-red-600' : 'text-amber-600') }}">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                Status Pembayaran
                            </label>
                            <select name="payment_status"
                                class="w-full bg-white border-2 border-slate-200 text-slate-900 rounded-xl px-4 py-3.5 focus:ring-0 focus:border-blue-500 outline-none font-bold text-sm appearance-none transition-all cursor-pointer hover:border-blue-300">
                                <option value="unpaid" {{ $order->payment_status == 'unpaid' ? 'selected' : '' }}>⏳ Belum
                                    Dibayar</option>
                                <option value="paid" {{ $order->payment_status == 'paid' ? 'selected' : '' }}>✅ Lunas
                                    (Paid)</option>
                                <option value="cancelled" {{ $order->payment_status == 'cancelled' ? 'selected' : '' }}>✕
                                    Dibatalkan</option>
                            </select>
                        </div>

                        {{-- Kontrol Pengiriman --}}
                        <div class="bg-blue-50/50 p-5 rounded-2xl border border-blue-200">
                            <label
                                class="block text-xs font-black text-blue-600 uppercase tracking-wider mb-3 flex items-center gap-2">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                </svg>
                                Status Pengiriman
                            </label>
                            <div class="relative">
                                <select name="order_status"
                                    class="w-full bg-white border-2 border-blue-200 text-slate-900 rounded-xl px-4 py-3.5 focus:ring-0 focus:border-blue-600 outline-none font-bold text-sm appearance-none transition-all cursor-pointer hover:border-blue-400 pr-10 relative z-10">
                                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>🕒
                                        Menunggu Konfirmasi</option>
                                    <option value="processing"
                                        {{ $order->order_status == 'processing' ? 'selected' : '' }}>
                                        📦 Sedang Diproses</option>
                                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>🚚
                                        Sedang Dikirim</option>
                                    <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>
                                        🎉
                                        Pesanan Selesai</option>
                                </select>
                                <div
                                    class="absolute right-4 top-1/2 -translate-y-1/2 text-blue-500 pointer-events-none z-0">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </div>
                            </div>
                        </div>

                        <div class="pt-4">
                            <button type="submit"
                                class="w-full group relative overflow-hidden bg-slate-900 hover:bg-blue-600 text-white font-bold py-4 rounded-xl shadow-xl shadow-slate-900/20 transition-all duration-300 transform hover:-translate-y-1">
                                <span class="relative z-10 flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4">
                                        </path>
                                    </svg>
                                    Simpan Perubahan
                                </span>
                                <div
                                    class="absolute inset-0 h-full w-full bg-gradient-to-r from-transparent via-white/20 to-transparent -translate-x-full group-hover:animate-[shimmer_1s_infinite]">
                                </div>
                            </button>
                            <p class="text-xs text-center text-slate-400 mt-4 font-medium">Pastikan data sudah benar
                                sebelum menyimpan.</p>
                        </div>
                    </form>
                </div>
            </div>

        </div>
    </div>
@endsection
