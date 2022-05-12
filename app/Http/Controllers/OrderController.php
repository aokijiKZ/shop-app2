<?php

namespace App\Http\Controllers;

use App\Http\Resources\CheckBillResource;
use App\Http\Resources\OrderItemResource;
use App\Http\Resources\OrderResource;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    public function index()
    {
        return response()->json(['Order Table', OrderResource::collection(Order::all())]);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'address'  =>  'required|string|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }


        $order = new Order();
        $order->address = $request->address;
        $order->save();

        return response()->json(['Order created successfully!', new OrderResource($order)]);
    }

    public function updateAddress(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orderID'  =>  'required|not_in:0',
            'address'  =>  'required|string|max:200',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $findOrder = Order::find($request->orderID);
        if ($findOrder) {

            $order = $findOrder;
            $order->address = $request->address;
            $order->save();

            return response()->json(['Address order updated successfully!', new OrderResource($order)]);
        } else {
            return response()->json(['This order not found!']);
        }
    }

    public function addProductToOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productDetailID'  =>  'required|not_in:0|exists:product_details,id',
            'orderID'  =>  'required|not_in:0',
            'amount' => 'required|not_in:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $findOrder = Order::find($request->orderID);

        if ($findOrder) {
            if ($findOrder->statusID == 1) {

                $checkProduct = OrderItem::where([['orderID', $request->orderID], ['productDetailID', $request->productDetailID]])->first();

                if ($checkProduct) {
                    $checkProduct->amount = $checkProduct->amount + $request->amount;
                    $checkProduct->order->update([
                        'price' =>  $checkProduct->order->price + ($checkProduct->productDetail->price * $request->amount)
                    ]);

                    $checkProduct->save();
                    return response()->json(['Product added successfully!', new OrderItemResource($checkProduct)]);
                } else {
                    $orderItem = new OrderItem();
                    $orderItem->productDetailID = $request->productDetailID;
                    $orderItem->orderID = $request->orderID;

                    $orderItem->amount = $request->amount;
                    $orderItem->order->update([
                        'price' =>  $orderItem->productDetail->price * $request->amount
                    ]);

                    $orderItem->save();
                    return response()->json(['Product added successfully!', new OrderItemResource($orderItem)]);
                }
            } else {
                return response()->json(['This Order is closed!']);
            }
        } else {
            return response()->json(['This order not found!']);
        }
    }

    public function removeProductToOrder(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'productDetailID'  =>  'required|not_in:0|exists:product_details,id',
            'orderID'  =>  'required|not_in:0',
            'amount' => 'required|not_in:0'
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $findOrder = Order::find($request->orderID);

        if ($findOrder) {
            if ($findOrder->statusID == 1) {

                $checkProduct = OrderItem::where([['orderID', $request->orderID], ['productDetailID', $request->productDetailID]])->first();

                if ($checkProduct) {

                    if ($request->amount > $checkProduct->amount) {
                        return response()->json(['The amount of this product is not enough.']);
                    }

                    $checkProduct->amount = $checkProduct->amount - $request->amount;
                    $checkProduct->order->update([
                        'price' =>  $checkProduct->order->price - ($checkProduct->productDetail->price * $request->amount)
                    ]);

                    if ($checkProduct->amount == 0) {
                        $checkProduct->delete();
                    } else {
                        $checkProduct->save();
                    }

                    return response()->json(['Item deleted successfully!', new OrderItemResource($checkProduct)]);
                } else {
                    return response()->json(['This item not found']);
                }
            } else {
                return response()->json(['This order is closed!']);
            }
        } else {
            return response()->json(['This order not found!']);
        }
    }

    public function delete($id)
    {
        $dataOrder = Order::find($id);
        if ($dataOrder) {
            if ($dataOrder->statusID == 3) {
                return response()->json(['Order cant delete!']);
            }

            $dataOIT = OrderItem::where('orderID', $id);
            $dataOIT->delete();
            $dataOrder->delete();

            return response()->json(['Order deleted successfully!']);
        } else {
            return response()->json(['This order not found!']);
        }
    }

    public function checkBill(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'orderID' => 'required|not_in:0|exists:orders,id',
            'money' => 'required|numeric',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors());
        }

        $order = Order::find($request->orderID);
        

        if ($order) {

            if($request->money < $order->price){
                return response()->json(['Not enough money!']);
            }

            if ($order->statusID == 1) {
                $order->statusID = 3;
                $order->save();
            }else{
                return response()->json(['This order is closed!']);
            }

            $change = $request->money - $order->price;
            return response()->json(['This order has been billed.', new CheckBillResource($order), ['Change' => $change]]);
        
        } else {
            return response()->json(['This order not found!']);
        }
    }
}
