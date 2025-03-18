<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Admin_details;
use Illuminate\Http\Request;
use App\Models\Company;
use Auth;

class CompanyController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:company.list'])->only(['list']);
        $this->middleware(['permission:company.create'])->only(['create','store']);
        $this->middleware(['permission:company.edit'])->only(['edit','update']);
        $this->middleware(['permission:company.delete'])->only(['delete']);
    }
    public function list(){
        $data['company'] = Company::orderBy('id','desc')->get();
        $data['active'] = count(Company::where('status','1')->get());
        $data['inactive'] = count(Company::where('status','!=','1')->get());
        return view('dashboard.setting.company.company_list')->with($data);
    }


    public function create(){

        return view('dashboard.setting.company.create_company');
    }

    public function store(Request $request){
        $request->validate([
            'company_name' => 'required|max:100|nullable',
        ]);
        $company = new Company();
        $company->company_name = $request->company_name;
        $company->added_by = Auth::user()->id;
        $company->updated_by = Auth::user()->id;
        $company->status = ( $request->status !='' ? '1':'0');
        $company->save();

        if ($company) {
            return redirect()->route('setting.company_list')->with('success', 'company added Successfully');
        } else {
            return redirect()->back()->with('error', 'company added Failed');
        }
    }

    public function edit($id){
        $company = Company::find($id);
        return view('dashboard.setting.company.create_company',compact('company'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'company_name' => 'required|max:100|nullable',
        ]);
        $company = Company::find($id);
        $company->company_name = $request->company_name;
        $company->updated_by = Auth::user()->id;
        $company->status = ( $request->status !='' ? '1':'0');
        $company->update();

        if ($company) {
            return redirect()->route('setting.company_list')->with('success', 'company updated Successfully');
        } else {
            return redirect()->back()->with('error', 'company updated Failed');
        }

    }

    public function delete($id){

        $count = Admin_details::where('company_id', $id)->get()->count();
        if ($count == 0) {
            $company = Company::find($id)->delete();
            if ($company) {
                return redirect()->route('setting.company_list')->with('success', 'Company updated Successfully');
            }else{
                return redirect()->back()->with('error', 'Company updated Failed');
            }
        }
        return redirect()->back()->with('error', 'Company Already Use in Another Module');
    }
}

