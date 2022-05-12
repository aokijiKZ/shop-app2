<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gender extends Model
{
    use HasFactory;

    public function productDetail(){
        return $this->hasMany(ProductDetail::class, 'genderID');
    }
}
