@extends('layouts.admin')
@section('title', 'Manajemen User')

@section('content')
<div class="mb-8 flex justify-between items-center">
    <div>
        <h1 class="font-display text-3xl font-extrabold text-slate-900">Manajemen User</h1>
        <p class="text-slate-500 mt-1">Kelola hak akses admin dan customer di sistemmu.</p>
    </div>
    <a href="{{ route('admin.users.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-bold transition-colors shadow-lg shadow-blue-500/30 flex items-center gap-2">
        + Tambah User
    </a>
</div>

{{-- Notifikasi --}}
@if(session('success'))
    <div class="bg-emerald-50 border border-emerald-200 text-emerald-600 px-4 py-3 rounded-xl mb-6 font-bold flex items-center gap-3">✅ {{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="bg-red-50 border border-red-200 text-red-600 px-4 py-3 rounded-xl mb-6 font-bold flex items-center gap-3">❌ {{ session('error') }}</div>
@endif

<div class="bg-white rounded-[2rem] shadow-sm border border-slate-100 overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left border-collapse">
            <thead>
                <tr class="bg-slate-50/50 border-b border-slate-100 text-xs uppercase tracking-widest text-slate-400 font-bold">
                    <th class="p-6">User / Email</th>
                    <th class="p-6 text-center">Role</th>
                    <th class="p-6">Bergabung</th>
                    <th class="p-6 text-right">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-slate-100 text-sm">
                @foreach($users as $user)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="p-6 flex items-center gap-4">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode($user->name) }}&background=0D8ABC&color=fff" class="w-10 h-10 rounded-full shadow-sm">
                            <div>
                                <p class="font-bold text-slate-900">{{ $user->name }}</p>
                                <p class="text-xs text-slate-500">{{ $user->email }}</p>
                            </div>
                        </td>
                        <td class="p-6 text-center">
                            @if($user->role === 'admin')
                                <span class="px-3 py-1 bg-purple-100 text-purple-700 rounded-lg text-xs font-black tracking-widest uppercase">Admin</span>
                            @else
                                <span class="px-3 py-1 bg-slate-100 text-slate-600 rounded-lg text-xs font-black tracking-widest uppercase">Customer</span>
                            @endif
                        </td>
                        <td class="p-6 text-slate-500 font-medium">{{ $user->created_at->format('d M Y') }}</td>
                        <td class="p-6 text-right flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.show', $user->id) }}" class="p-2 bg-blue-50 text-blue-600 rounded-lg hover:bg-blue-600 hover:text-white transition-colors">👁️</a>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="p-2 bg-amber-50 text-amber-600 rounded-lg hover:bg-amber-500 hover:text-white transition-colors">✏️</a>
                            <form action="{{ route('admin.users.destroy', $user->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus user ini?')">
                                @csrf @method('DELETE')
                                <button type="submit" class="p-2 bg-red-50 text-red-600 rounded-lg hover:bg-red-600 hover:text-white transition-colors">🗑️</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
