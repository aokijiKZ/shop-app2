<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'amount',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'orderID');
    }

    public function productDetail(){
        return $this->belongsTo(ProductDetail::class, 'productDetailID');
    }

}
