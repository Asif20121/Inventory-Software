<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    public function unit(){
        return $this->belongsTo(Unit::class, 'unit_id', 'id');
    }

    public function category(){
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function store(){
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }


    public function created_employee(){
        return $this->belongsTo(Admin::class, 'added_by', 'id');
    }
    public function updated_employee(){
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }

    public function products_details(){
        return $this->hasMany(ProductDetails::class, 'product_id', 'id');
    }
}
