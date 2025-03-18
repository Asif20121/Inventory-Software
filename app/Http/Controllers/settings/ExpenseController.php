<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Expense_manage;
use Illuminate\Http\Request;
use App\Models\Expense_type;
use Auth;

class ExpenseController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:expense_type.list'])->only(['list']);
        $this->middleware(['permission:expense_type.create'])->only(['create','store']);
        $this->middleware(['permission:expense_type.edit'])->only(['edit','update']);
        $this->middleware(['permission:expense_type.delete'])->only(['delete']);
    }

    public function list(){
        $data['expense'] = Expense_type::orderBy('id','desc')->get();
        $data['active'] = count(Expense_type::where('status','1')->get());
        $data['inactive'] = count(Expense_type::where('status','!=','1')->get());
        return view('dashboard.setting.expense.expense_list')->with($data);
    }


    public function create(){

        return view('dashboard.setting.expense.create_expense');
    }

    public function store(Request $request){
        $request->validate([
            'type_name' => 'required|max:100',
        ]);
        $expense = new Expense_type();
        $expense->type_name = $request->type_name;
        $expense->added_by = Auth::user()->id;
        $expense->updated_by = Auth::user()->id;
        $expense->status = ( $request->status !='' ? '1':'0');
        $expense->save();

        if ($expense) {
            return redirect()->route('invoice_setting.expense_list')->with('success', 'Expense Type added Successfully');
        } else {
            return redirect()->back()->with('error', 'Expense Type added Failed');
        }
    }

    public function edit($id){
        $expense = Expense_type::find($id);
        return view('dashboard.setting.expense.create_expense',compact('expense'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'type_name' => 'required|max:100',
        ]);
        $expense = Expense_type::find($id);
        $expense->type_name = $request->type_name;
        $expense->updated_by = Auth::user()->id;
        $expense->status = ( $request->status !='' ? '1':'0');
        $expense->update();

        if ($expense) {
            return redirect()->route('invoice_setting.expense_list')->with('success', 'Expense Type updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Expense Type updated Failed');
        }

    }

    public function delete($id){
        $count =Expense_manage::where("expense_type",$id)->get()->count();
        if ($count == 0) {
            $expense = Expense_type::find($id)->delete();
            if ($expense) {
                return redirect()->route('invoice_setting.expense_list')->with('success', 'Expense Type Deleted Successfully');
            }else{
                return redirect()->back()->with('error', 'Expense Type Deleted Failed');
            }
        }
        return redirect()->back()->with('error', 'Expense Type Already Use in Another Module');
    }
}

