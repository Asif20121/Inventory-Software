<?php

namespace App\Http\Controllers\User_Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class AllPermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:permission.list'])->only(['list']);
        $this->middleware(['permission:permission.create'])->only(['create']);
    }

    public function list()
    {
        $permission = Permission::orderByDesc('id')->get();

        return view('dashboard.role_permission.permission.permission_list', compact('permission'));
    }


    public function create()
    {
        return view('dashboard.role_permission.permission.create_permission');
    }

    public function store(Request $request)
    {

        $request->validate([
            'name' => 'required',
            'group_name' => 'required',
        ]);

        $permission = Permission::create([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        if ($permission) {
            return redirect()->route('rpm.permission.list')->with('success', 'Permission Successfully Added');
        } else {
            return redirect()->back()->with('error', 'Permission Failed');
        }
    }


    public function edit($id)
    {
        $permission = Permission::findOrFail($id);

        return view('dashboard.role_permission.permission.create_permission', compact('permission'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
            'group_name' => 'required',
        ]);

        $permission = Permission::findOrFail($id)->update([
            'name' => $request->name,
            'group_name' => $request->group_name,
        ]);

        if ($permission) {
            return redirect()->route('rpm.permission.list')->with('success', 'Permission Successfully Updated');
        } else {
            return redirect()->back()->with('error', 'Permission Updated Failed');
        }
    }


    public function delete($id)
    {

        $permission = Permission::findOrFail($id)->delete();
        return redirect()->route('rpm.permission.list')->with('success', 'Permission Successfully Deleted');
    }
}
