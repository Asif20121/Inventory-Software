<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceDetails extends Model
{
    use HasFactory;

    protected $table = 'invoice_details';
    protected $fillable = [
        'date',
        'invoice_id',
        'product_name',
        'qty',
        'unit_price',
        'unit_discount',
        'unit_price_wd',
        'selling_price_wod',
        'selling_price_wd',
        'status',
    ];
}
