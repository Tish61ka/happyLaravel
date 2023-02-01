<?php

namespace App\Http\Controllers;

use App\Http\Resources\BasketResource;
use App\Models\Bascet;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function all(){
        $user = User::where('token', '!=', 'null')->first();
        $orders = Order::all()->where('user_id', $user->id);
        return response()->json([
            'content' => $orders
        ]);
    }
    public function store(){
        $user = User::where('token', '!=', 'null')->first();
        $products = BasketResource::collection(Bascet::all()->where('user_id', $user->id));

        if($products->count() == 0){
            return response()->json([
                'message' => 'Нет товаров для оформления заказа',
                'code' => 422
            ]);
        } else {
            $arr = [];
            $fullPrice = 0;

            foreach($products as $product){
                $arr[] = $product->product_id;
                $obj = Product::find($product->product_id);
                $fullPrice += $obj->price;
                $product->delete();
            }

            $order = Order::create([
                'order_price' => $fullPrice,
                'products' => json_encode($arr),
                'user_id' => $user->id
            ]);







            return response()->json([
                'order_id' => $order->id,
                'message' => 'Заказ оформлен'
            ]);
        }
    }
}
