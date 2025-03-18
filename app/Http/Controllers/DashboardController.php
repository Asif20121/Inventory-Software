<?php

namespace App\Http\Controllers;

use App\Models\StorePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:admin.dashboard'])->only(['admin_dashboard', 'admin_dashboard_show', 'admin_dashboard_search']);
        $this->middleware(['permission:store.wise.dashboard'])->only(['sw_dashboard', 'sw_dashboard_show', 'sw_dashboard_search']);
        $this->middleware(['permission:sales.dashboard'])->only(['sales_dashboard', 'sales_dashboard_show', 'sales_dashboard_search']);
    }


    public function admin_dashboard()
    {
        $store = DB::select("select s.id,s.store_name from  stores as s ORDER BY s.store_name asc ");
        return view('dashboard.admin_dashboard', compact('store'));
    }

    public function admin_dashboard_show()
    {
        $current_date = date('Y-m-d');

        //Sales Overview
        $sales = DB::select("SELECT sum(p.total_amount) as total_payable_amount , sum(p.paid_amount) as total_paid, sum(p.due_amount) as total_due from invoices as inv left join payments as p on inv.id=p.invoice_id where  inv.status !='2' and DATE_FORMAT(inv.date, '%Y-%m-%d') = '$current_date'");
        $receive_amount = DB::select("SELECT sum(payd.actual_paid) as receive_amount FROM payment_details AS payd left join invoices as inv on inv.id = payd.invoice_id WHERE payd.status= '1' and inv.status !='2' and  DATE_FORMAT(payd.date,'%Y-%m-%d')= '$current_date' ");

        //Purchase and Expenses
        $total_purchase = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'))->where(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), $current_date)->where('status', '!=', '2')->get();
        $approve_purchase = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'))->where(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), $current_date)->where('status', '=', '1')->get();
        $pending_purchase = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'))->where(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), $current_date)->where('status', '=', '0')->get();
        $expense = DB::table('expense_manages')->select(DB::raw('SUM(cost) as expense'))->where('expense_date', $current_date)->where('status', '!=', '2')->get();

        //Profit
        $profit = ($sales[0]->total_payable_amount != '' ? $sales[0]->total_payable_amount : 0) - (($approve_purchase[0]->purchase_amount != '' ? $approve_purchase[0]->purchase_amount : 0) + ($expense[0]->expense != '' ? $expense[0]->expense : 0));

        //Cancel Count
        $cancel_invoice = DB::table('invoices')->where('status', '2')->where('date', $current_date)->count();
        $cancel_purchase = DB::table('purchases')->where('status', '2')->where(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), $current_date)->count();

        //Store
        $active_store = DB::table('stores')->where('status', '1')->count();
        $inactive_store = DB::table('stores')->where('status', '0')->count();

        //Employee
        $active_employee = DB::table('admins')->where('status', '1')->count();
        $inactive_employee = DB::table('admins')->where('status', '0')->count();

        return response()->json(compact('sales', 'receive_amount', 'total_purchase', 'pending_purchase', 'approve_purchase', 'expense', 'profit', 'cancel_invoice', 'cancel_purchase', 'active_store', 'inactive_store', 'active_employee', 'inactive_employee'));
    }

    public function admin_dashboard_search(Request $request)
    {
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $store_id = $request->store_id ? $request->store_id : '';

        //Sales Overview
        $sql_cond_sales = "";
        $clause_sales = " and";
        $sql_cond_sales .= $from_date && $to_date != "" ? " $clause_sales inv.date between '$from_date' and '$to_date' " : "";
        $sql_cond_sales .= $store_id != "" ? " $clause_sales inv.store_id = $store_id" : "";

        $sales = DB::select("SELECT sum(p.total_amount) as total_payable_amount , sum(p.paid_amount) as total_paid, sum(p.due_amount) as total_due from invoices as inv left join payments as p on inv.id=p.invoice_id where  inv.status !='2' $sql_cond_sales ");

        $sql_cond_receive_amount = "";
        $clause_receive_amount = " and";
        $sql_cond_receive_amount .= $from_date && $to_date != "" ? " $clause_receive_amount DATE_FORMAT(payd.date,'%Y-%m-%d') between '$from_date' and '$to_date' " : "";
        $sql_cond_receive_amount .= $store_id != "" ? " $clause_receive_amount inv.store_id = $store_id" : "";
        $receive_amount = DB::select("SELECT sum(payd.actual_paid) as receive_amount FROM payment_details AS payd left join invoices as inv on inv.id = payd.invoice_id WHERE payd.status= '1' and inv.status !='2'  $sql_cond_receive_amount");

        //Purchase and Expenses
        $total_purchase_query = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'));
        $approve_purchase_query = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'));
        $pending_purchase_query = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'));
        $expenese_query = DB::table('expense_manages')->select(DB::raw('SUM(cost) as expense'))->where('status', '!=', '2');
        $cancel_invoice_query = DB::table('invoices')->where('status', '2');
        $cancel_purchase_query = DB::table('purchases')->where('status', '2');
        $query_active_employee = DB::table('admins as ad')->where('ad.status', '1');
        $query_inactive_employee = DB::table('admins as ad')->where('ad.status', '0');

        if ($from_date != '' && $to_date != '') {
            $total_purchase_query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), [$from_date, $to_date]);
            $approve_purchase_query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), [$from_date, $to_date]);
            $pending_purchase_query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), [$from_date, $to_date]);
            $expenese_query->whereBetween('expense_date', [$from_date, $to_date]);
            $cancel_invoice_query->whereBetween('date', [$from_date, $to_date]);
            $cancel_purchase_query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), [$from_date, $to_date]);
        }

        if ($store_id != '') {
            $total_purchase_query->where('purchases.store', $store_id);
            $approve_purchase_query->where('purchases.store', $store_id);
            $pending_purchase_query->where('purchases.store', $store_id);
            $expenese_query->where('store_id', $store_id);
            $cancel_invoice_query->where('store_id', $store_id);
            $cancel_purchase_query->where('store', $store_id);

            $query_active_employee->rightJoin('store_permissions as sp', 'ad.id', 'sp.emp_id')
                ->rightJoin('store_permission_details as spd', function ($join) use ($store_id) {
                    $join->on('sp.id', 'spd.sp_id')
                        ->where('spd.store_id', $store_id);

                });

            $query_inactive_employee->rightJoin('store_permissions as sp', 'ad.id', 'sp.emp_id')
                ->rightJoin('store_permission_details as spd', function ($join) use ($store_id) {
                    $join->on('sp.id', 'spd.sp_id')
                        ->where('spd.store_id', $store_id);

                });
        }

        $total_purchase = $total_purchase_query->where('status', '!=', '2')->get();
        $approve_purchase = $approve_purchase_query->where('status', '=', '1')->get();
        $pending_purchase = $pending_purchase_query->where('status', '=', '0')->get();
        $expense = $expenese_query->get();
        $profit = ($sales[0]->total_payable_amount != '' ? $sales[0]->total_payable_amount : 0) - (($approve_purchase[0]->purchase_amount != '' ? $approve_purchase[0]->purchase_amount : 0) + ($expense[0]->expense != '' ? $expense[0]->expense : 0));

        //Cancel Count
        $cancel_invoice = $cancel_invoice_query->where('status', '2')->count();
        $cancel_purchase = $cancel_purchase_query->where('status', '2')->count();

        //Store
        $active_store = DB::table('stores')->where('status', '1')->count();
        $inactive_store = DB::table('stores')->where('status', '0')->count();

        //Employee
        $active_employee = $query_active_employee->count();
        $inactive_employee = $query_inactive_employee->count();

        return response()->json(compact('sales', 'receive_amount', 'total_purchase', 'pending_purchase', 'approve_purchase', 'expense', 'profit', 'cancel_invoice', 'cancel_purchase', 'active_store', 'inactive_store', 'active_employee', 'inactive_employee'));
    }

    public function sw_dashboard()
    {
        $auth_id = Auth::user()->id;
        $store = DB::select("select s.id,s.store_name
         from store_permissions as sp
         left join store_permission_details as spd on spd.sp_id = sp.id
         left join stores as s on spd.store_id = s.id
         where sp.emp_id = $auth_id and sp.status = '1'
         ORDER BY s.id asc
         ");
        return view('dashboard.sw_dashboard', compact('store'));
    }

    public function sw_dashboard_show()
    {
        $current_date = date('Y-m-d');
        $auth_id = Auth::user()->id;

        $store_condition = "(select spd.store_id from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id  where sp.emp_id = $auth_id and sp.status = '1'  group by spd.store_id )";
        //Sales Overview
        $sales = DB::select("SELECT sum(p.total_amount) as total_payable_amount , sum(p.paid_amount) as total_paid, sum(p.due_amount) as total_due from invoices as inv left join payments as p on inv.id=p.invoice_id where  inv.status !='2' and DATE_FORMAT(inv.date, '%Y-%m-%d') = '$current_date' and inv.store_id IN  $store_condition ");
        $receive_amount = DB::select("SELECT sum(payd.actual_paid) as receive_amount FROM payment_details AS payd left join invoices as inv on inv.id = payd.invoice_id WHERE payd.status= '1' and inv.status !='2' and  DATE_FORMAT(payd.date,'%Y-%m-%d')= '$current_date' and inv.store_id IN  $store_condition ");

        //Purchase and Expenses
        $total_purchase = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'))->where(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), $current_date)->where('status', '!=', '2')
            ->whereIn('store', StorePermission::auth_store_permission($auth_id))->get();
        $approve_purchase = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'))->where(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), $current_date)->where('status', '=', '1')
            ->whereIn('store', StorePermission::auth_store_permission($auth_id))->get();
        $pending_purchase = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'))->where(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), $current_date)->where('status', '=', '0')
            ->whereIn('store', StorePermission::auth_store_permission($auth_id))->get();
        $expense = DB::table('expense_manages')->select(DB::raw('SUM(cost) as expense'))->where('expense_date', $current_date)->where('status', '!=', '2')->whereIn('store_id', StorePermission::auth_store_permission($auth_id))->get();


        //Cancel Count
        $cancel_invoice = DB::table('invoices')->where('status', '2')->where('date', $current_date)->whereIn('store_id', StorePermission::auth_store_permission($auth_id))->count();
        $cancel_purchase = DB::table('purchases')->where('status', '2')->where(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), $current_date)->whereIn('store', StorePermission::auth_store_permission($auth_id))->count();

        //Store
        $active_store = DB::table('stores')->where('status', '1')->whereIn('id', StorePermission::auth_store_permission($auth_id))->count();
        $inactive_store = DB::table('stores')->where('status', '0')->whereIn('id', StorePermission::auth_store_permission($auth_id))->count();

        //Employee
        $active_employee = count(DB::table('admins as ad')->select('ad.id')
                ->where('ad.status', '1')
                ->where('sp.status', '1')
                ->rightJoin('store_permissions as sp', 'ad.id', 'sp.emp_id')
                ->rightJoin('store_permission_details as spd', 'sp.id', 'spd.sp_id')
                ->whereIn('spd.store_id', StorePermission::auth_store_permission($auth_id))
                ->groupBy('ad.id')
                ->get());

        $inactive_employee = count(DB::table('admins as ad')->select('ad.id')
                ->where('ad.status', '0')
                ->where('sp.status', '1')
                ->rightJoin('store_permissions as sp', 'ad.id', 'sp.emp_id')
                ->rightJoin('store_permission_details as spd', 'sp.id', 'spd.sp_id')
                ->whereIn('spd.store_id', StorePermission::auth_store_permission($auth_id))
                ->groupBy('ad.id')
                ->get());

        return response()->json(compact('sales', 'receive_amount', 'total_purchase', 'pending_purchase', 'approve_purchase', 'expense','cancel_invoice', 'cancel_purchase', 'active_store', 'inactive_store', 'active_employee', 'inactive_employee'));
    }

    public function sw_dashboard_search(Request $request)
    {
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $store_id = $request->store_id ? $request->store_id : '';

        $auth_id = Auth::user()->id;

        //Sales Overview
        $sql_cond_sales = "";
        $clause_sales = " and";
        $sql_cond_sales .= $from_date && $to_date != "" ? " $clause_sales inv.date between '$from_date' and '$to_date' " : "";
        $sql_cond_sales .= $store_id != "" ? " $clause_sales inv.store_id = $store_id" : "";

        $store_condition = "(select spd.store_id from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id  where sp.emp_id = $auth_id and sp.status = '1'  group by spd.store_id )";

        //Sales Overview
        $sales = DB::select("SELECT sum(p.total_amount) as total_payable_amount , sum(p.paid_amount) as total_paid, sum(p.due_amount) as total_due from invoices as inv left join payments as p on inv.id=p.invoice_id where  inv.status !='2'  and inv.store_id IN  $store_condition $sql_cond_sales");

        $sql_cond_receive_amount = "";
        $clause_receive_amount = " and";
        $sql_cond_receive_amount .= $from_date && $to_date != "" ? " $clause_receive_amount DATE_FORMAT(payd.date,'%Y-%m-%d') between '$from_date' and '$to_date' " : "";
        $sql_cond_receive_amount .= $store_id != "" ? " $clause_receive_amount inv.store_id = $store_id" : "";
        $receive_amount = DB::select("SELECT sum(payd.actual_paid) as receive_amount FROM payment_details AS payd left join invoices as inv on inv.id = payd.invoice_id WHERE payd.status= '1' and inv.status !='2'  and inv.store_id IN  $store_condition $sql_cond_receive_amount ");

        //Purchase and Expenses
        $total_purchase_query = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'));
        $approve_purchase_query = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'));
        $pending_purchase_query = DB::table('purchases')->select(DB::raw('SUM(grand_total) as purchase_amount'));
        $expenese_query = DB::table('expense_manages')->select(DB::raw('SUM(cost) as expense'))->where('status', '!=', '2');
        $cancel_invoice_query = DB::table('invoices')->where('status', '2');
        $cancel_purchase_query = DB::table('purchases')->where('status', '2');

        $query_active_employee = DB::table('admins as ad')->select('ad.id')->where('ad.status', '1')->where('sp.status', '1')->rightJoin('store_permissions as sp', 'ad.id', 'sp.emp_id')->rightJoin('store_permission_details as spd', 'sp.id', 'spd.sp_id')
        ->whereIn('spd.store_id', StorePermission::auth_store_permission($auth_id))->groupBy('ad.id');
        $query_inactive_employee = DB::table('admins as ad')->select('ad.id')->where('ad.status', '0')->where('sp.status', '1')->rightJoin('store_permissions as sp', 'ad.id', 'sp.emp_id')->rightJoin('store_permission_details as spd', 'sp.id', 'spd.sp_id')
        ->whereIn('spd.store_id', StorePermission::auth_store_permission($auth_id))->groupBy('ad.id');

        if ($from_date != '' && $to_date != '') {
            $total_purchase_query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), [$from_date, $to_date]);
            $approve_purchase_query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), [$from_date, $to_date]);
            $pending_purchase_query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), [$from_date, $to_date]);
            $expenese_query->whereBetween('expense_date', [$from_date, $to_date]);
            $cancel_invoice_query->whereBetween('date', [$from_date, $to_date]);
            $cancel_purchase_query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(date, '%d-%m-%Y'), '%Y-%m-%d')"), [$from_date, $to_date]);
        }

        if ($store_id != '') {
            $total_purchase_query->where('purchases.store', $store_id);
            $approve_purchase_query->where('purchases.store', $store_id);
            $pending_purchase_query->where('purchases.store', $store_id);
            $expenese_query->where('store_id', $store_id);
            $cancel_invoice_query->where('store_id', $store_id);
            $cancel_purchase_query->where('store', $store_id);

            $query_active_employee->where('spd.store_id', $store_id);

            $query_inactive_employee->where('spd.store_id', $store_id);
        }

        $total_purchase = $total_purchase_query->where('status', '!=', '2')->whereIn('store', StorePermission::auth_store_permission($auth_id))->get();
        $approve_purchase = $total_purchase_query->where('status', '=', '1')->whereIn('store', StorePermission::auth_store_permission($auth_id))->get();
        $pending_purchase = $total_purchase_query->where('status', '=', '0')->whereIn('store', StorePermission::auth_store_permission($auth_id))->get();
        $expense = $expenese_query->whereIn('store_id', StorePermission::auth_store_permission($auth_id))->get();


        //Cancel Count
        $cancel_invoice = $cancel_invoice_query->whereIn('store_id', StorePermission::auth_store_permission($auth_id))->count();
        $cancel_purchase = $cancel_purchase_query->whereIn('store', StorePermission::auth_store_permission($auth_id))->count();

        //Store
        $active_store = DB::table('stores')->where('status', '1')->whereIn('id', StorePermission::auth_store_permission($auth_id))->count();
        $inactive_store = DB::table('stores')->where('status', '0')->whereIn('id', StorePermission::auth_store_permission($auth_id))->count();

        //Employee
        $active_employee =count( $query_active_employee->get());

        $inactive_employee =count($query_inactive_employee->get());

        return response()->json(compact('sales', 'receive_amount', 'total_purchase', 'pending_purchase', 'approve_purchase', 'expense', 'cancel_invoice', 'cancel_purchase', 'active_store', 'inactive_store', 'active_employee', 'inactive_employee'));

    }

    public function sales_dashboard()
    {
        $auth_id = Auth::user()->id;
        $store = DB::select("select s.id,s.store_name
         from store_permissions as sp
         left join store_permission_details as spd on spd.sp_id = sp.id
         left join stores as s on spd.store_id = s.id
         where sp.emp_id = $auth_id and sp.status = '1'
         ORDER BY s.id asc
         ");

        return view('dashboard.sales_dashboard',compact('store'));
    }

    public function sales_dashboard_show(){
        $current_date = date('Y-m-d');
        $auth_id = Auth::user()->id;
        //Sales Overview
        $sales = DB::select("SELECT sum(p.total_amount) as total_payable_amount , sum(p.paid_amount) as total_paid, sum(p.due_amount) as total_due from invoices as inv left join payments as p on inv.id=p.invoice_id where  inv.status !='2' and inv.created_by = $auth_id and DATE_FORMAT(inv.date, '%Y-%m-%d') = '$current_date'");
        $receive_amount = DB::select("SELECT sum(payd.actual_paid) as receive_amount FROM payment_details AS payd left join invoices as inv on inv.id = payd.invoice_id WHERE payd.status= '1' and payd.updated_by = $auth_id and inv.status !='2'  and  DATE_FORMAT(payd.date,'%Y-%m-%d')= '$current_date' ");

        return response()->json(compact('sales', 'receive_amount'));
    }

    public function sales_dashboard_search(Request $request){

        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $store_id = $request->store_id ? $request->store_id : '';
        $auth_id = Auth::user()->id;


        //Sales Overview
        $sql_cond_sales = "";
        $clause_sales = " and";
        $sql_cond_sales .= $from_date && $to_date != "" ? " $clause_sales inv.date between '$from_date' and '$to_date' " : "";
        $sql_cond_sales .= $store_id != "" ? " $clause_sales inv.store_id = $store_id" : "";
        $sales = DB::select("SELECT sum(p.total_amount) as total_payable_amount , sum(p.paid_amount) as total_paid, sum(p.due_amount) as total_due from invoices as inv left join payments as p on inv.id=p.invoice_id where  inv.status !='2' and inv.created_by = $auth_id $sql_cond_sales");

        $sql_cond_receive_amount = "";
        $clause_receive_amount = " and";
        $sql_cond_receive_amount .= $from_date && $to_date != "" ? " $clause_receive_amount DATE_FORMAT(payd.date,'%Y-%m-%d') between '$from_date' and '$to_date' " : "";
        $sql_cond_receive_amount .= $store_id != "" ? " $clause_receive_amount inv.store_id = $store_id" : "";
        $receive_amount = DB::select("SELECT sum(payd.actual_paid) as receive_amount FROM payment_details AS payd left join invoices as inv on inv.id = payd.invoice_id WHERE payd.status= '1' and payd.updated_by = $auth_id and inv.status !='2' $sql_cond_receive_amount");
        return response()->json(compact('sales', 'receive_amount'));
    }

}
