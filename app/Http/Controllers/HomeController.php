<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data produk
        $products = Product::all();

        // Kirim ke tampilan 'welcome'
        return view('welcome', compact('products'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $product = Product::findOrFail($id);
        return view('customer.product-detail', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function katalog(Request $request)
    {
        // 1. Mulai query produk
        $query = \App\Models\Product::query();

        // (Opsional) Jika kamu punya fitur search, taruh di sini
        // if ($request->search) {
        //     $query->where('name', 'like', '%' . $request->search . '%');
        // }

        // 2. LOGIKA PENGURUTAN (SORTING)
        if ($request->sort == 'termurah') {
            $query->orderBy('price', 'asc'); // Harga terkecil ke terbesar
        } elseif ($request->sort == 'termahal') {
            $query->orderBy('price', 'desc'); // Harga terbesar ke terkecil
        } else {
            $query->latest(); // Default: Produk paling baru ditambahkan
        }

        // 3. Eksekusi query dengan Pagination
        // WAJIB tambahkan withQueryString() agar saat pindah halaman 2, urutannya tidak ter-reset!
        $products = $query->paginate(12)->withQueryString();

        // return view('katalog', compact('products'));





        // Mengambil semua produk dengan paginasi (12 produk per halaman)
        // $products = Product::latest()->paginate(12);

        return view('customer.katalog', compact('products'));
    }
}
