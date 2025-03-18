<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Admin_details;
use Illuminate\Http\Request;
use App\Models\Department;
use Auth;

class DepartmentController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:department.list'])->only(['list']);
        $this->middleware(['permission:department.create'])->only(['create','store']);
        $this->middleware(['permission:department.edit'])->only(['edit','update']);
        $this->middleware(['permission:department.delete'])->only(['delete']);
    }

    public function list(){
        $data['department'] = Department::orderBy('id','desc')->get();
        $data['active'] = count(Department::where('status','1')->get());
        $data['inactive'] = count(Department::where('status','!=','1')->get());
        return view('dashboard.setting.department.department_list')->with($data);
    }


    public function create(){

        return view('dashboard.setting.department.create_department');
    }

    public function store(Request $request){
        $request->validate([
            'department_name' => 'required|max:100|nullable',
        ]);
        $department = new Department();
        $department->department_name = $request->department_name;
        $department->added_by = Auth::user()->id;
        $department->updated_by = Auth::user()->id;
        $department->status = ( $request->status !='' ? '1':'0');
        $department->save();

        if ($department) {
            return redirect()->route('setting.department_list')->with('success', 'Department added Successfully');
        } else {
            return redirect()->back()->with('error', 'Department added Failed');
        }
    }

    public function edit($id){
        $department = Department::find($id);
        return view('dashboard.setting.department.create_department',compact('department'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'department_name' => 'required|max:100|nullable',
        ]);
        $department = Department::find($id);
        $department->department_name = $request->department_name;
        $department->updated_by = Auth::user()->id;
        $department->status = ( $request->status !='' ? '1':'0');
        $department->update();

        if ($department) {
            return redirect()->route('setting.department_list')->with('success', 'Department updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Department updated Failed');
        }

    }

    public function delete($id){
        $count = Admin_details::where('department_id', $id)->get()->count();
        if ($count == 0) {
            $department = Department::find($id)->delete();
            if ($department) {
                return redirect()->route('setting.department_list')->with('success', 'Department Deleted Successfully');
            }else{
                return redirect()->back()->with('error', 'Department updated Failed');
            }
        }

        return redirect()->back()->with('error', 'Department Already Use in Another Module');
    }
}

