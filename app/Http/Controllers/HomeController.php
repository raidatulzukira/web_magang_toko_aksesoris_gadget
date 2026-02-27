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
        // 1. Tarik semua kategori untuk ditampilkan sebagai tombol filter
        $categories = \App\Models\Category::all();

        // 2. Mulai query produk beserta relasi kategorinya
        $query = \App\Models\Product::with('category');

        // 3. FITUR PENCARIAN (SEARCH)
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('name', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // 4. FITUR FILTER KATEGORI
        if ($request->filled('category')) {
            $query->whereHas('category', function($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        // 5. LOGIKA PENGURUTAN (SORTING)
        if ($request->sort == 'termurah') {
            $query->orderBy('price', 'asc');
        } elseif ($request->sort == 'termahal') {
            $query->orderBy('price', 'desc');
        } else {
            $query->latest(); // Default
        }

        // 6. Eksekusi query dengan Pagination
        // withQueryString() memastikan URL (search, sort, category) terbawa ke halaman 2, 3, dst.
        $products = $query->paginate(12)->withQueryString();

        return view('customer.katalog', compact('products', 'categories'));
    }
}
