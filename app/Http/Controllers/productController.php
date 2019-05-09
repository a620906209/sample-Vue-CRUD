<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
// use App\Http\Request;
use App\product;
use App\Http\Resources\Product as ProductResource;
class productController extends Controller
{
    public function index(){

      $products = product::paginate(5);
      // dd($products);
      return ProductResource::collection($products);

    }
    

    public function show($id){

      $products = product::findOrFail($id);

      return new ProductResource($products);

    }


    public function store(Request $request)
    {
      $myproduct = $request->isMethod('put') ? product::findOrFail($request->id) : new product;
      

      $myproduct->id = $request->input('id');
      $myproduct->product_name = $request->input('product_name');
      $myproduct->product_price = $request->input('product_price');
      $myproduct->product_type = $request->input('product_type');


      if($myproduct->save()){
        return new ProductResource($myproduct);
      }

    }

    public function destroy($id){

      $products = product::findOrFail($id);

      if($products->delete()){

      return new ProductResource($products);
      }


    }
}
