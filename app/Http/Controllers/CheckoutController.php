<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\HomepageController; // ganti jika beda namespace
use Binafy\LaravelCart\Models\Cart;
use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Theme;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    protected $themeFolder;

    public function process(Request $request)
{
    $cart = Cart::with('items.itemable')
        ->where('user_id', Auth::guard('customer')->id())
        ->firstOrFail();

    $total = $cart->items->sum(fn($i) => $i->qty * $i->itemable->price);

    $order = Order::create([
        'customer_id'  => Auth::guard('customer')->id(),
        'order_date'   => now(),    // simpan tanggal order
        'total_amount'=> $total,           // sesuai kolom total_amount
        'status'       => 'pending',       // atau status lain sesuai aplikasi
    ]);

    foreach ($cart->items as $item) {
        OrderDetail::create([
            'order_id'   => $order->id,
            'product_id' => $item->itemable->id,
            'quantity'   => $item->quantity,                    // sesuai kolom quantity
            'unit_price' => $item->itemable->price,       // sesuai unit_price
            'subtotal'   => $item->quantity * $item->itemable->price,
        ]);
    }

    $cart->items()->delete();

    return redirect()->route('cart.index')
        ->with('success', 'Pesanan berhasil dibuat!');
}

    public function show()
{
    $cart = Cart::with('items.itemable')
        ->where('user_id', Auth::guard('customer')->id())
        ->firstOrFail();

    $subtotal = $cart->items->sum(fn($item) => $item->qty * $item->itemable->price);
    $ongkir   = ($subtotal >= 50000) ? 0 : 5000;
    $total    = $subtotal + $ongkir;

    return view($this->themeFolder.'.checkout', compact('cart','subtotal','ongkir','total'));
}


    public function __construct()
    {
        $theme = Theme::where('status', 'active')->first();
        $this->themeFolder = $theme ? $theme->folder : 'web';
    }
}


