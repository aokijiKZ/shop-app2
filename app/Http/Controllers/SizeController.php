<?php

namespace App\Http\Controllers;

use App\Http\Resources\SizeResource;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SizeController extends Controller
{
    //
    public function index(){
        return response()->json(['Size Table', SizeResource::collection(Size::all())]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'sizeName'  =>  'required|unique:sizes|string|max:100',   
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

       $size = new SIze();
       $size->sizeName = $request->sizeName;
       $size->save();

        return response()->json(['Size created successfully!', new SizeResource($size)]);
    }
}
