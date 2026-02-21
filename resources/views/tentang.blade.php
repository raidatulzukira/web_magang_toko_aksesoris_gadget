@extends('layouts.front')
@section('title', 'Tentang Kami - GadgetStore')

@section('content')
<div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8 py-10 min-h-screen">

    {{-- Hero Section --}}
    <div class="relative overflow-hidden bg-gradient-to-br from-[#0B1426] to-blue-900 rounded-[2.5rem] p-12 md:p-20 text-center text-white shadow-2xl mb-16 group">
        {{-- Dekorasi Glow --}}
        <div class="absolute -top-24 -left-24 w-72 h-72 bg-blue-500 rounded-full mix-blend-screen filter blur-[80px] opacity-40 group-hover:opacity-60 transition-opacity duration-700"></div>
        <div class="absolute -bottom-24 -right-24 w-72 h-72 bg-teal-400 rounded-full mix-blend-screen filter blur-[80px] opacity-20 group-hover:opacity-40 transition-opacity duration-700"></div>

        <div class="relative z-10">
            <span class="px-4 py-1.5 rounded-full bg-blue-500/20 border border-blue-400/30 text-blue-300 text-xs font-bold uppercase tracking-widest mb-6 inline-block">Kenali Kami Lebih Dekat</span>
            <h1 class="font-display text-4xl md:text-6xl font-black mb-6 leading-tight">
                Inovasi Gadget untuk <br> <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-300 to-teal-200">Gaya Hidup Digitalmu</span>
            </h1>
            <p class="text-blue-100/80 text-lg md:text-xl max-w-2xl mx-auto leading-relaxed">
                GadgetStore hadir sebagai destinasi utama untuk aksesoris gadget premium di Padang. Kami berkomitmen memberikan produk original dengan kualitas terbaik.
            </p>
        </div>
    </div>

    {{-- Visi & Misi --}}
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-16">
        <div class="bg-white rounded-[2rem] p-10 shadow-lg border border-slate-300 hover:shadow-lg transition-shadow duration-300">
            <div class="w-14 h-14 bg-blue-50 rounded-2xl flex items-center justify-center text-blue-600 mb-6 border border-blue-100">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path></svg>
            </div>
            <h3 class="text-2xl font-black text-slate-900 mb-4">Visi Kami</h3>
            <p class="text-slate-600 leading-relaxed">Menjadi e-commerce aksesoris gadget nomor satu dan paling terpercaya, yang mampu menjangkau dan memenuhi kebutuhan teknologi masyarakat modern dengan mudah dan aman.</p>
        </div>
        <div class="bg-white rounded-[2rem] p-10 shadow-lg border border-slate-300 hover:shadow-lg transition-shadow duration-300">
            <div class="w-14 h-14 bg-teal-50 rounded-2xl flex items-center justify-center text-teal-600 mb-6 border border-teal-100">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
            </div>
            <h3 class="text-2xl font-black text-slate-900 mb-4">Misi Kami</h3>
            <ul class="space-y-3 text-slate-600">
                <li class="flex items-start gap-3">
                    <span class="text-teal-500 font-bold">✓</span> Menyediakan produk 100% original dan bergaransi.
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-teal-500 font-bold">✓</span> Memberikan pelayanan pelanggan yang cepat, ramah, dan solutif.
                </li>
                <li class="flex items-start gap-3">
                    <span class="text-teal-500 font-bold">✓</span> Menghadirkan pengalaman belanja online yang mulus dan tanpa hambatan.
                </li>
            </ul>
        </div>
    </div>

    {{-- Kenapa Memilih Kami (Grid Keunggulan) --}}
    <div class="text-center mb-12">
        <h2 class="text-3xl font-black text-slate-900 mb-4">Kenapa Memilih GadgetStore?</h2>
        <p class="text-slate-500 max-w-xl mx-auto">Kami tidak hanya menjual barang, tapi juga memberikan pengalaman belanja dan layanan purna jual yang menenangkan.</p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-16">
        {{-- Card 1 --}}
        <div class="bg-white border border-slate-200 shadow-lg rounded-[2rem] p-8 text-center hover:-translate-y-2 transition-transform duration-300">
            <div class="text-5xl mb-6">🛡️</div>
            <h4 class="text-xl font-bold text-slate-900 mb-3">Kualitas Terjamin</h4>
            <p class="text-sm text-slate-500">Semua produk kami telah melewati proses Quality Control ketat sebelum dikirim ke alamatmu.</p>
        </div>
        {{-- Card 2 --}}
        <div class="bg-white border border-slate-200 shadow-lg rounded-[2rem] p-8 text-center hover:-translate-y-2 transition-transform duration-300">
            <div class="text-5xl mb-6">⚡</div>
            <h4 class="text-xl font-bold text-slate-900 mb-3">Pengiriman Cepat</h4>
            <p class="text-sm text-slate-500">Bekerja sama dengan kurir terbaik untuk memastikan gadget impianmu tiba tepat waktu.</p>
        </div>
        {{-- Card 3 --}}
        <div class="bg-white border border-slate-200 shadow-lg rounded-[2rem] p-8 text-center hover:-translate-y-2 transition-transform duration-300">
            <div class="text-5xl mb-6">💳</div>
            <h4 class="text-xl font-bold text-slate-900 mb-3">Pembayaran Aman</h4>
            <p class="text-sm text-slate-500">Transaksi dijamin aman dengan integrasi Midtrans yang mendukung berbagai metode pembayaran.</p>
        </div>
    </div>

    {{-- Kontak / Lokasi Mini --}}
    <div class="mb-10 bg-[#19284C]/70 rounded-[2rem] p-10 md:p-14 flex flex-col md:flex-row items-center justify-between gap-8 shadow-xl shadow-blue-600/20 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[url('https://www.transparenttextures.com/patterns/cubes.png')] opacity-10"></div>
        <div class="relative z-10 md:w-2/3">
            <h2 class="text-3xl font-black mb-4">Punya Pertanyaan?</h2>
            <p class="text-blue-100 text-lg">Tim Customer Service kami siap membantumu. Kunjungi toko offline kami atau hubungi kami via WhatsApp.</p>
            <div class="mt-6 flex flex-wrap gap-4 text-sm font-medium text-blue-100">
                <span class="flex items-center gap-2 bg-blue-700/50 px-4 py-2 rounded-full border border-blue-500/50">
                    📍 Padang, Sumatera Barat
                </span>
                <span class="flex items-center gap-2 bg-blue-700/50 px-4 py-2 rounded-full border border-blue-500/50">
                    📞 0812-3456-7890
                </span>
            </div>
        </div>
        <div class="relative z-10 md:w-1/3 text-center md:text-right w-full">
            <a href="{{ route('front.katalog') ?? route('home') }}" class="inline-block w-full md:w-auto bg-white text-blue-600 font-bold px-8 py-4 rounded-full shadow-lg hover:bg-slate-50 transition-colors">
                Mulai Belanja
            </a>
        </div>
    </div>

</div>
@endsection
