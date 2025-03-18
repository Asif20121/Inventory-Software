<?php

namespace App\Http\Controllers;

use App\Models\Expense_manage;
use App\Models\Expense_type;
use App\Models\Store;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class ExpenseManageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:expense_manage.list'])->only(['list','showData','expense_manage_search','expense_manage_search_print']);
        $this->middleware(['permission:expense_manage.create'])->only(['create','store']);
        $this->middleware(['permission:expense_manage.edit'])->only(['edit','update']);
        $this->middleware(['permission:expense_manage.delete'])->only(['delete']);
    }
    function list() {
        $auth_id = Auth::user()->id;

        $pre_store = DB::select("select s.id,s.store_name
        from store_permissions as sp
        left join store_permission_details as spd on spd.sp_id = sp.id
        left join stores as s on spd.store_id = s.id
        where sp.emp_id = $auth_id and sp.status = '1'
        ORDER BY s.id asc
        ");

        return view('dashboard.invoice.expense_manage.expense_manage_list', compact('pre_store'));
    }

    public function showData()
    {
        $auth_id = Auth::user()->id;
        $current_date = date('Y-m-d');
        $expense_manage = DB::select("SELECT ex.id,ex.expense_date,ex.cost,ex.description,ex.status,ex.created_at,ex.updated_at,s.store_name,et.type_name,ad.name from expense_manages as ex left join stores as s on s.id=ex.store_id left join expense_types as et on et.id=ex.expense_type left join admins as ad on ad.id=ex.added_by where ex.store_id in (select s.id from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id left join stores as s on spd.store_id = s.id where sp.emp_id = $auth_id and sp.status = '1') and DATE_FORMAT(ex.expense_date, '%Y-%m-%d')='$current_date'");
        return response()->json(['message' => 'Show All Data', 'expense_manage' => $expense_manage]);
    }

    public function expense_manage_search(Request $request)
    {
        $auth_id = Auth::user()->id;
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $employee_id = $request->employee_id ? $request->employee_id : '';
        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " and";
        $sql_cond .= $from_date && $to_date != "" ? " $clause  DATE_FORMAT(ex.expense_date, '%Y-%m-%d') between '$from_date' and '$to_date' " : "";
        $sql_cond .= $employee_id != "" ? " $clause ad.id = $employee_id" : "";
        $sql_cond .= $store_id != "" ? " $clause s.id = $store_id" : "";

        $expense_manage = DB::select("SELECT ex.id,ex.expense_date,ex.cost,ex.description,ex.status,ex.created_at,ex.updated_at,s.store_name,et.type_name,ad.name from expense_manages as ex left join stores as s on s.id=ex.store_id left join expense_types as et on et.id=ex.expense_type left join admins as ad on ad.id=ex.added_by where ex.store_id in (select s.id from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id left join stores as s on spd.store_id = s.id where sp.emp_id = $auth_id and sp.status = '1') $sql_cond ");
        return response()->json(['message' => 'Show All Data', 'expense_manage' => $expense_manage]);
    }

    public function expense_manage_search_print(Request $request)
    {
        $auth_id = Auth::user()->id;
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $employee_id = $request->employee_id ? $request->employee_id : '';
        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " and";
        $sql_cond .= $from_date && $to_date != "" ? " $clause  DATE_FORMAT(ex.expense_date, '%Y-%m-%d') between '$from_date' and '$to_date' " : "";
        $sql_cond .= $employee_id != "" ? " $clause ad.id = $employee_id" : "";
        $sql_cond .= $store_id != "" ? " $clause s.id = $store_id" : "";
        $expense_manage = DB::select("SELECT ex.id,ex.expense_date,ex.cost,ex.description,ex.status,ex.created_at,ex.updated_at,s.store_name,et.type_name,ad.name from expense_manages as ex left join stores as s on s.id=ex.store_id left join expense_types as et on et.id=ex.expense_type left join admins as ad on ad.id=ex.added_by where ex.store_id in (select s.id from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id left join stores as s on spd.store_id = s.id where sp.emp_id = $auth_id and sp.status = '1') $sql_cond ");


        $employee = DB::table('admins as a')
            ->leftJoin('admin_details as ad', 'a.id', 'ad.admin_id')
            ->select(
                'a.name',
                'ad.card_no'
            )
            ->where('a.id', $request->employee_id)
            ->first();

        $store = Store::where('id', $request->store_id)->select("store_name", "phone", "email", "web_url", "address")->first();
        $from_date_expense = isset($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : '';
        $to_date_expense = isset($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : '';

        $pdf = Pdf::loadView('dashboard.invoice.expense_manage.expense_manage_list_print', compact('expense_manage', 'from_date_expense', 'to_date_expense','employee','store'));
        return $pdf->stream('expense_manage_list_print.pdf');

    }

    public function create()
    {
        $data['pre_store'] = DB::table('store_permissions as sp')
            ->leftJoin('store_permission_details as spd', 'sp.id', 'spd.sp_id')
            ->leftJoin('stores as s', 'spd.store_id', 's.id')
            ->where('sp.status', '1')->where('sp.emp_id', Auth::user()->id)
            ->where('sp.status', '1')
            ->where('s.status', '1')
            ->select(
                's.id',
                's.store_name',
            )
            ->get();

        $data['pre_expense'] = Expense_type::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();

        return view('dashboard.invoice.expense_manage.create_expense_manage')->with($data);
    }

    public function store(Request $request)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'store_id' => 'required',
            'expense_type' => 'required',
            'cost' => 'required',
            'description' => 'max:1000',
        ]);
        $expense_manage = new Expense_manage();
        $expense_manage->expense_date = date("Y-m-d", strtotime($request->expense_date));
        $expense_manage->store_id = $request->store_id;
        $expense_manage->expense_type = $request->expense_type;
        $expense_manage->cost = $request->cost;
        $expense_manage->description = $request->description;

        $expense_manage->added_by = Auth::user()->id;
        $expense_manage->updated_by = Auth::user()->id;
        $expense_manage->save();

        if ($expense_manage) {
            return redirect()->route('admin.expense_manage_list')->with('success', 'Expense manage Add Successfully');
        } else {
            return redirect()->back()->with('error', 'Expense manage Add Failed');
        }
    }

    public function edit($id)
    {

        // return $id;

        $data['pre_store'] = DB::table('store_permissions as sp')
            ->leftJoin('store_permission_details as spd', 'sp.id', 'spd.sp_id')
            ->leftJoin('stores as s', 'spd.store_id', 's.id')
            ->where('sp.status', '1')->where('sp.emp_id', Auth::user()->id)
            ->where('sp.status', '1')
            ->where('s.status', '1')
            ->select(
                's.id',
                's.store_name',
            )
            ->get();

        $data['pre_expense'] = Expense_type::orderBy('id', 'desc')
            ->where('status', '1')
            ->get();

        $data['expense_manage'] = Expense_manage::find($id);

        return view('dashboard.invoice.expense_manage.create_expense_manage')->with($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'expense_date' => 'required|date',
            'store_id' => 'required',
            'expense_type' => 'required',
            'cost' => 'required',
            'description' => 'max:1000',
        ]);

        $expense_manage = Expense_manage::find($id);
        $expense_manage->expense_date = date("Y-m-d", strtotime($request->expense_date));
        $expense_manage->store_id = $request->store_id;
        $expense_manage->expense_type = $request->expense_type;
        $expense_manage->cost = $request->cost;
        $expense_manage->description = $request->description;

        $expense_manage->updated_by = Auth::user()->id;
        $expense_manage->update();

        if ($expense_manage) {
            return redirect()->route('admin.expense_manage_list')->with('success', 'Expense manage Update Successfully');
        } else {
            return redirect()->back()->with('error', 'Expense manage Update Failed');
        }

    }

    public function delete($id)
    {
        $expense_manage = Expense_manage::findOrFail($id)->delete();

        if ($expense_manage) {
            return redirect()->back()->with('success', 'Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Deleted Failed');
        }
    }
}
