@extends('layouts.admin')
@section('title', 'Detail Pelanggan - ' . $customer->name)

@section('content')
<div class="max-w-6xl mx-auto">

    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.customers.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 hover:border-blue-600 transition-colors">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path></svg>
        </a>
        <h1 class="font-display text-2xl font-extrabold text-slate-900">Profil Pelanggan</h1>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- KOLOM KIRI: Kartu Profil Pelanggan --}}
        <div class="lg:col-span-1">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8 text-center sticky top-8">
                <div class="relative w-32 h-32 mx-auto mb-6">
                    <div class="absolute inset-0 bg-blue-500 rounded-full blur-[20px] opacity-20"></div>
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=0D8ABC&color=fff&rounded=true&size=128"
                         class="relative w-full h-full rounded-full border-4 border-white shadow-xl">
                </div>

                <h2 class="font-black text-2xl text-slate-900 mb-1">{{ $customer->name }}</h2>
                <p class="text-slate-500 font-medium mb-8">{{ $customer->email }}</p>

                <div class="grid grid-cols-2 gap-4 border-t border-slate-100 pt-8">
                    <div class="bg-blue-50/50 p-4 rounded-2xl border border-blue-100 text-center">
                        <p class="text-[10px] font-bold text-blue-500 uppercase tracking-widest mb-1">Pesanan</p>
                        <p class="font-black text-2xl text-blue-700">{{ $customer->orders->count() }}</p>
                    </div>
                    <div class="bg-emerald-50/50 p-4 rounded-2xl border border-emerald-100 text-center">
                        <p class="text-[10px] font-bold text-emerald-500 uppercase tracking-widest mb-1">Total Nilai</p>
                        <p class="font-black text-lg text-emerald-700">Rp {{ number_format($customer->orders->sum('total_price') / 1000, 0, ',', '.') }}k</p>
                    </div>
                </div>

                <div class="mt-8 text-left space-y-4">
                    <div>
                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Bergabung Sejak</p>
                        <p class="font-bold text-slate-800">{{ $customer->created_at->format('d F Y') }}</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- KOLOM KANAN: Riwayat Transaksi Pelanggan --}}
        <div class="lg:col-span-2">
            <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 p-8">
                <h3 class="text-xl font-extrabold text-slate-900 mb-6 flex items-center gap-3">
                    <span class="w-10 h-10 bg-slate-100 rounded-xl flex items-center justify-center">🛍️</span>
                    Riwayat Transaksi
                </h3>

                @if($customer->orders->count() > 0)
                    <div class="space-y-4">
                        @foreach($customer->orders as $order)
                            <div class="flex flex-col sm:flex-row justify-between sm:items-center gap-4 p-5 rounded-2xl border border-slate-100 hover:border-blue-200 hover:shadow-md transition-all group">
                                <div>
                                    <p class="font-bold text-slate-900 text-lg group-hover:text-blue-600 transition-colors">
                                        {{ $order->order_number }}
                                    </p>
                                    <p class="text-xs font-medium text-slate-500 mt-1">{{ $order->created_at->format('d M Y, H:i') }}</p>
                                </div>

                                <div class="flex items-center gap-4">
                                    <div class="text-right">
                                        <p class="text-[10px] font-bold text-slate-400 uppercase tracking-widest mb-1">Total</p>
                                        <p class="font-black text-slate-900">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                                    </div>
                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="w-10 h-10 bg-slate-50 rounded-full flex items-center justify-center text-slate-500 hover:bg-blue-600 hover:text-white transition-all">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path></svg>
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center py-10">
                        <p class="text-slate-500 font-medium">Pelanggan ini belum memiliki riwayat transaksi.</p>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
