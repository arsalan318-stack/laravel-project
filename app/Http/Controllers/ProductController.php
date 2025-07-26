<?php

namespace App\Http\Controllers;
use App\Product;

use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function manage_product(){
        $products = Product::orderBy('id','desc')->get();
        return view('Admin.product.manage_product',compact('products'));
    }

    public function update_status(Request $request)
{
    $request->validate([
        'id' => 'required|exists:products,id',
        'status' => 'required|string',
    ]);

    $product = Product::find($request->id);
    $product->status = $request->status;
    $product->save();

    return response()->json(['message' => 'Status updated']);
}

public function product_delete($id)
{
    try{
    $products = Product::findOrFail($id);
    $products->delete();
    return redirect()->route('manage_product')->with('success', 'Product deleted successfully!');
    }
    catch(\Exception $e){

        return redirect()->route('manage_product')->with('error', 'Failed to delete Product.');
    }

}
}