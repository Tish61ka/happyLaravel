<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Bascet;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\CartRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\BasketResource;

class BascetController extends Controller
{
    public function all(){
        $user = User::where('token', '!=', null)->first();
        return response()->json([
            'content' => BasketResource::collection(Bascet::all()->where('user_id', $user->id))
        ]);
    }
    public function store($product_id){
        $product = Product::find($product_id);
        $user = User::where('token', '!=', null)->first();
        Bascet::create([
            'user_id' => $user->id,
            'product_id' => $product_id
        ]);
        return response()->json([
            'message' => 'Товар в корзине'
        ]);
    }
    public function destroy($id){
        $product = Bascet::find($id);
        $product->delete();
        return response()->json([
            'content' => [
                'message' => 'Позиция удалена из корзины'
            ]
        ]);
    }
}
