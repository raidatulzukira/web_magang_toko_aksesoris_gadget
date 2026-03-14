@extends('layouts.admin')
@section('title', 'Kelola Pesanan Masuk')

@section('content')
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-10">
        <div class="flex justify-between items-center mb-8">
            <div>
                <h1 class="font-display text-3xl font-extrabold text-slate-900">Pesanan Masuk</h1>
                <p class="text-slate-500 mt-1">Kelola semua pesanan pelanggan dari satu tempat.</p>
            </div>
        </div>

        {{-- Notifikasi Sukses --}}
        @if (session('success'))
            <div
                class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl mb-6 font-medium flex items-center gap-3">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr
                            class="bg-slate-50/50 border-b border-slate-100 text-xs uppercase tracking-wider text-slate-500 font-bold">
                            <th class="p-5">Produk & Waktu</th>
                            <th class="p-5">Pembeli</th>
                            <th class="p-5">Total Bayar</th>
                            <th class="p-5">Status Bayar</th>
                            <th class="p-5">Pengiriman</th>
                            <th class="p-5 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 text-sm">
                        @forelse($orders as $order)
                            <tr class="hover:bg-slate-50/50 transition-colors">
                                <td class="p-5">
                                    <p class="font-bold text-slate-900 line-clamp-1">
                                        @if ($order->items->count() > 0 && $order->items->first()->product)
                                            {{ $order->items->first()->product->name }}
                                            @if ($order->items->count() > 1)
                                                <span
                                                    class="text-xs font-medium text-slate-500 ml-1">(+{{ $order->items->count() - 1 }}
                                                    lainnya)</span>
                                            @endif
                                        @else
                                            Pesanan Tanpa Produk
                                        @endif
                                    </p>
                                    <p class="text-xs font-medium text-slate-500 mt-1">{{ $order->order_number }} &bull;
                                        {{ $order->created_at->format('d M Y, H:i') }}</p>
                                </td>
                                <td class="p-5">
                                    <p class="font-bold text-slate-700">{{ $order->user->name ?? 'User Dihapus' }}</p>
                                    <p class="text-xs text-slate-500 mt-1">
                                        {{ str_contains(strtolower($order->address), 'midtrans') ? 'Transfer' : 'COD' }}</p>
                                </td>
                                <td class="p-5 font-bold text-slate-900">
                                    Rp {{ number_format($order->total_price, 0, ',', '.') }}
                                </td>
                                {{-- <td class="p-5">
                                    @if ($order->payment_status === 'paid')
                                        <span
                                            class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold">Lunas</span>
                                    @else
                                        <span
                                            class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-bold">Belum</span>
                                    @endif
                                </td> --}}
                                <td class="p-5">
                                    @if ($order->payment_status === 'paid')
                                        <span class="px-3 py-1 bg-emerald-100 text-emerald-700 rounded-lg text-xs font-bold">
                                            Lunas
                                        </span>
                                    @elseif ($order->payment_status === 'cancelled')
                                        <span class="px-3 py-1 bg-red-100 text-red-700 rounded-lg text-xs font-bold">
                                            Dibatalkan
                                        </span>
                                    @else
                                        {{-- Sisa: unpaid atau pending --}}
                                        <span class="px-3 py-1 bg-amber-100 text-amber-700 rounded-lg text-xs font-bold">
                                            Belum
                                        </span>
                                    @endif
                                </td>
                                <td class="p-5">
                                    @php
                                        $statusColors = [
                                            'pending' => 'bg-slate-100 text-slate-700',
                                            'processing' => 'bg-blue-100 text-blue-700',
                                            'shipped' => 'bg-indigo-100 text-indigo-700',
                                            'delivered'  => 'bg-teal-100 text-teal-800',
                                            'completed' => 'bg-emerald-100 text-emerald-700',
                                            'cancelled' => 'bg-red-100 text-red-700',
                                        ];
                                        $statusLabels = [
                                            'pending' => 'Menunggu',
                                            'processing' => 'Diproses',
                                            'shipped' => 'Dikirim',
                                            'delivered'  => 'Tiba di Tujuan',
                                            'completed' => 'Selesai',
                                            'cancelled' => 'Dibatalkan',
                                        ];
                                    @endphp
                                    <span
                                        class="px-3 py-1 {{ $statusColors[$order->order_status] }} rounded-lg text-xs font-bold">
                                        {{ $statusLabels[$order->order_status] }}
                                    </span>
                                </td>
                                <td class="p-5 text-right">
                                    <a href="{{ route('admin.orders.show', $order->id) }}"
                                        class="inline-flex items-center gap-2 bg-slate-900 hover:bg-blue-600 text-white px-4 py-2 rounded-xl text-xs font-bold transition-colors">
                                        Kelola
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M9 5l7 7-7 7"></path>
                                        </svg>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="p-10 text-center text-slate-500">Belum ada pesanan yang masuk.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection
