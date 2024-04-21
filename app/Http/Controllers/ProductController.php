<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\ProductRequest;
class ProductController extends Controller
{
    public function index()
    {
        $products = Product::all();
        if($products->isEmpty()){
            return response('no products found',404);
        }
        return response()->json(['message' => 'Success', 'products' => $products->toArray()], 200);
    }
    public function getsingleproduct($id){
        $product = Product::find($id);
        if($product === null) {
            return response('No product found with id ' . $id, 404);
        }
        return response()->json(['message' => 'Success', 'product' => $product->toArray()], 200);
    }

    public function add_product(ProductRequest $request)
    {
        //product_name product_price product_description product_images
        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->product_description = $request->product_description;
        $sora = $request->file('product_images');
        $sora_name = $sora->getClientOriginalName();
        $sora->storeAs('products_folder', $sora_name, 'public');
        $path = "products_folder/".$sora_name;
        $product->product_images = $path;
        $product->save();
        return response('product added successfully',200);
    }


    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        //
    }
    public function updateproduct(ProductRequest $request,$id)
    {
        $product = Product::find($id);
        $product->product_name = $request->product_name;
        $product->product_price = $request->product_price;
        $product->product_description = $request->product_description;
        $product->save();
        return response()->json(['message' => 'product updated successfully', 'product' => $product], 200);
    }

    public function destroy($id)
    {
        $product = Product::find($id);
        $product->delete();
        // $product = Product::destroy($id);
        return response()->json(['message' => 'product deleted successfully'], 200);
    }
}
