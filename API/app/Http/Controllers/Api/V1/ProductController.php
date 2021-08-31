<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Http\Requests\V1\ProductRequest;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\ProductResource;


class ProductController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return ProductResource::collection(Product::paginate()); 
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
        
        $product = Auth::user()->products()->create($request->all());
        
        $url_image = $request->file('image');

        $image = $url_image->store('product', 'public');
        
        $product->productImages()->create(compact('image'));
            
        return response([
            'message' => 'Product created succesfully'
        ], 201);
    
        
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

        $this->authorize('author', $product);

        $product->update($request->all());

        return [
            'Product' => $product,
            'message' => 'Product updated succesfully'
        ];

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

        $this->authorize('author', $product);

        $product->delete();

        return [
            'message' => 'Product deleted succesfully'
        ];


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
