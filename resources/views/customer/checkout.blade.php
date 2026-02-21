@extends('layouts.front')

@section('title', 'Checkout Pesanan - GadgetStore')

@section('content')
<div class="min-h-screen py-12 md:py-20" x-data="{ paymentMethod: 'midtrans' }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-10">
            <h1 class="font-display text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">Checkout</h1>
            <p class="text-slate-500 font-medium">Lengkapi alamat pengiriman dan pilih metode pembayaran.</p>
        </div>

        <form action="{{ route('checkout.pay') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">
            @csrf

            <div class="lg:col-span-8 space-y-8">
                <div class="bg-white rounded-[2rem] p-8 shadow-lg border border-slate-200">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        Alamat Pengiriman
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nama Penerima</label>
                            <input type="text" name="recipient_name" value="{{ auth()->user()->name }}" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3.5 focus:ring-1 focus:ring-blue-600 outline-none transition-all text-slate-700">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-700 mb-2">Nomor WhatsApp</label>
                            <input type="number" name="phone_number" placeholder="0812xxxxxx" required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3.5 focus:ring-1 focus:ring-blue-600 outline-none transition-all text-slate-700">
                        </div>
                    </div>

                    <div>
                        <label class="block text-sm font-bold text-slate-700 mb-2">Alamat Lengkap</label>
                        <textarea name="shipping_address" rows="4" placeholder="Nama Jalan, RT/RW, Kelurahan, Kecamatan, Kota/Kab, Provinsi, Kode Pos..." required class="w-full bg-slate-50 border border-slate-300 rounded-xl p-3.5 focus:ring-1 focus:ring-blue-600 outline-none transition-all text-slate-700"></textarea>
                    </div>
                </div>

                <div class="bg-white rounded-[2rem] p-8 shadow-lg border border-slate-200">
                    <h3 class="text-xl font-bold text-slate-900 mb-6 flex items-center gap-2">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z"></path></svg>
                        Metode Pembayaran
                    </h3>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="midtrans" x-model="paymentMethod" class="peer sr-only">
                            <div class="p-5 border-2 rounded-2xl transition-all peer-checked:border-blue-600 peer-checked:bg-blue-50/50 hover:border-blue-300">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-slate-900">Transfer / E-Wallet</span>
                                    <span class="w-4 h-4 rounded-full border-2 border-slate-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 flex items-center justify-center">
                                        <span class="w-2 h-2 rounded-full bg-white" x-show="paymentMethod === 'midtrans'"></span>
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500">Otomatis dicek via Midtrans (Gopay, OVO, VA Bank, QRIS).</p>
                            </div>
                        </label>

                        <label class="relative cursor-pointer">
                            <input type="radio" name="payment_method" value="cod" x-model="paymentMethod" class="peer sr-only">
                            <div class="p-5 border-2 rounded-2xl transition-all peer-checked:border-teal-600 peer-checked:bg-teal-50/50 hover:border-teal-300">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="font-bold text-slate-900">Bayar di Tempat (COD)</span>
                                    <span class="w-4 h-4 rounded-full border-2 border-slate-300 peer-checked:border-teal-600 peer-checked:bg-teal-600 flex items-center justify-center">
                                        <span class="w-2 h-2 rounded-full bg-white" x-show="paymentMethod === 'cod'"></span>
                                    </span>
                                </div>
                                <p class="text-xs text-slate-500">Bayar tunai langsung ke kurir saat barang sampai.</p>
                            </div>
                        </label>
                    </div>
                </div>
            </div>

            <div class="lg:col-span-4">
                <div class="bg-[#0B0B45]/90 text-white rounded-[2rem] p-8 shadow-2xl sticky top-32 border border-slate-700/50">
                    <h3 class="text-xl font-bold mb-6 border-b border-slate-500 pb-4">Pesanan Kamu</h3>

                    <div class="space-y-4 mb-6 max-h-[300px] overflow-y-auto pr-2 custom-scrollbar">
                        @foreach($checkoutItems as $item)
                            <div class="flex gap-4 items-start">
                                <img src="{{ $item['product']->image }}" class="w-16 h-16 rounded-xl object-cover bg-white">
                                <div>
                                    <p class="font-bold text-sm line-clamp-2">{{ $item['product']->name }}</p>
                                    <p class="text-xs text-slate-400 mt-1">
                                        {{ $item['quantity'] }}x @ Rp {{ number_format($item['product']->price, 0, ',', '.') }}
                                        @if($item['variant']) | {{ $item['variant'] }} @endif
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="h-px bg-slate-500 my-4"></div>

                    <div class="space-y-4 mb-8">
                        <div class="flex justify-between items-center">
                            <span class="text-lg font-bold">Total Tagihan</span>
                            <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-300">
                                Rp {{ number_format($totalAmount, 0, ',', '.') }}
                            </span>
                        </div>
                    </div>

                    <button type="submit" class="w-full block text-center text-white rounded-2xl font-extrabold text-lg py-4 transition-all shadow-lg transform hover:-translate-y-1"
                            :class="paymentMethod === 'cod' ? 'bg-teal-600 hover:bg-teal-500 shadow-teal-500/30' : 'bg-blue-600 hover:bg-blue-500 shadow-blue-500/30'">
                        Buat Pesanan
                    </button>

                </div>
            </div>
        </form>
    </div>
</div>

<style>
/* Kustomisasi scrollbar untuk daftar barang di keranjang kanan */
.custom-scrollbar::-webkit-scrollbar { width: 4px; }
.custom-scrollbar::-webkit-scrollbar-track { background: transparent; }
.custom-scrollbar::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.2); border-radius: 4px; }
</style>
@endsection
