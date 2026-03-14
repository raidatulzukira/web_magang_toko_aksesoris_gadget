@extends('layouts.front')
@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
    <div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">

        {{-- Tombol Kembali --}}
        <a href="{{ route('dashboard') }}"
            class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold text-sm mb-6 transition-colors group">
            <div
                class="w-8 h-8 rounded-full bg-slate-100 flex items-center justify-center group-hover:bg-blue-100 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18">
                    </path>
                </svg>
            </div>
            Kembali ke Dashboard
        </a>

        <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden mb-8">

            {{-- HEADER: JUDUL & STATUS --}}
            <div class="bg-[#0B1426] p-8 md:p-10 text-white relative overflow-hidden">
                {{-- Dekorasi Latar Belakang --}}
                <div
                    class="absolute top-0 right-0 w-64 h-64 bg-blue-600 rounded-full mix-blend-screen filter blur-[80px] opacity-20 animate-pulse">
                </div>
                <div
                    class="absolute bottom-0 left-0 w-64 h-64 bg-teal-500 rounded-full mix-blend-screen filter blur-[80px] opacity-10">
                </div>

                <div class="relative z-10 flex flex-col md:flex-row justify-between items-start md:items-center gap-6">
                    <div>
                        <p class="text-blue-200 font-heading text-xs font-bold tracking-widest uppercase mb-2">Nomor Pesanan
                        </p>
                        <h1 class="font-display text-3xl md:text-4xl font-black tracking-tight">{{ $order->order_number }}
                        </h1>
                        <p class="text-blue-100 text-sm mt-2 font-medium flex items-center gap-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                            {{ $order->created_at->format('d F Y, H:i') }} WIB
                        </p>
                    </div>

                    <div class="text-left md:text-right">
                        <p class="text-blue-200 font-heading text-xs font-bold tracking-widest uppercase mb-3">Status Saat
                            Ini</p>
                        @php
                            $statusLabels = [
                                'processing' => '📦 Sedang Diproses',
                                'shipped' => '🚚 Sedang Dikirim',
                                'delivered' => '📍 Tiba di Tujuan',
                                'completed' => '✅ Selesai',
                            ];
                        @endphp

                        @if ($order->order_status == 'pending')
                            <span
                                class="bg-amber-500/20 border border-amber-400/50 text-amber-100 px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 backdrop-blur-md shadow-lg shadow-amber-900/20">
                                ⏳ Menunggu Pembayaran
                            </span>
                        @elseif($order->order_status == 'cancelled')
                            <span
                                class="bg-red-500/20 border border-red-400/50 text-red-100 px-5 py-2.5 rounded-xl text-sm font-bold flex items-center gap-2 backdrop-blur-md shadow-lg shadow-red-900/20">
                                ❌ Dibatalkan
                            </span>
                        @else
                            <span
                                class="bg-white/10 border border-white/20 text-white px-5 py-2.5 rounded-xl text-sm font-bold backdrop-blur-md shadow-lg">
                                {{ $statusLabels[$order->order_status] ?? $order->order_status }}
                            </span>
                        @endif
                    </div>
                </div>
            </div>

            {{-- ⏰ FITUR COUNTDOWN (Hanya Muncul Jika Belum Lunas & Bukan COD) --}}
            @if (
                ($order->payment_status === 'unpaid' || $order->payment_status === 'pending') &&
                    $order->snap_token &&
                    $order->order_status != 'cancelled')
                <div
                    class="bg-indigo-50 border-b border-indigo-100 p-6 flex flex-col md:flex-row items-center justify-between gap-4">
                    <div class="flex items-center gap-4">
                        <div
                            class="w-12 h-12 bg-indigo-100 text-indigo-600 rounded-xl flex items-center justify-center shrink-0">
                            <svg class="w-6 h-6 animate-pulse" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="font-bold text-indigo-900">Selesaikan Pembayaran Dalam:</p>
                            <p id="countdown-timer" class="font-mono font-black text-xl text-indigo-600">-- : -- : --</p>
                        </div>
                    </div>
                    <div class="text-right">
                        <p class="text-xs text-indigo-400 font-bold uppercase tracking-wider mb-1">Batas Waktu</p>
                        <p class="text-sm font-bold text-indigo-800">
                            {{ $order->created_at->addHours(24)->format('d M Y, H:i') }} WIB</p>
                    </div>
                </div>
            @endif

            <div class="p-8 md:p-10 space-y-10">

                {{-- 🚚 KARTU PELACAKAN RESI (Hanya Muncul Jika Sudah Dikirim & Ada Resi) --}}
                {{-- @if ($order->order_status == 'shipped' && $order->tracking_number)
                    <div class="bg-gradient-to-r from-blue-600 to-indigo-600 rounded-[2rem] p-6 md:p-8 text-white shadow-xl shadow-blue-500/30 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">

                        <div class="absolute -right-10 -top-10 w-40 h-40 bg-white rounded-full mix-blend-overlay opacity-10"></div>

                        <div class="flex items-center gap-5 relative z-10 w-full md:w-auto">
                            <div class="w-16 h-16 bg-white/20 backdrop-blur-md border border-white/30 rounded-2xl flex items-center justify-center text-3xl shrink-0 shadow-inner">
                                📦
                            </div>
                            <div class="flex-1">
                                <p class="text-blue-100 text-xs font-bold uppercase tracking-widest mb-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0"></path></svg>
                                    Dikirim via {{ strtoupper($order->courier) }}
                                </p>
                                <div class="flex items-center gap-3">
                                    <h4 class="font-mono text-2xl md:text-3xl font-black tracking-wider drop-shadow-md">
                                        {{ $order->tracking_number }}
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 w-full md:w-auto relative z-10">

                            <button onclick="copyResi('{{ $order->tracking_number }}')" class="flex-1 md:flex-none bg-white/10 hover:bg-white/20 border border-white/30 text-white px-5 py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2 backdrop-blur-sm">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path></svg>
                                Salin
                            </button>


                            <a href="https://cekresi.com/?noresi={{ $order->tracking_number }}" target="_blank" class="flex-1 md:flex-none bg-white text-indigo-600 hover:bg-blue-50 px-6 py-3 rounded-xl font-black shadow-lg shadow-black/10 transition-all flex items-center justify-center gap-2 transform hover:-translate-y-1">
                                Lacak Live
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"></path></svg>
                            </a>
                        </div>
                    </div>
                @endif --}}

                {{-- 🚚 KARTU PELACAKAN RESI (SMART LOGIC) --}}
                @if ($order->order_status == 'shipped' && $order->tracking_number)
                    @php
                        // 1. Cek apakah teks yang diinput Admin adalah sebuah Link (URL)
                        $isLink = filter_var($order->tracking_number, FILTER_VALIDATE_URL);

                        // 2. Daftar Kurir yang TIDAK BISA dilacak di CekResi.com
                        $kurirLokal = ['GOSEND', 'GRAB', 'LALAMOVE', 'MAXIM', 'KURIR_TOKO', 'AMBIL_SENDIRI', 'LAINNYA'];
                        $isLokal = in_array($order->courier, $kurirLokal);
                    @endphp

                    <div
                        class="bg-gradient-to-r from-slate-700 to-indigo-600 rounded-[2rem] p-8 md:p-6 text-white shadow-xl shadow-blue-500/30 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden">
                        {{-- Dekorasi Card --}}
                        <div
                            class="absolute -right-10 -top-10 w-60 h-40 bg-white rounded-full mix-blend-overlay opacity-15">
                        </div>

                        <div class="ml-0 flex items-center gap-5 relative z-10 w-full md:w-auto">
                            <div
                                class="w-12 h-12 bg-white/20 backdrop-blur-md border border-white/30 rounded-2xl flex items-center justify-center text-3xl shrink-0 shadow-inner">
                                @if ($isLokal)
                                    🛵
                                @else
                                    📦
                                @endif
                            </div>
                            <div class="flex-1 min-w-0">
                                <p
                                    class="text-blue-100 text-xs font-bold uppercase tracking-widest mb-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16V6a1 1 0 00-1-1H4a1 1 0 00-1 1v10a1 1 0 001 1h1m8-1a1 1 0 01-1 1H9m4-1V8a1 1 0 011-1h2.586a1 1 0 01.707.293l3.414 3.414a1 1 0 01.293.707V16a1 1 0 01-1 1h-1m-6-1a1 1 0 001 1h1M5 17a2 2 0 104 0m-4 0a2 2 0 114 0m6 0a2 2 0 104 0m-4 0a2 2 0 114 0">
                                        </path>
                                    </svg>
                                    Dikirim via {{ strtoupper($order->courier) }}
                                </p>

                                {{-- Menampilkan Nomor Resi / Plat / Teks --}}
                                <div class="flex items-center gap-3">
                                    <h4
                                        class="font-mono text-xl md:text-xl font-black tracking-wider drop-shadow-md uppercase break-all">
                                        @if ($isLink)
                                            <span class="text-lg">Link Pelacakan Tersedia</span>
                                        @else
                                            {{ $order->tracking_number }}
                                        @endif
                                    </h4>
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center gap-4 w-full md:w-auto relative z-10">
                            {{-- Tombol Salin (Hanya muncul jika BUKAN link) --}}
                            @if (!$isLink)
                                <button onclick="copyResi('{{ $order->tracking_number }}')"
                                    class="flex-1 md:flex-none bg-white/10 hover:bg-white/20 border border-white/30 text-white px-5 py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2 backdrop-blur-sm">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                    Salin
                                </button>
                            @endif

                            {{-- SMART BUTTON LOGIC --}}
                            @if ($isLink)
                                {{-- Jika Admin input URL (Maka Buka URL tersebut) --}}
                                <a href="{{ $order->tracking_number }}" target="_blank"
                                    class="flex-1 md:flex-none bg-emerald-400 text-emerald-900 hover:bg-emerald-300 px-6 py-3 rounded-xl font-black shadow-lg shadow-black/10 transition-all flex items-center justify-center gap-2 transform hover:-translate-y-1 mr-0">
                                    Buka Peta Live
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                    </svg>
                                </a>
                            @elseif(!$isLokal)
                                {{-- Jika Kurir Standar (J&T, dll) & Bukan Link (Maka buka CekResi) --}}
                                <a href="https://cekresi.com/?noresi={{ $order->tracking_number }}" target="_blank"
                                    class="flex-1 md:flex-none bg-white text-indigo-600 hover:bg-blue-50 px-6 py-3 rounded-xl font-black shadow-lg shadow-black/10 transition-all flex items-center justify-center gap-2 mr-0 transform hover:-translate-y-1">
                                    Lacak Live
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14">
                                        </path>
                                    </svg>
                                </a>
                            @endif
                            {{-- Catatan: Jika Kurir Lokal DAN BUKAN Link, maka Tombol Lacak tidak ditampilkan (Hanya tombol Salin saja) --}}
                        </div>
                    </div>
                @endif
                {{-- BATAS KARTU PELACAKAN --}}
                {{-- BATAS KARTU PELACAKAN --}}

                {{-- 🔥 TOMBOL KONFIRMASI PESANAN DITERIMA (Hanya Muncul Jika Dikirim) --}}
                {{-- @if ($order->order_status == 'shipped')
                    <div class="bg-gradient-to-r from-emerald-50 to-emerald-100 border border-emerald-200 rounded-[2rem] p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 relative overflow-hidden shadow-sm">
                        <div class="absolute -right-6 -top-6 text-emerald-500/10 text-9xl font-black pointer-events-none">✓</div>
                        <div class="relative z-10 text-center md:text-left">
                            <h3 class="text-xl md:text-2xl font-black text-emerald-900 mb-1">Paket Sudah Diterima?</h3>
                            <p class="text-sm font-medium text-emerald-700">Mohon konfirmasi jika fisik barang sudah sampai dan sesuai pesanan.</p>
                        </div>
                        <form action="{{ route('customer.order.complete', $order->order_number) }}" method="POST" class="w-full md:w-auto relative z-10">
                            @csrf
                            @method('PUT')
                            <button type="submit" onclick="return confirm('Apakah Anda yakin pesanan sudah diterima dengan baik? Status akan menjadi Selesai.')"
                                    class="w-full md:w-auto px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-xl shadow-lg shadow-emerald-600/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                                Pesanan Diterima
                            </button>
                        </form>
                    </div>
                @endif --}}
                {{-- 🔥 TOMBOL KONFIRMASI (ABU-ABU JIKA DIKIRIM, HIJAU JIKA TIBA) --}}
                @if (in_array($order->order_status, ['shipped', 'delivered']))
                    <div
                        class="bg-gradient-to-r from-slate-50 to-slate-100 border border-slate-200 rounded-[2rem] p-6 md:p-8 flex flex-col md:flex-row items-center justify-between gap-6 relative shadow-sm mt-8">

                        <div class="relative z-10 w-full md:w-auto">
                            <h3 class="text-xl font-black text-slate-800 mb-1 text-center md:text-left">Konfirmasi Pesanan
                            </h3>
                            @if ($order->order_status == 'shipped')
                                <p
                                    class="text-sm font-medium text-amber-600 bg-amber-50 px-3 py-1.5 rounded-lg inline-block border border-amber-200 mt-2">
                                    ⏳ Menunggu kurir mengantarkan paket...
                                </p>
                            @else
                                <p
                                    class="text-sm font-medium text-emerald-600 bg-emerald-50 px-3 py-1.5 rounded-lg inline-block border border-emerald-200 mt-2">
                                    Paket telah dinyatakan tiba oleh kurir.
                                </p>
                            @endif
                        </div>

                        {{-- Form Tombol --}}
                        <form action="{{ route('customer.order.complete', $order->order_number) }}" method="POST"
                            class="w-full md:w-auto">
                            @csrf
                            @method('PUT')

                            @if ($order->order_status == 'shipped')
                                {{-- Tombol Abu-abu (Mati) --}}
                                <button type="button" disabled
                                    class="w-full md:w-auto px-8 py-4 bg-slate-300 text-slate-500 font-black rounded-xl cursor-not-allowed flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z">
                                        </path>
                                    </svg>
                                    Belum Bisa Dikonfirmasi
                                </button>
                            @else
                                {{-- Tombol Hijau (Aktif) --}}
                                <button type="submit" onclick="return confirm('Yakin paket sudah diterima dengan baik?')"
                                    class="w-full md:w-auto px-8 py-4 bg-emerald-600 hover:bg-emerald-700 text-white font-black rounded-xl shadow-lg shadow-emerald-600/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                    <svg class="w-6 h-6 animate-bounce" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M5 13l4 4L19 7"></path>
                                    </svg>
                                    Pesanan Diterima
                                </button>
                            @endif
                        </form>
                    </div>
                @endif
                {{-- BATAS TOMBOL KONFIRMASI --}}
                {{-- BATAS TOMBOL KONFIRMASI --}}

                {{-- GANTI BAGIAN "Informasi Pengiriman" DENGAN INI --}}
                {{-- GANTI BAGIAN "Informasi Pengiriman" DENGAN INI --}}
                <div>
                    <h3 class="text-lg font-black text-slate-900 mb-5 flex items-center gap-2">
                        <span class="w-1 h-6 bg-blue-600 rounded-full"></span> Informasi Pengiriman
                    </h3>
                    <div
                        class="bg-slate-50 rounded-2xl p-6 border border-slate-100 hover:border-blue-200 transition-colors">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Penerima</p>
                                <p class="font-bold text-slate-900 text-lg">{{ auth()->user()->name }}</p>
                            </div>
                            <div>
                                <p class="text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">WhatsApp</p>
                                <p class="font-bold text-slate-900 text-lg">{{ $order->phone ?? '-' }}</p>
                            </div>
                        </div>

                        {{-- Logika Pemisah Alamat Super Aman --}}
                        @php
                            // 1. Pisahkan format dari Controller (Nama | Alamat | Metode)
                            $parts = explode(' | ', $order->address);
                            $alamatPenuh = isset($parts[1]) ? $parts[1] : $order->address;

                            // 2. Pisahkan Detail Manual dan Maps menggunakan simbol |||
                            $alamatSplit = explode(' ||| ', $alamatPenuh);

                            // Jika ada simbol |||, berarti format baru
                            if (count($alamatSplit) > 1) {
                                $detailRumah = $alamatSplit[0];
                                $alamatMaps = $alamatSplit[1];
                            } else {
                                // Jika order lama, tampilkan semua di maps
                                $detailRumah = '-';
                                $alamatMaps = $alamatPenuh;
                            }
                        @endphp

                        <div class="grid grid-cols-1 gap-4">
                            {{-- Kotak Detail Rumah --}}
                            <div class="bg-indigo-50 p-4 rounded-xl border border-indigo-100 shadow-sm">
                                <p
                                    class="text-xs font-bold text-indigo-500 uppercase tracking-widest mb-1 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                        </path>
                                    </svg>
                                    Detail Rumah / Patokan
                                </p>
                                <p class="text-indigo-900 text-base font-black">
                                    {{ $detailRumah }}
                                </p>
                            </div>

                            {{-- Kotak Titik Peta --}}
                            <div class="bg-white p-4 rounded-xl border-l-4 border-blue-500 shadow-sm">
                                <p
                                    class="text-xs font-bold text-blue-500 uppercase tracking-widest mb-2 flex items-center gap-1">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                        </path>
                                    </svg>
                                    Titik Alamat Peta
                                </p>
                                <p class="text-slate-700 text-sm leading-relaxed font-medium">
                                    {{ $alamatMaps }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Daftar Produk --}}
                <div>
                    <h3 class="text-lg font-black text-slate-900 mb-5 flex items-center gap-2">
                        <span class="w-1 h-6 bg-indigo-600 rounded-full"></span> Rincian Pembelian
                    </h3>
                    <div class="space-y-4">
                        @foreach ($order->items as $item)
                            <div
                                class="flex items-center gap-5 p-4 rounded-2xl border border-slate-100 hover:shadow-md transition-all bg-white group">
                                <div
                                    class="w-20 h-20 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0 relative">
                                    @if ($item->product && $item->product->image)
                                        @php
                                            $imagePath = Str::startsWith($item->product->image, ['http://', 'https://'])
                                                ? $item->product->image
                                                : asset('storage/' . str_replace('public/', '', $item->product->image));
                                        @endphp
                                        <img src="{{ $imagePath }}"
                                            class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-500"
                                            alt="{{ $item->product->name }}">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center text-3xl">📦</div>
                                    @endif
                                </div>
                                <div class="flex-1">
                                    <h4 class="font-bold text-slate-900 text-base md:text-lg mb-1">
                                        {{ $item->product->name ?? 'Produk Dihapus' }}</h4>

                                        @if ($item->variant_info)
                                        <p class="text-xs font-bold text-indigo-600 mb-2 flex items-center gap-1">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"></path></svg>
                                            Varian: {{ $item->variant_info }}
                                        </p>
                                    @endif

                                    <p
                                        class="text-sm font-medium text-slate-500 bg-slate-100 px-2 py-1 rounded-md inline-block">
                                        {{ $item->quantity }} barang &times; Rp
                                        {{ number_format($item->price, 0, ',', '.') }}
                                    </p>
                                </div>
                                <div class="font-black text-slate-900 text-lg md:text-xl">
                                    Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                {{-- Total Tagihan & Pembayaran --}}
                <div
                    class="bg-gradient-to-br from-slate-50 to-white border border-slate-200 rounded-3xl p-8 relative overflow-hidden">
                    <div
                        class="absolute top-0 right-0 w-32 h-32 bg-blue-100 rounded-full mix-blend-multiply filter blur-3xl opacity-50">
                    </div>

                    <div class="relative z-10">
                        <div
                            class="flex flex-col md:flex-row justify-between items-center gap-6 mb-8 border-b border-slate-200 pb-6">
                            <div>
                                <p class="font-bold text-slate-500 mb-1">Metode Pembayaran</p>
                                <div class="flex items-center gap-2">
                                    <div
                                        class="w-2 h-2 rounded-full {{ str_contains(strtolower($order->address), 'midtrans') ? 'bg-blue-500' : 'bg-slate-800' }}">
                                    </div>
                                    <p class="font-black text-slate-800 uppercase text-lg tracking-tight">
                                        {{ str_contains(strtolower($order->address), 'midtrans') ? 'Transfer / E-Wallet' : 'Bayar di Tempat (COD)' }}
                                    </p>
                                </div>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-slate-500 mb-1">Total Tagihan</p>
                                <p
                                    class="font-black text-3xl text-transparent bg-clip-text bg-gradient-to-r from-blue-700 to-indigo-600">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </p>
                            </div>
                        </div>

                        {{-- Tombol Bayar Midtrans --}}
                        @if (
                            ($order->payment_status === 'unpaid' || $order->payment_status === 'pending') &&
                                $order->snap_token &&
                                $order->order_status != 'cancelled')
                            <div class="text-right">
                                <button
                                    onclick="payWithMidtrans('{{ $order->snap_token }}', '{{ $order->order_number }}')"
                                    class="w-full md:w-auto bg-slate-900 hover:bg-blue-700 text-white px-10 py-4 rounded-xl font-bold shadow-xl hover:shadow-blue-900/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3 ml-auto">
                                    Lanjutkan Pembayaran
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 8l4 4m0 0l-4 4m4-4H3"></path>
                                    </svg>
                                </button>
                                <p class="text-xs text-slate-400 mt-3 font-medium">Klik tombol di atas untuk menyelesaikan
                                    pembayaran via Midtrans.</p>
                            </div>
                        @endif

                        {{-- Jika Dibatalkan --}}
                        {{-- @if ($order->order_status == 'cancelled')
                            <div
                                class="bg-red-50 border border-red-100 rounded-xl p-4 flex items-center gap-3 text-red-700 font-bold">
                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                Pesanan ini telah dibatalkan karena melewati batas waktu pembayaran.
                            </div>
                        @endif --}}
                        {{-- Jika Dibatalkan --}}
                        @if ($order->order_status == 'cancelled')
                            @php
                                $isTransfer = str_contains(strtolower($order->address), 'midtrans');
                            @endphp
                            <div class="bg-red-50 border border-red-100 rounded-xl p-4 flex items-start md:items-center gap-3 text-red-700 mt-4">
                                <svg class="w-6 h-6 shrink-0 mt-0.5 md:mt-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                                <span class="font-bold text-sm leading-snug">
                                    @if($isTransfer)
                                        Pesanan ini telah dibatalkan karena melewati batas waktu pembayaran atau dibatalkan oleh Admin.
                                    @else
                                        Pesanan COD ini dibatalkan oleh Admin. (Kemungkinan karena stok habis atau kendala pada alamat pengiriman).
                                    @endif
                                </span>
                            </div>
                        @endif
                    </div>
                </div>

            </div>
        </div>
    </div>

    {{-- Script Midtrans & Countdown --}}
    @if (
        ($order->payment_status === 'unpaid' || $order->payment_status === 'pending') &&
            $order->snap_token &&
            $order->order_status != 'cancelled')
        <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}">
        </script>
        <script>
            // --- LOGIKA HITUNG MUNDUR (SAMA SEPERTI HALAMAN PAYMENT) ---
            const orderTime = new Date("{{ $order->created_at->format('Y-m-d H:i:s') }}").getTime();
            // Ganti angka 24 * 60 * 60 * 1000 dengan durasi testingmu jika perlu
            // const expiryTime = orderTime + (24 * 60 * 60 * 1000);
            const expiryTime = orderTime + (3 * 60 * 1000);

            function updateDetailTimer() {
                const now = new Date().getTime();
                const distance = expiryTime - now;
                const timerElement = document.getElementById("countdown-timer");

                if (!timerElement) return;

                if (distance < 0) {
                    timerElement.innerHTML = "<span class='text-red-500'>Waktu Habis</span>";
                    return;
                }

                const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                timerElement.innerText = `${hours}j ${minutes}m ${seconds}d`;
            }

            setInterval(updateDetailTimer, 1000);
            updateDetailTimer();

            // --- FUNGSI BAYAR ---
            function payWithMidtrans(snapToken, orderNumber) {
                snap.pay(snapToken, {
                    onSuccess: function(result) {
                        window.location.href = "/checkout/success/" + orderNumber;
                    },
                    onPending: function(result) {
                        window.location.reload();
                    },
                    onError: function(result) {
                        alert("Pembayaran gagal!");
                    }
                });
            }
        </script>
    @endif
    <script>
        function copyResi(resi) {
            navigator.clipboard.writeText(resi).then(() => {
                alert("Hore! Nomor Resi " + resi + " berhasil disalin.");
            }).catch(err => {
                console.error('Gagal menyalin text: ', err);
            });
        }
    </script>
@endsection
