<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
    ];

    public function status(){
        return $this->belongsTo(Status::class, 'statusID');
    }

    public function orderDetail(){
        return $this->hasMany(OrderItem::class, 'orderID');
    }
}
