<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $fillable = [
        'invoice_no',
        'date',
        'store_id',
        'description',
        'status',
        'created_by',
        'updated_by',
    ];


    public function invoice_detailsf(){
        return $this->hasMany(InvoiceDetails::class, 'invoice_id', 'id');
    }
    public function paymentf(){
        return $this->belongsTo(Payment::class, 'id', 'invoice_id');
    }
    public function payment_detailsf(){
        return $this->hasMany(PaymentDetails::class, 'invoice_id', 'id');
    }
    public function storef(){
        return $this->hasOne(Store::class, 'id', 'store_id');
    }
}
