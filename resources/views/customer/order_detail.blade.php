@extends('layouts.front')
@section('title', 'Detail Pesanan ' . $order->order_number)

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">

    {{-- Tombol Kembali --}}
    <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 text-slate-500 hover:text-blue-600 font-bold text-sm mb-4 transition-colors mt-6">
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
        Kembali ke Dashboard
    </a>

    <div class="bg-white rounded-[1.5rem] shadow-[0_8px_30px_rgb(0,0,0,0.04)] border border-slate-100 overflow-hidden mb-6">

        {{-- Header Struk --}}
        <div class="bg-slate-700 p-8 text-white flex flex-col md:flex-row justify-between md:items-center gap-6 relative overflow-hidden">
            <div class="absolute top-0 right-0 w-64 h-64 bg-blue-500 rounded-full mix-blend-screen filter blur-[80px] opacity-20"></div>
            <div class="relative z-10">
                <p class="text-blue-400 font-bold text-xs uppercase tracking-widest mb-1">Nomor Pesanan</p>
                <h1 class="font-display text-2xl md:text-3xl font-black">{{ $order->order_number }}</h1>
                <p class="text-slate-400 text-sm mt-2">{{ $order->created_at->format('d F Y, H:i') }} WIB</p>
            </div>

            <div class="relative z-10 text-left md:text-right">
                <p class="text-slate-400 font-bold text-xs uppercase tracking-widest mb-2">Status Pesanan</p>
                @if($order->payment_status === 'unpaid' || $order->payment_status === 'pending')
                    <span class="inline-block px-4 py-2 bg-amber-500 text-white font-black text-sm rounded-xl shadow-lg shadow-amber-500/30 animate-pulse">
                        ⏳ Menunggu Pembayaran
                    </span>
                @elseif($order->order_status === 'pending')
                    <span class="inline-block px-4 py-2 bg-slate-600 text-white font-black text-sm rounded-xl">Menunggu Diproses</span>
                @elseif($order->order_status === 'processing')
                    <span class="inline-block px-4 py-2 bg-blue-500 text-white font-black text-sm rounded-xl shadow-lg shadow-blue-500/30">📦 Sedang Diproses</span>
                @elseif($order->order_status === 'shipped')
                    <span class="inline-block px-4 py-2 bg-indigo-500 text-white font-black text-sm rounded-xl shadow-lg shadow-indigo-500/30">🚚 Sedang Dikirim</span>
                @elseif($order->order_status === 'completed')
                    <span class="inline-block px-4 py-2 bg-emerald-500 text-white font-black text-sm rounded-xl shadow-lg shadow-emerald-500/30">✅ Selesai</span>
                @endif
            </div>
        </div>

        <div class="p-8 space-y-8">
            {{-- Info Pengiriman --}}
            <div>
                <h3 class="text-lg font-black text-slate-900 mb-4 border-b border-slate-100 pb-3">Informasi Pengiriman</h3>
                <div class="bg-slate-50 rounded-2xl p-5 border border-slate-100">
                    <p class="font-bold text-slate-800">{{ auth()->user()->name }} <span class="text-slate-400 font-medium ml-2">{{ $order->phone ?? '' }}</span></p>
                    <p class="text-slate-600 mt-2 text-sm leading-relaxed">{{ $order->address }}</p>
                </div>
            </div>

            {{-- Daftar Produk --}}
            <div>
                <h3 class="text-lg font-black text-slate-900 mb-4 border-b border-slate-100 pb-3">Rincian Pembelian</h3>
                <div class="space-y-4">
                    @foreach($order->items as $item)
                        <div class="flex items-center gap-4">
                            <div class="w-16 h-16 rounded-xl bg-slate-100 border border-slate-200 overflow-hidden shrink-0">
                                @if($item->product && $item->product->image)
                                    @php
                                        $imagePath = Str::startsWith($item->product->image, ['http://', 'https://'])
                                            ? $item->product->image
                                            : asset('storage/' . str_replace('public/', '', $item->product->image));
                                    @endphp
                                    <img src="{{ $imagePath }}" class="w-full h-full object-cover" alt="{{ $item->product->name }}">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-2xl">📦</div>
                                @endif
                            </div>
                            <div class="flex-1">
                                <h4 class="font-bold text-slate-900">{{ $item->product->name ?? 'Produk Dihapus' }}</h4>
                                <p class="text-sm text-slate-500">{{ $item->quantity }} x Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                            </div>
                            <div class="font-black text-slate-900">
                                Rp {{ number_format($item->quantity * $item->price, 0, ',', '.') }}
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- Total Tagihan --}}
            <div class="border-t-2 border-dashed border-slate-200 pt-6 mt-6">
                <div class="flex justify-between items-center mb-2">
                    <p class="font-bold text-slate-500">Metode Pembayaran</p>
                    <p class="font-bold text-slate-800 uppercase">{{ str_contains(strtolower($order->address), 'midtrans') ? 'Transfer / E-Wallet' : 'Bayar di Tempat (COD)' }}</p>
                </div>
                <div class="flex justify-between items-center mt-4 bg-blue-50 p-4 rounded-xl border border-blue-100">
                    <p class="font-black text-blue-800 uppercase tracking-widest text-sm">Total Tagihan</p>
                    <p class="font-black text-blue-600 text-2xl">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                </div>

                {{-- Tombol Bayar Midtrans jika belum lunas --}}
                @if(($order->payment_status === 'unpaid' || $order->payment_status === 'pending') && $order->snap_token)
                    <div class="mt-6 text-right">
                        <button onclick="payWithMidtrans('{{ $order->snap_token }}', '{{ $order->order_number }}')" class="bg-slate-900 hover:bg-blue-600 text-white px-8 py-4 rounded-full font-bold shadow-xl transition-all w-full md:w-auto">
                            Lanjutkan Pembayaran
                        </button>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>

{{-- Script Midtrans --}}
@if(($order->payment_status === 'unpaid' || $order->payment_status === 'pending') && $order->snap_token)
    <script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ config('midtrans.client_key') }}"></script>
    <script>
        function payWithMidtrans(snapToken, orderNumber) {
            snap.pay(snapToken, {
                onSuccess: function(result){ window.location.href = "/checkout/success/" + orderNumber; },
                onPending: function(result){ window.location.reload(); },
                onError: function(result){ alert("Pembayaran gagal!"); }
            });
        }
    </script>
@endif
@endsection
