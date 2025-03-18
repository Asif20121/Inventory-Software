<?php

namespace App\Http\Controllers\User_Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class AllRoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:role.list'])->only(['list']);
        $this->middleware(['permission:role.create'])->only(['create']);
    }

    public function list()
    {
        $role = Role::all();

        return view('dashboard.role_permission.role.role_list', compact('role'));
    }

    public function create()
    {
        return view('dashboard.role_permission.role.create_role');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = Role::create([
            'name' => $request->name,
        ]);

        if ($role) {
            return redirect()->route('rpm.role.list')->with('success', 'Role Successfully Added');
        } else {
            return redirect()->back()->with('error', 'Role Failed');
        }
    }

    public function edit($id)
    {
        $role = Role::findOrFail($id);

        return view('dashboard.role_permission.role.create_role', compact('role'));
    }


    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required',
        ]);

        $role = Role::findOrFail($id)->update([
            'name' => $request->name,
        ]);

        if ($role) {
            return redirect()->route('rpm.role.list')->with('success', 'Role Successfully Updated');
        } else {
            return redirect()->back()->with('error', 'Role Updated Failed');
        }
    }


    public function delete($id)
    {
        $role = Role::findOrFail($id)->delete();
        return redirect()->route('rpm.role.list')->with('success', 'Role Successfully Deleted');
    }
}
