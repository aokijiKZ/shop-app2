<?php

namespace App\Http\Controllers;

use App\Http\Resources\AdminFilterResource;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;

class AdminFilterController extends Controller
{
    //
    public function getOrderByStatus(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'statusID' => 'required|not_in:0',
            'pageLimit' => 'not_in:0|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $order = Order::where('statusID', $request->statusID);

        $page = $request->pageLimit;

        if($page){
            $orderFilter = $order->paginate($page);
        }else{
            $orderFilter = $order->get();
        } 

        if ($orderFilter->count()) {
            return response()->json(
                [
                    'data' => AdminFilterResource::collection($orderFilter)
                ]
            );
        } else {
            return response()->json(['Not found order!']);
        }
        // dd($product);
    }

    public function getOrderByDate(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'dateStart' => 'required|date',
            'dateEnd' => 'required|date|after:dateStart',
            'pageLimit' => 'not_in:0|nullable'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $start = Carbon::parse($request->dateStart);  /* format('Y-m-d') */
        $end = Carbon::parse($request->dateEnd);

        $order = Order::where('statusID',3)->whereBetween('updated_at',[$start,$end]);

        $page = $request->pageLimit;

        if($page){
            $orderFilter = $order->paginate($page);
        }else{
            $orderFilter = $order->get();
        }
        
        if ($orderFilter->count()) {
            return response()->json(
                [
                    'data' => AdminFilterResource::collection($orderFilter)
                ]
            );
        } else {
            return response()->json(['Not found order!']);
        }
    }
}
