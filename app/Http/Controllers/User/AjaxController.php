<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderList;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AjaxController extends Controller
{
    //return pizza list
    public function pizzaList(Request $request)
    {
        if ($request->status == 'desc') {
            $data = Product::orderBy('created_at', 'desc')->get();
        } else {
            $data = Product::orderBy('created_at', 'asc')->get();
        }
        return response()->json($data, 200);
    }

    // return cart list
    public function addToCart(Request $request)
    {
        $data = $this->requestCartData($request);
        Cart::create($data);
        $response = [
            'status' => 'success',
            'message' => 'Add To Cart Complete',
        ];
        return response()->json($response, 200);
    }

    // order
    public function order(Request $request)
    {
        $total = 0;
        foreach ($request->all() as $item) {
            $data = OrderList::create([
                'user_id' => $item['user_id'],
                'product_id' => $item['product_id'],
                'qty' => $item['qty'],
                'total' => $item['total'],
                'order_code' => $item['order_code'],
            ]);
            $total += $data->total;
        }

        Cart::where('user_id', Auth::user()->id)->delete();

        Order::create([
            'user_id' => Auth::user()->id,
            'order_code' => $data->order_code,
            'total_price' => $total + 3000,
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'Order Complete',
        ], 200);
    }

    // clear cart
    public function clearCart(Request $request)
    {
        Cart::where('user_id', Auth::user()->id)->delete();
    }

    // clear current item
    public function clearCurrentItem(Request $request)
    {
        Cart::where('user_id', Auth::user()->id)
            ->where('product_id', $request->product_id)
            ->where('id', $request->order_id)
            ->delete();
    }

    // increase pizza view count
    public function increaseViewCount(Request $request)
    {
        $pizza = Product::where('id', $request->productId)->first();
        $viewCount = [
            'view_count' => $pizza->view_count + 1,
        ];
        Product::where('id', $request->productId)->update($viewCount);
    }

    // request cart data
    private function requestCartData($request)
    {
        return [
            'user_id' => $request->userId,
            'product_id' => $request->pizzaId,
            'qty' => $request->pizzaCount,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
