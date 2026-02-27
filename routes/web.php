<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\Admin\ProductController;
use App\Http\Controllers\Customer\CartController;
use App\Http\Controllers\Customer\CheckoutController;


Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/produk/{id}', [HomeController::class, 'show'])->name('front.product.show');
Route::get('/katalog', [HomeController::class, 'katalog'])->name('front.katalog');
Route::get('/tentang', function () {
    return view('tentang');
})->name('tentang');

// Route::get('/', function () {
//     return view('welcome');
// });

// ROUTE DASHBOARD (Pemisahan Admin & Customer)
// Route::get('/dashboard', function () {
//     // Memberitahu VS Code secara paksa bahwa ini adalah Model User
//     /** @var \App\Models\User $user */
//     $user = Auth::user();

//     if ($user->role === 'admin') {
//         return view('admin.dashboard');
//     }

//     return view('customer.dashboard');
// })->middleware(['auth', 'verified'])->name('dashboard');

// ROUTE DASHBOARD (Pemisahan Admin & Customer)
Route::get('/dashboard', function () {
    // Memberitahu VS Code secara paksa bahwa ini adalah Model User
    /** @var \App\Models\User $user */
    $user = Auth::user();

    if ($user->role === 'admin') {
        return view('admin.dashboard');
    }

    // --- TAMBAHAN BARU: Ambil data pesanan khusus untuk customer ---
    $orders = \App\Models\Order::with('items.product')->where('user_id', $user->id)->latest()->get();

    // Kirim data $orders ke tampilan dashboard customer
    return view('customer.dashboard', compact('orders'));

})->middleware(['auth', 'verified'])->name('dashboard');



Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('products', ProductController::class);
    Route::resource('orders', \App\Http\Controllers\Admin\OrderController::class)->only(['index', 'show', 'update']);
    Route::resource('customers', \App\Http\Controllers\Admin\CustomerController::class)->only(['index', 'show']);
    Route::resource('users', \App\Http\Controllers\Admin\UserController::class);
    Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class)->except(['show']);
});










Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Route Keranjang
    Route::post('/cart/add', [CartController::class, 'store'])->name('cart.store');
    Route::get('/keranjang', [CartController::class, 'index'])->name('cart.index');
    Route::delete('/keranjang/{id}', [CartController::class, 'destroy'])->name('cart.destroy');
    Route::post('/checkout/direct', [CheckoutController::class, 'direct'])->name('checkout.direct');
    Route::post('/checkout/process', [CheckoutController::class, 'processCart'])->name('checkout.process');
    Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    Route::post('/checkout/pay', [CheckoutController::class, 'pay'])->name('checkout.pay');
    // Route Update Status Pembayaran Lokal
    Route::get('/checkout/success/{order_number}', [CheckoutController::class, 'success'])->name('checkout.success');
    Route::get('/pesanan/{order_number}', [\App\Http\Controllers\Customer\OrderController::class, 'show'])->name('customer.order.show');
});

require __DIR__.'/auth.php';
