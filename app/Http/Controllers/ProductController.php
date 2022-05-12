<?php

namespace App\Http\Controllers;

use App\Http\Resources\ProductFilterResource;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function index()
    {
        return response()->json(['Product Table', ProductResource::collection(Product::all())]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'categoryID'  =>  'required|not_in:0',
            'productName'  =>  'required|unique:products|string|max:100',
            'productDesc'  =>  'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $product = new Product();
        $product->categoryID = $request->categoryID;
        $product->productName = $request->productName;
        $product->productDesc = $request->productDesc;
        $product->save();

        return response()->json(['Product created successfully!', new ProductResource($product)]);
    }

    public function filterProduct(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'genderName' => 'string|max:255|nullable',
            'categoryName' => 'string|max:255|nullable',
            'sizeName' => 'string|max:255|nullable',
            'pageLimit' => 'not_in:0|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $product = DB::table('product_details')
            ->join('products', 'product_details.productID', '=', 'products.id')
            ->join('genders', 'product_details.genderID', '=', 'genders.id')
            ->join('sizes', 'product_details.sizeID', '=', 'sizes.id')
            ->join('categories', 'products.categoryID', '=', 'categories.id')
            ->select('products.*', 'product_details.*', 'genders.*', 'categories.*', 'sizes.*');

        if ($request->genderName) {
            $product->where('genders.genderName', $request->genderName);
        }

        if ($request->categoryName) {
            $product->where('categories.categoryName', $request->categoryName);
        }

        if ($request->sizeName) {
            $product->where('sizes.sizeName', $request->sizeName);
        }

        // $productFilter = $product->get();

        $page = $request->pageLimit;
        if($page){
            $productFilter = $product->paginate($page);
        }else{
            $productFilter = $product->get();
        } 

        if($productFilter->count()){
            return response()->json(['Data', ProductFilterResource::collection($productFilter)]);
        }else{
            return response()->json('Not found product.');
        }


        // return response()->json(['Pass!', $productFilter]);


    }
}
