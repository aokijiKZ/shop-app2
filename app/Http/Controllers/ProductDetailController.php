<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductDetailResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use App\Models\ProductDetail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductDetailController extends Controller
{
    //

    public function index(){
        return response()->json(['ProductDetail Table', ProductDetailResource::collection(ProductDetail::all())]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'productID' => 'required|not_in:0|exists:products,id',
            'genderID' => 'required|not_in:0',
            'sizeID' => 'required|not_in:0',
            'price' => 'required|numeric',
        ]);
        
        if($validator->fails()){
            return response()->json([
                'status' => false,
                'message' => $validator->errors()
            ]);
        }

        $productDetail = new ProductDetail();
        $productDetail->productID = $request->productID;
        $productDetail->genderID = $request->genderID;
        $productDetail->sizeID = $request->sizeID;
        $productDetail->price = $request->price;
        $productDetail->save();

        return response()->json(['Product created successfully!', new ProductDetailResource($productDetail)]);
    }

    public function getProductByID($id){

        $data = ProductDetail::where('productID', $id)->get();
        
        if($data){
            return response()->json(['Pass', ProductDetailResource::collection($data)]);
            
        }else{
            return response()->json('Not found Product!');
        }
    }


}
