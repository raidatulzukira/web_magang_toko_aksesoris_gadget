@extends('layouts.front')
@section('title', 'Menunggu Pembayaran - GadgetStore')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-16 text-center min-h-[70vh] flex items-center justify-center">

    <div class="w-full bg-[#19284C]/70 rounded-[2.5rem] shadow-xl shadow-blue-900/5 border border-slate-100 p-10 md:p-16 relative overflow-hidden">
        {{-- Dekorasi Latar Belakang --}}
        <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full mix-blend-multiply filter blur-[80px] opacity-10 pointer-events-none"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-teal-400 rounded-full mix-blend-multiply filter blur-[80px] opacity-10 pointer-events-none"></div>

        <div class="relative z-10">
            {{-- Ikon Sukses --}}
            <div class="w-24 h-24 bg-emerald-50 text-emerald-500 rounded-full flex items-center justify-center mx-auto mb-6 shadow-inner border border-emerald-100">
                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
            </div>

            <h1 class="font-display text-3xl font-black text-slate-900 mb-2">Pesanan Berhasil Dibuat!</h1>
            <p class="text-white-500 mb-10 text-sm md:text-base">Terima kasih, pesananmu telah tercatat. Silakan selesaikan pembayaran untuk memproses pesanan.</p>

            {{-- Ringkasan Mini --}}
            <div class="bg-slate-50 border border-slate-100 rounded-3xl p-6 md:p-8 mb-10 max-w-md mx-auto text-left relative overflow-hidden group">
                <div class="absolute left-0 top-0 bottom-0 w-1.5 bg-blue-500"></div>

                <div class="flex justify-between items-end mb-4 border-b border-slate-200/60 pb-4">
                    <div>
                        <span class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-1">Nomor Pesanan</span>
                        <span class="font-black text-slate-800">{{ $order->order_number }}</span>
                    </div>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-bold text-slate-500">Total Tagihan</span>
                    <span class="font-black text-2xl text-blue-600">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
                </div>
            </div>

            {{-- Tombol Aksi --}}
            <div class="space-y-4">
                <button id="pay-button" class="w-full md:w-auto bg-slate-900 hover:bg-blue-600 text-white px-12 py-4 rounded-full font-bold text-lg shadow-xl shadow-slate-900/20 hover:shadow-blue-500/30 transition-all transform hover:-translate-y-1 flex items-center justify-center gap-3 mx-auto">
                    Pilih Metode Pembayaran
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                </button>

                <div class="pt-4">
                    <a href="{{ route('dashboard') }}" class="text-sm font-bold text-white-400 hover:text-slate-700 transition-colors">
                        Bayar Nanti (Kembali ke Dashboard)
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
<script type="text/javascript">
    // Script otomatis klik (window.onload) SUDAH DIHAPUS.
    // Sekarang pop-up hanya muncul JIKA tombol diklik.

    document.getElementById('pay-button').onclick = function () {
        snap.pay('{{ $snapToken }}', {
            // JIKA SUKSES BAYAR
            onSuccess: function(result){
                window.location.href = "/checkout/success/{{ $order->order_number }}";
            },
            // JIKA PENDING
            onPending: function(result){
                window.location.href = "{{ route('dashboard') }}";
            },
            // JIKA ERROR
            onError: function(result){
                alert('Maaf, pembayaran gagal!');
                window.location.href = "{{ route('dashboard') }}";
            },
            // JIKA POP-UP DITUTUP MANUAL
            onClose: function(){
                // Tidak melakukan apa-apa agar user tetap di halaman ini dan bisa klik tombol lagi
                console.log('Pop-up ditutup');
            }
        });
    };
</script>
@endsection
