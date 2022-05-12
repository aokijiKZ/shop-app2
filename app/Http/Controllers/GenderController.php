<?php

namespace App\Http\Controllers;

use App\Http\Resources\GenderResource;
use App\Models\Gender;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class GenderController extends Controller
{
    //
    public function index(){
        return response()->json(['Gender Table', GenderResource::collection(Gender::all())]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'genderName'  =>  'required|unique:genders|string|max:100',   
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

       $gender = new Gender();
       $gender->genderName = $request->genderName;
       $gender->save();

        return response()->json(['Gender created successfully!', new GenderResource($gender)]);
    }

}
