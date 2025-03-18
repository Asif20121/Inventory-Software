<?php

namespace App\Models;

use Database\Seeders\AdminSeeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $guard = "admin";
    protected $table = 'admins';
    protected $fillable = [
        'name',
        'phone',
        'email',
        'password',
        'status',
        'role',
        'admin_type',
    ];


    public function admin_detail_data()
    {
        return $this->belongsTo(Admin_details::class, 'id', 'admin_id');
    }

    public static function get_permission(){
        $permission_group = DB::table('permissions')->select('group_name')->groupBy('group_name')->get();

        return $permission_group;
    }
    public static function getPermissionByGroupName($group_name){
        $permission = DB::table('permissions')->select('name','id')->where('group_name',$group_name)->get();

        return $permission;
    }

    public function rolHasPermissions($role,$permissions){

        $hasPermission = true;

        foreach($permissions as $permission){
            if(!$role->hasPermissionTo($permission->name)){
                $hasPermission = false;
                return $hasPermission;
            }
            return $hasPermission;
        }
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
}
