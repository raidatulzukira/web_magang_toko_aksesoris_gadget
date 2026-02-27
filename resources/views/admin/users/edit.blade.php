@extends('layouts.admin')
@section('title', 'Edit User')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="mb-8 flex items-center gap-4">
        <a href="{{ route('admin.users.index') }}" class="w-10 h-10 bg-white border border-slate-200 rounded-full flex items-center justify-center text-slate-500 hover:text-blue-600 transition-colors">←</a>
        <h1 class="font-display text-2xl font-extrabold text-slate-900">Edit User: {{ $user->name }}</h1>
    </div>

    <form action="{{ route('admin.users.update', $user->id) }}" method="POST" class="bg-white rounded-[2rem] p-8 shadow-sm border border-slate-100 space-y-6">
        @csrf @method('PUT')
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Nama Lengkap</label>
            <input type="text" name="name" value="{{ $user->name }}" required class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 outline-none">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Email</label>
            <input type="email" name="email" value="{{ $user->email }}" required class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 outline-none">
        </div>
        <div>
            <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Role (Hak Akses)</label>
            <select name="role" required class="w-full bg-slate-50 border border-slate-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-blue-600 outline-none">
                <option value="customer" {{ $user->role == 'customer' ? 'selected' : '' }}>Customer (Pelanggan Biasa)</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin (Pengelola Toko)</option>
            </select>
        </div>
        <div class="p-4 bg-amber-50 rounded-2xl border border-amber-100">
            <label class="block text-xs font-bold text-amber-700 uppercase tracking-wider mb-2">Reset Password Baru (Opsional)</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah password" class="w-full bg-white border border-amber-200 px-5 py-3.5 rounded-2xl focus:ring-2 focus:ring-amber-500 outline-none">
        </div>
        <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-4 rounded-2xl shadow-lg transition-all mt-4">Simpan Perubahan</button>
    </form>
</div>
@endsection
