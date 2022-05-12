<?php

namespace App\Http\Controllers;

use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    //
    public function index(){
        return response()->json(['Category Table', CategoryResource::collection(Category::all())]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'categoryName'  =>  'required|unique:categories|string|max:100',   
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

       $category = new Category();
       $category->categoryName = $request->categoryName;
       $category->save();

        return response()->json(['Category created successfully!', new CategoryResource($category)]);
    }
}
