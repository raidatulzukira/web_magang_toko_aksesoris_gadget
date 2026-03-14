@extends('layouts.front')
@section('title', 'Semua Pesanan Saya - GadgetStore')

@section('content')
    <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">

        {{-- Breadcrumb minimalis --}}
        <nav class="mb-8 flex text-sm text-slate-500 font-medium">
            <a href="{{ route('home') }}" class="hover:text-blue-600 transition-colors">Home</a>
            <span class="mx-2">/</span>
            <a href="{{ url('/dashboard') }}" class="hover:text-blue-600 transition-colors">Dashboard</a>
            <span class="mx-2">/</span>
            <span class="text-slate-800">Semua Pesanan</span>
        </nav>

        <div class="space-y-8">
            {{-- Header Page --}}
            <div class="flex flex-col md:flex-row justify-between items-start md:items-end gap-6 border-b border-slate-200 pb-6">
                <div>
                    <h1 class="font-display text-3xl md:text-4xl font-extrabold text-slate-900 tracking-tight mb-2">
                        Riwayat Pesanan
                    </h1>
                    <p class="text-slate-500 font-medium">Lacak, pantau, dan kelola seluruh transaksi belanjamu di sini.</p>
                </div>
            </div>

            {{-- Menghitung Jumlah Status (Sama seperti Dashboard) --}}
            @php
                $pendingCount = $orders->where('order_status', 'pending')->count();
                $processCount = $orders->where('order_status', 'processing')->count();
                $shippedCount = $orders->where('order_status', 'shipped')->count();
                $completedCount = $orders->where('order_status', 'completed')->count();
                $cancelledCount = $orders->where('order_status', 'cancelled')->count();
            @endphp

            {{-- ALPINE JS WRAPPER (Termasuk Fitur Pencarian & Filter) --}}
            <div x-data="{
                filter: 'all',
                searchQuery: '',
                orders: [
                    @foreach ($orders as $order)
                    {
                        id: {{ $order->id }},
                        category: '{{ $order->order_status }}',
                        invoice: '{{ strtolower($order->order_number) }}'
                    },
                    @endforeach
                ],
                get visibleIds() {
                    // 1. Filter by Status
                    let filtered = this.filter === 'all' ? this.orders : this.orders.filter(o => o.category === this.filter);

                    // 2. Filter by Search Query (Nomor Invoice)
                    if (this.searchQuery.trim() !== '') {
                        filtered = filtered.filter(o => o.invoice.includes(this.searchQuery.toLowerCase().trim()));
                    }

                    // KEMBALIKAN SEMUA DATA (Tanpa ada .slice(0,7) limit)
                    return filtered.map(o => o.id);
                }
            }">

                {{-- KONTROL FILTER & PENCARIAN --}}
                <div class="bg-white rounded-[2rem] p-4 md:p-6 shadow-xl shadow-slate-200/50 border border-slate-100 flex flex-col xl:flex-row gap-6 mb-10 sticky top-4 z-20">

                    {{-- Tombol Filter Status (Bisa di-scroll ke samping di HP) --}}
                    <div class="flex-1 overflow-x-auto hide-scrollbar pb-2 xl:pb-0">
                        <div class="flex items-center gap-3 min-w-max">
                            <button @click="filter = 'all'" :class="filter === 'all' ? 'bg-slate-900 text-white shadow-lg shadow-slate-900/20' : 'bg-slate-100 text-slate-500 hover:bg-slate-200'" class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-300">
                                Semua
                            </button>
                            <button @click="filter = 'pending'" :class="filter === 'pending' ? 'bg-amber-500 text-white shadow-lg shadow-amber-500/30' : 'bg-amber-50 text-amber-700 hover:bg-amber-100'" class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-300 flex items-center gap-2">
                                ⏳ Menunggu <span class="bg-white/20 px-2 py-0.5 rounded-lg text-xs">{{ $pendingCount }}</span>
                            </button>
                            <button @click="filter = 'processing'" :class="filter === 'processing' ? 'bg-blue-500 text-white shadow-lg shadow-blue-500/30' : 'bg-blue-50 text-blue-700 hover:bg-blue-100'" class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-300 flex items-center gap-2">
                                📦 Diproses <span class="bg-white/20 px-2 py-0.5 rounded-lg text-xs">{{ $processCount }}</span>
                            </button>
                            <button @click="filter = 'shipped'" :class="filter === 'shipped' ? 'bg-indigo-500 text-white shadow-lg shadow-indigo-500/30' : 'bg-indigo-50 text-indigo-700 hover:bg-indigo-100'" class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-300 flex items-center gap-2">
                                🚚 Dikirim <span class="bg-white/20 px-2 py-0.5 rounded-lg text-xs">{{ $shippedCount }}</span>
                            </button>
                            <button @click="filter = 'completed'" :class="filter === 'completed' ? 'bg-emerald-500 text-white shadow-lg shadow-emerald-500/30' : 'bg-emerald-50 text-emerald-700 hover:bg-emerald-100'" class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-300 flex items-center gap-2">
                                ✅ Selesai <span class="bg-white/20 px-2 py-0.5 rounded-lg text-xs">{{ $completedCount }}</span>
                            </button>
                            <button @click="filter = 'cancelled'" :class="filter === 'cancelled' ? 'bg-red-500 text-white shadow-lg shadow-red-500/30' : 'bg-red-50 text-red-700 hover:bg-red-100'" class="px-5 py-3 rounded-xl font-bold text-sm transition-all duration-300 flex items-center gap-2">
                                ❌ Batal <span class="bg-white/20 px-2 py-0.5 rounded-lg text-xs">{{ $cancelledCount }}</span>
                            </button>
                        </div>
                    </div>

                    {{-- Kotak Pencarian Invoice --}}
                    <div class="relative xl:w-72 shrink-0">
                        <div class="absolute inset-y-0 left-0 pl-4 flex items-center pointer-events-none text-slate-400">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path></svg>
                        </div>
                        <input type="text" x-model="searchQuery" placeholder="Cari No. Invoice..." class="w-full pl-12 pr-4 py-3 bg-slate-50 border border-slate-200 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all text-sm font-bold text-slate-700 placeholder:font-medium">
                    </div>
                </div>

                {{-- LIST PESANAN KESELURUHAN --}}
                <div class="space-y-5 mb-10">
                    @forelse ($orders as $order)
                        {{-- Kartu Pesanan Individual --}}
                        <div x-show="visibleIds.includes({{ $order->id }})"
                            x-transition:enter="transition ease-out duration-300"
                            x-transition:enter-start="opacity-0 transform translate-y-4"
                            x-transition:enter-end="opacity-100 transform translate-y-0"
                            class="bg-white p-6 rounded-[2rem] shadow-sm border border-slate-100 hover:border-blue-400 hover:shadow-xl hover:shadow-blue-500/10 transition-all duration-300 group flex flex-col md:flex-row gap-6 items-start md:items-center">

                            {{-- Gambar Ikon Kiri --}}
                            <div class="w-20 h-20 bg-slate-50 group-hover:bg-blue-50 text-slate-400 group-hover:text-blue-500 rounded-2xl flex items-center justify-center text-3xl shrink-0 transition-colors border border-slate-100 group-hover:border-blue-100">
                                @if($order->order_status == 'completed') 🎁
                                @elseif($order->order_status == 'cancelled') 💔
                                @elseif($order->order_status == 'shipped') 🛵
                                @else 🛍️ @endif
                            </div>

                            {{-- Detail Utama --}}
                            <div class="flex-1 min-w-0">
                                <div class="flex items-center gap-3 mb-2">
                                    <p class="font-mono text-sm font-black text-slate-900 bg-slate-100 px-3 py-1 rounded-lg border border-slate-200">
                                        {{ $order->order_number }}
                                    </p>
                                    <p class="text-xs font-bold text-slate-400">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>

                                <h3 class="font-black text-lg text-slate-800 truncate">
                                    @if ($order->items->count() > 0 && $order->items->first()->product)
                                        {{ $order->items->first()->product->name }}
                                        @if ($order->items->count() > 1)
                                            <span class="text-sm font-medium text-slate-500 ml-1">(+{{ $order->items->count() - 1 }} produk lainnya)</span>
                                        @endif
                                    @else
                                        Pesanan Tanpa Produk
                                    @endif
                                </h3>

                                <div class="flex items-center gap-2 mt-3">
                                    <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-[10px] font-black uppercase tracking-wider">{{ str_contains(strtolower($order->address), 'midtrans') ? 'Transfer' : 'COD' }}</span>

                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-amber-100 text-amber-700',
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
                                    <span class="px-3 py-1 {{ $statusColors[$order->order_status] }} rounded-lg text-[10px] font-black uppercase tracking-wider">
                                        {{ $statusLabels[$order->order_status] }}
                                    </span>
                                </div>
                            </div>

                            {{-- Kanan: Harga & Tombol --}}
                            <div class="flex md:flex-col items-center md:items-end justify-between w-full md:w-auto gap-4 md:gap-2 pt-4 md:pt-0 border-t md:border-t-0 border-slate-100 md:border-transparent md:pl-6 md:border-l">
                                <div class="text-left md:text-right">
                                    <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-0.5">Total Harga</p>
                                    <p class="font-black text-blue-600 text-xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                </div>
                                <a href="{{ route('customer.order.show', $order->order_number) }}" class="px-6 py-3 bg-white border-2 border-slate-200 text-slate-600 hover:text-white hover:bg-slate-900 hover:border-slate-900 font-bold text-sm rounded-xl transition-all shadow-sm hover:shadow-lg hover:shadow-slate-900/20 shrink-0 transform hover:-translate-y-0.5">
                                    Lihat Detail
                                </a>
                            </div>

                        </div>
                    @empty
                        {{-- Ini akan tampil dari PHP jika Database kosong total --}}
                        <div class="text-center py-20 bg-slate-50 rounded-[3rem] border border-slate-100 border-dashed">
                            <div class="text-6xl mb-6 opacity-40">🛒</div>
                            <h2 class="font-extrabold text-slate-800 text-2xl mb-2">Belum ada pesanan</h2>
                            <p class="text-slate-500 font-medium">Kamu belum pernah melakukan transaksi apa pun.</p>
                            <a href="{{ route('home') }}" class="inline-block mt-6 px-8 py-4 bg-blue-600 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 hover:bg-blue-700 transition-colors">Belanja Sekarang</a>
                        </div>
                    @endforelse

                    {{-- Ini akan tampil dari Javascript jika pencarian tidak ditemukan --}}
                    <div x-show="visibleIds.length === 0 && {{ $orders->count() }} > 0" style="display: none;" class="text-center py-16 bg-white rounded-[3rem] shadow-sm border border-slate-100">
                        <div class="text-5xl mb-4 opacity-50">🔍</div>
                        <h2 class="font-extrabold text-slate-700 text-xl mb-1">Pesanan tidak ditemukan</h2>
                        <p class="text-slate-500 text-sm">Coba ubah filter atau kata kunci pencarianmu.</p>
                        <button @click="filter = 'all'; searchQuery = ''" class="mt-4 text-blue-600 font-bold hover:underline">Reset Pencarian</button>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
