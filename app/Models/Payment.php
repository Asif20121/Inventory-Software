<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $table = 'payments';
    protected $fillable = [
        'invoice_id',
        'customer_id',
        'total_amount',
        'paid_amount',
        'discount_amount',
        'due_amount',
        'paid_status',
    ];

    public function customerf(){
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
