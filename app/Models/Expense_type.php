<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense_type extends Model
{
    use HasFactory;
    protected $table = 'expense_types';
    protected $fillable = [
        'type_name',
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
