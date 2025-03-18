<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Admin_details;
use Illuminate\Http\Request;
use App\Models\Religion;
use Auth;

class ReligionController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:religion.list'])->only(['list']);
        $this->middleware(['permission:religion.create'])->only(['create','store']);
        $this->middleware(['permission:religion.edit'])->only(['edit','update']);
        $this->middleware(['permission:religion.delete'])->only(['delete']);
    }
    public function list(){
        $data['religion'] = Religion::orderBy('id','desc')->get();
        $data['active'] = count(Religion::where('status','1')->get());
        $data['inactive'] = count(Religion::where('status','!=','1')->get());
        return view('dashboard.setting.religion.religion_list')->with($data);
    }


    public function create(){

        return view('dashboard.setting.religion.create_religion');
    }

    public function store(Request $request){
        $request->validate([
            'religion_name' => 'required|max:100|nullable',
        ]);
        $religion = new Religion();
        $religion->religion_name = $request->religion_name;
        $religion->added_by = Auth::user()->id;
        $religion->updated_by = Auth::user()->id;
        $religion->status = ( $request->status !='' ? '1':'0');
        $religion->save();

        if ($religion) {
            return redirect()->route('setting.religion_list')->with('success', 'religion added Successfully');
        } else {
            return redirect()->back()->with('error', 'religion added Failed');
        }
    }

    public function edit($id){
        $religion = Religion::find($id);
        return view('dashboard.setting.religion.create_religion',compact('religion'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'religion_name' => 'required|max:100|nullable',
        ]);
        $religion = Religion::find($id);
        $religion->religion_name = $request->religion_name;
        $religion->updated_by = Auth::user()->id;
        $religion->status = ( $request->status !='' ? '1':'0');
        $religion->update();

        if ($religion) {
            return redirect()->route('setting.religion_list')->with('success', 'religion updated Successfully');
        } else {
            return redirect()->back()->with('error', 'religion updated Failed');
        }

    }

    public function delete($id){
        $count = Admin_details::where('religion', $id)->get()->count();
        if ($count == 0) {
            $religion = Religion::find($id)->delete();
            if ($religion) {
                return redirect()->route('setting.religion_list')->with('success', 'Religion updated Successfully');
            }else{
                return redirect()->back()->with('error', 'Religion updated Failed');
            }
        }
        return redirect()->back()->with('error', 'Religion Already Use in Another Module');
    }
}

