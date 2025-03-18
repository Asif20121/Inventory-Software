<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Admin_details extends Model
{
    use HasFactory;
    protected $table = 'admin_details';
    protected $fillable = [
        'admin_id',
        'card_no',
        'designation_id',
        'department_id',
        'company_id',
        'nid_id',
        'dob',
        'gender',
        'religion',
        'b_group',
        'tin',
        'address',
        'ref_by',
        'family_mn',
        'family_mp',
        'source',
        'joining_date',
        'admin_note',
        'image',
    ];

    public function designation_data()
    {
        return $this->belongsTo(Designation::class, 'designation_id', 'id');
    }
    public function department_data()
    {
        return $this->belongsTo(Department::class, 'department_id', 'id');
    }
    public function company_data()
    {
        return $this->belongsTo(Company::class, 'company_id', 'id');
    }
    public function religion_data()
    {
        return $this->belongsTo(Religion::class, 'religion', 'id');
    }
    public function blood_group_data()
    {
        return $this->belongsTo(Blood_group::class, 'b_group', 'id');
    }
}
