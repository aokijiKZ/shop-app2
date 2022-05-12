<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDetail extends Model
{
    use HasFactory;

    public function product(){
        return $this->belongsTo(Product::class,'productID');
    }

    // public function products(){
    //     return $this->belongsTo(Product::class,'productID');
    // }

    public function gender(){
        return $this->belongsTo(Gender::class,'genderID');
    }

    public function size(){
        return $this->belongsTo(Size::class,'sizeID');
    }


}
