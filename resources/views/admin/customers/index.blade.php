@extends('layouts.admin')
@section('title', 'Data Pelanggan - GadgetAdmin')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="mb-8">
        <h1 class="font-display text-3xl font-extrabold text-slate-900">Data Pelanggan</h1>
        <p class="text-slate-500 mt-1">Daftar pelanggan yang telah melakukan transaksi di tokomu.</p>
    </div>

    <div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 border-b border-slate-100 text-xs uppercase tracking-widest text-slate-400 font-bold">
                        <th class="p-6">Profil Pelanggan</th>
                        <th class="p-6 text-center">Total Pesanan</th>
                        <th class="p-6">Total Belanja</th>
                        <th class="p-6">Bergabung</th>
                        <th class="p-6 text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($customers as $customer)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            <td class="p-6">
                                <div class="flex items-center gap-4">
                                    <img src="https://ui-avatars.com/api/?name={{ urlencode($customer->name) }}&background=0D8ABC&color=fff&rounded=true"
                                         class="w-12 h-12 rounded-full shadow-sm border-2 border-white group-hover:border-blue-100 transition-all">
                                    <div>
                                        <p class="font-bold text-slate-900 text-base">{{ $customer->name }}</p>
                                        <p class="text-xs text-slate-500 mt-0.5">{{ $customer->email }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="p-6 text-center">
                                <span class="inline-flex items-center justify-center w-10 h-10 rounded-xl bg-blue-50 text-blue-600 font-black text-lg">
                                    {{ $customer->orders_count }}
                                </span>
                            </td>
                            <td class="p-6">
                                <p class="font-black text-slate-900 text-lg">Rp {{ number_format($customer->orders_sum_total_price, 0, ',', '.') }}</p>
                            </td>
                            <td class="p-6 text-slate-500 font-medium">
                                {{ $customer->created_at->format('d M Y') }}
                            </td>
                            <td class="p-6 text-right">
                                <a href="{{ route('admin.customers.show', $customer->id) }}" class="inline-flex items-center gap-2 bg-white border-2 border-slate-100 hover:border-blue-600 hover:text-blue-600 text-slate-600 px-5 py-2.5 rounded-xl font-bold transition-all shadow-sm">
                                    Detail
                                </a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="p-16 text-center">
                                <div class="text-6xl mb-4">👥</div>
                                <h3 class="font-bold text-slate-800 text-lg">Belum ada pelanggan</h3>
                                <p class="text-slate-500 text-sm">Akan muncul data setelah ada user yang melakukan transaksi.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
