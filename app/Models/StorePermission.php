<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class StorePermission extends Model
{
    use HasFactory;

    public function employee(){
        return $this->belongsTo(Admin::class, 'emp_id', 'id');
    }

 public static function auth_store_permission($auth_id){
   return DB::table('store_permissions as sp')->select('s.id')->leftJoin('store_permission_details as spd', 'spd.sp_id', '=', 'sp.id')->leftJoin('stores as s', 'spd.store_id', '=', 's.id')->where('sp.emp_id', $auth_id)->where('sp.status', '1');
 }

    public function sp_details(){
        return $this->hasMany(StorePermissionDetails::class, 'sp_id', 'id');
    }

    public function created_employee(){
        return $this->belongsTo(Admin::class, 'added_by', 'id');
    }
    public function updated_employee(){
        return $this->belongsTo(Admin::class, 'updated_by', 'id');
    }
}
