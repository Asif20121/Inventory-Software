<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $table = 'stores';

    protected $fillable = [
        'store_name',
        'phone',
        'email',
        'web_url',
        'address',
        'description',
        'status',
        'added_by',
        'updated_by',
    ];
    public function supplier(){
        return $this->hasMany(Supplier::class, 'store_id', 'id');
    }

    public function created_employee(){
        return $this->belongsTo(Admin::class, 'added_by', 'id');
    }
    public function updated_employee(){
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }
}
