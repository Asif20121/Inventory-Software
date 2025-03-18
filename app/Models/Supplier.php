<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    use HasFactory;
    protected $table = 'suppliers';

    protected $fillable = [
        'supplier_name',
        'email',
        'phone',
        'store_id',
        'address',
        'description',
        'status',
        'added_by',
        'updated_by',
    ];

    public function store(){
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    
    public function created_employee(){
        return $this->belongsTo(Admin::class, 'added_by', 'id');
    }
    public function updated_employee(){
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }
}
