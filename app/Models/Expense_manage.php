<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expense_manage extends Model
{
    use HasFactory;
    protected $table = 'expense_manages';
    protected $fillable = [
        'expense_date',
        'store_id',
        'expense_type',
        'cost',
        'description',
        'status',
        'added_by',
        'updated_by',
    ];

    public function store(){
        return $this->belongsTo(Store::class, 'store_id', 'id');
    }
    public function expense_type_data(){
        return $this->belongsTo(Expense_type::class, 'expense_type', 'id');
    }
    public function created_employee(){
        return $this->belongsTo(Admin::class, 'added_by', 'id');
    }
    public function updated_employee(){
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }
}
