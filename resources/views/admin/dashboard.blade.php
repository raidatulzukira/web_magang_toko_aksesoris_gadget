@extends('layouts.admin')
@section('title', 'Dashboard Admin')

@section('content')

@section('content')
    {{-- MENGAMBIL DATA LANGSUNG DARI DATABASE --}}
    @php
        $totalRevenue = \App\Models\Order::where('payment_status', 'paid')->sum('total_price');
        $totalOrders = \App\Models\Order::count();
        $totalProducts = \App\Models\Product::count();
        // $totalCustomers = \App\Models\User::whereHas('orders')->count();
        $totalCustomers = \App\Models\User::where('role', '!=', 'admin')->count();

        // Ambil 5 pesanan terbaru
        $latestOrders = \App\Models\Order::with('user')->latest()->take(5)->get();
    @endphp

    <div class="mb-8">
        <h1 class="text-3xl font-bold text-slate-900">Ringkasan Hari Ini</h1>
        <p class="text-slate-500 mt-1">Pantau perkembangan toko dan penjualanmu di sini.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-lg transition-shadow duration-300">
            <div class="w-14 h-14 bg-emerald-100 text-emerald-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Pendapatan</p>
                <h3 class="text-2xl font-black text-slate-800">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-lg transition-shadow duration-300">
            <div class="w-14 h-14 bg-blue-100 text-blue-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Pesanan</p>
                <h3 class="text-2xl font-black text-slate-800">{{ number_format($totalOrders, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-lg transition-shadow duration-300">
            <div class="w-14 h-14 bg-amber-100 text-amber-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">Produk Aktif</p>
                <h3 class="text-2xl font-black text-slate-800">{{ number_format($totalProducts, 0, ',', '.') }}</h3>
            </div>
        </div>

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-slate-100 flex items-center gap-5 hover:shadow-lg transition-shadow duration-300">
            <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-2xl flex items-center justify-center text-2xl shadow-inner">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"></path></svg>
            </div>
            <div>
                <p class="text-sm font-bold text-slate-400 uppercase tracking-wider">User</p>
                <h3 class="text-2xl font-black text-slate-800">{{ number_format($totalCustomers, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex justify-between items-center">
            <h2 class="text-xl font-bold text-slate-800">Pesanan Terbaru</h2>
            <a href="{{ route('admin.orders.index') }}" class="text-sm font-bold text-blue-600 hover:text-blue-700">Lihat Semua &rarr;</a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50 text-slate-500 text-xs uppercase tracking-wider">
                        <th class="px-6 py-4 font-bold">ID Pesanan</th>
                        <th class="px-6 py-4 font-bold">Pelanggan</th>
                        <th class="px-6 py-4 font-bold">Tanggal</th>
                        <th class="px-6 py-4 font-bold">Total</th>
                        <th class="px-6 py-4 font-bold">Status</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($latestOrders as $order)
                        <tr class="hover:bg-slate-50/50 transition-colors">
                            <td class="px-6 py-4 font-bold text-slate-900">{{ $order->order_number }}</td>
                            <td class="px-6 py-4 font-medium">{{ $order->user->name ?? 'User Dihapus' }}</td>
                            <td class="px-6 py-4 text-slate-500">{{ $order->created_at->format('d M Y, H:i') }}</td>
                            <td class="px-6 py-4 font-bold text-slate-700">Rp {{ number_format($order->total_price, 0, ',', '.') }}</td>
                            <td class="px-6 py-4">
                                @if($order->payment_status === 'paid')
                                    <span class="px-3 py-1.5 text-[10px] font-black uppercase tracking-wider rounded-full bg-emerald-100 text-emerald-700">Lunas</span>
                                @elseif($order->payment_status === 'cancelled')
                                    <span class="px-3 py-1.5 text-[10px] font-black uppercase tracking-wider rounded-full bg-red-100 text-red-700">Batal</span>
                                @else
                                    <span class="px-3 py-1.5 text-[10px] font-black uppercase tracking-wider rounded-full bg-amber-100 text-amber-700">Belum Bayar</span>
                                @endif
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="px-6 py-10 text-center text-slate-500 font-medium">Belum ada pesanan yang masuk.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
