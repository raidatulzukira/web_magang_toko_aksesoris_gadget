@extends('layouts.admin')
@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">

        {{-- Navigasi Kembali --}}
        <a href="{{ route('admin.orders.index') }}"
            class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold text-sm mb-6 transition-colors group">
            <div class="w-8 h-8 rounded-full bg-white border border-slate-200 flex items-center justify-center group-hover:bg-blue-50 group-hover:border-blue-200 transition-all shadow-sm">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                </svg>
            </div>
            Kembali ke Pesanan Masuk
        </a>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- KOLOM KIRI: Detail Utama --}}
            <div class="lg:col-span-2 space-y-6">

                {{-- KARTU HEADER & STATUS --}}
                <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden relative">
                    {{-- Latar Header --}}
                    <div class="bg-[#0f172a] p-8 relative overflow-hidden">
                        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-600 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>

                        <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-4">
                            <div>
                                <p class="text-blue-300 font-bold text-xs uppercase tracking-widest mb-1">Nomor Invoice</p>
                                <h1 class="font-display text-3xl font-black text-white tracking-tight">{{ $order->order_number }}</h1>
                                <p class="text-slate-400 text-sm mt-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ $order->created_at->format('d F Y, H:i') }} WIB
                                </p>
                            </div>

                            {{-- Status Badge Utama --}}
                            <div>
                                @php
                                    $statusLabels = [
                                        'pending'    => 'Menunggu Konfirmasi',
                                        'processing' => 'Sedang Diproses',
                                        'shipped'    => 'Sedang Dikirim',
                                        'completed'  => 'Selesai',
                                        'cancelled'  => 'Dibatalkan',
                                    ];
                                    $statusClasses = [
                                        'pending'    => 'bg-amber-500/20 text-amber-100 border-amber-500/30',
                                        'processing' => 'bg-blue-500/20 text-blue-100 border-blue-500/30',
                                        'shipped'    => 'bg-indigo-500/20 text-indigo-100 border-indigo-500/30',
                                        'completed'  => 'bg-emerald-500/20 text-emerald-100 border-emerald-500/30',
                                        'cancelled'  => 'bg-red-500/20 text-red-100 border-red-500/30',
                                    ];
                                @endphp
                                <span class="px-5 py-2.5 rounded-xl border backdrop-blur-md font-bold text-sm shadow-lg {{ $statusClasses[$order->order_status] ?? 'bg-slate-500/20 text-white' }}">
                                    {{ $statusLabels[$order->order_status] ?? strtoupper($order->order_status) }}
                                </span>
                            </div>
                        </div>
                    </div>

                    {{-- 🛑 ALERT DIBATALKAN (Prioritas Tertinggi) --}}
                    @if ($order->order_status == 'cancelled')
                        <div class="bg-red-50 border-b border-red-100 p-6 flex items-start gap-4">
                            <div class="w-10 h-10 rounded-full bg-red-100 border border-red-200 flex items-center justify-center shrink-0 text-red-600">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"></path></svg>
                            </div>
                            <div>
                                <h4 class="font-bold text-red-800 text-base mb-1">Pesanan Dibatalkan</h4>
                                <p class="text-sm text-red-600 font-medium leading-relaxed">
                                    Pesanan ini telah dibatalkan karena melewati batas waktu pembayaran.
                                </p>
                            </div>
                        </div>

                    {{-- ⏳ COUNTDOWN TIMER (Hanya jika Transfer & Belum Lunas & Belum Batal) --}}
                    @elseif (($order->payment_status === 'unpaid' || $order->payment_status === 'pending') && $order->snap_token)
                        <div class="bg-amber-50 border-b border-amber-100 p-4 flex items-center justify-between gap-4">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-amber-100 text-amber-600 rounded-lg flex items-center justify-center shrink-0 animate-pulse">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-amber-800 uppercase tracking-wide">Batas Waktu Pembayaran Customer</p>
                                    <p id="admin-countdown" class="font-mono font-black text-lg text-amber-600">-- : -- : --</p>
                                </div>
                            </div>
                            <div class="text-right hidden sm:block">
                                <p class="text-[10px] text-amber-500 font-bold uppercase">Berakhir Pada</p>
                                <p class="text-xs font-bold text-amber-700">{{ $order->created_at->addHours(24)->format('d M Y, H:i') }}</p>
                            </div>
                        </div>
                    @endif

                    <div class="p-8">
                        {{-- Data Pembeli --}}
                        {{-- GANTI BAGIAN "Data Penerima" DENGAN INI --}}
                        <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-4 flex items-center gap-2">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path></svg>
                            Data Penerima & Lokasi
                        </h3>
                        <div class="bg-slate-50 rounded-2xl p-6 border border-slate-200">
                            @php
                                // 1. Ekstrak string bawaan Controller (Pisahkan dengan ' | ')
                                $parts = explode(' | ', $order->address);
                                $alamatPenuh = isset($parts[1]) ? $parts[1] : $order->address;

                                // 2. Ekstrak Metode Pembayaran (Ini ada di urutan ke-3 alias index 2)
                                $metodePembayaran = isset($parts[2]) ? str_replace('Metode: ', '', $parts[2]) : 'Tidak diketahui';

                                // 3. Ekstrak Detail Rumah Manual vs Peta
                                $detailRumah = '-';
                                $alamatMaps = $alamatPenuh;

                                if (strpos($alamatPenuh, ' ||| ') !== false) {
                                    $splitManual = explode(' ||| ', $alamatPenuh);
                                    $detailRumah = $splitManual[0];
                                    $alamatMaps = $splitManual[1];
                                }
                            @endphp
                            {{-- Baris Info (Dibuat 3 Kolom) --}}
                            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase mb-1">Nama Penerima</p>
                                    <p class="font-bold text-slate-800 text-lg">{{ $order->user->name ?? 'Guest' }}</p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase mb-1">Nomor Telepon</p>
                                    <p class="font-bold text-slate-800 text-lg flex items-center gap-2">
                                        <svg class="w-4 h-4 text-green-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                                        {{ $order->phone ?? '-' }}
                                    </p>
                                </div>
                                <div>
                                    <p class="text-xs font-bold text-slate-400 uppercase mb-1">Metode Bayar</p>
                                    <p class="font-black text-blue-700 text-lg flex items-center gap-2">
                                        @if(trim(strtoupper($metodePembayaran)) == 'COD')
                                            🤝 COD
                                        @else
                                            💳 Transfer
                                        @endif
                                    </p>
                                </div>
                            </div>

                            {{-- <div class="md:col-span-2 bg-white p-4 rounded-xl border-l-4 border-blue-500 shadow-sm">
                                <p class="text-xs font-bold text-slate-400 uppercase mb-2 flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path></svg>
                                    Detail Alamat Lengkap
                                </p>
                                <p class="font-medium text-slate-800 leading-relaxed text-sm">
                                    {{ $order->address }}
                                </p>
                            </div> --}}
                            @php
                                $parts = explode(' | ', $order->address);
                                $alamatPenuh = isset($parts[1]) ? $parts[1] : $order->address;

                                $detailRumah = '-';
                                $alamatMaps = $alamatPenuh;

                                if (strpos($alamatPenuh, ' ||| ') !== false) {
                                    $splitManual = explode(' ||| ', $alamatPenuh);
                                    $detailRumah = $splitManual[0];
                                    $alamatMaps = $splitManual[1];
                                }
                            @endphp

                            <div class="md:col-span-2 space-y-4 mt-2">
                                {{-- Kotak 1: Detail Rumah --}}
                                <div class="bg-yellow-50 p-4 rounded-xl border border-yellow-200">
                                    <p class="text-xs font-black text-yellow-700 uppercase mb-1">📝 Patokan / Detail Rumah</p>
                                    <p class="font-medium text-slate-600 text-sm">
                                        {{ $detailRumah }}
                                    </p>
                                </div>

                                {{-- Kotak 2: Titik Peta --}}
                                <div class="bg-white p-4 rounded-xl border border-slate-200 shadow-sm">
                                    <p class="text-sm font-bold text-slate-700 uppercase mb-2 flex items-center gap-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path></svg>
                                        Titik Alamat Peta
                                    </p>
                                    <p class="font-medium text-slate-600 leading-relaxed text-sm">
                                        {{ $alamatMaps }}
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- KARTU PRODUK --}}
                <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/60 border border-slate-100 overflow-hidden p-8">
                    <h3 class="text-sm font-black text-slate-900 uppercase tracking-widest mb-6 flex items-center gap-2">
                        <svg class="w-5 h-5 text-indigo-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
                        Item Pesanan
                    </h3>

                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div class="flex items-center gap-5 p-4 rounded-2xl border border-slate-100 hover:bg-slate-50 transition-colors">
                                {{-- Gambar Produk --}}
                                <div class="w-16 h-16 rounded-xl bg-white border border-slate-200 overflow-hidden shrink-0">
                                    @if ($item->product && $item->product->image)
                                        @php
                                            $imagePath = Str::startsWith($item->product->image, ['http://', 'https://'])
                                                ? $item->product->image
                                                : asset('storage/' . str_replace('public/', '', $item->product->image));
                                        @endphp
                                        <img src="{{ $imagePath }}" class="w-full h-full object-cover" alt="Product">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-2xl">📦</div>
                                    @endif
                                </div>

                                {{-- Detail Nama & Harga --}}
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-900 text-sm md:text-base">{{ $item->product->name ?? 'Produk dihapus' }}</h4>
                                    <p class="text-xs font-bold text-slate-500 mt-1">
                                        {{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>

                                {{-- Subtotal --}}
                                <div class="font-black text-slate-900">
                                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- Total Footer --}}
                    <div class="mt-6 pt-6 border-t-2 border-dashed border-slate-100 flex justify-between items-center">
                        <span class="font-bold text-slate-500 uppercase text-xs tracking-widest">Total Transaksi</span>
                        <span class="font-black text-2xl text-blue-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                    </div>
                </div>

            </div>

            {{-- KOLOM KANAN: Panel Kontrol --}}
            <div class="lg:col-span-1">
                <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/60 border border-slate-100 p-6 sticky top-6">
                    <h3 class="font-black text-slate-900 text-lg mb-6 flex items-center gap-2">
                        <div class="w-8 h-8 rounded-lg bg-slate-900 text-white flex items-center justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6V4m0 2a2 2 0 100 4m0-4a2 2 0 110 4m-6 8a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4m6 6v10m6-2a2 2 0 100-4m0 4a2 2 0 110-4m0 4v2m0-6V4"></path></svg>
                        </div>
                        Panel Kontrol
                    </h3>

                    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST" class="space-y-6">
                        @csrf
                        @method('PUT')

                        {{-- 1. Status Pembayaran (Read Only) --}}
                        <div class="bg-slate-50 p-4 rounded-2xl border border-slate-200">
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-wider mb-2">Status Pembayaran</label>

                            @if ($order->payment_status == 'paid')
                                <div class="w-full bg-emerald-100 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl font-bold text-sm flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    LUNAS (Paid)
                                </div>
                            @elseif ($order->payment_status == 'cancelled')
                                <div class="w-full bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl font-bold text-sm flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                                    DIBATALKAN
                                </div>
                            @else
                                <div class="w-full bg-amber-100 border border-amber-200 text-amber-700 px-4 py-3 rounded-xl font-bold text-sm flex items-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                    BELUM DIBAYAR
                                </div>
                            @endif

                            <p class="text-[10px] text-slate-400 mt-2 italic">*Status ini berubah otomatis.</p>
                            <input type="hidden" name="payment_status" value="{{ $order->payment_status }}">
                        </div>

                        {{-- 2. Status Pengiriman (Dropdown) --}}
                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Update Pengiriman</label>
                            <div class="relative">
                                <select name="order_status" class="w-full bg-white border-2 border-slate-200 text-slate-800 rounded-xl px-4 py-3.5 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 font-bold text-sm appearance-none cursor-pointer outline-none transition-all hover:border-blue-400">
                                    <option value="pending" {{ $order->order_status == 'pending' ? 'selected' : '' }}>🕒 Menunggu Konfirmasi</option>
                                    <option value="processing" {{ $order->order_status == 'processing' ? 'selected' : '' }}>📦 Sedang Diproses</option>
                                    <option value="shipped" {{ $order->order_status == 'shipped' ? 'selected' : '' }}>🚚 Sedang Dikirim</option>
                                    <option value="completed" {{ $order->order_status == 'completed' ? 'selected' : '' }}>✅ Pesanan Selesai</option>
                                    <option value="cancelled" {{ $order->order_status == 'cancelled' ? 'selected' : '' }}>❌ Dibatalkan</option>
                                </select>
                                <div class="absolute right-4 top-1/2 -translate-y-1/2 text-slate-400 pointer-events-none">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path></svg>
                                </div>
                            </div>
                        </div>

                        {{-- Tombol Simpan --}}
                        @if ($order->order_status !== 'cancelled' && $order->order_status !== 'completed')
                            <button type="submit" class="w-full bg-slate-900 hover:bg-blue-600 text-white font-bold py-4 rounded-xl shadow-lg shadow-slate-900/20 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                                Simpan Perubahan
                            </button>
                        @else
                            <div class="w-full bg-slate-100 text-slate-400 font-bold py-4 rounded-xl text-center border border-slate-200 cursor-not-allowed">
                                Pesanan Final
                            </div>
                        @endif

                    </form>
                </div>
            </div>

        </div>
    </div>

    {{-- SCRIPT COUNTDOWN ADMIN --}}
    @if (($order->payment_status === 'unpaid' || $order->payment_status === 'pending') && $order->snap_token && $order->order_status != 'cancelled')
    <script>
        // Ambil waktu dari PHP
        const orderTime = new Date("{{ $order->created_at->format('Y-m-d H:i:s') }}").getTime();
        // Set waktu expiry (sesuaikan dengan logic controller, misal 24 jam atau 2 menit testing)
        // Gunakan 2 menit untuk sinkron dengan mode testingmu saat ini
        const expiryTime = orderTime + (3 * 60 * 1000);
        // const expiryTime = orderTime + (24 * 60 * 60 * 1000); // Mode Production

        function updateAdminTimer() {
            const now = new Date().getTime();
            const distance = expiryTime - now;
            const timerElement = document.getElementById("admin-countdown");

            if (!timerElement) return;

            if (distance < 0) {
                timerElement.innerHTML = "<span class='text-red-500'>Waktu Habis (Akan Batal Otomatis)</span>";
                return;
            }

            const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            const seconds = Math.floor((distance % (1000 * 60)) / 1000);

            timerElement.innerText = `${hours}j ${minutes}m ${seconds}d`;
        }

        setInterval(updateAdminTimer, 1000);
        updateAdminTimer();
    </script>
    @endif
@endsection
