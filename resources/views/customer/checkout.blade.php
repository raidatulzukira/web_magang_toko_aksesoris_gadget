@extends('layouts.front')

@section('title', 'Checkout Pesanan - GadgetStore')

@section('content')
    {{-- LIBRARY PETA & ALPINE --}}
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <div class="min-h-screen py-12 md:py-20 bg-[#F8FAFC]"
        style="background-image: radial-gradient(#e0e7ff 1px, transparent 1px); background-size: 24px 24px;">

        <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">

            {{-- Header --}}
            <div class="mb-10 text-center md:text-left">
                <h1 class="font-display text-3xl md:text-5xl font-black text-slate-900 mb-3 tracking-tight">
                    Checkout <span
                        class="text-transparent bg-clip-text bg-gradient-to-r from-blue-600 to-indigo-600">Pesanan</span>
                </h1>
                <p class="text-slate-500 font-medium text-lg">Pastikan lokasi pin peta sesuai dengan alamat pengirimanmu.</p>
            </div>

            <form action="{{ route('checkout.pay') }}" method="POST"
                class="grid grid-cols-1 lg:grid-cols-12 gap-8 lg:gap-12" x-data="checkoutPage()">
                @csrf

                {{-- KOLOM KIRI: FORM --}}
                <div class="lg:col-span-7 space-y-8 ml-0 mr-0">

                    {{-- 1. Kartu Alamat & Peta --}}
                    <div
                        class="bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/60 border border-slate-100 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-blue-500 to-indigo-600"></div>

                        <h3 class="text-xl font-extrabold text-slate-900 mb-8 flex items-center gap-3">
                            <div class="w-10 h-10 rounded-xl bg-blue-50 text-blue-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                    </path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            Lokasi Pengiriman
                        </h3>

                        {{-- Data Diri --}}
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nama
                                    Penerima</label>
                                <input type="text" name="recipient_name" value="{{ auth()->user()->name }}" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-bold text-slate-800">
                            </div>
                            <div class="space-y-2">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Nomor
                                    WhatsApp</label>
                                <input type="number" name="phone_number" placeholder="Contoh: 081234567890" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-2 focus:ring-blue-500 focus:border-blue-500 outline-none transition-all font-bold text-slate-800">
                            </div>
                        </div>

                        <div class="space-y-6">
                            {{-- Dropdown Wilayah --}}
                            <div class="p-6 bg-slate-50 rounded-2xl border border-slate-200/60">
                                <label class="text-xs font-bold text-slate-500 uppercase tracking-wider block mb-4">Wilayah
                                    Administratif</label>
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                    <select x-model="selectedProvince" @change="fetchCities()" class="select-custom">
                                        <option value="">Pilih Provinsi</option>
                                        <template x-for="prov in provinces" :key="prov.id">
                                            <option :value="JSON.stringify({ id: prov.id, name: prov.name })"
                                                x-text="prov.name"></option>
                                        </template>
                                    </select>
                                    <select x-model="selectedCity" @change="fetchDistricts()" class="select-custom"
                                        :disabled="!selectedProvince">
                                        <option value="">Pilih Kota/Kabupaten</option>
                                        <template x-for="city in cities" :key="city.id">
                                            <option :value="JSON.stringify({ id: city.id, name: city.name })"
                                                x-text="city.name"></option>
                                        </template>
                                    </select>
                                    <select x-model="selectedDistrict" @change="fetchVillages()" class="select-custom"
                                        :disabled="!selectedCity">
                                        <option value="">Pilih Kecamatan</option>
                                        <template x-for="dist in districts" :key="dist.id">
                                            <option :value="JSON.stringify({ id: dist.id, name: dist.name })"
                                                x-text="dist.name"></option>
                                        </template>
                                    </select>
                                    <select x-model="selectedVillage" @change="updateMap()" class="select-custom"
                                        :disabled="!selectedDistrict">
                                        <option value="">Pilih Kelurahan</option>
                                        <template x-for="vill in villages" :key="vill.id">
                                            <option :value="JSON.stringify({ id: vill.id, name: vill.name })"
                                                x-text="vill.name"></option>
                                        </template>
                                    </select>
                                </div>
                            </div>

                            {{-- PENCARIAN PETA CANGGIH --}}
                            <div class="relative z-20">
                                <label
                                    class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1 mb-2 block">Cari
                                    Jalan / Lokasi Spesifik</label>
                                <div class="relative">
                                    <input type="text" x-model="searchQuery" @input.debounce.500ms="searchPlaces()"
                                        placeholder="Ketik nama jalan atau gedung terdekat..."
                                        class="w-full pl-12 pr-4 py-4 bg-white border-2 border-blue-100 rounded-2xl focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all font-bold text-slate-800 shadow-sm"
                                        :disabled="!selectedCity">
                                    <div class="absolute left-4 top-1/2 -translate-y-1/2 text-blue-500">
                                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                        </svg>
                                    </div>
                                    {{-- Loading Spinner --}}
                                    <div class="absolute right-4 top-1/2 -translate-y-1/2" x-show="isSearching">
                                        <svg class="w-5 h-5 animate-spin text-blue-500" fill="none" viewBox="0 0 24 24">
                                            <circle class="opacity-25" cx="12" cy="12" r="10"
                                                stroke="currentColor" stroke-width="4"></circle>
                                            <path class="opacity-75" fill="currentColor"
                                                d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                                            </path>
                                        </svg>
                                    </div>
                                </div>

                                {{-- Hasil Pencarian Dropdown --}}
                                <div class="absolute w-full bg-white mt-2 rounded-2xl shadow-2xl border border-slate-100 overflow-hidden z-50"
                                    x-show="searchResults.length > 0" @click.outside="searchResults = []"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 translate-y-2"
                                    x-transition:enter-end="opacity-100 translate-y-0">
                                    <ul>
                                        <template x-for="place in searchResults" :key="place.place_id">
                                            <li @click="selectLocation(place)"
                                                class="px-5 py-3 hover:bg-blue-50 cursor-pointer border-b border-slate-50 last:border-0 flex items-start gap-3 transition-colors">
                                                <div class="mt-1 text-blue-500"><svg class="w-4 h-4" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z">
                                                        </path>
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                                    </svg></div>
                                                <div>
                                                    <p class="font-bold text-slate-800 text-sm" x-text="place.name"></p>
                                                    <p class="text-xs text-slate-500 line-clamp-1"
                                                        x-text="place.display_name"></p>
                                                </div>
                                            </li>
                                        </template>
                                    </ul>
                                </div>
                            </div>

                            {{-- AREA PETA --}}
                            <div
                                class="relative w-full h-80 rounded-2xl overflow-hidden border-2 border-slate-200 shadow-inner group z-0">
                                <div id="map" class="w-full h-full z-0"></div>
                                {{-- Info Box --}}
                                <div
                                    class="absolute top-3 right-3 z-[400] bg-white/90 backdrop-blur px-3 py-2 rounded-xl text-[10px] font-bold text-slate-600 shadow-sm border border-slate-200 max-w-[200px]">
                                    <span class="flex items-center gap-1 mb-1 text-blue-600"><svg class="w-3 h-3"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg> Info:</span>
                                    Geser Pin 📍 di peta jika lokasi belum tepat.
                                </div>
                            </div>

                            {{-- INPUT DETAIL ALAMAT (YANG KAMU MINTA) --}}
                            <div class="grid grid-cols-1 gap-4">
                                {{-- 1. Alamat Map (Read Only / Bisa Edit Dikit) --}}
                                <div class="space-y-2">
                                    <label class="text-xs font-bold text-slate-500 uppercase tracking-wider ml-1">Titik
                                        Alamat Peta</label>
                                    <textarea x-model="streetDetail" rows="2"
                                        class="w-full bg-slate-100 border border-slate-200 rounded-2xl px-5 py-4 focus:ring-0 outline-none font-medium text-slate-500 text-sm shadow-inner cursor-not-allowed"
                                        readonly placeholder="Otomatis terisi dari peta..."></textarea>
                                </div>

                                {{-- 2. Detail Spesifik (Rumah No, Kos, dll) --}}
                                <div class="space-y-2">
                                    <label
                                        class="text-xs font-bold text-blue-600 uppercase tracking-wider ml-1 flex items-center gap-1">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                                            </path>
                                        </svg>
                                        Detail Rumah / Bangunan (Wajib Diisi)
                                    </label>
                                    <input type="text" x-model="specificDetail"
                                        class="w-full bg-white border-2 border-blue-100 rounded-2xl px-5 py-4 focus:ring-4 focus:ring-blue-100 focus:border-blue-500 outline-none transition-all font-bold text-slate-800 placeholder:font-normal placeholder:text-slate-400"
                                        placeholder="Cth: Rumah No. 4B, Kos Buk Linda (Pagar Hitam), Lantai 2..." required>
                                </div>
                            </div>

                            {{-- Hidden Input yang menggabungkan semuanya --}}
                            <input type="hidden" name="shipping_address" :value="fullAddress">
                        </div>
                    </div>

                    {{-- 2. Kartu Metode Pembayaran (Sama) --}}
                    <div
                        class="bg-white rounded-[2rem] p-8 shadow-xl shadow-slate-200/60 border border-slate-100 relative overflow-hidden">
                        <div class="absolute top-0 left-0 w-2 h-full bg-gradient-to-b from-indigo-500 to-purple-600"></div>
                        <h3 class="text-xl font-extrabold text-slate-900 mb-8 flex items-center gap-3">
                            <div
                                class="w-10 h-10 rounded-xl bg-indigo-50 text-indigo-600 flex items-center justify-center">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z">
                                    </path>
                                </svg>
                            </div>
                            Metode Pembayaran
                        </h3>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="payment_method" value="midtrans" x-model="paymentMethod"
                                    class="peer sr-only">
                                <div
                                    class="p-6 border-2 border-slate-100 rounded-3xl transition-all duration-300 peer-checked:border-blue-600 peer-checked:bg-blue-50/50 peer-checked:shadow-lg peer-checked:shadow-blue-500/10 group-hover:border-blue-300 h-full flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start mb-3">
                                            <div
                                                class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-2xl">
                                                🏦</div>
                                            <div
                                                class="w-6 h-6 rounded-full border-2 border-slate-300 peer-checked:border-blue-600 peer-checked:bg-blue-600 flex items-center justify-center transition-all">
                                                <svg class="w-3 h-3 text-white transform scale-0 peer-checked:scale-100 transition-transform"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="font-extrabold text-slate-900 text-lg block mb-1">Transfer /
                                            QRIS</span>
                                        <p class="text-xs text-slate-500 leading-relaxed">Otomatis via Midtrans (Gopay,
                                            OVO, VA Bank, QRIS).</p>
                                    </div>
                                </div>
                            </label>
                            <label class="relative cursor-pointer group">
                                <input type="radio" name="payment_method" value="cod" x-model="paymentMethod"
                                    class="peer sr-only">
                                <div
                                    class="p-6 border-2 border-slate-100 rounded-3xl transition-all duration-300 peer-checked:border-teal-500 peer-checked:bg-teal-50/50 peer-checked:shadow-lg peer-checked:shadow-teal-500/10 group-hover:border-teal-300 h-full flex flex-col justify-between">
                                    <div>
                                        <div class="flex justify-between items-start mb-3">
                                            <div
                                                class="w-12 h-12 bg-white rounded-xl shadow-sm border border-slate-100 flex items-center justify-center text-2xl">
                                                🤝</div>
                                            <div
                                                class="w-6 h-6 rounded-full border-2 border-slate-300 peer-checked:border-teal-500 peer-checked:bg-teal-500 flex items-center justify-center transition-all">
                                                <svg class="w-3 h-3 text-white transform scale-0 peer-checked:scale-100 transition-transform"
                                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="3"
                                                        d="M5 13l4 4L19 7"></path>
                                                </svg>
                                            </div>
                                        </div>
                                        <span class="font-extrabold text-slate-900 text-lg block mb-1">Bayar di
                                            Tempat</span>
                                        <p class="text-xs text-slate-500 leading-relaxed">Bayar tunai langsung ke kurir
                                            saat barang sampai.</p>
                                    </div>
                                </div>
                            </label>
                        </div>
                    </div>
                </div>

                {{-- KOLOM KANAN: RINGKASAN (Tetap Sama) --}}
                <div class="lg:col-span-5">
                    <div
                        class="bg-[#0B0B45]/90 text-white rounded-[2.5rem] p-8 shadow-2xl shadow-blue-900/30 sticky top-10 border border-slate-700/50 relative overflow-hidden">
                        <div
                            class="absolute -top-24 -right-24 w-64 h-64 bg-blue-600 rounded-full mix-blend-screen filter blur-[80px] opacity-20">
                        </div>
                        <div
                            class="absolute -bottom-24 -left-24 w-64 h-64 bg-indigo-600 rounded-full mix-blend-screen filter blur-[80px] opacity-20">
                        </div>

                        <div class="relative z-10">
                            <h3
                                class="text-xl font-black mb-6 border-b border-slate-700 pb-4 flex items-center justify-between">
                                Pesanan Kamu
                                <span
                                    class="text-xs font-bold bg-white/10 px-2 py-1 rounded text-blue-200">{{ count($checkoutItems) }}
                                    Item</span>
                            </h3>

                            <div class="space-y-5 mb-8 max-h-[350px] overflow-y-auto pr-2 custom-scrollbar">
                                @foreach ($checkoutItems as $item)
                                    <div class="flex gap-4 items-start group">
                                        <div class="w-16 h-16 rounded-xl bg-white p-1 shrink-0 overflow-hidden">
                                            <img src="{{ $item['product']->image }}"
                                                class="w-full h-full object-cover rounded-lg group-hover:scale-110 transition-transform">
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <p class="font-bold text-sm text-slate-100 line-clamp-2 leading-snug">
                                                {{ $item['product']->name }}</p>
                                            <p class="text-xs text-slate-400 mt-1 font-mono">
                                                {{ $item['quantity'] }}x <span class="text-slate-300">Rp
                                                    {{ number_format($item['product']->price, 0, ',', '.') }}</span>
                                            </p>
                                        </div>
                                    </div>
                                @endforeach
                            </div>

                            <div class="bg-white/5 rounded-2xl p-5 border border-white/10 mb-8 backdrop-blur-sm">
                                <div class="flex justify-between items-center mb-2">
                                    <span class="text-slate-400 text-sm font-medium">Subtotal Produk</span>
                                    <span class="text-slate-200 font-bold">Rp
                                        {{ number_format($totalAmount, 0, ',', '.') }}</span>
                                </div>
                                <div class="flex justify-between items-center mb-4">
                                    <span class="text-slate-400 text-sm font-medium">Biaya Layanan</span>
                                    <span class="text-emerald-400 font-bold text-sm">Gratis</span>
                                </div>
                                <div class="h-px bg-white/10 my-3"></div>
                                <div class="flex justify-between items-center">
                                    <span class="text-lg font-bold text-white">Total Bayar</span>
                                    <span
                                        class="text-2xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-teal-300">
                                        Rp {{ number_format($totalAmount, 0, ',', '.') }}
                                    </span>
                                </div>
                            </div>

                            <button type="submit"
                                class="w-full relative group overflow-hidden rounded-2xl p-[2px] transition-all transform hover:-translate-y-1 active:scale-95">
                                <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 rounded-2xl">
                                </div>
                                <div
                                    class="relative bg-slate-900 rounded-2xl py-4 px-6 flex items-center justify-center gap-2 group-hover:bg-transparent transition-colors">
                                    <span class="font-bold text-lg text-white">Buat Pesanan</span>
                                    <svg class="w-5 h-5 text-white" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                                            d="M14 5l7 7m0 0l-7 7m7-7H3" />
                                    </svg>
                                </div>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <style>
        .select-custom {
            width: 100%;
            background-color: white;
            border: 1px solid #e2e8f0;
            border-radius: 1rem;
            padding: 1rem;
            font-weight: 600;
            color: #1e293b;
            outline: none;
            appearance: none;
            background-image: url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%236b7280' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e");
            background-position: right 1rem center;
            background-repeat: no-repeat;
            background-size: 1.5em 1.5em;
            transition: all 0.3s;
        }

        .select-custom:focus {
            border-color: #3b82f6;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.1);
        }

        .select-custom:disabled {
            background-color: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
        }

        .custom-scrollbar::-webkit-scrollbar {
            width: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: rgba(255, 255, 255, 0.05);
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.2);
            border-radius: 10px;
        }

        .leaflet-pane {
            z-index: 0 !important;
        }

        .leaflet-bottom,
        .leaflet-top {
            z-index: 10 !important;
        }
    </style>

    {{-- SCRIPT LOGIKA WILAYAH, MAPS & PENCARIAN TEMPAT --}}
    <script>
        document.addEventListener('alpine:init', () => {
            Alpine.data('checkoutPage', () => ({
                paymentMethod: 'midtrans',

                provinces: [],
                cities: [],
                districts: [],
                villages: [],
                selectedProvince: '',
                selectedCity: '',
                selectedDistrict: '',
                selectedVillage: '',
                streetDetail: '',
                specificDetail: '',

                searchQuery: '',
                searchResults: [],
                isSearching: false,
                map: null,
                marker: null,

                init() {
                    fetch('https://www.emsifa.com/api-wilayah-indonesia/api/provinces.json')
                        .then(response => response.json()).then(data => this.provinces = data);

                    this.$nextTick(() => {
                        // 1. Peta Jalan (Biasa/Kartun) - Bagus untuk lihat nama jalan jelas
                        const roadMap = L.tileLayer(
                            'https://{s}.google.com/vt/lyrs=m&x={x}&y={y}&z={z}', {
                                maxZoom: 20,
                                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                                attribution: 'Google Maps'
                            });

                        // 2. Peta Hybrid (Satelit + Nama Jalan/Tempat) - INI YANG KAMU CARI
                        const hybridMap = L.tileLayer(
                            'https://{s}.google.com/vt/lyrs=y&x={x}&y={y}&z={z}', {
                                maxZoom: 20,
                                subdomains: ['mt0', 'mt1', 'mt2', 'mt3'],
                                attribution: 'Google Maps Hybrid'
                            });

                        // 3. Inisialisasi Peta (Default langsung pakai Hybrid biar nampak rumah + nama jalan)
                        this.map = L.map('map', {
                            center: [-0.789275, 113.921327],
                            zoom: 5,
                            layers: [hybridMap], // <--- Default Layer
                            zoomControl: false // Kita pindah zoom control biar gak nutupin search
                        });

                        L.control.zoom({
                            position: 'bottomright'
                        }).addTo(this.map);

                        // 4. Tambahkan Tombol Ganti Layer (Pojok Kanan Atas)
                        const baseMaps = {
                            "Satelit + Jalan": hybridMap,
                            "Peta Biasa": roadMap
                        };
                        L.control.layers(baseMaps).addTo(this.map);
                    });
                },

                fetchCities() {
                    if (!this.selectedProvince) return;
                    const prov = JSON.parse(this.selectedProvince);
                    this.cities = [];
                    this.districts = [];
                    this.villages = [];
                    this.selectedCity = '';
                    this.selectedDistrict = '';
                    this.selectedVillage = '';
                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/regencies/${prov.id}.json`)
                        .then(response => response.json()).then(data => this.cities = data);
                },
                fetchDistricts() {
                    if (!this.selectedCity) return;
                    const city = JSON.parse(this.selectedCity);
                    this.districts = [];
                    this.villages = [];
                    this.selectedDistrict = '';
                    this.selectedVillage = '';
                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/districts/${city.id}.json`)
                        .then(response => response.json()).then(data => this.districts = data);

                    this.searchGeneralLocation(city.name);
                },
                fetchVillages() {
                    if (!this.selectedDistrict) return;
                    const dist = JSON.parse(this.selectedDistrict);
                    this.villages = [];
                    this.selectedVillage = '';
                    fetch(`https://www.emsifa.com/api-wilayah-indonesia/api/villages/${dist.id}.json`)
                        .then(response => response.json()).then(data => this.villages = data);
                },

                // --- FITUR AUTOCOMPLETE ---
                searchPlaces() {
                    if (this.searchQuery.length < 3) return;
                    let context = "";
                    if (this.selectedCity) {
                        const city = JSON.parse(this.selectedCity).name;
                        context = " " + city;
                    }
                    this.isSearching = true;
                    fetch(
                            `https://nominatim.openstreetmap.org/search?format=json&q=${this.searchQuery}${context}&addressdetails=1&limit=5`)
                        .then(response => response.json())
                        .then(data => {
                            this.searchResults = data.map(item => ({
                                place_id: item.place_id,
                                name: item.address.amenity || item.address.building ||
                                    item.address.shop || item.address.road || item
                                    .display_name.split(',')[0],
                                display_name: item.display_name,
                                lat: item.lat,
                                lon: item.lon
                            }));
                        })
                        .finally(() => {
                            this.isSearching = false;
                        });
                },

                // --- GANTI BAGIAN FITUR AUTOCOMPLETE INI SAJA ---
                // --- FITUR AUTOCOMPLETE ---
                // searchPlaces() {
                //     if (this.searchQuery.length < 3) return;
                //     let context = "";
                //     if (this.selectedCity) {
                //         const city = JSON.parse(this.selectedCity).name;
                //         context = " " + city;
                //     }
                //     this.isSearching = true;
                //     fetch(
                //             `https://nominatim.openstreetmap.org/search?format=json&q=${this.searchQuery}${context}&addressdetails=1&limit=5`)
                //         .then(response => response.json())
                //         .then(data => {
                //             this.searchResults = data.map(item => ({
                //                 place_id: item.place_id,
                //                 name: item.address.amenity || item.address.building ||
                //                     item.address.shop || item.address.road || item
                //                     .display_name.split(',')[0],
                //                 display_name: item.display_name,
                //                 lat: item.lat,
                //                 lon: item.lon
                //             }));
                //         })
                //         .finally(() => {
                //             this.isSearching = false;
                //         });
                // },
                // --- BATAS GANTI ---

                selectLocation(place) {
                    this.updatePin(place.lat, place.lon, place.display_name);
                    this.searchResults = [];
                    this.searchQuery = place.name;
                },

                // --- LOGIKA UPDATE PIN & DRAGGABLE ---
                updatePin(lat, lon, addressText = '') {
                    this.map.setView([lat, lon], 20); // Zoom sangat dekat (Level 20)

                    if (this.marker) this.map.removeLayer(this.marker);

                    this.marker = L.marker([lat, lon], {
                        draggable: true
                    }).addTo(this.map);

                    if (addressText) this.streetDetail = addressText;

                    this.marker.on('dragend', (event) => {
                        const position = event.target.getLatLng();
                        this.reverseGeocode(position.lat, position.lng);
                    });
                },

                reverseGeocode(lat, lon) {
                    fetch(
                            `https://nominatim.openstreetmap.org/reverse?format=json&lat=${lat}&lon=${lon}&zoom=18&addressdetails=1`)
                        .then(response => response.json())
                        .then(data => {
                            if (data && data.display_name) {
                                const specificName = data.address.road || data.address.building ||
                                    data.address.amenity || "";
                                this.streetDetail = data.display_name;
                                if (specificName) this.searchQuery = specificName;
                            }
                        });
                },

                searchGeneralLocation(query) {
                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=1`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                this.map.setView([data[0].lat, data[0].lon], 13);
                            }
                        });
                },

                updateMap() {
                    if (!this.selectedVillage) return;
                    const prov = JSON.parse(this.selectedProvince).name;
                    const city = JSON.parse(this.selectedCity).name;
                    const dist = JSON.parse(this.selectedDistrict).name;
                    const vill = JSON.parse(this.selectedVillage).name;
                    const query = `${vill}, ${dist}, ${city}, ${prov}`;

                    fetch(`https://nominatim.openstreetmap.org/search?format=json&q=${query}&limit=1`)
                        .then(response => response.json())
                        .then(data => {
                            if (data.length > 0) {
                                // Zoom agak jauh sedikit biar kelihatan area sekitar dulu
                                this.map.setView([data[0].lat, data[0].lon], 17);

                                if (this.marker) this.map.removeLayer(this.marker);
                                this.marker = L.marker([data[0].lat, data[0].lon], {
                                    draggable: true
                                }).addTo(this.map);

                                this.marker.on('dragend', (event) => {
                                    const position = event.target.getLatLng();
                                    this.reverseGeocode(position.lat, position.lng);
                                });
                            }
                        });
                },

                get fullAddress() {
                    let mapAddress = this.streetDetail ? this.streetDetail : "";

                    if (this.selectedProvince && this.selectedCity) {
                        const city = JSON.parse(this.selectedCity).name;
                        const prov = JSON.parse(this.selectedProvince).name;
                        if (!mapAddress.includes(city)) {
                            mapAddress += `, ${city}, ${prov}`;
                        }
                    }

                    // KITA GUNAKAN SIMBOL ||| AGAR TIDAK BENTROK DENGAN KOMA DARI PETA
                    let manualInput = this.specificDetail ? this.specificDetail : "Tidak ada patokan khusus";

                    return manualInput + " ||| " + mapAddress;
                }
            }))
        })
    </script>
@endsection
