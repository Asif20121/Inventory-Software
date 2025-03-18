<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use App\Models\Unit;
use Auth;
class UnitController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:unit.list'])->only(['list']);
        $this->middleware(['permission:unit.create'])->only(['create','store']);
        $this->middleware(['permission:unit.edit'])->only(['edit','update']);
        $this->middleware(['permission:unit.delete'])->only(['delete']);
    }
    public function list(){
        $data['unit'] = Unit::orderBy('id','desc')->get();
        $data['active'] = count(Unit::where('status','1')->get());
        $data['inactive'] = count(Unit::where('status','!=','1')->get());

        return view('dashboard.setting.unit.unit_list')->with($data);
    }


    public function create(){

        return view('dashboard.setting.unit.create_unit');
    }

    public function store(Request $request){
        $request->validate([
            'unit_name' => 'required|max:100|nullable',
        ]);
        $unit = new Unit();
        $unit->unit_name = $request->unit_name;
        $unit->added_by = Auth::user()->id;
        $unit->updated_by = Auth::user()->id;
        $unit->status = ( $request->status !='' ? '1':'0');
        $unit->save();

        if ($unit) {
            return redirect()->route('invoice_setting.unit_list')->with('success', 'Unit added Successfully');
        } else {
            return redirect()->back()->with('error', 'Unit added Failed');
        }
    }

    public function edit($id){
        $unit = Unit::find($id);
        return view('dashboard.setting.unit.create_unit',compact('unit'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'unit_name' => 'required|max:100|nullable',
        ]);
        $unit = Unit::find($id);
        $unit->unit_name = $request->unit_name;
        $unit->updated_by = Auth::user()->id;
        $unit->status = ( $request->status !='' ? '1':'0');
        $unit->update();

        if ($unit) {
            return redirect()->route('invoice_setting.unit_list')->with('success', 'Unit updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Unit updated Failed');
        }

    }

    public function delete($id){
          $count = Product::where('unit_id', $id)->get()->count();
        if ($count == 0) {
            $unit = Unit::find($id)->delete();
            if ($unit) {
                return redirect()->route('invoice_setting.unit_list')->with('success', 'Unit Deleted Successfully');
            }else{
                return redirect()->back()->with('error', 'Unit Deleted Failed');
            }
        }
        return redirect()->back()->with('error', 'Unit Already Use in Another Module');

    }
}
