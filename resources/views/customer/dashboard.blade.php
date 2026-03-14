@extends('layouts.front')
@section('title', 'Pesanan Saya - GadgetStore')

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10">

        {{-- Breadcrumb minimalis --}}
        <nav class="mb-8 card-stagger flex text-sm text-slate-500 font-medium">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Home</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Dashboard Akun</span>
        </nav>

        <div class="space-y-8">
            {{-- Banner Selamat Datang Premium (Full Width) --}}
            <div
                class="relative overflow-hidden bg-gradient-to-br from-[#0B1426] to-blue-900 rounded-[2rem] p-8 md:p-12 text-white shadow-xl shadow-blue-900/20 card-stagger">
                {{-- Efek Glow/Cahaya di dalam banner --}}
                <div
                    class="absolute -top-24 -right-24 w-64 h-64 bg-blue-500 rounded-full mix-blend-screen filter blur-[80px] opacity-40 animate-pulse">
                </div>
                <div
                    class="absolute -bottom-24 -left-24 w-64 h-64 bg-teal-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20">
                </div>

                <div class="relative z-10">
                    <p class="text-blue-300 font-heading font-semibold tracking-widest uppercase text-xs mb-3">Dashboard
                        Overview</p>
                    <h1 class="font-display text-3xl md:text-5xl font-extrabold mb-4 leading-tight">
                        Selamat datang kembali,<br>
                        <span
                            class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-teal-200">{{ explode(' ', auth()->user()->name)[0] }}!</span>
                        👋
                    </h1>
                    <p class="text-blue-100/80 text-sm md:text-base max-w-2xl leading-relaxed">
                        Pantau aktivitas pesananmu, lihat status pengiriman, dan temukan berbagai promo menarik khusus
                        untukmu hari ini.
                    </p>
                </div>
            </div>

            {{-- Hitung Statistik Pesanan --}}
            @php
                $unpaidCount = $orders->whereIn('payment_status', ['unpaid', 'pending'])->count();
                $paidCount = $orders->where('payment_status', 'paid')->count();
            @endphp

            {{-- 3 Kartu Mini Statistik Pesanan (Full Width Grid) --}}
            {{-- <div class="grid grid-cols-1 md:grid-cols-3 gap-6 card-stagger" style="animation-delay: 0.2s;">
                <div
                    class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex items-center gap-5">
                        <div
                            class="w-14 h-14 rounded-2xl bg-amber-50 flex items-center justify-center text-amber-500 text-3xl">
                            ⏳</div>
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Belum Dibayar</p>
                            <p class="font-display font-extrabold text-slate-900 text-3xl">{{ $unpaidCount }}</p>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex items-center gap-5">
                        <div
                            class="w-14 h-14 rounded-2xl bg-blue-50 flex items-center justify-center text-blue-500 text-3xl">
                            🚚</div>
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Diproses</p>
                            <p class="font-display font-extrabold text-slate-900 text-3xl">{{ $paidCount }}</p>
                        </div>
                    </div>
                </div>
                <div
                    class="bg-white rounded-2xl p-6 shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 hover:-translate-y-1 transition-transform duration-300">
                    <div class="flex items-center gap-5">
                        <div
                            class="w-14 h-14 rounded-2xl bg-green-50 flex items-center justify-center text-green-500 text-3xl">
                            ✅</div>
                        <div>
                            <p class="text-slate-500 text-xs font-bold uppercase tracking-wider mb-1">Pesanan Selesai</p>
                            <p class="font-display font-extrabold text-slate-900 text-3xl">0</p>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- MENGHITUNG JUMLAH PESANAN PER KATEGORI --}}
            {{-- @php
                $unpaidCount = $orders->whereIn('payment_status', ['unpaid', 'pending'])->count();
                $completedCount = $orders->where('order_status', 'completed')->where('payment_status', 'paid')->count();
                $processCount = $orders
                    ->whereNotIn('payment_status', ['unpaid', 'pending'])
                    ->where('order_status', '!=', 'completed')
                    ->count();
            @endphp --}}

            {{-- MENGHITUNG JUMLAH PESANAN PER KATEGORI --}}
            {{-- @php
                $unpaidCount = $orders
                    ->whereIn('payment_status', ['unpaid', 'pending'])
                    ->where('order_status', '!=', 'cancelled')
                    ->count();
                $processCount = $orders->where('order_status', 'processing')->count();
                $shippedCount = $orders->where('order_status', 'shipped')->count();
                $completedCount = $orders->where('order_status', 'completed')->count();
                $cancelledCount = $orders->where('order_status', 'cancelled')->count();
            @endphp --}}

            {{-- MENGHITUNG JUMLAH PESANAN BERDASARKAN ORDER_STATUS SAJA --}}
            @php
                // Pending = Transfer tapi belum bayar (Menunggu)
                $pendingCount = $orders->where('order_status', 'pending')->count();
                // Processing = Transfer Lunas ATAU COD (Diproses)
                $processCount = $orders->where('order_status', 'processing')->count();
                // Sisanya sama
                $shippedCount = $orders->where('order_status', 'shipped')->count();
                $completedCount = $orders->where('order_status', 'completed')->count();
                $cancelledCount = $orders->where('order_status', 'cancelled')->count();
            @endphp

            {{-- WRAPPER ALPINE.JS UNTUK FILTER TANPA RELOAD --}}
            {{-- <div x-data="{
                filter: 'all',
                orders: [
                    @foreach ($orders as $order)
            {
                id: {{ $order->id }},
                category: '{{ in_array($order->payment_status, ['unpaid', 'pending']) ? 'unpaid' : ($order->order_status == 'completed' ? 'completed' : 'processing') }}'
            }, @endforeach
                ],
                get visibleIds() {
                    // Saring data berdasarkan tombol yang diklik (atau tampilkan semua)
                    let filtered = this.filter === 'all' ?
                        this.orders :
                        this.orders.filter(o => o.category === this.filter);

                    // LIMIT MAKSIMAL 7 DATA SAJA
                    return filtered.slice(0, 7).map(o => o.id);
                }
            }"> --}}

            {{-- WRAPPER ALPINE.JS UNTUK FILTER TANPA RELOAD --}}
            {{-- <div x-data="{
                filter: 'all',
                orders: [
                    @foreach ($orders as $order)
                    {
                        id: {{ $order->id }},
                        category: '{{ $order->order_status == 'cancelled' ? 'cancelled' : ($order->order_status == 'shipped' ? 'shipped' : ($order->order_status == 'completed' ? 'completed' : ($order->order_status == 'processing' ? 'processing' : 'unpaid'))) }}'
                    }, @endforeach
                ],
                get visibleIds() {
                    let filtered = this.filter === 'all' ? this.orders : this.orders.filter(o => o.category === this.filter);
                    return filtered.slice(0, 7).map(o => o.id);
                }
            }"> --}}

            <div x-data="{
                filter: 'all',
                orders: [
                    @foreach ($orders as $order)
                    {
                        id: {{ $order->id }},
                        category: '{{ $order->order_status }}' // <-- SANGAT SIMPEL, IKUTI STATUS ORDER SAJA
                    }, @endforeach
                ],
                get visibleIds() {
                    let filtered = this.filter === 'all' ? this.orders : this.orders.filter(o => o.category === this.filter);
                    return filtered.slice(0, 7).map(o => o.id);
                }
            }">

                {{-- 3 KOTAK STATUS (Sekarang Bisa Diklik!) --}}
                {{-- <div class="grid grid-cols-1 md:grid-cols-5 gap-6 mb-10 mt-8">
                    {{-- Kotak Belum Dibayar --}
                    <button @click="filter = filter === 'unpaid' ? 'all' : 'unpaid'"
                        :class="filter === 'unpaid' ? 'ring-4 ring-amber-400 bg-amber-50 transform -translate-y-1' :
                            'bg-white hover:bg-slate-50 hover:-translate-y-1'"
                        class="rounded-[1.5rem] p-6 shadow-lg border border-slate-100 flex items-center gap-5 transition-all duration-300 text-left cursor-pointer group">
                        <div
                            class="w-14 h-14 bg-amber-100 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition-transform">
                            ⏳</div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Belum Dibayar</p>
                            <p class="font-black text-3xl text-slate-900">{{ $unpaidCount }}</p>
                        </div>
                    </button>

                    {{-- Kotak Diproses --}
                    <button @click="filter = filter === 'processing' ? 'all' : 'processing'"
                        :class="filter === 'processing' ? 'ring-4 ring-blue-400 bg-blue-50 transform -translate-y-1' :
                            'bg-white hover:bg-slate-50 hover:-translate-y-1'"
                        class="rounded-[1.5rem] p-6 shadow-lg border border-slate-100 flex items-center gap-5 transition-all duration-300 text-left cursor-pointer group">
                        <div
                            class="w-14 h-14 bg-blue-100 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition-transform">
                            🚚</div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Diproses</p>
                            <p class="font-black text-3xl text-slate-900">{{ $processCount }}</p>
                        </div>
                    </button>

                    {{-- Kotak Selesai --}
                    <button @click="filter = filter === 'completed' ? 'all' : 'completed'"
                        :class="filter === 'completed' ? 'ring-4 ring-emerald-400 bg-emerald-50 transform -translate-y-1' :
                            'bg-white hover:bg-slate-50 hover:-translate-y-1'"
                        class="rounded-[1.5rem] p-6 shadow-lg border border-slate-100 flex items-center gap-5 transition-all duration-300 text-left cursor-pointer group">
                        <div
                            class="w-14 h-14 bg-emerald-100 rounded-2xl flex items-center justify-center text-2xl shadow-inner group-hover:scale-110 transition-transform">
                            ✅</div>
                        <div>
                            <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Pesanan Selesai</p>
                            <p class="font-black text-3xl text-slate-900">{{ $completedCount }}</p>
                        </div>
                    </button>
                </div> --}}

                {{-- 5 KOTAK STATUS (Sekarang Bisa Diklik!) --}}
                <div class="grid grid-cols-1 md:grid-cols-5 gap-4 mb-10 mt-8">

                    {{-- 1. Kotak Belum Dibayar --}}
                    {{-- <button @click="filter = filter === 'unpaid' ? 'all' : 'unpaid'"
                        :class="filter === 'unpaid' ? 'ring-4 ring-amber-400 bg-amber-50 transform -translate-y-1' :
                            'bg-white hover:bg-slate-50 hover:-translate-y-1'"
                        class="rounded-3xl p-5 shadow-lg border border-slate-100 flex flex-col items-center justify-center gap-3 transition-all duration-300 text-center cursor-pointer group">
                        <div
                            class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">
                            ⏳</div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Belum Dibayar</p>
                            <p class="font-black text-2xl text-slate-900">{{ $unpaidCount }}</p>
                        </div>
                    </button> --}}

                    {{-- 1. Kotak Menunggu (Khusus Transfer Belum Bayar) --}}
                    <button @click="filter = filter === 'pending' ? 'all' : 'pending'"
                        :class="filter === 'pending' ? 'ring-4 ring-amber-400 bg-amber-50 transform -translate-y-1' : 'bg-white hover:bg-slate-50 hover:-translate-y-1'"
                        class="rounded-3xl p-5 shadow-lg border border-slate-100 flex flex-col items-center justify-center gap-3 transition-all duration-300 text-center cursor-pointer group">
                        <div class="w-12 h-12 bg-amber-100 rounded-xl flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">⏳</div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Menunggu</p>
                            <p class="font-black text-2xl text-slate-900">{{ $pendingCount }}</p>
                        </div>
                    </button>

                    {{-- 2. Kotak Diproses --}}
                    <button @click="filter = filter === 'processing' ? 'all' : 'processing'"
                        :class="filter === 'processing' ? 'ring-4 ring-blue-400 bg-blue-50 transform -translate-y-1' :
                            'bg-white hover:bg-slate-50 hover:-translate-y-1'"
                        class="rounded-3xl p-5 shadow-lg border border-slate-100 flex flex-col items-center justify-center gap-3 transition-all duration-300 text-center cursor-pointer group">
                        <div
                            class="w-12 h-12 bg-blue-100 rounded-xl flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">
                            📦</div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Diproses</p>
                            <p class="font-black text-2xl text-slate-900">{{ $processCount }}</p>
                        </div>
                    </button>

                    {{-- 3. Kotak Dikirim --}}
                    <button @click="filter = filter === 'shipped' ? 'all' : 'shipped'"
                        :class="filter === 'shipped' ? 'ring-4 ring-indigo-400 bg-indigo-50 transform -translate-y-1' :
                            'bg-white hover:bg-slate-50 hover:-translate-y-1'"
                        class="rounded-3xl p-5 shadow-lg border border-slate-100 flex flex-col items-center justify-center gap-3 transition-all duration-300 text-center cursor-pointer group">
                        <div
                            class="w-12 h-12 bg-indigo-100 rounded-xl flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">
                            🚚</div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Dikirim</p>
                            <p class="font-black text-2xl text-slate-900">{{ $shippedCount }}</p>
                        </div>
                    </button>

                    {{-- 4. Kotak Selesai --}}
                    <button @click="filter = filter === 'completed' ? 'all' : 'completed'"
                        :class="filter === 'completed' ? 'ring-4 ring-emerald-400 bg-emerald-50 transform -translate-y-1' :
                            'bg-white hover:bg-slate-50 hover:-translate-y-1'"
                        class="rounded-3xl p-5 shadow-lg border border-slate-100 flex flex-col items-center justify-center gap-3 transition-all duration-300 text-center cursor-pointer group">
                        <div
                            class="w-12 h-12 bg-emerald-100 rounded-xl flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">
                            ✅</div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Selesai</p>
                            <p class="font-black text-2xl text-slate-900">{{ $completedCount }}</p>
                        </div>
                    </button>

                    {{-- 5. Kotak Dibatalkan --}}
                    <button @click="filter = filter === 'cancelled' ? 'all' : 'cancelled'"
                        :class="filter === 'cancelled' ? 'ring-4 ring-red-400 bg-red-50 transform -translate-y-1' :
                            'bg-white hover:bg-slate-50 hover:-translate-y-1'"
                        class="rounded-3xl p-5 shadow-lg border border-slate-100 flex flex-col items-center justify-center gap-3 transition-all duration-300 text-center cursor-pointer group">
                        <div
                            class="w-12 h-12 bg-red-100 rounded-xl flex items-center justify-center text-xl shadow-inner group-hover:scale-110 transition-transform">
                            ❌</div>
                        <div>
                            <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Dibatalkan</p>
                            <p class="font-black text-2xl text-slate-900">{{ $cancelledCount }}</p>
                        </div>
                    </button>

                </div>

                {{-- RIWAYAT BELANJA --}}
                <div class="bg-white rounded-[2.5rem] shadow-sm border border-slate-100 p-8 md:p-10 mb-10">
                    <div class="flex justify-between items-center mb-8 border-b border-slate-100 pb-4">
                        <h3 class="text-2xl font-black text-slate-900 flex items-center gap-3">
                            Riwayat Belanja
                            {{-- Badge Status Aktif (Muncul saat kotak diklik) --}}
                            <span x-show="filter !== 'all'"
                                class="text-xs px-3 py-1 bg-slate-900 text-white rounded-full font-bold ml-2"
                                x-text="filter === 'unpaid' ? 'Filter: Belum Dibayar' : (filter === 'processing' ? 'Filter: Diproses' : 'Filter: Selesai')"></span>
                        </h3>

                        {{-- Tombol Lihat Semua --}}
                        <a href="{{ url('/pesanan-saya') }}"
                            class="text-sm font-bold text-blue-600 hover:text-blue-800 transition-colors flex items-center gap-1">
                            Lihat Semua
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                            </svg>
                        </a>
                    </div>

                    <div class="space-y-4">
                        @foreach ($orders as $order)
                            {{-- Item Pesanan --}}
                            <div x-show="visibleIds.includes({{ $order->id }})"
                                x-transition:enter="transition ease-out duration-300"
                                x-transition:enter-start="opacity-0 transform scale-95"
                                x-transition:enter-end="opacity-100 transform scale-100"
                                class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-5 rounded-3xl border border-slate-300 hover:border-blue-500 transition-all group bg-white hover:shadow-md"
                                style="{{ $loop->iteration > 7 ? 'display: none;' : '' }}">

                                {{-- Kiri: Info Produk --}}
                                <div class="flex items-center gap-4">
                                    <div
                                        class="w-14 h-14 bg-slate-50 group-hover:bg-blue-50 text-slate-400 group-hover:text-blue-500 rounded-2xl flex items-center justify-center text-2xl shrink-0 transition-colors">
                                        🛍️</div>
                                    <div>
                                        <p class="text-xs font-bold text-slate-400 mb-1 tracking-wide">
                                            {{ $order->order_number }} &bull;
                                            {{ $order->created_at->format('d M Y, H:i') }}</p>
                                        <p class="font-extrabold text-slate-900 text-base">
                                            @if ($order->items->count() > 0 && $order->items->first()->product)
                                                {{ $order->items->first()->product->name }}
                                                @if ($order->items->count() > 1)
                                                    <span
                                                        class="text-xs font-medium text-slate-500 font-normal ml-1">(+{{ $order->items->count() - 1 }}
                                                        produk lainnya)</span>
                                                @endif
                                            @else
                                                Pesanan Tanpa Produk
                                            @endif
                                        </p>
                                    </div>
                                </div>

                                {{-- Tengah: Badges --}}
                                <div class="flex flex-wrap items-center gap-2">
                                    <span
                                        class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-wider">{{ str_contains(strtolower($order->address), 'midtrans') ? 'Transfer/E-Wallet' : 'COD' }}</span>

                                    @if ($order->payment_status === 'paid')
                                        <span
                                            class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-[10px] font-black uppercase tracking-wider">Lunas</span>
                                    @elseif($order->payment_status === 'cancelled')
                                        <span
                                            class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-[10px] font-black uppercase tracking-wider">Dibatalkan</span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-[10px] font-black uppercase tracking-wider">Belum
                                            Bayar</span>
                                    @endif

                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-slate-100 text-slate-700',
                                            'processing' => 'bg-blue-100 text-blue-700',
                                            'shipped' => 'bg-indigo-100 text-indigo-700',
                                            'delivered' => 'bg-teal-100 text-teal-800',
                                            'completed' => 'bg-emerald-100 text-emerald-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'processing' => 'Diproses',
                                            'shipped' => 'Dikirim',
                                            'delivered' => 'Tiba di Tujuan',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 {{ $statusColors[$order->order_status] }} rounded-lg text-[10px] font-black uppercase tracking-wider">
                                        {{ $statusLabels[$order->order_status] }}
                                    </span>
                                </div>

                                {{-- Kanan: Harga & Tombol --}}
                                <div
                                    class="flex items-center gap-6 w-full md:w-auto justify-between md:justify-end border-t md:border-t-0 border-slate-100 pt-4 md:pt-0 mt-2 md:mt-0">
                                    <div class="text-left md:text-right">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">
                                            Total</p>
                                        <p class="font-black text-slate-900 text-lg">Rp
                                            {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </div>
                                    <a href="{{ route('customer.order.show', $order->order_number) }}"
                                        class="px-5 py-2.5 bg-white border-2 border-slate-100 text-slate-600 hover:text-blue-600 hover:border-blue-600 font-bold text-xs rounded-xl transition-colors shrink-0">
                                        Detail
                                    </a>
                                </div>
                            </div>
                        @endforeach

                        {{-- Tampilan Kosong Jika Filter Tidak Menemukan Data --}}
                        <div x-show="visibleIds.length === 0" style="display: none;"
                            class="text-center py-12 bg-slate-50 rounded-3xl border border-slate-100 border-dashed">
                            <div class="text-5xl mb-4 opacity-50">📭</div>
                            <p class="font-extrabold text-slate-700 text-lg">Tidak ada pesanan</p>
                            <p class="text-slate-500 text-sm mt-1">Belum ada riwayat pesanan untuk kategori ini.</p>
                        </div>
                    </div>
                </div>

            </div>

            {{-- Card Riwayat Belanja (Kompak & Rapi) --}}


        </div>
    </div>

    {{-- @if ($orders->whereIn('payment_status', ['unpaid', 'pending'])->whereNotNull('snap_token')->count() > 0)
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>

    @endif --}}

    @if (session('success') || session('error'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 5000)"
            x-transition:enter="ease-out duration-500 transition-all" x-transition:enter-start="opacity-0 translate-y-10"
            x-transition:enter-end="opacity-100 translate-y-0" x-transition:leave="ease-in duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0 translate-y-10"
            class="fixed bottom-8 right-8 z-[200] {{ session('success') ? 'bg-slate-900' : 'bg-red-600' }} text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 border {{ session('success') ? 'border-slate-700' : 'border-red-500' }}">

            <div class="bg-white/20 p-2 rounded-xl">
                @if (session('success'))
                    <svg class="w-6 h-6 text-blue-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                @else
                    <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                @endif
            </div>
            <span class="font-bold text-sm md:text-base">{{ session('success') ?? session('error') }}</span>
            <button @click="show = false" class="text-white/70 hover:text-white transition-colors ml-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    @endif

    @if ($orders->whereIn('payment_status', ['unpaid', 'pending'])->whereNotNull('snap_token')->count() > 0)
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>

        <script>
            function payWithMidtrans(snapToken, orderNumber) {
                snap.pay(snapToken, {
                    // JIKA PEMBAYARAN SUKSES DI SIMULATOR
                    onSuccess: function(result) {
                        // Arahkan ke rute sukses untuk mengubah status di database jadi LUNAS
                        window.location.href = "/checkout/success/" + orderNumber;
                    },
                    // JIKA PEMBAYARAN PENDING (Misal: Pilih Transfer Bank tapi belum ditransfer)
                    onPending: function(result) {
                        alert("Sip! Silakan selesaikan transfermu ya.");
                        window.location.reload();
                    },
                    // JIKA ERROR
                    onError: function(result) {
                        alert("Maaf, pembayaran gagal!");
                    },
                    // JIKA POP-UP DITUTUP SEBELUM BAYAR
                    onClose: function() {
                        console.log("Pop-up ditutup tanpa menyelesaikan pembayaran");
                    }
                });
            }
        </script>
    @endif

@endsection
