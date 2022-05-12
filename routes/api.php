<?php

use App\Http\Controllers\AdminFillterController;
use App\Http\Controllers\AdminFilterController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\GenderController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProductDetailController;
use App\Http\Controllers\SizeController;
use App\Http\Controllers\StatusController;
use App\Http\Resources\ProductResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
Route::get('category/', [CategoryController::class, 'index']);
Route::post('category/create', [CategoryController::class, 'create']);

Route::get('gender/', [GenderController::class, 'index']);
Route::post('gender/create', [GenderController::class, 'create']);

Route::get('size/', [SizeController::class, 'index']);
Route::post('size/create', [sizeController::class, 'create']);

Route::get('product/', [ProductController::class, 'index']);
Route::post('product/create', [ProductController::class, 'create']);

Route::get('productDetail/', [ProductDetailController::class, 'index']);
Route::get('productDetail/{id}', [ProductDetailController::class, 'getProductByID']);
Route::post('/productDetail/create',[ProductDetailController::class,'create']);

Route::post('filterProduct/', [ProductController::class, 'filterProduct']);

Route::get('order/', [OrderController::class, 'index']);
Route::post('order/create', [OrderController::class, 'create']);
Route::post('order/update', [OrderController::class, 'updateAddress']);
Route::post('order/addProductToOrder', [OrderController::class, 'addProductToOrder']);
Route::post('order/removeProductToOrder', [OrderController::class, 'removeProductToOrder']);
Route::delete('order/delete/{id}', [OrderController::class, 'delete']);
Route::post('order/checkBill', [OrderController::class, 'checkBill']);

Route::get('status/', [StatusController::class, 'index']);
Route::post('status/create', [StatusController::class, 'create']);

Route::post('admin/paidOrder', [AdminFilterController::class, 'getOrderByDate']);
Route::post('admin/statusOrder', [AdminFilterController::class, 'getOrderByStatus']);

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});
