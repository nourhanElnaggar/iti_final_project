<?php

namespace App\Http\Controllers\API;

use Illuminate\Support\Facades\Facade;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\MultiImage;
use Illuminate\Support\Facades\Validator;

class ProductController extends Controller
{
    public function index()
    {
        $product = Product::all();

        return response()->json([
            'status' => 200,
            'products' => $product,
        ]);
    }
    public function StoreProduct(Request $request)
    {
        $validator = $request->validate([
            'brand'=>'required',
            'category_id'=>'required',
            'sub_category_id'=>'required',
            'name'=>'required|max:191',
            'description'=>'required|max:191',
            'product_qty'=>'required|max:20',
            'tags'=>'required|max:20',
            'product_size'=>'required|max:191',
            'color'=>'required|max:191',
            'selling_price'=>'required|max:20',
            'discount_price'=>'required|max:20',
            'short_desc'=>'required|max:191',
            'status'=>'required',
            'avgRate'=>'required',
            'image'=>'required|max:2048|image|mimes:png,jpg,jpeg',

        ]);
        if($image = $request->image){
            $destinationPath = 'uploads/product';
            $newImage= time() . "." . $image->getClientOriginalExtension();
            $image->move($destinationPath, $newImage);
            $validator['image'] = $newImage;
        }
        $op = Product::create($validator);
        if ($op) {
            return response()->json([
                'status' => 200,
                'message' => 'Product added succesfully',
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'errors' => $validator->messages()
            ]);

    }

    }
    public function MultiImageUpdate(Request $request)
    {

    }
    public function ShowProduct($id)
    {
        $product = Product::find($id);

        if($product){
            return response()->json([
                'status'=>200,
                '$product'=>$product ]);
        }
        else {
            return response()->json([
                'status'=>404,
                'message'=>'No product id found' ]);
        }
    }
    public function EditProduct($id)
    {

        $product = Product::find($id);

        if($product){
            return response()->json([
                'status'=>200,
                '$product'=>$product ]);
        }
        else {
            return response()->json([
                'status'=>404,
                'message'=>'No product id found' ]);
        }

    }
    public function UpdateProduct(Request $request, $id)
    {
        $validator = $request->validate([
            'brand'=>'required',
            'category_id'=>'required',
            'sub_category_id'=>'required',
            'name'=>'required|max:191',
            'description'=>'required|max:191',
            'product_qty'=>'required|max:20',
            'tags'=>'required|max:20',
            'product_size'=>'required|max:191',
            'color'=>'required|max:191',
            'selling_price'=>'required|max:20',
            'discount_price'=>'required|max:20',
            'short_desc'=>'required|max:191',
            'status'=>'required',
            'avgRate'=>'required',
            'image'=>'required|max:2048|image|mimes:png,jpg,jpeg',

        ]);
        $op = Product::where('id',$request->id)->update($validator);
        if ($op){
            return response()->json([
                'status' => 200,
                'message' => 'Product updated succesfully',
            ]);
        }else{
            return response()->json([
                'status'=>422,
                'errors'=> $validator->messages()
            ]);
        }

    }
    public function DeleteProduct($id)
    {
        $product = Product::find($id);

        if($product){
            $product->delete();
            //unlink($product->image);
            return response()->json([
                'status'=>200,
                'message'=>'$product deleted succesfully']);
        } else{
            return response()->json([
                'status'=>404,
                'message'=>'$product ID not found']);
        }
    }
    // product Stock
    public function ProductStock()
    {
        $products = Product::latest()->get();
        if ($products) {
            return response()->json([
                'status' => 200,
                'message' => 'Product get succesfully',
                'products' => $products
            ]);
        } else {
            return response()->json([
                'status' => 422,
                'errors' => 'not product update found'
            ]);

        }
    }
}