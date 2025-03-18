<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Purchase extends Model
{
    use HasFactory;

    public function purchase_detailsf(){
        return $this->hasMany(PurchaseDetails::class, 'purchase_id', 'id');
    }

    public function supplierf(){
        return $this->belongsTo(Supplier::class, 'supplier', 'id');
    }

    public function storef(){
        return $this->belongsTo(Store::class, 'store', 'id');
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
