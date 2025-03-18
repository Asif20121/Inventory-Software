<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Purchase;
use App\Models\Supplier;
use App\Models\Store;
use App\Models\SupplierWiseStore;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SupplierController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:supplier.list'])->only(['list']);
        $this->middleware(['permission:supplier.create'])->only(['create','store']);
        $this->middleware(['permission:supplier.edit'])->only(['edit','update']);
        $this->middleware(['permission:supplier.delete'])->only(['delete']);
    }


    public function list(){

        $data['supplier'] = Supplier::with('store')->orderBy('id','desc')->get();
        $data['active'] = count(Supplier::where('status','1')->get());
        $data['inactive'] = count(Supplier::where('status','!=','1')->get());

        return view('dashboard.setting.supplier.supplier_list')->with($data);
    }

    public function create()
    {
        return view('dashboard.setting.supplier.create_supplier');
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier_name' => 'required|max:100|nullable',
            'email' => 'email|max:100|nullable',
            'phone' => 'required|max:20',
            'address' => 'max:250|nullable',
            'description' => 'max:1000|nullable',
        ]);
        $supplier = new Supplier();
        $supplier->supplier_name = $request->supplier_name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->description = $request->description;

        $supplier->added_by = Auth::user()->id;
        $supplier->updated_by = Auth::user()->id;
        $supplier->status = ($request->status != '' ? '1' : '0');
        $supplier->save();

        if ($supplier) {
            return redirect()->route('invoice_setting.supplier_list')->with('success', 'supplier added Successfully');
        } else {
            return redirect()->back()->with('error', 'supplier added Failed');
        }
    }

    public function edit($id)
    {
        $supplier = Supplier::find($id);
        return view('dashboard.setting.supplier.create_supplier', compact('supplier'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'supplier_name' => 'required|max:100|nullable',
            'email' => 'email|max:100|nullable',
            'phone' => 'required|max:20',
            'address' => 'max:250|nullable',
            'description' => 'max:1000|nullable',
        ]);

        $supplier = Supplier::find($id);
        $supplier->supplier_name = $request->supplier_name;
        $supplier->email = $request->email;
        $supplier->phone = $request->phone;
        $supplier->address = $request->address;
        $supplier->description = $request->description;

        $supplier->updated_by = Auth::user()->id;
        $supplier->status = ($request->status != '' ? '1' : '0');
        $supplier->update();

        if ($supplier) {
            return redirect()->route('invoice_setting.supplier_list')->with('success', 'supplier updated Successfully');
        } else {
            return redirect()->back()->with('error', 'supplier updated Failed');
        }

    }

    public function delete($id)
    {

          $count = SupplierWiseStore::where('supplier_id', $id)->get()->count();
        $count2 = Purchase::where('supplier', $id)->get()->count();
        if ($count==0 && $count2==0) {
            $supplier = Supplier::find($id)->delete();
            if ($supplier) {
                return redirect()->route('invoice_setting.supplier_list')->with('success', 'Supplier Deleted Successfully');
            }else{
                return redirect()->back()->with('error', 'Supplier Deleted Failed');
            }
        }
        return redirect()->back()->with('error', 'Supplier Already Use in Another Module');
    }
}
