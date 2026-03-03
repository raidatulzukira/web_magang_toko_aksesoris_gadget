<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\StockHistory;
use Illuminate\Support\Facades\DB;

class StockController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil produk untuk dropdown form
        $products = Product::orderBy('name', 'asc')->get();

        // Ambil riwayat stok beserta relasi nama produk dan nama admin
        $histories = StockHistory::with(['product', 'user'])
                        ->latest()
                        ->paginate(10);

        return view('admin.stocks.index', compact('products', 'histories'));
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
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'type' => 'required|in:in,out', // in = masuk, out = keluar
            'quantity' => 'required|integer|min:1',
            'description' => 'nullable|string|max:255',
        ]);

        try {
            DB::transaction(function () use ($request) {
                // Kunci baris produk ini sementara agar tidak bentrok jika ada transaksi bersamaan
                $product = Product::lockForUpdate()->find($request->product_id);

                // Jika Barang Keluar, cek apakah stok cukup
                if ($request->type === 'out' && $product->stock < $request->quantity) {
                    throw new \Exception('Stok tidak mencukupi! Sisa stok saat ini hanya: ' . $product->stock);
                }

                // Update stok utama di tabel products
                if ($request->type === 'in') {
                    $product->increment('stock', $request->quantity);
                } else {
                    $product->decrement('stock', $request->quantity);
                }

                // Ambil data produk terbaru setelah di-update
                $product->refresh();

                // Catat ke Buku Besar (History)
                StockHistory::create([
                    'product_id' => $request->product_id,
                    'user_id' => auth()->id(),
                    'type' => $request->type,
                    'quantity' => $request->quantity,
                    'current_stock' => $product->stock, // Simpan sisa stok akhir
                    'description' => $request->description ?? ($request->type === 'in' ? 'Penambahan stok manual' : 'Pengurangan stok manual'),
                ]);
            });

            return redirect()->route('admin.stocks.index')->with('success', 'Transaksi stok berhasil dicatat!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', $e->getMessage())->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
}
