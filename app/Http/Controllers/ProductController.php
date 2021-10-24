<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products=Product::all();
        if($products->all()){
            return response()->json([
                'success'=>true,
                'data'=>$products
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'chưa có sp nào trong db'
            ]);
        }
       
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $products=Product::create($request->all());
        return response()->json([
            'success'=>true,
            'data'=>$products
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $product=Product::find($id);
        if($product){
            return response()->json([
                'success'=>true,
                'data'=>$product
            ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'sp chưa tồn tại'
            ]); 
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product=Product::find($id);
        if($product){
           $product->fill($request->all());
           $product->save();
           return response()->json([
            'success'=>true,
            'data'=>$product
        ]);
        }else{
            return response()->json([
                'success'=>false,
                'message'=>'sp ko tồn tại'
            ]); 
        }
    }
   
    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::find($id);
        if($product){
            $product->delete();
            return response()->json([
             'success'=>true,
             'data'=>$product
         ]);
         }else{
             return response()->json([
                 'success'=>false,
                 'message'=>'sp ko tồn tại'
             ]); 
         }
       
    }
}
