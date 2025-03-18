<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplierWiseStoreDetails extends Model
{
    use HasFactory;

    protected $table = 'supplier_wise_store_details';

    protected $fillable = [
        'sws_id',
        'store_id',
    ];


    public function store(){
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
