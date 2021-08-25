<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\V1\ProductRequest;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::all();
        return $products;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    { 
        $request->validated();

        $product = new Product();

        $product->title = $request->title;
        $product->price = $request->price;
        $product->description = $request->description;
        $image = $request->file('path');

        $path = $image->store('product', 'public');
        $product->productImages()->create(compact('path'));         

        $product->save();

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $product = findOrFiel($request->id);

        $product->title = $request->title;
        $product->price = $request->price;
        $product->description = $request->description;
        $image = $request->file('path');

        $path = $image->store('product', 'public');
        $product->productImages()->create(compact('path'));   

        $product->save();

        return $product;


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $product = Product::destroy($request->id);

        return $product; 

    }
}
