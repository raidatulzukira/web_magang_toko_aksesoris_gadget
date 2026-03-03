@extends('layouts.admin')
@section('title', 'Buku Besar Stok - GadgetStore')

@section('content')
<div class="max-w-7xl mx-auto py-8 font-sans" x-data="{ transactionType: 'in', selectedProductStock: 0 }">

    {{-- Header dengan Animasi Gradasi --}}
    <div class="mb-10 relative">
        <div class="absolute -top-10 -left-10 w-40 h-40 bg-blue-400 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-pulse"></div>
        <div class="absolute -bottom-10 -right-10 w-40 h-40 bg-emerald-400 rounded-full mix-blend-multiply filter blur-2xl opacity-30 animate-pulse" style="animation-delay: 2s;"></div>

        <div class="relative z-10 bg-white/80 backdrop-blur-xl p-8 rounded-[2rem] border border-white/40 shadow-xl shadow-slate-200/50 flex flex-col md:flex-row justify-between items-center gap-6">
            <div>
                <h1 class="text-3xl md:text-4xl font-black text-transparent bg-clip-text bg-gradient-to-r from-slate-900 to-slate-700 tracking-tight mb-2">
                    Buku Besar Stok
                </h1>
                <p class="text-slate-500 font-medium">Catat, pantau, dan audit lalu lintas barang masuk & keluar.</p>
            </div>
            <div class="flex gap-4">
                <div class="bg-emerald-50 px-5 py-3 rounded-2xl border border-emerald-100 flex items-center gap-3">
                    <div class="w-10 h-10 bg-emerald-100 rounded-full flex items-center justify-center text-emerald-600 font-black">📥</div>
                    <div>
                        <p class="text-[10px] uppercase font-black text-emerald-600 tracking-widest">Total Masuk</p>
                        <p class="font-black text-slate-800 text-lg">{{ $histories->where('type', 'in')->sum('quantity') }}</p>
                    </div>
                </div>
                <div class="bg-red-50 px-5 py-3 rounded-2xl border border-red-100 flex items-center gap-3">
                    <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center text-red-600 font-black">📤</div>
                    <div>
                        <p class="text-[10px] uppercase font-black text-red-600 tracking-widest">Total Keluar</p>
                        <p class="font-black text-slate-800 text-lg">{{ $histories->where('type', 'out')->sum('quantity') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Error Handling Estetik --}}
    @if(session('error'))
        <div class="mb-6 p-4 rounded-2xl bg-rose-50 border border-rose-200 text-rose-700 font-bold flex items-center gap-3 shadow-sm">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path></svg>
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">

        {{-- KOLOM KIRI: FORM INTERAKTIF --}}
        <div class="lg:col-span-4">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden sticky top-8">

                {{-- Header Form (Menggunakan SVG agar tidak error/rusak seperti emoji) --}}
                <div class="p-6 transition-colors duration-500"
                     :class="transactionType === 'in' ? 'bg-emerald-600' : 'bg-rose-600'">
                    <h3 class="text-xl font-black text-white flex items-center gap-3">
                        {{-- Icon Masuk --}}
                        <svg x-show="transactionType === 'in'" class="w-8 h-8 bg-white/20 p-1.5 rounded-xl backdrop-blur-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 14l-7 7m0 0l-7-7m7 7V3"></path></svg>
                        {{-- Icon Keluar --}}
                        <svg x-show="transactionType === 'out'" style="display: none;" class="w-8 h-8 bg-white/20 p-1.5 rounded-xl backdrop-blur-sm" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 10l7-7m0 0l7 7m-7-7v18"></path></svg>

                        <span x-text="transactionType === 'in' ? 'Form Barang Masuk' : 'Form Barang Keluar'"></span>
                    </h3>
                </div>

                <form action="{{ route('admin.stocks.store') }}" method="POST" class="p-8 space-y-6 bg-white relative">
                    @csrf

                    {{-- Toggle In/Out (Radio Buttons) --}}
                    <div class="flex p-1.5 bg-slate-100/80 rounded-2xl relative backdrop-blur-sm border border-slate-200">

                        {{-- Tombol Tambah --}}
                        <label class="flex-1 cursor-pointer relative z-10 group">
                            <input type="radio" name="type" value="in" x-model="transactionType" class="peer sr-only">
                            <div class="text-center py-3 rounded-xl font-bold text-sm transition-all duration-300 ease-out
                                        text-slate-500 group-hover:text-emerald-600 group-hover:bg-emerald-50/80
                                        peer-checked:text-white peer-checked:bg-emerald-500 peer-checked:shadow-lg peer-checked:shadow-emerald-500/40
                                        active:scale-95">
                                + Tambah
                            </div>
                        </label>

                        {{-- Tombol Kurangi --}}
                        <label class="flex-1 cursor-pointer relative z-10 group ml-1">
                            <input type="radio" name="type" value="out" x-model="transactionType" class="peer sr-only">
                            <div class="text-center py-3 rounded-xl font-bold text-sm transition-all duration-300 ease-out
                                        text-slate-500 group-hover:text-rose-600 group-hover:bg-rose-50/80
                                        peer-checked:text-white peer-checked:bg-rose-500 peer-checked:shadow-lg peer-checked:shadow-rose-500/40
                                        active:scale-95">
                                - Kurangi
                            </div>
                        </label>

                    </div>

                    {{-- Pilih Produk (INFO SISA STOK SUDAH DIKEMBALIKAN KE SINI) --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Pilih Produk</label>
                        <select name="product_id" required
                                class="w-full bg-slate-50 border border-slate-200 text-slate-800 rounded-xl px-4 py-3 focus:ring-1 focus:ring-blue-200 outline-none font-medium cursor-pointer hover:bg-white transition-colors">
                            <option value="">-- Pilih Produk --</option>
                            @foreach ($products as $product)
                                <option value="{{ $product->id }}">
                                    {{ $product->name }} (Sisa: {{ $product->stock }})
                                </option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Jumlah Stok --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Jumlah</label>
                        <div class="relative group">
                            <input type="number" name="quantity" min="1" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-xl pl-14 pr-4 py-3 focus:ring-1 outline-none font-black text-xl transition-all hover:bg-white"
                                :class="transactionType === 'in' ? 'focus:ring-emerald-500 text-emerald-700' : 'focus:ring-rose-200 text-rose-700'"
                                placeholder="0">
                            <div class="absolute left-4 top-1/2 -translate-y-1/2 font-black text-2xl"
                                 :class="transactionType === 'in' ? 'text-emerald-500' : 'text-rose-500'"
                                 x-text="transactionType === 'in' ? '+' : '-'"></div>
                        </div>
                    </div>

                    {{-- Keterangan --}}
                    <div>
                        <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Catatan Audit</label>
                        <textarea name="description" rows="2"
                            class="w-full bg-slate-50 border border-slate-200 rounded-xl px-4 py-3 focus:ring-1 focus:ring-blue-200 outline-none font-medium transition-all hover:bg-white"
                            :placeholder="transactionType === 'in' ? 'Cth: Restock dari supplier...' : 'Cth: Barang rusak / Hilang...'"></textarea>
                    </div>

                    {{-- Tombol Simpan Dinamis --}}
                    <button type="submit"
                        class="w-full text-white font-black py-4 rounded-xl shadow-lg transition-all transform hover:-translate-y-1 hover:shadow-xl flex justify-center items-center gap-2"
                        :class="transactionType === 'in' ? 'bg-emerald-600 hover:bg-emerald-500 shadow-emerald-500/30' : 'bg-rose-600 hover:bg-rose-400 shadow-rose-400/30'">
                        <span x-text="transactionType === 'in' ? 'Konfirmasi Masuk' : 'Konfirmasi Keluar'"></span>
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"></path></svg>
                    </button>
                </form>
            </div>
        </div>

        {{-- KOLOM KANAN: TABEL RIWAYAT (Running Balance) --}}
        <div class="lg:col-span-8">
            <div class="bg-white rounded-[2rem] shadow-xl shadow-slate-200/50 border border-slate-100 overflow-hidden relative">

                {{-- Table Header --}}
                <div class="p-8 border-b border-slate-100 flex justify-between items-center bg-slate-50/50">
                    <h3 class="text-lg font-black text-slate-900 flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 text-blue-600 rounded-xl flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"></path></svg>
                        </div>
                        Catatan Transaksi
                    </h3>
                </div>

                @if($histories->count() > 0)
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="bg-slate-50 text-slate-400 text-xs uppercase tracking-wider font-bold">
                                    <th class="py-4 px-6">Waktu</th>
                                    <th class="py-4 px-6">Produk</th>
                                    <th class="py-4 px-6 text-center">Mutasi</th>
                                    <th class="py-4 px-6 text-center">Sisa Stok</th>
                                    <th class="py-4 px-6">Operator & Catatan</th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100 text-sm">
                                @foreach($histories as $history)
                                    <tr class="hover:bg-blue-50/30 transition-colors group">
                                        <td class="py-5 px-6 whitespace-nowrap">
                                            <p class="font-bold text-slate-700">{{ $history->created_at->format('d M Y') }}</p>
                                            <p class="text-xs text-slate-400 mt-0.5">{{ $history->created_at->format('H:i') }} WIB</p>
                                        </td>
                                        <td class="py-5 px-6">
                                            <p class="font-black text-slate-900">{{ $history->product->name ?? 'Produk Dihapus' }}</p>
                                        </td>
                                        <td class="py-5 px-6 text-center">
                                            @if($history->type == 'in')
                                                <span class="inline-flex items-center gap-1 bg-emerald-100 text-emerald-700 px-3 py-1.5 rounded-xl font-black shadow-sm">
                                                    +{{ $history->quantity }}
                                                </span>
                                            @else
                                                <span class="inline-flex items-center gap-1 bg-red-100 text-rose-700 px-3 py-1.5 rounded-xl font-black shadow-sm">
                                                    -{{ $history->quantity }}
                                                </span>
                                            @endif
                                        </td>
                                        <td class="py-5 px-6 text-center">
                                            <span class="font-black text-slate-800 bg-slate-100 px-3 py-1.5 rounded-lg border border-slate-200">
                                                {{ $history->current_stock }}
                                            </span>
                                        </td>
                                        <td class="py-5 px-6">
                                            <div class="flex items-center gap-2 mb-1">
                                                <div class="w-5 h-5 bg-blue-100 text-blue-600 rounded-full flex items-center justify-center text-[10px] font-bold">
                                                    {{ substr($history->user->name ?? 'A', 0, 1) }}
                                                </div>
                                                <p class="font-bold text-slate-800 text-xs">{{ $history->user->name ?? 'Unknown' }}</p>
                                            </div>
                                            <p class="text-xs text-slate-500 truncate max-w-[200px]" title="{{ $history->description }}">
                                                {{ $history->description ?? '-' }}
                                            </p>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>

                    {{-- Pagination --}}
                    <div class="p-6 border-t border-slate-100 bg-slate-50/50">
                        {{ $histories->links() }}
                    </div>
                @else
                    <div class="text-center py-20 px-4">
                        <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 shadow-inner border border-slate-100 text-4xl">
                            📭
                        </div>
                        <h4 class="text-slate-900 font-black mb-2 text-xl">Belum ada aktivitas stok</h4>
                        <p class="text-slate-500 text-sm max-w-sm mx-auto">Catatan pergerakan barang (masuk/keluar) akan muncul di sini secara otomatis.</p>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
@endsection
