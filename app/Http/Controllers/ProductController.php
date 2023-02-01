<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use Illuminate\Http\Request;
use App\Models\Product;

class ProductController extends Controller
{
    public function all(){
        $products = Product::all();
        return response()->json([
            'content' => $products
        ]);
    }
    public function index($id){
        return response()->json([
            'content' => Product::find($id)
        ]);
    }
    public function store(ProductRequest $request){
        $product = Product::create($request->all());

        return response()->json([
            'content' => [
                'id' => $product->id,
                'message' => 'Товар добавлен'
            ]
        ]);
    }
    public function update(Request $request){

    }
    public function destroy($id){
        $product = Product::find($id);
        $product->delete();
        return response()->json([
            'content' => [
                'message' => 'Товар удален'
            ]
        ]);
    }
}
