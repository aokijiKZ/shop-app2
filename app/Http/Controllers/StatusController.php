<?php

namespace App\Http\Controllers;

use App\Http\Resources\StatusResource;
use App\Models\Status;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class StatusController extends Controller
{
    public function index(){
        return response()->json(['Status Table', StatusResource::collection(Status::all())]);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(),[
            'statusName'  =>  'required|unique:statuses|string|max:100',   
        ]);

        if($validator->fails()){
            return response()->json($validator->errors());
        }

       $status = new Status();
       $status->statusName = $request->statusName;
       $status->save();

        return response()->json(['Status created successfully!', new StatusResource($status)]);
    }
}
