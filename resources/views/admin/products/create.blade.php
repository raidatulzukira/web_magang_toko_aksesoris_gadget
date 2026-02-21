@extends('layouts.admin')

@section('title', 'Tambah Produk Baru')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="mb-8">
        <a href="{{ route('admin.products.index') }}" class="text-blue-600 font-bold flex items-center gap-2 mb-2 hover:underline">
            &larr; Kembali ke Daftar
        </a>
        <h1 class="text-3xl font-bold text-slate-900">Tambah Produk</h1>
    </div>

    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="md:col-span-1">
                <div class="bg-white p-6 rounded-[2.5rem] shadow-sm border border-slate-100 text-center">
                    <label class="block text-sm font-bold text-slate-700 mb-4">Foto Produk</label>
                    <div x-data="{photoName: null, photoPreview: null}" class="relative">
                        <input type="file" name="image" class="hidden" x-ref="photo"
                               @change="
                                    photoName = $refs.photo.files[0].name;
                                    const reader = new FileReader();
                                    reader.onload = (e) => { photoPreview = e.target.result; };
                                    reader.readAsDataURL($refs.photo.files[0]);
                               ">

                        <div class="w-full h-48 rounded-3xl bg-slate-50 border-2 border-dashed border-slate-200 flex items-center justify-center overflow-hidden"
                             x-show="!photoPreview" @click="$refs.photo.click()">
                            <span class="text-slate-400 text-xs">Klik untuk upload</span>
                        </div>

                        <div class="w-full h-48 rounded-3xl bg-slate-50 overflow-hidden shadow-inner cursor-pointer"
                             x-show="photoPreview" @click="$refs.photo.click()">
                            <img :src="photoPreview" class="w-full h-full object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <div class="md:col-span-2 space-y-6">
                <div class="bg-white p-8 rounded-[2.5rem] shadow-sm border border-slate-100 space-y-5">

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Nama Produk</label>
                        <input type="text" name="name" required class="w-full bg-slate-50 border-slate-200 rounded-2xl p-4 focus:ring-blue-600 focus:border-blue-600" placeholder="Cth: Casing iPhone 15 Pro Max">
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Harga (Rp)</label>
                            <input type="number" name="price" required class="w-full bg-slate-50 border-slate-200 rounded-2xl p-4" placeholder="50000">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Stok</label>
                            <input type="number" name="stock" required class="w-full bg-slate-50 border-slate-200 rounded-2xl p-4" placeholder="10">
                        </div>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Varian (Pisahkan dengan koma)</label>
                        <input type="text" name="variants" class="w-full bg-slate-50 border-slate-200 rounded-2xl p-4" placeholder="iPhone 11, iPhone 12, iPhone 13">
                        <p class="text-[10px] text-slate-400 mt-1 italic">*Kosongkan jika produk universal (seperti Powerbank)</p>
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-400 uppercase tracking-widest mb-2">Deskripsi</label>
                        <textarea name="description" rows="4" class="w-full bg-slate-50 border-slate-200 rounded-2xl p-4"></textarea>
                    </div>

                    <button type="submit" class="w-full bg-slate-900 text-white font-bold py-4 rounded-2xl hover:bg-blue-600 transition-all shadow-lg shadow-slate-200">
                        Simpan Produk
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
