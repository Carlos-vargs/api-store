<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\V1\ProductRequest;
use Illuminate\Support\Facades\Auth;


class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::all();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $request->validated();
        
        return Auth::user()->products()->create($request->all());
    
        
        /*
        $product = new Product();
        
        $product->title = $request->title;
        $product->price = $request->price;
        $product->description = $request->description;
        
        $product->save();
        */
        
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return Product::find($id);   
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        if (Auth::id() === $product->user->id) {

            $product->update($request->all());

            return $product;

        }

        return response([
            'message' => "you can't update another user's products",
        ], 403); 


    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        
        $product = Product::find($id);

        if (Auth::id() === $product->user->id) {

            Product::destroy($id);

            return [
                'message' => 'Product deleted succesfully'
            ];

        }

        return response([
            'message' => "you can't delete another user's products",
        ], 403); 

    }

    /**
     * .
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function search($title)
    {
       return Product::where('title', 'like', '%'.$title.'%')->get();
    }

}
