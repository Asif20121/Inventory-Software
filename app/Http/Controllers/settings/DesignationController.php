<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Admin_details;
use App\Models\Designation;
use Auth;
use Illuminate\Http\Request;

class DesignationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:designation.list'])->only(['list']);
        $this->middleware(['permission:designation.create'])->only(['create','store']);
        $this->middleware(['permission:designation.edit'])->only(['edit','update']);
        $this->middleware(['permission:designation.delete'])->only(['delete']);
    }

    function list() {
        $data['designation'] = Designation::orderBy('id', 'desc')->get();
        $data['active'] = count(Designation::where('status', '1')->get());
        $data['inactive'] = count(Designation::where('status', '!=', '1')->get());

        return view('dashboard.setting.designation.designation_list')->with($data);
    }

    public function create()
    {

        return view('dashboard.setting.designation.create_designation');
    }

    public function store(Request $request)
    {
        $request->validate([
            'designation_name' => 'required|max:100|nullable',
        ]);
        $designation = new Designation();
        $designation->designation_name = $request->designation_name;
        $designation->added_by = Auth::user()->id;
        $designation->updated_by = Auth::user()->id;
        $designation->status = ($request->status != '' ? '1' : '0');
        $designation->save();

        if ($designation) {
            return redirect()->route('setting.designation_list')->with('success', 'Designation added Successfully');
        } else {
            return redirect()->back()->with('error', 'Designation added Failed');
        }
    }

    public function edit($id)
    {
        $designation = Designation::find($id);
        return view('dashboard.setting.designation.create_designation', compact('designation'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'designation_name' => 'required|max:100|nullable',
        ]);
        $designation = Designation::find($id);
        $designation->designation_name = $request->designation_name;
        $designation->updated_by = Auth::user()->id;
        $designation->status = ($request->status != '' ? '1' : '0');
        $designation->update();

        if ($designation) {
            return redirect()->route('setting.designation_list')->with('success', 'Designation updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Designation updated Failed');
        }

    }

    public function delete($id)
    {

        $count = Admin_details::where('designation_id', $id)->get()->count();
        if ($count == 0) {
            $designation = Designation::find($id)->delete();
            if ($designation) {
                return redirect()->route('setting.designation_list')->with('success', 'Designation Deleted Successfully');
            }else{
                return redirect()->back()->with('error', 'Designation updated Failed');
            }
        }

        return redirect()->back()->with('error', 'Designation Already Use in Another Module');

    }
}
