<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function addproduct(Request $req){

        $product = new Product;
        $product->name= $req->input('name');
        $product->price= $req->input('price');
        $product->description= $req->input('description');
        $product->image= $req->file('image')->store('products');
        $product->save();
        return $product;
    }
    public function productlist(){

        $product = Product::all();
        return $product;
    }

    public function deletproduct($id){

        $product = Product::find($id);
        if($product){
            $product->delete();
            return ['error'=>"deleted sucsess"];
        }
        else{
            return ['error'=>"Opration Failed"];
        }
    }
    public function getproduct($id){

        return Product::find($id);
    }


    public function updateproduct($id,Request $req){
        
        $product =Product::find($id);

        $product->name= $req->input('name');
        $product->price= $req->input('price');
        $product->description= $req->input('description');
        if($req->file('image'))
        {
            Storage::delete('products/',$product->image);
            $product->image= $req->file('image')->store('products');
        }
        $product->save();
        return $product;
    }

    public function searchproduct($key){

        return Product::where('name','like',"%$key%")->get();
    }
}
