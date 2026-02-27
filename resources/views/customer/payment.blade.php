@extends('layouts.front')
@section('title', 'Menunggu Pembayaran - GadgetStore')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-12 md:py-20 text-center min-h-[80vh] flex items-center justify-center">

    {{-- Kartu Utama (Glassmorphism Dark Blue) --}}
    <div class="w-full bg-[#0B1426]/90 backdrop-blur-xl rounded-[2.5rem] shadow-2xl shadow-blue-900/20 border border-white/10 p-8 md:p-12 relative overflow-hidden">

        {{-- Dekorasi Latar Belakang (Glow Effects) --}}
        <div class="absolute top-0 right-0 w-80 h-80 bg-blue-600 rounded-full mix-blend-screen filter blur-[100px] opacity-20 pointer-events-none animate-pulse"></div>
        <div class="absolute bottom-0 left-0 w-80 h-80 bg-teal-500 rounded-full mix-blend-screen filter blur-[100px] opacity-15 pointer-events-none"></div>

        <div class="relative z-10">
            {{-- Header: Judul & Ikon --}}
            <div class="mb-8">
                <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 text-white rounded-3xl flex items-center justify-center mx-auto mb-6 shadow-lg shadow-blue-500/30 transform rotate-3 hover:rotate-6 transition-transform">
                    <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
                </div>
                <h1 class="font-display text-2xl md:text-4xl font-black text-white mb-3 tracking-tight">Menunggu Pembayaran</h1>
                <p class="text-blue-200 text-sm md:text-base max-w-lg mx-auto leading-relaxed">Pesananmu berhasil dibuat. Amankan stok produkmu dengan menyelesaikan pembayaran sebelum waktu habis.</p>
            </div>

            {{-- ⏰ COUNTDOWN TIMER --}}
            <div class="bg-white/5 border border-white/10 rounded-2xl p-6 mb-10 max-w-md mx-auto backdrop-blur-sm">
                <p class="text-xs font-bold text-blue-300 uppercase tracking-widest mb-3">Sisa Waktu Pembayaran</p>
                <div class="flex justify-center gap-4 text-white font-mono" id="countdown-timer">
                    {{-- Timer akan diisi oleh Javascript --}}
                    <span class="text-3xl font-black tracking-widest animate-pulse">-- : -- : --</span>
                </div>
                <p class="text-[10px] text-slate-400 mt-3">Batas Akhir: {{ $order->created_at->addHours(24)->format('d M Y, H:i') }} WIB</p>
            </div>

            {{-- Detail Tagihan --}}
            <div class="bg-white rounded-3xl p-6 md:p-8 mb-8 max-w-md mx-auto text-left shadow-xl relative overflow-hidden">
                <div class="absolute top-0 left-0 w-full h-1.5 bg-gradient-to-r from-blue-500 via-indigo-500 to-teal-400"></div>

                <div class="flex justify-between items-center mb-6 border-b border-slate-100 pb-4">
                    <div>
                        <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Nomor Order</span>
                        <span class="font-bold text-slate-800 text-lg">{{ $order->order_number }}</span>
                    </div>
                    <div class="text-right">
                        <span class="block text-[10px] font-extrabold text-slate-400 uppercase tracking-widest mb-1">Metode</span>
                        <span class="font-bold text-indigo-600 text-sm bg-indigo-50 px-3 py-1 rounded-full">Transfer / QRIS</span>
                    </div>
                </div>

                <div class="flex justify-between items-center bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <span class="text-sm font-bold text-slate-500">Total Tagihan</span>
                    <span class="font-black text-2xl text-slate-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="flex flex-col gap-4 max-w-xs mx-auto">
                <button id="pay-button" class="w-full bg-gradient-to-r from-blue-600 to-indigo-600 hover:from-blue-500 hover:to-indigo-500 text-white py-4 rounded-xl font-bold text-lg shadow-lg shadow-blue-600/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-2 group">
                    Bayar Sekarang
                    <svg class="w-5 h-5 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>

                <a href="{{ route('dashboard') }}" class="text-sm font-bold text-slate-400 hover:text-white transition-colors py-2">
                    Bayar Nanti (Masuk Dashboard)
                </a>
            </div>
        </div>
    </div>
</div>

{{-- SCRIPT MIDTRANS & COUNTDOWN --}}
<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script>
    // --- 1. LOGIKA COUNTDOWN TIMER ---
    // Ambil waktu order dibuat dari PHP, tambah 24 jam, ubah ke format timestamp JS
    const orderTime = new Date("{{ $order->created_at->format('Y-m-d H:i:s') }}").getTime();
    // const expiryTime = orderTime + (24 * 60 * 60 * 1000); // Tambah 24 Jam (dalam milidetik)
    const expiryTime = orderTime + (3 * 60 * 1000);

    const timerElement = document.getElementById("countdown-timer");

    function updateTimer() {
        const now = new Date().getTime();
        const distance = expiryTime - now;

        if (distance < 0) {
            timerElement.innerHTML = "<span class='text-red-400 font-bold'>Waktu Habis</span>";
            document.getElementById("pay-button").disabled = true;
            document.getElementById("pay-button").classList.add("opacity-50", "cursor-not-allowed");
            document.getElementById("pay-button").innerText = "Pesanan Kadaluarsa";
            return;
        }

        const hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        timerElement.innerHTML = `
            <div class="text-center"><span class="text-3xl md:text-4xl font-black">${hours}</span><br><span class="text-[10px] text-slate-400 font-sans font-normal tracking-normal">JAM</span></div>
            <span class="text-2xl mt-1">:</span>
            <div class="text-center"><span class="text-3xl md:text-4xl font-black">${minutes}</span><br><span class="text-[10px] text-slate-400 font-sans font-normal tracking-normal">MENIT</span></div>
            <span class="text-2xl mt-1">:</span>
            <div class="text-center"><span class="text-3xl md:text-4xl font-black">${seconds}</span><br><span class="text-[10px] text-slate-400 font-sans font-normal tracking-normal">DETIK</span></div>
        `;
    }

    setInterval(updateTimer, 1000);
    updateTimer(); // Jalankan langsung biar gak nunggu 1 detik

    // --- 2. LOGIKA TOMBOL BAYAR MIDTRANS ---
    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            onSuccess: function(result){ window.location.href = "/checkout/success/{{ $order->order_number }}"; },
            onPending: function(result){ window.location.href = "{{ route('dashboard') }}"; },
            onError: function(result){ alert('Pembayaran gagal!'); window.location.href = "{{ route('dashboard') }}"; },
            onClose: function(){ console.log('Pop-up ditutup'); }
        });
    };
</script>
@endsection
