<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePermissionDetails extends Model
{
    use HasFactory;
    protected $table = 'store_permission_details';

    protected $fillable = [
        'sp_id',
        'store_id',
    ];


    public function store(){
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
}
