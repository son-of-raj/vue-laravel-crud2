<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Products;

class ProductsController extends Controller
{
    public function storeProduct(Request $request) {
        $product = new Products();
        $product->oem = $request->oem;
        $product->model_no = $request->model_no;
        $product->product_type = $request->product_type;
        $product->price = $request->price;
        $product->config = $request->config;
        $product->save();

        return $product;
    }

    public function getProducts(Request $request) {
        $products = Products::all();

        return $products;
    }
    
    public function deleteProduct(Request $request){
        $product = Products::find($request->id)->delete();
    }

    public  function editProduct(Request $request, $id){
        $product = Products::where('id',$id)->first();

        $product->oem = $request->get('val_1');
        $product->model_no = $request->get('val_2');
        $product->product_type = $request->get('val_3');
        $product->price = $request->get('val_4');
        $product->config = $request->get('val_5');
        $product->save();

        return $product;
    }
}
