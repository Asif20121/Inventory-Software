<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\Purchase;
use App\Models\Store;
use App\Models\Supplier;
use App\Repo\ReportRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    private $repo;
    public function __construct(ReportRepository $rep)
    {
        $this->repo = $rep;

        $this->middleware(['permission:report.daily_sales'])->only(['daily_sales', 'daily_sales_show', 'daily_sales_search', 'daily_sales_list_print']);
        $this->middleware(['permission:report.daily_cancel_inv'])->only(['daily_cancel_inv', 'daily_cancel_inv_show', 'daily_cancel_inv_search', 'daily_cancel_inv_list_print']);
        $this->middleware(['permission:report.monthly_sales'])->only(['monthly_sales', 'monthly_sales_show', 'monthly_sales_search', 'monthly_sales_print']);
        $this->middleware(['permission:report.yearly_sales'])->only(['yearly_sales', 'yearly_sales_show', 'yearly_sales_search', 'yearly_sales_print']);
        $this->middleware(['permission:report.date_wise_cashier'])->only(['date_wise_cashier', 'date_wise_cashier_show', 'search_date_wise_cashier', 'date_wise_cashier_list_print']);
        $this->middleware(['permission:report.income_summery_report'])->only(['income_summery_report', 'income_summery_report_show', 'income_summery_report_search', 'income_summery_report_print']);
        $this->middleware(['permission:report.daily_purchase'])->only(['daily_purchase', 'daily_purchase_data', 'daily_purchase_search', 'daily_purchase_search_print']);
        $this->middleware(['permission:report.daily_purchase_summery'])->only(['daily_purchase_summery', 'daily_purchase_summery_data', 'daily_purchase_summery_search', 'daily_purchase_summery_search_print']);
        $this->middleware(['permission:report.daily_expense_report'])->only(['daily_expense_report', 'daily_expense_report_show', 'daily_expense_report_search', 'daily_expense_report_search_print']);
        $this->middleware(['permission:report.expense_summery_report'])->only(['expense_summery_report', 'expense_summery_report_shoe', 'expense_summery_report_search', 'expense_summery_report_print']);
        $this->middleware(['permission:report.profit_report'])->only(['profit_report', 'profit_report_show', 'profit_report_search', 'profit_report_print']);
    }

    public function daily_sales()
    {
        $store = DB::select("select s.id,s.store_name from  stores as s ORDER BY s.store_name asc ");
        return view('dashboard.invoice.report.daily_sales', compact('store'));
    }

    public function daily_sales_show()
    {
        $invoice_details_arr = $this->repo->daily_sales();

        return response()->json(['message' => 'Show All Data', 'invoice_details_arr' => $invoice_details_arr]);
    }

    public function daily_sales_search(Request $request)
    {
        $invoice_details_arr = $this->repo->daily_sales_search($request);

        return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);
    }

    public function daily_sales_list_print(Request $request)
    {
        $invoice_details_arr = $this->repo->daily_sales_search($request);

        $employee = DB::table('admins as a')
            ->leftJoin('admin_details as ad', 'a.id', 'ad.admin_id')
            ->select(
                'a.name',
                'ad.card_no'
            )
            ->where('a.id', $request->employee_id)
            ->first();

        $customer = Customer::where('id', $request->customer_id)->select("customer_name", "phone")->first();
        $invoice = Invoice::where('id', $request->invoice_id)->select("invoice_no")->first();
        $store = Store::where('id', $request->store_id)->select("store_name", "phone", "email", "web_url", "address")->first();
        $from_date = isset($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : '';
        $to_date = isset($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : '';
        $paid_status = isset($request->status_id) && $request->status_id != '' ? $request->status_id : '';

        $pdf = Pdf::loadView('dashboard.invoice.report.daily_sales_list_print', compact('invoice_details_arr', 'from_date', 'to_date', 'employee', 'employee', 'customer', 'invoice', 'store', 'paid_status'));
        return $pdf->stream('Daily_sales_list.pdf');
    }

    public function daily_sales_details($id)
    {
        $data['invoice'] = count($this->repo->daily_sales_view($id)) > 0 ? $this->repo->daily_sales_view($id)[0] : false;

        if ($data['invoice'] != false) {
            return view('dashboard.invoice.report.daily_sales_details_view')->with($data);
        } else {
            return abort(404);
        }
    }

    public function daily_sales_details_print($id)
    {
        $invoice = count($this->repo->daily_sales_view($id)) > 0 ? $this->repo->daily_sales_view($id)[0] : false;

        if ($invoice != false) {
            $pdf = Pdf::loadView('dashboard.invoice.salese.invoice_details_print', compact('invoice'));
            return $pdf->stream('invoice_details_print.pdf');

        } else {
            return abort(404);
        }
    }

    public function daily_cancel_inv()
    {
        $store = DB::select("select s.id,s.store_name from  stores as s ORDER BY s.store_name asc ");
        return view('dashboard.invoice.report.daily_cancel_inv', compact('store'));
    }

    public function daily_cancel_inv_show()
    {
        $invoice_details_arr = $this->repo->daily_cancel_inv();

        return response()->json(['message' => 'Show All Data', 'invoice_details_arr' => $invoice_details_arr]);
    }

    public function daily_cancel_inv_search(Request $request)
    {
        $invoice_details_arr = $this->repo->daily_cancel_inv_search($request);

        return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);
    }

    public function daily_cancel_inv_list_print(Request $request)
    {
        $invoice_details_arr = $this->repo->daily_cancel_inv_search($request);

        $employee = DB::table('admins as a')
            ->leftJoin('admin_details as ad', 'a.id', 'ad.admin_id')
            ->select(
                'a.name',
                'ad.card_no'
            )
            ->where('a.id', $request->employee_id)
            ->first();

        $customer = Customer::where('id', $request->customer_id)->select("customer_name", "phone")->first();
        $invoice = Invoice::where('id', $request->invoice_id)->select("invoice_no")->first();
        $store = Store::where('id', $request->store_id)->select("store_name", "phone", "email", "web_url", "address")->first();
        $from_date = isset($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : '';
        $to_date = isset($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : '';
        $paid_status = isset($request->status_id) && $request->status_id != '' ? $request->status_id : '';

        $pdf = Pdf::loadView('dashboard.invoice.report.daily_cancel_list_print', compact('invoice_details_arr', 'from_date', 'to_date', 'employee', 'employee', 'customer', 'invoice', 'store', 'paid_status'));
        return $pdf->stream('Daily_sales_list.pdf');
    }

    public function daily_cancel_inv_details($id)
    {
        $data['invoice'] = count($this->repo->daily_sales_view($id)) > 0 ? $this->repo->daily_sales_view($id)[0] : false;

        if ($data['invoice'] != false) {
            return view('dashboard.invoice.report.daily_cancel_inv_details_view')->with($data);
        } else {
            return abort(404);
        }
    }

    public function daily_cancel_inv_details_print($id)
    {
        $invoice = count($this->repo->daily_sales_view($id)) > 0 ? $this->repo->daily_sales_view($id)[0] : false;

        if ($invoice != false) {
            $pdf = Pdf::loadView('dashboard.invoice.salese.cancel_invoice_details_print', compact('invoice'));
            return $pdf->stream('cancel_invoice_details_print.pdf');

        } else {
            return abort(404);
        }
    }

    public function monthly_sales()
    {
        $store = DB::select("select s.id,s.store_name from  stores as s ORDER BY s.store_name asc ");
        return view('dashboard.invoice.report.monthly_sales', compact('store'));
    }

    public function monthly_sales_show()
    {
        $invoice_details_arr = $this->repo->monthly_sales();

        return response()->json(['message' => 'Show All Data', 'invoice_details_arr' => $invoice_details_arr]);
    }

    public function monthly_sales_search(Request $request)
    {

        $invoice_details_arr = $this->repo->monthly_sales_search($request);

        return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);
    }

    public function monthly_sales_print(Request $request)
    {

        $invoice_details_arr = $this->repo->monthly_sales_search($request);

        // return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);

        $employee = DB::table('admins as a')
            ->leftJoin('admin_details as ad', 'a.id', 'ad.admin_id')
            ->select(
                'a.name',
                'ad.card_no'
            )
            ->where('a.id', $request->employee_id)
            ->first();
        $customer = Customer::where('id', $request->customer_id)->select("customer_name", "phone")->first();
        $store = Store::where('id', $request->store_id)->select("store_name", "phone", "email", "web_url", "address")->first();
        $from_date = isset($request->from_date) ? date("F Y", strtotime($request->from_date)) : '';
        $to_date = isset($request->to_date) ? date("F Y", strtotime($request->to_date)) : '';

        $pdf = Pdf::loadView('dashboard.invoice.report.monthly_sales_print', compact('invoice_details_arr', 'from_date', 'to_date', 'employee', 'store', 'customer'));
        return $pdf->stream('monthly_sales_print.pdf');

    }

    public function date_wise_cashier()
    {

        $store = DB::select("select s.id,s.store_name from  stores as s ORDER BY s.store_name asc ");

        return view('dashboard.invoice.report.date_wise_casire', compact('store'));
    }

    public function date_wise_cashier_show()
    {
        $invoice_details_arr = $this->repo->rep_date_wise_cashier_report();

        return response()->json(['message' => 'Show All Data', 'invoice_details_arr' => $invoice_details_arr]);
    }

    public function search_date_wise_cashier(Request $request)
    {

        $invoice_details_arr = $this->repo->rep_search_date_wise_cashier_report($request);

        return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);
    }
    public function date_wise_cashier_details($id)
    {
        $data['invoice'] = count($this->repo->daily_sales_view($id)) > 0 ? $this->repo->daily_sales_view($id)[0] : false;

        if ($data['invoice'] != false) {
            return view('dashboard.invoice.report.date_wise_cashier_details')->with($data);
        } else {
            return abort(404);
        }
    }

    public function date_wise_cashier_details_print($id)
    {
        $invoice = count($this->repo->daily_sales_view($id)) > 0 ? $this->repo->daily_sales_view($id)[0] : false;

        if ($invoice != false) {
            $pdf = Pdf::loadView('dashboard.invoice.report.date_wise_cashier_details_print', compact('invoice'));
            return $pdf->stream('date_wise_cashier_details_print.pdf');

        } else {
            return abort(404);
        }
    }

    public function date_wise_cashier_list_print(Request $request)
    {

        $invoice_details_arr = $this->repo->rep_search_date_wise_cashier_report($request);

        $employee = DB::table('admins as a')
            ->leftJoin('admin_details as ad', 'a.id', 'ad.admin_id')
            ->select(
                'a.name',
                'ad.card_no'
            )
            ->where('a.id', $request->employee_id)
            ->first();
        $invoice = Invoice::where('id', $request->invoice_id)->select("invoice_no")->first();
        $store = Store::where('id', $request->store_id)->select("store_name", "phone", "email", "web_url", "address")->first();
        $from_date = isset($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : '';
        $to_date = isset($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : '';

        $pdf = Pdf::loadView('dashboard.invoice.report.date_wise_casiher_list_print', compact('invoice_details_arr', 'from_date', 'to_date', 'employee', 'invoice', 'store'));
        return $pdf->stream('date_wise_casiher_list_print.pdf');

    }

    public function yearly_sales()
    {
        $store = DB::select("select s.id,s.store_name from  stores as s ORDER BY s.store_name asc ");
        return view('dashboard.invoice.report.yearly_sales', compact('store'));
    }

    public function yearly_sales_show()
    {
        $invoice_details_arr = $this->repo->yearly_sales();

        return response()->json(['message' => 'Show All Data', 'invoice_details_arr' => $invoice_details_arr]);
    }

    public function yearly_sales_search(Request $request)
    {

        $invoice_details_arr = $this->repo->yearly_sales_search($request);

        return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);
    }

    public function yearly_sales_print(Request $request)
    {
        $invoice_details_arr = $this->repo->yearly_sales_search($request);

        $employee = DB::table('admins as a')
            ->leftJoin('admin_details as ad', 'a.id', 'ad.admin_id')
            ->select(
                'a.name',
                'ad.card_no'
            )
            ->where('a.id', $request->employee_id)
            ->first();
        $customer = Customer::where('id', $request->customer_id)->select("customer_name", "phone")->first();
        $store = Store::where('id', $request->store_id)->select("store_name", "phone", "email", "web_url", "address")->first();
        $from_date = isset($request->from_date) ? $request->from_date : '';
        $to_date = isset($request->to_date) ? $request->to_date : '';

        $pdf = Pdf::loadView('dashboard.invoice.report.yearly_sales_print', compact('invoice_details_arr', 'from_date', 'to_date', 'employee', 'store', 'customer'));
        return $pdf->stream('yearly_sales_print.pdf');

    }

    public function income_summery_report()
    {
        $store = DB::select("select s.id,s.store_name from  stores as s ORDER BY s.store_name asc ");
        return view('dashboard.invoice.report.income_summery_report', compact('store'));
    }

    public function income_summery_report_show()
    {
        $invoice_details_arr = $this->repo->income_summary_report();

        return response()->json(['message' => 'Show All Data', 'invoice_details_arr' => $invoice_details_arr]);
    }

    public function income_summery_report_search(Request $request)
    {

        $invoice_details_arr = $this->repo->search_income_summary_report($request);

        return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);
    }

    public function income_summery_report_print(Request $request)
    {
        $invoice_details_arr = $this->repo->search_income_summary_report($request);

        // return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);

        $employee = DB::table('admins as a')
            ->leftJoin('admin_details as ad', 'a.id', 'ad.admin_id')
            ->select(
                'a.name',
                'ad.card_no'
            )
            ->where('a.id', $request->employee_id)
            ->first();
        // $customer = Customer::where('id', $request->customer_id)->select("customer_name", "phone")->first();
        $invoice = Invoice::where('id', $request->invoice_id)->select("invoice_no")->first();
        $store = Store::where('id', $request->store_id)->select("store_name", "phone", "email", "web_url", "address")->first();
        $from_date = isset($request->from_date) ? date("F Y", strtotime($request->from_date)) : '';
        $to_date = isset($request->to_date) ? date("F Y", strtotime($request->to_date)) : '';

        $pdf = Pdf::loadView('dashboard.invoice.report.income_summery_print', compact('invoice_details_arr', 'from_date', 'to_date', 'employee', 'store', 'invoice'));
        return $pdf->stream('income_summery_print.pdf');

    }

    public function daily_purchase()
    {
        $data['store_search_data'] = DB::select("select s.id,s.store_name from  stores as s ORDER BY s.store_name asc ");

        $data['supplier_search_data'] = DB::table('suppliers as s')->select('s.id as supplier_id', 's.supplier_name')->get();

        return view('dashboard.invoice.report.daily_purchase')->with($data);
    }

    public function daily_purchase_data()
    {
        $purchase = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(p.date, '%d-%m-%Y'), '%Y-%m-%d')"), date('Y-m-d'))
            ->leftJoin('suppliers as su', 'p.supplier', 'su.id')
            ->leftJoin('admins as ad', 'p.added_by', 'ad.id')
            ->select(
                'p.id',
                'p.date',
                'p.voucher',
                'st.store_name',
                'su.supplier_name',
                'su.email as supplier_email',
                'su.phone as supplier_phone',
                'p.tax',
                'p.vat',
                'p.shipping_cost',
                'p.other_cost',
                'p.discount',
                'p.product_cost',
                'p.grand_total',
                'p.status',
                'ad.name as added_by',
                'p.updated_at',
            )
            ->orderBy('p.id', 'desc')
            ->get();

        return response()->json(['message' => 'Show All Data', 'purchase' => $purchase]);
    }

    public function daily_purchase_search(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->leftJoin('suppliers as su', 'p.supplier', 'su.id')
            ->leftJoin('admins as ad', 'p.added_by', 'ad.id')
            ->select(
                'p.id',
                'p.date',
                'p.voucher',
                'st.store_name',
                'su.supplier_name',
                'su.email as supplier_email',
                'su.phone as supplier_phone',
                'p.tax',
                'p.vat',
                'p.shipping_cost',
                'p.other_cost',
                'p.discount',
                'p.product_cost',
                'p.grand_total',
                'p.status',
                'ad.name as added_by',
                'p.updated_at',
            );

        if ($fromDate && $toDate) {
            $query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(p.date, '%d-%m-%Y'), '%Y-%m-%d')"), [$fromDate, $toDate]);
        }

        if ($request->employee_id != null) {
            $query->where('p.added_by', $request->employee_id);
        }

        if ($request->store_id != null) {
            $query->where('p.store', $request->store_id);
        }
        if ($request->supplier_id != null) {
            $query->where('p.supplier', $request->supplier_id);
        }

        if ($request->purchase_status != '') {
            if ($request->purchase_status == 'approve') {
                $query->where('p.status', 1);
            }

            if ($request->purchase_status == 'pending') {
                $query->where('p.status', 0);
            }

            if ($request->purchase_status == 'cancel') {
                $query->where('p.status', 2);
            }
        }

        $purchase = $query->orderBy('p.id', 'desc')->get();

        return response()->json(['message' => 'Show All Data', 'purchase' => $purchase]);
    }

    public function daily_purchase_search_print(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->leftJoin('suppliers as su', 'p.supplier', 'su.id')
            ->leftJoin('admins as ad', 'p.added_by', 'ad.id')
            ->select(
                'p.id',
                'p.date',
                'p.voucher',
                'st.store_name',
                'su.supplier_name',
                'su.email as supplier_email',
                'su.phone as supplier_phone',
                'p.tax',
                'p.vat',
                'p.shipping_cost',
                'p.other_cost',
                'p.discount',
                'p.product_cost',
                'p.grand_total',
                'p.status',
                'ad.name as added_by',
                'p.updated_at',
            );

        if ($fromDate && $toDate) {
            $query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(p.date, '%d-%m-%Y'), '%Y-%m-%d')"), [$fromDate, $toDate]);
        }

        if ($request->employee_id != null) {
            $query->where('p.added_by', $request->employee_id);
        }

        if ($request->store_id != null) {
            $query->where('p.store', $request->store_id);
        }
        if ($request->supplier_id != null) {
            $query->where('p.supplier', $request->supplier_id);
        }

        if ($request->purchase_status != '') {
            if ($request->purchase_status == 'approve') {
                $query->where('p.status', 1);
            } elseif ($request->purchase_status == 'pending') {
                $query->where('p.status', 0);
            } elseif ($request->purchase_status == 'cancel') {
                $query->where('p.status', 2);
            }
        }

        $purchase = $query->orderBy('p.id', 'desc')->get();

        $employee = DB::table('admins as a')
            ->leftJoin('admin_details as ad', 'a.id', 'ad.admin_id')
            ->select(
                'a.name',
                'ad.card_no'
            )
            ->where('a.id', $request->employee_id)
            ->first();
        $supplier = Supplier::where('id', $request->supplier_id)->select("supplier_name")->first();
        $store = Store::where('id', $request->store_id)->select("store_name", "phone", "email", "web_url", "address")->first();
        $from_date = isset($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : '';
        $to_date = isset($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : '';

        $pdf = Pdf::loadView('dashboard.invoice.purchase.purchase_list_print', compact('purchase', 'from_date', 'to_date', 'employee', 'store', 'supplier'));
        return $pdf->stream('purchase_list_print.pdf');
    }

    public function daily_purchase_view($id)
    {
        $auth_id = Auth::user()->id;
        $purchase = Purchase::with(['purchase_detailsf' => function ($query) {
            return $query->with(['created_employee', 'updated_employee', 'productf'])->where('status', '1');
        }, 'supplierf', 'storef', 'created_employee', 'updated_employee'])
            ->where('id', $id)
            ->first();

        $cancel_list = Purchase::select('id')->with(['purchase_detailsf' => function ($query) {
            return $query->with(['created_employee', 'updated_employee', 'productf'])->where('status', '2');
        }])
            ->where('id', $id)
            ->first();

        // return $purchase;
        if ($purchase || $cancel_list) {
            return view('dashboard.invoice.report.daily_purchase_view', compact('purchase', 'cancel_list'));
        } else {
            return abort(404);
        }
    }

    public function daily_purchase_view_print($id)
    {
        $auth_id = Auth::user()->id;
        $purchase = Purchase::with(['purchase_detailsf' => function ($query) {
            return $query->with(['created_employee', 'updated_employee', 'productf'])->where('status', '1');
        }, 'supplierf', 'storef', 'created_employee', 'updated_employee'])
            ->where('id', $id)
            ->first();

        $cancel_list = Purchase::select('id')->with(['purchase_detailsf' => function ($query) {
            return $query->with(['created_employee', 'updated_employee', 'productf'])->where('status', '2');
        }])
            ->where('id', $id)
            ->first();

        // return $purchase;
        if ($purchase || $cancel_list) {

            $pdf = Pdf::loadView('dashboard.invoice.purchase.purchase_details_print', compact('purchase', 'cancel_list'));
            return $pdf->stream('purchase_details.pdf');
        } else {
            return abort(404);
        }
    }

    public function daily_purchase_summery()
    {
        $data['store_search_data'] = DB::select("select s.id,s.store_name from  stores as s ORDER BY s.store_name asc ");

        $data['supplier_search_data'] = DB::table('suppliers as s')->select('s.id as supplier_id', 's.supplier_name')->get();

        return view('dashboard.invoice.report.daily_purchase_summery')->with($data);
    }

    public function daily_purchase_summery_data()
    {
        $purchase = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(p.date, '%d-%m-%Y'), '%Y-%m')"), date('Y-m'))
            ->leftJoin('suppliers as su', 'p.supplier', 'su.id')
            ->leftJoin('admins as ad', 'p.added_by', 'ad.id')
            ->select(
                DB::raw('SUM(p.tax) as total_tax'),
                DB::raw('SUM(p.vat) as total_vat'),
                DB::raw('SUM(p.shipping_cost) as total_shipping_cost'),
                DB::raw('SUM(p.other_cost) as total_other_cost'),
                DB::raw('SUM(p.discount) as total_discount'),
                DB::raw('SUM(p.product_cost) as total_product_cost'),
                DB::raw('SUM(p.grand_total) as total_grand_total')
            )
            ->get();

        return response()->json(['message' => 'Show All Data', 'purchase' => $purchase]);
    }

    public function daily_purchase_summery_search(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m', strtotime($request->to_date)) : "";
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->leftJoin('suppliers as su', 'p.supplier', 'su.id')
            ->leftJoin('admins as ad', 'p.added_by', 'ad.id')
            ->select(
                DB::raw('SUM(p.tax) as total_tax'),
                DB::raw('SUM(p.vat) as total_vat'),
                DB::raw('SUM(p.shipping_cost) as total_shipping_cost'),
                DB::raw('SUM(p.other_cost) as total_other_cost'),
                DB::raw('SUM(p.discount) as total_discount'),
                DB::raw('SUM(p.product_cost) as total_product_cost'),
                DB::raw('SUM(p.grand_total) as total_grand_total')
            );

        if ($fromDate && $toDate) {
            $query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(p.date, '%d-%m-%Y'), '%Y-%m')"), [$fromDate, $toDate]);
        }

        if ($request->employee_id != null) {
            $query->where('p.added_by', $request->employee_id);
        }

        if ($request->store_id != null) {
            $query->where('p.store', $request->store_id);
        }
        if ($request->supplier_id != null) {
            $query->where('p.supplier', $request->supplier_id);
        }

        if ($request->purchase_status != '') {
            if ($request->purchase_status == 'approve') {
                $query->where('p.status', 1);
            }

            if ($request->purchase_status == 'pending') {
                $query->where('p.status', 0);
            }

            if ($request->purchase_status == 'cancel') {
                $query->where('p.status', 2);
            }
        }

        $purchase = $query->get();

        return response()->json(['message' => 'Show All Data', 'purchase' => $purchase]);
    }

    public function daily_purchase_summery_search_print(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m', strtotime($request->to_date)) : "";
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->leftJoin('suppliers as su', 'p.supplier', 'su.id')
            ->leftJoin('admins as ad', 'p.added_by', 'ad.id')
            ->select(
                DB::raw('SUM(p.tax) as total_tax'),
                DB::raw('SUM(p.vat) as total_vat'),
                DB::raw('SUM(p.shipping_cost) as total_shipping_cost'),
                DB::raw('SUM(p.other_cost) as total_other_cost'),
                DB::raw('SUM(p.discount) as total_discount'),
                DB::raw('SUM(p.product_cost) as total_product_cost'),
                DB::raw('SUM(p.grand_total) as total_grand_total')
            );

        if ($fromDate && $toDate) {
            $query->whereBetween(DB::raw("DATE_FORMAT(STR_TO_DATE(p.date, '%d-%m-%Y'), '%Y-%m')"), [$fromDate, $toDate]);
        }

        if ($request->employee_id != null) {
            $query->where('p.added_by', $request->employee_id);
        }

        if ($request->store_id != null) {
            $query->where('p.store', $request->store_id);
        }
        if ($request->supplier_id != null) {
            $query->where('p.supplier', $request->supplier_id);
        }

        $status = $request->purchase_status;
        if ($request->purchase_status != '') {

            if ($request->purchase_status == 'approve') {
                $query->where('p.status', 1);
            } elseif ($request->purchase_status == 'pending') {
                $query->where('p.status', 0);
            } elseif ($request->purchase_status == 'cancel') {
                $query->where('p.status', 2);
            }
        }

        $purchase = $query->get();

        $employee = DB::table('admins as a')
            ->leftJoin('admin_details as ad', 'a.id', 'ad.admin_id')
            ->select(
                'a.name',
                'ad.card_no'
            )
            ->where('a.id', $request->employee_id)
            ->first();
        $supplier = Supplier::where('id', $request->supplier_id)->select("supplier_name")->first();
        $store = Store::where('id', $request->store_id)->select("store_name", "phone", "email", "web_url", "address")->first();
        $from_date = isset($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : '';
        $to_date = isset($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : '';

        $pdf = Pdf::loadView("dashboard.invoice.report.daily_purchase_summery_print", compact('purchase', 'from_date', 'to_date', 'employee', 'store', 'supplier', 'status'));
        return $pdf->stream('daily_purchase_summery_print.pdf');
    }

    public function daily_expense_report()
    {
        $pre_store = DB::select("select s.id,s.store_name
        from stores as s
        ORDER BY s.id asc
        ");
        return view('dashboard.invoice.report.daily_expense', compact('pre_store'));
    }

    public function daily_expense_report_show()
    {
        $current_date = date('Y-m-d');
        $expense_manage = DB::select("SELECT ex.id,ex.expense_date,ex.cost,ex.description,ex.status,ex.created_at,ex.updated_at,s.store_name,et.type_name,ad.name from expense_manages as ex left join stores as s on s.id=ex.store_id left join expense_types as et on et.id=ex.expense_type left join admins as ad on ad.id=ex.added_by where  DATE_FORMAT(ex.expense_date, '%Y-%m-%d')='$current_date'");
        return response()->json(['message' => 'Show All Data', 'expense_manage' => $expense_manage]);
    }

    public function daily_expense_report_search(Request $request)
    {
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $employee_id = $request->employee_id ? $request->employee_id : '';
        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " where";
        $sql_cond .= $from_date && $to_date != "" ? " $clause  DATE_FORMAT(ex.expense_date, '%Y-%m-%d') between '$from_date' and '$to_date' " : "";
        $clause = $sql_cond != '' ? ' and' : 'where';
        $sql_cond .= $employee_id != "" ? " $clause ad.id = $employee_id" : "";
        $clause = $sql_cond != '' ? ' and' : 'where';
        $sql_cond .= $store_id != "" ? " $clause s.id = $store_id" : "";

        $expense_manage = DB::select("SELECT ex.id,ex.expense_date,ex.cost,ex.description,ex.status,ex.created_at,ex.updated_at,s.store_name,et.type_name,ad.name from expense_manages as ex left join stores as s on s.id=ex.store_id left join expense_types as et on et.id=ex.expense_type left join admins as ad on ad.id=ex.added_by $sql_cond ");
        return response()->json(['message' => 'Show All Data', 'expense_manage' => $expense_manage]);
    }
    public function daily_expense_report_search_print(Request $request)
    {
        $from_date = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $employee_id = $request->employee_id ? $request->employee_id : '';
        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " where";
        $sql_cond .= $from_date && $to_date != "" ? " $clause  DATE_FORMAT(ex.expense_date, '%Y-%m-%d') between '$from_date' and '$to_date' " : "";
        $clause = $sql_cond != '' ? ' and' : 'where';
        $sql_cond .= $employee_id != "" ? " $clause ad.id = $employee_id" : "";
        $clause = $sql_cond != '' ? ' and' : 'where';
        $sql_cond .= $store_id != "" ? " $clause s.id = $store_id" : "";

        $expense_manage = DB::select("SELECT ex.id,ex.expense_date,ex.cost,ex.description,ex.status,ex.created_at,ex.updated_at,s.store_name,et.type_name,ad.name from expense_manages as ex left join stores as s on s.id=ex.store_id left join expense_types as et on et.id=ex.expense_type left join admins as ad on ad.id=ex.added_by $sql_cond ");

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

        $pdf = Pdf::loadView('dashboard.invoice.report.daily_expense_manage_list_print', compact('expense_manage', 'from_date_expense', 'to_date_expense', 'employee', 'store'));
        return $pdf->stream('daily_expense_manage_list_print.pdf');
    }

    public function expense_summery_report()
    {
        $pre_store = DB::select("select s.id,s.store_name
        from stores as s
        ORDER BY s.id asc
        ");
        return view('dashboard.invoice.report.expense_summery_report', compact('pre_store'));
    }

    public function expense_summery_report_shoe()
    {
        $current_date = date('Y-m');
        $expense_manage = DB::select("SELECT sum(ex.cost) as total_cost from expense_manages as ex left join stores as s on s.id=ex.store_id left join expense_types as et on et.id=ex.expense_type left join admins as ad on ad.id=ex.added_by where  DATE_FORMAT(STR_TO_DATE(ex.expense_date, '%Y-%m-%d'), '%Y-%m') = '$current_date'");
        return response()->json(['message' => 'Show All Data', 'expense_manage' => $expense_manage]);
    }

    public function expense_summery_report_search(Request $request)
    {
        $from_date = $request->from_date ? date('Y-m', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m', strtotime($request->to_date)) : "";
        $employee_id = $request->employee_id ? $request->employee_id : '';
        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " where";
        $sql_cond .= $from_date && $to_date != "" ? " $clause  DATE_FORMAT(STR_TO_DATE(ex.expense_date, '%Y-%m-%d'), '%Y-%m') between '$from_date' and '$to_date' " : "";
        $clause = $sql_cond != '' ? ' and' : 'where';
        $sql_cond .= $employee_id != "" ? " $clause ad.id = $employee_id" : "";
        $clause = $sql_cond != '' ? ' and' : 'where';
        $sql_cond .= $store_id != "" ? " $clause s.id = $store_id" : "";

        $expense_manage = DB::select("SELECT sum(ex.cost) as total_cost from expense_manages as ex left join stores as s on s.id=ex.store_id left join expense_types as et on et.id=ex.expense_type left join admins as ad on ad.id=ex.added_by $sql_cond ");
        return response()->json(['message' => 'Show All Data', 'expense_manage' => $expense_manage]);
    }

    public function expense_summery_report_print(Request $request)
    {
        $from_date = $request->from_date ? date('Y-m', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m', strtotime($request->to_date)) : "";
        $employee_id = $request->employee_id ? $request->employee_id : '';
        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond = "";
        $clause = " where";
        $sql_cond .= $from_date && $to_date != "" ? " $clause  DATE_FORMAT(STR_TO_DATE(ex.expense_date, '%Y-%m-%d'), '%Y-%m') between '$from_date' and '$to_date' " : "";
        $clause = $sql_cond != '' ? ' and' : 'where';
        $sql_cond .= $employee_id != "" ? " $clause ad.id = $employee_id" : "";
        $clause = $sql_cond != '' ? ' and' : 'where';
        $sql_cond .= $store_id != "" ? " $clause s.id = $store_id" : "";

        $expense_manage = DB::select("SELECT sum(ex.cost) as total_cost from expense_manages as ex left join stores as s on s.id=ex.store_id left join expense_types as et on et.id=ex.expense_type left join admins as ad on ad.id=ex.added_by $sql_cond ");

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

        $pdf = Pdf::loadView('dashboard.invoice.report.expense_summery_report_print_print', compact('expense_manage', 'from_date_expense', 'to_date_expense', 'employee', 'store'));
        return $pdf->stream('expense_summery_report_print_print.pdf');
    }

    public function profit_report()
    {
        $pre_store = DB::select("select s.id,s.store_name from stores as s ORDER BY s.id asc ");

        $current_date = date('Y-m');

        return view('dashboard.invoice.report.profit_report', compact('pre_store'));
    }

    public function profit_report_show()
    {

        $current_date = date('Y-m');
        $salese = DB::select("SELECT sum(pay.total_amount) as total_sales_amount from invoices as inv left join payments as pay on inv.id=pay.invoice_id Where inv.status =1 and DATE_FORMAT(STR_TO_DATE(inv.date, '%Y-%m-%d'), '%Y-%m') = '$current_date'");

        $purchases = DB::select("SELECT sum(pu.grand_total) as total_purchase_price from purchases as pu where pu.status=1 and DATE_FORMAT(STR_TO_DATE(pu.date, '%d-%m-%Y'), '%Y-%m') = '$current_date'");
        $expense_manages = DB::select("SELECT sum(cost) as total_cost from expense_manages where status !=2 and DATE_FORMAT(STR_TO_DATE(expense_date, '%Y-%m-%d'), '%Y-%m') = '$current_date'");

        return response()->json(['message' => 'Show All Data', 'salese' => $salese, 'purchases' => $purchases, 'expense_manages' => $expense_manages]);
    }

    public function profit_report_search(Request $request)
    {
        $from_date = $request->from_date ? date('Y-m', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m', strtotime($request->to_date)) : "";
        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond_sales = "";
        $clause_sales = " and";
        $sql_cond_sales .= $from_date && $to_date != "" ? " $clause_sales  DATE_FORMAT(STR_TO_DATE(inv.date, '%Y-%m-%d'), '%Y-%m') between '$from_date' and '$to_date' " : "";
        $clause_sales = $sql_cond_sales != '' ? ' and' : 'where';
        $sql_cond_sales .= $store_id != "" ? " $clause_sales inv.store_id = $store_id" : "";

        $salese = DB::select("SELECT sum(pay.total_amount) as total_sales_amount from invoices as inv left join payments as pay on inv.id=pay.invoice_id Where inv.status =1 $sql_cond_sales");

        $sql_cond_purchase = "";
        $clause_purchase = " and";
        $sql_cond_purchase .= $from_date && $to_date != "" ? " $clause_purchase  DATE_FORMAT(STR_TO_DATE(pu.date, '%d-%m-%Y'), '%Y-%m') between '$from_date' and '$to_date' " : "";
        $clause_purchase = $sql_cond_purchase != '' ? ' and' : 'where';
        $sql_cond_purchase .= $store_id != "" ? " $clause_purchase pu.store = $store_id" : "";

        $purchases = DB::select("SELECT sum(pu.grand_total) as total_purchase_price from purchases as pu where pu.status=1 $sql_cond_purchase");

        $sql_cond_expense = "";
        $clause_expense = " and";
        $sql_cond_expense .= $from_date && $to_date != "" ? " $clause_expense  DATE_FORMAT(STR_TO_DATE(expense_date, '%Y-%m-%d'), '%Y-%m') between '$from_date' and '$to_date' " : "";
        $clause_expense = $sql_cond_expense != '' ? ' and' : 'where';
        $sql_cond_expense .= $store_id != "" ? " $clause_expense store_id = $store_id" : "";

        $expense_manages = DB::select("SELECT sum(cost) as total_cost from expense_manages where status !=2 $sql_cond_expense ");

        return response()->json(['message' => 'Show All Data', 'salese' => $salese, 'purchases' => $purchases, 'expense_manages' => $expense_manages]);
    }

    public function profit_report_print(Request $request)
    {
        $from_date = $request->from_date ? date('Y-m', strtotime($request->from_date)) : '';
        $to_date = $request->to_date ? date('Y-m', strtotime($request->to_date)) : "";
        $store_id = $request->store_id ? $request->store_id : '';

        $sql_cond_sales = "";
        $clause_sales = " and";
        $sql_cond_sales .= $from_date && $to_date != "" ? " $clause_sales  DATE_FORMAT(STR_TO_DATE(inv.date, '%Y-%m-%d'), '%Y-%m') between '$from_date' and '$to_date' " : "";
        $clause_sales = $sql_cond_sales != '' ? ' and' : 'where';
        $sql_cond_sales .= $store_id != "" ? " $clause_sales inv.store_id = $store_id" : "";

        $salese = DB::select("SELECT sum(pay.total_amount) as total_sales_amount from invoices as inv left join payments as pay on inv.id=pay.invoice_id Where inv.status =1 $sql_cond_sales");

        $sql_cond_purchase = "";
        $clause_purchase = " and";
        $sql_cond_purchase .= $from_date && $to_date != "" ? " $clause_purchase  DATE_FORMAT(STR_TO_DATE(pu.date, '%d-%m-%Y'), '%Y-%m') between '$from_date' and '$to_date' " : "";
        $clause_purchase = $sql_cond_purchase != '' ? ' and' : 'where';
        $sql_cond_purchase .= $store_id != "" ? " $clause_purchase pu.store = $store_id" : "";

        $purchases = DB::select("SELECT sum(pu.grand_total) as total_purchase_price from purchases as pu where pu.status=1 $sql_cond_purchase");

        $sql_cond_expense = "";
        $clause_expense = " and";
        $sql_cond_expense .= $from_date && $to_date != "" ? " $clause_expense  DATE_FORMAT(STR_TO_DATE(expense_date, '%Y-%m-%d'), '%Y-%m') between '$from_date' and '$to_date' " : "";
        $clause_expense = $sql_cond_expense != '' ? ' and' : 'where';
        $sql_cond_expense .= $store_id != "" ? " $clause_expense store_id = $store_id" : "";

        $expense_manages = DB::select("SELECT sum(cost) as total_cost from expense_manages where status !=2 $sql_cond_expense ");

        $store = Store::where('id', $request->store_id)->select("store_name", "phone", "email", "web_url", "address")->first();
        $from_date_expense = isset($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : '';
        $to_date_expense = isset($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : '';

        $pdf = Pdf::loadView('dashboard.invoice.report.profit_report_print', compact('from_date_expense', 'to_date_expense', 'store', 'expense_manages', 'purchases', 'salese'));
        return $pdf->stream('profit_report_print.pdf');
    }

}
