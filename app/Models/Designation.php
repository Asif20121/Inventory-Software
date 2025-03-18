<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Designation extends Model
{
    use HasFactory;
    protected $table = 'designations';
    protected $fillable = [
        'designation_name',
        'status',
        'added_by',
        'updated_by',
    ];

    public function created_employee(){
        return $this->belongsTo(Admin::class, 'added_by', 'id');
    }
    public function updated_employee(){
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }
}
