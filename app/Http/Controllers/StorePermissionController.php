<?php

namespace App\Http\Controllers;

use App\Models\Store;
use App\Models\StorePermission;
use App\Models\StorePermissionDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class StorePermissionController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:store_previlage.list'])->only(['list']);
        $this->middleware(['permission:store_previlage.create'])->only(['create','store']);
        $this->middleware(['permission:store_previlage.edit'])->only(['edit','update']);
        $this->middleware(['permission:store_previlage.delete'])->only(['delete']);
    }


    function list() {
        $data['active'] = count(StorePermission::where('status', '1')->get());
        $data['inactive'] = count(StorePermission::where('status', '!=', '1')->get());

        $data["store_permission"] = StorePermission::with(['sp_details.store' => function ($q) {
            $q->where('status', '1');
        }])->orderBy('id', 'desc')->get();
        return view('dashboard.invoice.room_permission.room_permission_list')->with($data);
    }

    public function create()
    {
        $data['store'] = Store::orderBy('id', 'desc')->where('status', '1')->get();
        return view('dashboard.invoice.room_permission.create_room_permission')->with($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'employee' => 'required|numeric|max:100',
            'store' => 'required',
        ]);

        if (StorePermission::where('emp_id', $request->employee)->count() > 0) {
            return redirect()->back()->with('error', 'This User Already has Permission');
        }

        $count = count(StorePermission::all());
        if ($count == null) {
            $firstReg = '0';
            $rm_code = $firstReg + 1;
        } else {
            $product_id = StorePermission::orderBy('id', 'desc')->first()->id;
            $rm_code = $product_id + 1;
        }

        $room_permission = new StorePermission();
        $room_permission->sm_code = 'sp-00' . $rm_code;
        $room_permission->emp_id = $request->employee;
        $room_permission->status = ($request->status != '' ? '1' : '0');
        $room_permission->added_by = Auth::user()->id;
        $room_permission->updated_by = Auth::user()->id;
        $room_permission->save();

        DB::transaction(function () use ($request, $room_permission) {
            foreach ($request->store as $st) {
                $rp_details = new StorePermissionDetails();
                $rp_details->sp_id = $room_permission->id;
                $rp_details->store_id = $st;
                $rp_details->save();
            }

        });

        if ($room_permission) {
            return redirect()->route('admin.room_permission_list')->with('success', 'Store Permission added Successfully');
        } else {
            return redirect()->back()->with('error', 'Store Permission added Failed');
        }
    }

    public function edit($id)
    {

        $data['store_list'] = DB::table('stores as st')->where('st.status', '1')
            ->leftJoin('store_permission_details as spd', function ($q) use ($id) {$q->on('st.id', '=', 'spd.store_id'); $q->where('spd.sp_id', $id);})
            ->select('st.id as store_table_id', 'st.store_name', 'st.status as store_status', 'spd.sp_id', 'spd.store_id as spd_store_id')->get();

        $data['edit_sp'] = StorePermission::find($id);
        return view('dashboard.invoice.room_permission.edit_room_permission')->with($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'store' => 'required',
        ]);

        $delete = StorePermissionDetails::where('sp_id', $id)->delete();
        foreach ($request->store as $st) {
            $details = StorePermissionDetails::where('sp_id', $id)->where('store_id', $st)->first();

            if ($details == null || $details == '') {
                StorePermissionDetails::create([
                    'sp_id' => $id,
                    'store_id' => $st,
                ]);
            }
        }

        $room_permission = StorePermission::find($id);

        $room_permission->status = ($request->status != '' ? '1' : '0');
        $room_permission->updated_by = Auth::user()->id;
        $room_permission->update();

        if ($room_permission) {
            return redirect()->route('admin.room_permission_list')->with('success', 'Store Permission Updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Store Permission Updated Failed');
        }

    }

    public function delete($id)
    {
        $room_permission = StorePermission::find($id)->delete();
        $details = StorePermissionDetails::where('sp_id', $id)->delete();
        if ($room_permission && $details) {
            return redirect()->back()->with('success', 'Store Permission Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Store Permission Deleted Failed');
        }
    }
}
