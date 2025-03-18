<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentDetails extends Model
{
    use HasFactory;

    protected $table = 'payment_details';
    protected $fillable = [
        'invoice_id',
        'date',
        'current_paid_amount',
        'refound',
        'payment_method',
        'updated_by',
    ];


    public function invoicef(){
        return $this->hasOne(Invoice::class, 'id', 'invoice_id');
    }

    public function payment_methodf(){
        return $this->hasOne(PaymentType::class, 'id', 'payment_method');
    }

    public function received_byf(){
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }
}
