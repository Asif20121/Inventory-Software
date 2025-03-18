<?php

namespace App\Http\Controllers\User_Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Symfony\Contracts\Service\Attribute\Required;

class RoleInPermissionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:role.permission.list'])->only(['list']);
        $this->middleware(['permission:role.permission.create'])->only(['create']);
    }
    public function list()
    {
        $data['role'] = Role::orderBy('id','desc')->get();
        // $data['permission'] = Permission::all();

        return view('dashboard.role_permission.role _in_permission.role_in_permission_list')->with($data);
    }

    public function create()
    {
        $data['role'] = Role::where('role_type','!=','5')->get();
        // $data['permission'] = Permission::all();
        $data['permission_group'] = Admin::get_permission();
        return view('dashboard.role_permission.role _in_permission.create_role_in_permission')->with($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
        ]);

        $role_id = count(DB::table('role_has_permissions')->select('role_id')->where('role_id', $request->role_id)->get());

        if ($role_id > 0) {
            return redirect()->back()->with('error', 'Role In Permission Already Exist, You Can Only Edit This');
        } else {
            $data = [];
            $permission = $request->permission;
            if (isset($permission)) {
                foreach ($permission as $key => $item) {
                    $data['role_id'] = $request->role_id;
                    $data['permission_id'] = $item;
                    DB::table('role_has_permissions')->insert($data);
                }
            }
            if (count($data) > 0) {
                return redirect()->route('rpm.in_role_permission.list')->with('success', 'Role in Permission Successfully Added');
            } else {
                return redirect()->back()->with('error', 'Role in Permission Failed');
            }
        }
    }

    public function edit($id)
    {
         $data['role'] = Role::findOrFail($id);
        // $data['permission'] = Permission::all();
        $data['permission_group'] = Admin::get_permission();
        return view('dashboard.role_permission.role _in_permission.edit_role_in_permission')->with($data);
    }

    public function update(Request $request,$id){
        $role = Role::findOrFail($id);
        $permission =isset($request->permission) ? $request->permission : [];

        if(!empty($permission)){
            $role->syncPermissions($permission);
        }

            if (count($permission) > 0) {
                return redirect()->route('rpm.in_role_permission.list')->with('success', 'Role in Permission Successfully Updated');
            } else {
                return redirect()->back()->with('error', 'Role in Permission Updated Failed');
            }

    }
    public function delete($id)
    {
        $role = Role::findOrFail($id);

        if(!is_null($role)){
            $role->delete();
            return redirect()->route('rpm.in_role_permission.list')->with('success', 'Role in Permission Successfully Deleted');
        }else{
            return redirect()->back()->with('error', 'Role in Permission Deleted Failed');
        }
    }
}
