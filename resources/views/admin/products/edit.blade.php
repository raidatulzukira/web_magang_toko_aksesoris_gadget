@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="max-w-6xl mx-auto pb-10">
        <div class="mb-8">
            <a href="{{ route('admin.products.index') }}"
                class="text-blue-600 font-bold flex items-center gap-2 mb-2 hover:underline">
                &larr; Kembali ke Daftar
            </a>
            <h1 class="text-3xl font-bold text-slate-900">Edit Produk</h1>
        </div>

        <form action="{{ route('admin.products.update', $product->id) }}" method="POST" enctype="multipart/form-data"
            class="space-y-6">
            @csrf
            @method('PUT')

            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 lg:gap-12">

                <div class="lg:col-span-1">
                    <div class="bg-white p-8 rounded-[2rem] shadow-sm border border-slate-100 text-center sticky top-6">
                        <label class="block text-sm font-extrabold text-slate-900 mb-4">Foto Produk Saat Ini</label>
                        <div x-data="{ photoName: null, photoPreview: '{{ $product->image }}' }" class="relative w-full">
                            <input type="file" name="image" class="hidden" x-ref="photo" accept="image/*"
                                @change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                               ">

                            <div class="w-full aspect-square rounded-[1.5rem] bg-slate-50 overflow-hidden shadow-inner cursor-pointer hover:opacity-80 transition-opacity relative group"
                                @click="$refs.photo.click()">
                                <img :src="photoPreview" class="w-full h-full object-cover">
                                <div
                                    class="absolute inset-0 bg-black/40 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                    <span class="text-white font-bold text-sm">Ubah Gambar</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="lg:col-span-2 space-y-6">
                    <div class="bg-white p-8 md:p-10 rounded-[2rem] shadow-sm border border-slate-100 space-y-6">

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Nama
                                Produk</label>
                            <input type="text" name="name" value="{{ $product->name }}" required
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-blue-600 outline-none">
                        </div>

                        {{-- Input Kategori Edit --}}
                        <div class="mb-6">
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Kategori
                                Produk</label>
                            <select name="category_id" required
                                class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 outline-none font-bold text-slate-700 transition-all cursor-pointer hover:border-blue-300">
                                <option value="" disabled>-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}"
                                        {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                        {{ $category->icon }} {{ $category->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('category_id')
                                <p class="text-red-500 text-xs mt-1 font-bold">{{ $message }}</p>
                            @enderror
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Harga
                                    (Rp)</label>
                                <input type="number" name="price" value="{{ round($product->price) }}" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-blue-600 outline-none">
                            </div>
                            <div>
                                <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Stok
                                    Tersedia</label>
                                <input type="number" name="stock" value="{{ $product->stock }}" required
                                    class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-blue-600 outline-none">
                            </div>
                        </div>

                        <div>
                            <label
                                class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Varian</label>
                            <input type="text" name="variants" value="{{ $product->variants }}"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-blue-600 outline-none">
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-500 uppercase tracking-widest mb-2">Deskripsi
                                Produk</label>
                            <textarea name="description" rows="5"
                                class="w-full bg-slate-50 border border-slate-200 rounded-2xl p-4 focus:ring-2 focus:ring-blue-600 outline-none">{{ $product->description }}</textarea>
                        </div>

                    </div>

                    <button type="submit"
                        class="w-full bg-blue-600 text-white font-extrabold text-lg py-5 rounded-[1.5rem] hover:bg-blue-700 transition-all shadow-xl shadow-blue-500/30 transform hover:-translate-y-1">
                        Simpan Perubahan
                    </button>
                </div>

            </div>
        </form>
    </div>
@endsection
