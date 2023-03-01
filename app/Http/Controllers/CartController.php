<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    //redirect cart list
    function list() {
        $cartList = Cart::select('carts.*', 'products.id as product_id', 'products.name as product_name', 'products.price as product_price', 'products.image as image')
            ->leftJoin('products', 'products.id', 'carts.product_id')
            ->where('carts.user_id', Auth::user()->id)
            ->get();
        $totalPrice = 0;
        foreach ($cartList as $c) {
            $totalPrice += $c->product_price * $c->qty;
        }
        return view('user.cart.list', compact('cartList', 'totalPrice'));
    }

    // redirect cart history page
    public function history()
    {
        $order = Order::where('user_id', Auth::user()->id)->orderBy('created_at', 'desc')->paginate('6');
        return view('user.cart.history', compact('order'));
    }
}
