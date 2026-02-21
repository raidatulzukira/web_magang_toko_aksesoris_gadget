@extends('layouts.front')

@section('title', 'Keranjang Belanja - GadgetStore')

@section('content')
<div class="min-h-screen py-12 md:py-20"
     x-data="{
        loaded: false,
        selectedItems: [],
        itemPrices: {
            @foreach($cartItems as $item)
                '{{ $item->id }}': {{ $item->product->price * $item->quantity }},
            @endforeach
        },
        get totalHarga() {
            return this.selectedItems.reduce((total, id) => total + this.itemPrices[id], 0);
        },
        formatRupiah(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }
     }"
     x-init="setTimeout(() => loaded = true, 100)">

    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

        <div class="mb-10 opacity-0 translate-y-4 transition-all duration-700" :class="loaded ? '!opacity-100 !translate-y-0' : ''">
            <h1 class="font-display text-3xl md:text-4xl font-extrabold text-slate-900 mb-2">Keranjang Belanja</h1>
            <p class="text-slate-500 font-medium">Kamu memiliki {{ $cartItems->count() }} barang di keranjang.</p>
        </div>

        @if($cartItems->count() > 0)
            <form action="{{ route('checkout.process') }}" method="POST" class="grid grid-cols-1 lg:grid-cols-12 gap-10 lg:gap-14">
                @csrf

                <div class="lg:col-span-8 space-y-6 opacity-0 translate-y-8 transition-all duration-700 delay-100" :class="loaded ? '!opacity-100 !translate-y-0' : ''">

                    @foreach($cartItems as $item)
                        <div class="bg-white rounded-3xl p-5 md:p-6 shadow-sm shadow-slate-200/50 border border-slate-100 flex flex-col sm:flex-row gap-6 items-center group hover:shadow-lg transition-all duration-300 relative">

                            <div class="absolute sm:static top-6 left-6 z-10">
                                <input type="checkbox" name="cart_ids[]" value="{{ $item->id }}" x-model="selectedItems"
                                       class="w-6 h-6 text-blue-600 bg-slate-100 border-slate-300 rounded focus:ring-blue-500 focus:ring-2 cursor-pointer transition-all">
                            </div>

                            <div class="w-full sm:w-28 h-28 bg-slate-50 rounded-2xl overflow-hidden shrink-0 border border-slate-100 ml-8 sm:ml-0">
                                <img src="{{ $item->product->image }}" alt="{{ $item->product->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                            </div>

                            <div class="flex-1 w-full flex flex-col sm:flex-row justify-between gap-6">
                                <div class="space-y-1">
                                    <h3 class="font-bold text-lg text-slate-900 line-clamp-1 cursor-pointer" @click="selectedItems.includes('{{ $item->id }}') ? selectedItems = selectedItems.filter(i => i !== '{{ $item->id }}') : selectedItems.push('{{ $item->id }}')">
                                        {{ $item->product->name }}
                                    </h3>

                                    @if($item->variant)
                                        <p class="text-xs font-bold text-slate-500 bg-slate-100 border border-slate-200 inline-block px-3 py-1 rounded-lg">Varian: {{ $item->variant }}</p>
                                    @endif

                                    <p class="text-xl font-black text-blue-600 pt-1">Rp {{ number_format($item->product->price, 0, ',', '.') }}</p>
                                </div>

                                <div class="flex items-center justify-between sm:flex-col sm:items-end sm:justify-center gap-4">
                                    <div class="bg-slate-50 border border-slate-200 rounded-xl px-4 py-2 text-sm font-bold text-slate-700 shadow-sm">
                                        Qty: {{ $item->quantity }}
                                    </div>

                                    <a href="#" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $item->id }}').submit();" class="text-slate-400 hover:text-red-500 bg-white hover:bg-red-50 p-2.5 rounded-xl transition-all shadow-sm border border-slate-100 hover:border-red-200" title="Hapus Barang">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path></svg>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endforeach

                </div>

                <div class="lg:col-span-4 opacity-0 translate-y-8 transition-all duration-700 delay-200" :class="loaded ? '!opacity-100 !translate-y-0' : ''">
                    <div class="bg-[#00004b] text-white rounded-[2rem] p-8 shadow-2xl sticky top-32 border border-slate-700/50">
                        <h3 class="text-xl font-bold mb-6 border-b border-slate-500 pb-4">Ringkasan Belanja</h3>

                        <div class="space-y-4 mb-8">
                            <div class="flex justify-between text-slate-300 text-sm font-medium">
                                <span>Total Harga (<span x-text="selectedItems.length"></span> barang)</span>
                                <span class="font-bold text-white">Rp <span x-text="formatRupiah(totalHarga)"></span></span>
                            </div>
                            <div class="h-px bg-slate-500 my-4"></div>
                            <div class="flex justify-between items-center">
                                <span class="text-lg font-bold">Total Tagihan</span>
                                <span class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-300">
                                    Rp <span x-text="formatRupiah(totalHarga)"></span>
                                </span>
                            </div>
                        </div>

                        <button type="submit"
                                :disabled="selectedItems.length === 0"
                                class="w-full block text-center bg-blue-600 hover:bg-blue-500 text-white rounded-2xl font-extrabold text-lg py-4 transition-all shadow-lg shadow-blue-500/30 transform hover:-translate-y-1 disabled:opacity-50 disabled:cursor-not-allowed disabled:hover:translate-y-0 disabled:hover:bg-blue-600">
                            Lanjut ke Pembayaran
                        </button>

                        <p class="text-center text-slate-400 text-xs mt-6 flex items-center justify-center gap-2">
                            <svg class="w-4 h-4 text-teal-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"></path></svg>
                            Checkout aman & terenkripsi
                        </p>
                    </div>
                </div>
            </form>

            @foreach($cartItems as $item)
                <form id="delete-form-{{ $item->id }}" action="{{ route('cart.destroy', $item->id) }}" method="POST" class="hidden">
                    @csrf @method('DELETE')
                </form>
            @endforeach

        @else
            <div class="bg-white rounded-[3rem] p-12 text-center shadow-sm border border-slate-100 opacity-0 translate-y-8 transition-all duration-700 delay-100" :class="loaded ? '!opacity-100 !translate-y-0' : ''">
                <div class="w-32 h-32 bg-blue-50 rounded-full flex items-center justify-center mx-auto mb-6">
                    <span class="text-5xl">🛒</span>
                </div>
                <h2 class="font-display text-2xl font-bold text-slate-900 mb-3">Keranjangmu masih kosong</h2>
                <p class="text-slate-500 mb-8 max-w-md mx-auto leading-relaxed">Yuk, cari aksesoris gadget impianmu dan nikmati promo menarik hari ini!</p>
                <a href="{{ route('front.katalog') }}" class="inline-flex items-center gap-2 bg-blue-600 text-white px-8 py-4 rounded-full font-bold hover:bg-blue-700 transition-colors shadow-lg shadow-blue-600/30 hover:shadow-xl hover:-translate-y-1">
                    Mulai Belanja
                </a>
            </div>
        @endif

    </div>
</div>
@endsection
