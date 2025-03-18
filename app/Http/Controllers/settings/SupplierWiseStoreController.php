<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Store;
use App\Models\Supplier;
use App\Models\SupplierWiseStore;
use App\Models\SupplierWiseStoreDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SupplierWiseStoreController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:supplier_wise_store.list'])->only(['list']);
        $this->middleware(['permission:supplier_wise_store.create'])->only(['create','store']);
        $this->middleware(['permission:supplier_wise_store.edit'])->only(['edit','update']);
        $this->middleware(['permission:supplier_wise_store.delete'])->only(['delete']);
    }


    function list() {
        $data['active'] = count(SupplierWiseStore::where('status', '1')->get());
        $data['inactive'] = count(SupplierWiseStore::where('status', '!=', '1')->get());

        $data["supplier_wise_store"] = SupplierWiseStore::with(['sws_details.store' => function ($q) { $q->where('status', '1'); }])->orderBy('id', 'desc')->get();
        return view('dashboard.setting.supplier_wise_store.supplier_wise_store_list')->with($data);
    }
    public function create()
    {
        $data['store'] = Store::orderBy('id', 'desc')->where('status', '1')->get();
        $data['suppliers'] = Supplier::orderBy('id', 'desc')->where('status', '1')->get();

        return view('dashboard.setting.supplier_wise_store.create_supplier_wise_store')->with($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'supplier' => 'required',
            'store' => 'required',
        ]);

        if (SupplierWiseStore::where('supplier_id', $request->supplier)->count() > 0) {
            return redirect()->back()->with('error', 'This Supplier Already has Permission');
        }

        $count = count(SupplierWiseStore::all());
        if ($count == null) {
            $firstReg = '0';
            $rm_code = $firstReg + 1;
        } else {
            $product_id = SupplierWiseStore::orderBy('id', 'desc')->first()->id;
            $rm_code = $product_id + 1;
        }

        $supplier_wise_permission = new SupplierWiseStore();
        $supplier_wise_permission->sws_code = 'sws-00' . $rm_code;
        $supplier_wise_permission->supplier_id = $request->supplier;
        $supplier_wise_permission->status = ($request->status != '' ? '1' : '0');
        $supplier_wise_permission->added_by = Auth::user()->id;
        $supplier_wise_permission->updated_by = Auth::user()->id;
        $supplier_wise_permission->save();

        DB::transaction(function () use ($request, $supplier_wise_permission) {
            foreach ($request->store as $st) {
                $rp_details = new SupplierWiseStoreDetails();
                $rp_details->sws_id = $supplier_wise_permission->id;
                $rp_details->store_id = $st;
                $rp_details->save();
            }

        });

        if ($supplier_wise_permission) {
            return redirect()->route('invoice_setting.supplier_wise_store_list')->with('success', 'Supplier Wise Store added Successfully');
        } else {
            return redirect()->back()->with('error', 'Supplier Wise Store added Failed');
        }
    }

    public function edit($id)
    {

        $data['store_list'] = DB::table('stores as st')->where('st.status', '1')
            ->leftJoin('supplier_wise_store_details as spd', function ($q) use ($id) {$q->on('st.id', '=', 'spd.store_id'); $q->where('spd.sws_id', $id);})
            ->select('st.id as store_table_id', 'st.store_name', 'st.status as store_status', 'spd.sws_id', 'spd.store_id as spd_store_id')->get();

        $data['edit_sp'] = SupplierWiseStore::find($id);
        return view('dashboard.setting.supplier_wise_store.edit_supplier_wise_store')->with($data);
    }
    public function update(Request $request, $id)
    {

        $request->validate([
            'store' => 'required',
        ]);

        $delete = SupplierWiseStoreDetails::where('sws_id', $id)->delete();

        foreach ($request->store as $st) {
            $details = SupplierWiseStoreDetails::where('sws_id', $id)->where('store_id', $st)->first();

            if ($details == null || $details == '') {
                SupplierWiseStoreDetails::create([
                    'sws_id' => $id,
                    'store_id' => $st,
                ]);
            }
        }


        $supplier_wise_store = SupplierWiseStore::find($id);

        $supplier_wise_store->status = ($request->status != '' ? '1' : '0');
        $supplier_wise_store->updated_by = Auth::user()->id;
        $supplier_wise_store->update();

        if ($supplier_wise_store) {
            return redirect()->route('invoice_setting.supplier_wise_store_list')->with('success', 'Supplier Wise Store Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Supplier Wise Store Updated Failed');
        }

    }

    public function delete($id)
    {
        $supplier_wise_store = SupplierWiseStore::find($id)->delete();
        $details = SupplierWiseStoreDetails::where('sws_id', $id)->delete();
        if ($supplier_wise_store && $details) {
            return redirect()->back()->with('success', 'Supplier Wise Store Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Supplier Wise Store Deleted Failed');
        }
    }
}
