<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Resources\ProductResource;
use App\Http\Request\ProductRequest;

class ProductController extends Controller
{
     /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $product = Product::filterSearch()->filterId()->paginate(10);
        return ProductResource::collection($product);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(ProductRequest $request)
    {
        try {
            DB::beginTransaction();
            $request_data = $request->validated();
            $request_data['image'] = Product::uploadFile('image');
            $product = Product::create($request_data);
            DB::commit();
            return new ProductResource($product);
        }
        catch(\Exception $e)
        {

            return $e;
            DB::rollBack();
            return response()->json(['status'=>'error','message'=>'oops! something went wrong']);

        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Product  $company
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return new ProductResource($product);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        try {
            DB::beginTransaction();
            $request_data = $request->validated();
            $request_data['image'] = Product::uploadFile('image');
            $product = Product::update($request_data);
            DB::commit();
            return new ProductResource($product);
        }
        catch(\Exception $e)
        {

            return $e;
            DB::rollBack();
            return response()->json(['status'=>'error','message'=>'oops! something went wrong']);

        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        try{
            if (file_exists('images/product/image/'.$product->image) && !empty($product->image)) {
                unlink('images/product/image/'.$product->image);
            }
            $product->delete();
        }
        catch(\Exception $e)
        {
            // return $e;
            DB::rollBack();
            return response()->json(['status' => 'error' , 'message' => 'Something Went Wrong !']);

        }
    }

}
