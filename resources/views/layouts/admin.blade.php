<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Admin Dashboard - GadgetStore')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-slate-300/90 font-sans antialiased text-slate-900" x-data="{ sidebarOpen: true }">

    <div class="flex h-screen overflow-hidden">

        <aside :class="sidebarOpen ? 'translate-x-0 w-64' : '-translate-x-full w-0'"
            class="fixed inset-y-0 left-0 z-50 flex flex-col bg-slate-900 text-white transition-all duration-300 md:relative shadow-2xl">
            <div class="flex items-center justify-center h-20 border-b border-slate-800">
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div
                        class="w-8 h-8 bg-blue-600 rounded-lg flex items-center justify-center font-bold text-lg shadow-lg shadow-blue-500/30">
                        G</div>
                    <span x-show="sidebarOpen" class="text-xl font-bold tracking-wide">Gadget<span
                            class="text-blue-500">Admin</span></span>
                </a>
            </div>

            <nav class="flex-1 px-4 py-6 space-y-2 overflow-y-auto">
                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-3 text-white bg-blue-600 rounded-xl shadow-md shadow-blue-500/20 transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                        </path>
                    </svg>
                    <span class="font-medium">Dashboard</span>
                </a>
                <a href="{{ route('admin.products.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                    </svg>
                    <span class="font-medium">Produk</span>
                </a>
                <a href="{{ route('admin.stocks.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
                        </path>
                    </svg>
                    <span class="font-medium">Riwayat Stok</span>
                </a>
                <a href="{{ route('admin.categories.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z">
                        </path>
                    </svg>
                    <span class="font-medium">Kategori</span>
                </a>
                <a href="{{ route('admin.orders.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                    </svg>
                    <span class="font-medium">Pesanan</span>
                </a>
                <a href="{{ route('admin.customers.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z">
                        </path>
                    </svg>
                    <span class="font-medium">Pelanggan</span>
                </a>
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-3 text-slate-400 hover:text-white hover:bg-slate-800 rounded-xl transition-all">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <circle cx="9" cy="8" r="3" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M4 19c0-3 2.5-5 5-5s5 2 5 5" />
                        <circle cx="17" cy="16" r="2" stroke-width="1.8" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                            d="M17 12v1M17 19v1M13 16h1M20 16h1M14.8 13.8l.7.7M18.5 17.5l.7.7M14.8 18.2l.7-.7M18.5 14.5l.7-.7" />
                    </svg>
                    <span class="font-medium">User</span>
                </a>
            </nav>

            <div class="p-4 border-t border-slate-800">
                <form method="POST" action="{{ route('logout') }}"
                    onsubmit="return confirm('Apakah Anda yakin ingin keluar dari akun ini?')">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-3 text-red-400 hover:text-white hover:bg-red-500 rounded-xl transition-all">
                        ...
                        <span class="font-medium">Keluar</span>
                    </button>
                </form>

            </div>
        </aside>

        <div class="flex-1 flex flex-col overflow-hidden">
            <header class="h-20 bg-white border-b border-slate-200 flex items-center justify-between px-6 z-10">
                <button @click="sidebarOpen = !sidebarOpen"
                    class="text-slate-500 hover:text-blue-600 focus:outline-none transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h7"></path>
                    </svg>
                </button>

                <div class="flex items-center gap-4">
                    <button class="relative text-slate-400 hover:text-slate-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        <span
                            class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 border-2 border-white rounded-full"></span>
                    </button>

                    <div class="flex items-center gap-3 border-l border-slate-200 pl-4">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode(auth()->user()->name) }}&background=0D8ABC&color=fff"
                            class="w-10 h-10 rounded-full border border-slate-200 shadow-sm" alt="Avatar">
                        <div class="hidden md:block text-sm">
                            <p class="font-bold text-slate-900">{{ auth()->user()->name }}</p>
                            <p class="text-slate-500 text-xs capitalize">{{ auth()->user()->role }}</p>
                        </div>
                    </div>
                </div>
            </header>

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-slate-50/50 p-6">
                @yield('content')
            </main>
        </div>
    </div>

    @if (session('success'))
        <div x-data="{ show: true }" x-show="show" x-init="setTimeout(() => show = false, 4000)"
            x-transition:enter="ease-out duration-500 transition-all"
            x-transition:enter-start="opacity-0 translate-y-10" x-transition:enter-end="opacity-100 translate-y-0"
            x-transition:leave="ease-in duration-300" x-transition:leave-start="opacity-100"
            x-transition:leave-end="opacity-0 translate-y-10"
            class="fixed bottom-8 right-8 z-[200] bg-slate-900 text-white px-6 py-4 rounded-2xl shadow-2xl flex items-center gap-4 border border-slate-700">

            <div class="bg-blue-500/20 text-blue-400 p-2 rounded-xl">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
            </div>
            <span class="font-bold">{{ session('success') }}</span>
            <button @click="show = false" class="text-slate-400 hover:text-white transition-colors ml-2">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
        </div>
    @endif

</body>

</html>
