<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseDetails extends Model
{
    use HasFactory;

    public function productf(){
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    public function created_employee()
    {
        return $this->belongsTo(Admin::class, 'added_by', 'id');
    }

    public function updated_employee()
    {
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }
}
