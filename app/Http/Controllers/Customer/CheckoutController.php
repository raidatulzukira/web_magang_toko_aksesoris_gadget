<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use Midtrans\Config;
use Midtrans\Snap;

class CheckoutController extends Controller
{
    // 1. Proses dari tombol "Beli Sekarang" (Langsung 1 Produk)
    public function direct(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'variant' => 'nullable|string'
        ]);

        $product = Product::findOrFail($request->product_id);

        // Simpan data sementara ke Session
        $checkoutItems = [[
            'product' => $product,
            'quantity' => $request->quantity,
            'variant' => $request->variant,
            'cart_id' => null, // Tandai kalau ini BUKAN dari keranjang
            'subtotal' => $product->price * $request->quantity
        ]];

        session(['checkout_items' => $checkoutItems]);
        return redirect()->route('checkout.index');
    }

    // 2. Proses dari halaman "Keranjang" (Bisa banyak produk)
    public function processCart(Request $request)
    {
        // Validasi apakah ada barang yang dicentang
        $request->validate([
            'cart_ids' => 'required|array',
            'cart_ids.*' => 'exists:carts,id'
        ]);

        // Ambil data keranjang yang dicentang saja
        $carts = Cart::with('product')->whereIn('id', $request->cart_ids)->where('user_id', Auth::id())->get();

        $checkoutItems = [];
        foreach($carts as $cart) {
            $checkoutItems[] = [
                'product' => $cart->product,
                'quantity' => $cart->quantity,
                'variant' => $cart->variant,
                'cart_id' => $cart->id,
                'subtotal' => $cart->product->price * $cart->quantity
            ];
        }

        session(['checkout_items' => $checkoutItems]);
        return redirect()->route('checkout.index');
    }

    // 3. Menampilkan Halaman Checkout
    public function index()
    {
        // Ambil data dari session yang dikirim oleh fungsi direct/processCart
        $checkoutItems = session('checkout_items');

        // Jika tidak ada data, kembalikan ke keranjang
        if (!$checkoutItems) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada pesanan yang diproses.');
        }

        $totalAmount = collect($checkoutItems)->sum('subtotal');

        return view('customer.checkout', compact('checkoutItems', 'totalAmount'));
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

    public function pay(Request $request)
    {
        // 1. Validasi Input Form
        $request->validate([
            'recipient_name' => 'required|string|max:255',
            'phone_number' => 'required|string|max:20',
            'shipping_address' => 'required|string',
            'payment_method' => 'required|in:cod,midtrans',
        ]);

        $checkoutItems = session('checkout_items');
        if (!$checkoutItems) {
            return redirect()->route('cart.index')->with('error', 'Sesi checkout berakhir, silakan ulangi.');
        }

        // Pakai total_price sesuai DB kamu
        $totalPrice = collect($checkoutItems)->sum('subtotal');
        $orderNumber = 'TRX-' . strtoupper(Str::random(8));

        // Karena di DB tidak ada kolom recipient_name dan payment_method,
        // kita gabungkan datanya ke dalam kolom address agar informasinya tetap tersimpan rapi.
        $fullAddress = $request->recipient_name . ' | ' . $request->shipping_address . ' | Metode: ' . strtoupper($request->payment_method);

        // 2. Simpan Data ke Tabel Orders
        // $order = Order::create([
        //     'user_id' => Auth::id(),
        //     'order_number' => $orderNumber,
        //     'total_price' => $totalPrice, // Sesuai DB
        //     'payment_status' => 'unpaid',
        //     'address' => $fullAddress,    // Sesuai DB
        //     'phone' => $request->phone_number, // Sesuai DB
        // ]);

        // 2. Simpan Data ke Tabel Orders
        // LOGIKA BARU: Jika pembeli memilih COD, status order langsung "processing"
        $statusPengiriman = ($request->payment_method === 'cod') ? 'processing' : 'pending';

        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => $orderNumber,
            'total_price' => $totalPrice, // Sesuai DB
            'payment_status' => 'unpaid',
            'order_status' => $statusPengiriman, // <-- Otomatis menyesuaikan metode
            'address' => $fullAddress,    // Sesuai DB
            'phone' => $request->phone_number, // Sesuai DB
        ]);

        // 3. Simpan Detail Barang
        $cartIdsToDelete = [];
        foreach ($checkoutItems as $item) {
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $item['product']->id,
                'variant_info' => $item['variant'], // Sesuai DB (variant_info)
                'quantity' => $item['quantity'],
                'price' => $item['product']->price,
            ]);

            // Kurangi stok barang
            $item['product']->decrement('stock', $item['quantity']);

            if ($item['cart_id']) {
                $cartIdsToDelete[] = $item['cart_id'];
            }
        }

        // 4. Bersihkan Keranjang
        if (count($cartIdsToDelete) > 0) {
            Cart::whereIn('id', $cartIdsToDelete)->delete();
        }
        session()->forget('checkout_items');

        // 5. CABANG PEMBAYARAN
        if ($request->payment_method === 'cod') {
            return redirect()->route('dashboard')->with('success', 'Pesanan COD berhasil dibuat! Silakan bayar saat kurir tiba.');
        }

        // JIKA MIDTRANS
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');

        $params = [
            'transaction_details' => [
                'order_id' => $order->order_number,
                'gross_amount' => (int) $totalPrice, // WAJIB INTEGER
            ],
            'customer_details' => [
                'first_name' => $request->recipient_name,
                'phone' => $request->phone_number,
            ],
        ];

        try {
            $snapToken = \Midtrans\Snap::getSnapToken($params);

            $order->update(['snap_token' => $snapToken]);

            return view('customer.payment', compact('snapToken', 'order'));
        } catch (\Exception $e) {
            return redirect()->route('dashboard')->with('error', 'Gagal memproses Midtrans: ' . $e->getMessage());
        }
    }

    public function success($order_number)
    {
        // Cari pesanan berdasarkan nomor order dan user yang login
        $order = Order::where('order_number', $order_number)
                      ->where('user_id', Auth::id())
                      ->firstOrFail();

        // Ubah statusnya menjadi LUNAS
        // $order->update([
        //     'payment_status' => 'paid'
        // ]);

        // Ubah statusnya menjadi LUNAS dan otomatis DIPROSES
        $order->update([
            'payment_status' => 'paid',
            'order_status' => 'processing' // <-- Otomatis jadi diproses setelah bayar
        ]);

        // Lempar kembali ke dashboard dengan Notifikasi Sukses
        return redirect()->route('dashboard')->with('success', 'Hore! Pembayaran pesanan ' . $order_number . ' berhasil dikonfirmasi.');
    }
}
