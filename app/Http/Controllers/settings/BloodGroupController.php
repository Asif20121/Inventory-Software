<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Admin_details;
use Illuminate\Http\Request;
use App\Models\Blood_group;
use Auth;

class BloodGroupController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:bloodgroup.list'])->only(['list']);
        $this->middleware(['permission:bloodgroup.create'])->only(['create','store']);
        $this->middleware(['permission:bloodgroup.edit'])->only(['edit','update']);
        $this->middleware(['permission:bloodgroup.delete'])->only(['delete']);
    }

    public function list(){
        $data['bloodgroup'] = Blood_group::orderBy('id','desc')->get();
        $data['active'] = count(Blood_group::where('status','1')->get());
        $data['inactive'] = count(Blood_group::where('status','!=','1')->get());
        return view('dashboard.setting.bloodgroup.bloodgroup_list')->with($data);
    }


    public function create(){

        return view('dashboard.setting.bloodgroup.create_bloodgroup');
    }

    public function store(Request $request){
        $request->validate([
            'bloodgroup_name' => 'required|max:100|nullable',
        ]);
        $bloodgroup = new Blood_group();
        $bloodgroup->bloodgroup_name = $request->bloodgroup_name;
        $bloodgroup->added_by = Auth::user()->id;
        $bloodgroup->updated_by = Auth::user()->id;
        $bloodgroup->status = ( $request->status !='' ? '1':'0');
        $bloodgroup->save();

        if ($bloodgroup) {
            return redirect()->route('setting.bloodgroup_list')->with('success', 'bloodgroup added Successfully');
        } else {
            return redirect()->back()->with('error', 'bloodgroup added Failed');
        }
    }

    public function edit($id){
        $bloodgroup = Blood_group::find($id);
        return view('dashboard.setting.bloodgroup.create_bloodgroup',compact('bloodgroup'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'bloodgroup_name' => 'required|max:100|nullable',
        ]);

        $bloodgroup = Blood_group::find($id);
        $bloodgroup->bloodgroup_name = $request->bloodgroup_name;
        $bloodgroup->updated_by = Auth::user()->id;
        $bloodgroup->status = ( $request->status !='' ? '1':'0');
        $bloodgroup->update();

        if ($bloodgroup) {
            return redirect()->route('setting.bloodgroup_list')->with('success', 'bloodgroup updated Successfully');
        } else {
            return redirect()->back()->with('error', 'bloodgroup updated Failed');
        }

    }

    public function delete($id){
        $count = Admin_details::where('b_group', $id)->get()->count();
        if ($count == 0) {
            $bloodgroup = Blood_group::find($id)->delete();
            if ($bloodgroup) {
                return redirect()->route('setting.bloodgroup_list')->with('success', 'Bloodgroup updated Successfully');
            }else{
                return redirect()->back()->with('error', 'Bloodgroup updated Failed');
            }
        }
        return redirect()->back()->with('error', 'Bloodgroup Already Use in Another Module');
    }
}

