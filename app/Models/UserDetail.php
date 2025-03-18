<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserDetail extends Model
{
    use HasFactory;
    protected $table = 'user_details';
    protected $fillable = [
        'user_id',
        'image',
        'client_category',
        'client_code',
        'client_type',
        'company_name',
        'designation',
        'trede_license',
        'dob',
        'opening_balance',
        'family_member',
        'ref_by',
        'marketing_source',
        'Joining_date',
        'address',
        'gender',
        'add_by',
        'updated_by',
    ];
}
