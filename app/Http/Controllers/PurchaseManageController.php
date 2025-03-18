<?php

namespace App\Http\Controllers;

use App\Models\ProductDetails;
use App\Models\Purchase;
use App\Models\PurchaseDetails;
use App\Models\StorePermission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Store;
use App\Models\Supplier;

class PurchaseManageController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:purchase.new_purchase'])->only(['new_purchase','store']);
        $this->middleware(['permission:purchase.pending_list'])->only(['purchase_manage_pending_list','pending_showData','search_pending_data','search_pending_list_print']);
        $this->middleware(['permission:purchase.approve'])->only(['approve']);
        $this->middleware(['permission:purchase.reject'])->only(['reject']);
        $this->middleware(['permission:purchase.delete'])->only(['delete']);
        $this->middleware(['permission:purchase.view'])->only(['purchase_manage_view','purchase_manage_print']);

        $this->middleware(['permission:purchase.edit'])->only(['purchase_manage_edit','purchase_manage_update']);
        $this->middleware(['permission:purchase.list'])->only(['purchase_manage_list','purchase_showdata','search_purchase_list','search_purchase_list_print']);
        $this->middleware(['permission:purchase.approve_list'])->only(['purchase_approve_list','purchase_approve_list_show','purchase_approve_list_search','purchase_approve_list_print']);
        $this->middleware(['permission:purchase.cancel_list'])->only(['purchase_cancel_list','purchase_cancel_list_show','purchase_cancel_list_search','purchase_cancel_list_print']);
    }
    public function new_purchase()
    {
        $data['store'] = DB::table('store_permissions as sp')
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
        return view('dashboard.invoice.purchase.add_new_purchase')->with($data);
    }

    public function store_wise_supplier(Request $request)
    {
        $store_id = $request->store;
        $supplier = DB::table('supplier_wise_stores as sws')
            ->leftJoin('supplier_wise_store_details as swsd', 'sws.id', 'swsd.sws_id')
            ->leftJoin('suppliers as s', 'sws.supplier_id', 's.id')
            ->where('swsd.store_id', $store_id)
            ->select(
                's.id as supplier_id',
                's.supplier_name',
            )
            ->get();
        return response()->json($supplier);
    }

    public function store(Request $request)
    {

        $request->validate([
            'voucher' => 'required|max:50',
            'store' => 'required|max:50',
            'supplier' => 'required|max:50',
        ]);
        $purchase = new Purchase();

        $purchase->date = $request->date;
        $purchase->voucher = $request->voucher;
        $purchase->store = $request->store;
        $purchase->supplier = $request->supplier;
        $purchase->product_cost = $request->product_cost != null ? $request->product_cost : '0';
        $purchase->tax = $request->tax != null ? $request->tax : '0';
        $purchase->vat = $request->vat != null ? $request->vat : '0';
        $purchase->shipping_cost = $request->shipping_cost != null ? $request->shipping_cost : '0';
        $purchase->other_cost = $request->other_cost != null ? $request->other_cost : '';
        $purchase->discount = $request->final_discount != null ? $request->final_discount : '0';
        $purchase->grand_total = $request->grand_total;
        $purchase->description = $request->description;
        $purchase->added_by = Auth::user()->id;
        $purchase->updated_by = Auth::user()->id;

        DB::transaction(function () use ($request, $purchase) {
            if ($purchase->save()) {
                $product_count = count($request->product_id);

                for ($i = 0; $i < $product_count; $i++) {
                    $purchase_details = new PurchaseDetails();
                    $purchase_details->purchase_id = $purchase->id;
                    $purchase_details->product_id = $request->product_id[$i] != null ? $request->product_id[$i] : '0';
                    $purchase_details->buying_qty = $request->buying_qty[$i] != null ? $request->buying_qty[$i] : '0';
                    $purchase_details->unit_price = $request->unit_price[$i] != null ? $request->unit_price[$i] : '0';
                    $purchase_details->discount = $request->discount[$i] != null ? $request->discount[$i] : '0';
                    $purchase_details->upwd = $request->upwd[$i] != null ? $request->upwd[$i] : '0';
                    $purchase_details->total_price = $request->total_buying_unit_price[$i] != null ? $request->total_buying_unit_price[$i] : '0';
                    $purchase_details->added_by = Auth::user()->id;
                    $purchase_details->updated_by = Auth::user()->id;
                    $purchase_details->save();
                }
            }
        });

        if ($purchase) {
            return response()->json(['status' => 200, 'message' => "Purchase Successfully"]);
        }
    }

    public function purchase_manage_pending_list()
    {


        $data['permitted_store'] = DB::table('store_permissions as sp')
            ->leftJoin('store_permission_details as spd', 'sp.id', 'spd.sp_id')
            ->leftJoin('stores as s', 'spd.store_id', 's.id')
            ->where('sp.status', '1')->where('sp.emp_id', Auth::user()->id)
            ->where('sp.status', '1')
            ->select(
                's.id',
                's.store_name',
            )
            ->get();

        $auth_id = Auth::user()->id;
        $data['storewise_supplier'] = DB::table('supplier_wise_stores as sws')
            ->leftJoin('supplier_wise_store_details as swsd', 'sws.id', 'swsd.sws_id')
            ->leftJoin('suppliers as s', 'sws.supplier_id', 's.id')
            ->whereIn('swsd.store_id', StorePermission::auth_store_permission($auth_id))
            ->select(
                's.id as supplier_id',
                's.supplier_name'
            )
            ->groupBy(
                's.id',
                's.supplier_name'
            )
            ->get();


        return view('dashboard.invoice.purchase.purchase_pending_list')->with($data);
    }

    public function pending_showData()
    {
        $purchase = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where('p.status', 0)
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(p.date, '%d-%m-%Y'), '%Y-%m-%d')"), date('Y-m-d'))
            ->whereIn('p.store', StorePermission::auth_store_permission(Auth::user()->id))
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

    public function search_pending_data(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where('p.status', 0)
            ->whereIn('p.store', StorePermission::auth_store_permission(Auth::user()->id))
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

        $purchase = $query->orderBy('p.id', 'desc')->get();

        return response()->json(['message' => 'Show All Data', 'purchase' => $purchase]);
    }


    public function search_pending_list_print(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $auth_id = Auth::user()->id;
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where('p.status', 0)
            ->whereIn('p.store', StorePermission::auth_store_permission($auth_id))
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
        $purchase = $query->orderBy('p.id', 'desc')->get();

        // return $purchase;

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

        $pdf = Pdf::loadView('dashboard.invoice.purchase.purchase_pending_list_print', compact('purchase', 'from_date', 'to_date', 'employee', 'store', 'supplier'));
        return $pdf->stream('purchase_pending_list.pdf');
    }

    public function purchase_manage_edit($id)
    {
        $auth_id = Auth::user()->id;
        $purchase = Purchase::with(['purchase_detailsf' => function ($query) {
            return $query->where('status', '1');
        }])
            ->where('id', $id)->where('status', 0)
            ->whereIn('store', StorePermission::auth_store_permission($auth_id))
            ->first();

        // return $purchase;

        if ($purchase) {
            return view('dashboard.invoice.purchase.edit_purchase', compact('purchase'));
        } else {
            return abort(404);
        }
    }

    public function purchase_manage_update(Request $request)
    {
        // return $request->all();

        $purchase_data =  DB::transaction(function () use ($request) {
            $product_count = count($request->product_id);

            for ($i = 0; $i < $product_count; $i++) {
                $purchase_details = PurchaseDetails::where([['purchase_id', $request->purchase_id], ['product_id', $request->product_id]])->first();
                $purchase_details->buying_qty = $request->buying_qty[$i] != null ? $request->buying_qty[$i] : '0';
                $purchase_details->unit_price = $request->unit_price[$i] != null ? $request->unit_price[$i] : '0';
                $purchase_details->discount = $request->discount[$i] != null ? $request->discount[$i] : '0';
                $purchase_details->upwd = $request->upwd[$i] != null ? $request->upwd[$i] : '0';
                $purchase_details->total_price = $request->total_price[$i] != null ? $request->total_price[$i] : '0';
                if ($request->buying_qty[$i] == 0 || $request->buying_qty[$i] == null) {
                    $purchase_details->status = 2;
                }
                $purchase_details->updated_by = Auth::user()->id;
                $purchase_details->update();
            }

            $purchase = Purchase::find($request->purchase_id);
            $purchase->product_cost = $request->product_cost != '' ? $request->product_cost : 0;
            $purchase->tax = $request->tax != '' ? $request->tax : 0;
            $purchase->vat = $request->vat != '' ? $request->vat : 0;
            $purchase->shipping_cost = $request->shipping_cost != '' ? $request->shipping_cost : 0;
            $purchase->other_cost = $request->other_cost != '' ? $request->other_cost : 0;
            $purchase->discount = $request->special_discount != '' ? $request->special_discount : 0;
            $purchase->grand_total = $request->grand_total != '' ? $request->grand_total : 0;
            $purchase->description = $request->description != '' ? $request->description : '';
            $purchase->updated_by = Auth::user()->id;
            $purchase->update();

            return $purchase;
        });


        if ($purchase_data) {
            return redirect()->route('admin.purchase_manage_pending_list')->with('success', 'Purchase Edit Successfully');
        } else {
            return redirect()->back()->with('error', 'Purchase Edit Failed');
        }
    }

    public function purchase_manage_view($id)
    {
        $auth_id = Auth::user()->id;
        $purchase = Purchase::with(['purchase_detailsf' => function ($query) {
            return $query->with(['created_employee', 'updated_employee', 'productf'])->where('status', '1');
        }, 'supplierf', 'storef', 'created_employee', 'updated_employee'])
            ->where('id', $id)
            ->whereIn('store', StorePermission::auth_store_permission($auth_id))
            ->first();

        $cancel_list = Purchase::select('id')->with(['purchase_detailsf' => function ($query) {
            return $query->with(['created_employee', 'updated_employee', 'productf'])->where('status', '2');
        }])
            ->where('id', $id)
            ->whereIn('store', StorePermission::auth_store_permission($auth_id))
            ->first();

        // return $purchase;
        if ($purchase || $cancel_list) {
            return view('dashboard.invoice.purchase.purchase_details_view', compact('purchase', 'cancel_list'));
        } else {
            return abort(404);
        }
    }


    public function purchase_manage_print($id)
    {
        $auth_id = Auth::user()->id;
        $purchase = Purchase::with(['purchase_detailsf' => function ($query) {
            return $query->with(['created_employee', 'updated_employee', 'productf'])->where('status', '1');
        }, 'supplierf', 'storef', 'created_employee', 'updated_employee'])
            ->where('id', $id)
            ->whereIn('store', StorePermission::auth_store_permission($auth_id))
            ->first();

        $cancel_list = Purchase::select('id')->with(['purchase_detailsf' => function ($query) {
            return $query->with(['created_employee', 'updated_employee', 'productf'])->where('status', '2');
        }])
            ->where('id', $id)
            ->whereIn('store', StorePermission::auth_store_permission($auth_id))
            ->first();

        // return $purchase;
        if ($purchase || $cancel_list) {

            $pdf = Pdf::loadView('dashboard.invoice.purchase.purchase_details_print', compact('purchase', 'cancel_list'));
            return $pdf->stream('purchase_details.pdf');
        } else {
            return abort(404);
        }
    }

    public function purchase_manage_list()
    {
        $data['permitted_store'] = DB::table('store_permissions as sp')
            ->leftJoin('store_permission_details as spd', 'sp.id', 'spd.sp_id')
            ->leftJoin('stores as s', 'spd.store_id', 's.id')
            ->where('sp.status', '1')->where('sp.emp_id', Auth::user()->id)
            ->where('sp.status', '1')
            ->select(
                's.id',
                's.store_name',
            )
            ->get();

        $auth_id = Auth::user()->id;
        $data['storewise_supplier'] = DB::table('supplier_wise_stores as sws')
            ->leftJoin('supplier_wise_store_details as swsd', 'sws.id', 'swsd.sws_id')
            ->leftJoin('suppliers as s', 'sws.supplier_id', 's.id')
            ->whereIn('swsd.store_id', StorePermission::auth_store_permission($auth_id))
            ->select(
                's.id as supplier_id',
                's.supplier_name'
            )
            ->groupBy(
                's.id',
                's.supplier_name'
            )
            ->get();
        return view('dashboard.invoice.purchase.purchase_list')->with($data);
    }

    public function purchase_showdata()
    {

        $purchase = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(p.date, '%d-%m-%Y'), '%Y-%m-%d')"), date('Y-m-d'))
            ->whereIn('p.store', StorePermission::auth_store_permission(Auth::user()->id))
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

    public function search_purchase_list(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->whereIn('p.store', StorePermission::auth_store_permission(Auth::user()->id))
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
    public function search_purchase_list_print(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->whereIn('p.store', StorePermission::auth_store_permission(Auth::user()->id))
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



    public function approve($id)
    {

        $purchase = DB::table('purchases as p')->where('p.id', $id)
            ->leftJoin('purchase_details as pd', 'p.id', 'pd.purchase_id')
            ->select(
                'p.store',
                'pd.product_id',
                'pd.buying_qty',
                'pd.upwd',
            )
            ->get();

        foreach ($purchase as $pu) {
            $product_details = ProductDetails::where('product_id', $pu->product_id)->where('store_id', $pu->store)->first();
            $new_qty = $pu->buying_qty;
            $prev_qty = $product_details->qty;
            $total_qty = $new_qty + $prev_qty;

            $product_details->qty = $total_qty;
            $product_details->current_buying_price = $pu->upwd;

            $product_details->update();
        }

        $only_purchase = Purchase::find($id);
        $only_purchase->status = '1';
        $only_purchase->updated_by = Auth::user()->id;
        $only_purchase->update();

        if ($only_purchase) {
            return redirect()->back()->with('success', 'Purchase Approve Successfully');
        } else {
            return redirect()->back()->with('error', 'Purchase Approve Failed');
        }
    }

    public function reject($id)
    {
        $only_purchase = Purchase::find($id);
        $only_purchase->status = '2';
        $only_purchase->updated_by = Auth::user()->id;
        $only_purchase->update();

        if ($only_purchase) {
            return redirect()->route('admin.purchase_manage_list')->with('success', 'Purchase Rejected Successfully');
        } else {
            return redirect()->back()->with('error', 'Purchase Rejected Failed');
        }
    }

    public function delete($id)
    {
        $purchase = Purchase::find($id)->delete();
        PurchaseDetails::where('purchase_id', $id)->delete();

        if ($purchase) {
            return redirect()->back()->with('success', 'Purchase Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Purchase Deleted Failed');
        }
    }



    public function purchase_approve_list()
    {

        $data['permitted_store'] = DB::table('store_permissions as sp')
            ->leftJoin('store_permission_details as spd', 'sp.id', 'spd.sp_id')
            ->leftJoin('stores as s', 'spd.store_id', 's.id')
            ->where('sp.status', '1')->where('sp.emp_id', Auth::user()->id)
            ->where('sp.status', '1')
            ->select(
                's.id',
                's.store_name',
            )
            ->get();

        $auth_id = Auth::user()->id;
        $data['storewise_supplier'] = DB::table('supplier_wise_stores as sws')
            ->leftJoin('supplier_wise_store_details as swsd', 'sws.id', 'swsd.sws_id')
            ->leftJoin('suppliers as s', 'sws.supplier_id', 's.id')
            ->whereIn('swsd.store_id', StorePermission::auth_store_permission($auth_id))
            ->select(
                's.id as supplier_id',
                's.supplier_name'
            )
            ->groupBy(
                's.id',
                's.supplier_name'
            )
            ->get();


        return view('dashboard.invoice.purchase.purchase_approve_list')->with($data);
    }


    public function purchase_approve_list_show()
    {
        $purchase = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where('p.status', 1)
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(p.date, '%d-%m-%Y'), '%Y-%m-%d')"), date('Y-m-d'))
            ->whereIn('p.store', StorePermission::auth_store_permission(Auth::user()->id))
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


    public function purchase_approve_list_search(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where('p.status', 1)
            ->whereIn('p.store', StorePermission::auth_store_permission(Auth::user()->id))
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

        $purchase = $query->orderBy('p.id', 'desc')->get();

        return response()->json(['message' => 'Show All Data', 'purchase' => $purchase]);
    }

    public function purchase_approve_list_print(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where('p.status', 1)
            ->whereIn('p.store', StorePermission::auth_store_permission(Auth::user()->id))
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

        $pdf = Pdf::loadView('dashboard.invoice.purchase.purchase_approve_list_print', compact('purchase', 'from_date', 'to_date', 'employee', 'store', 'supplier'));
        return $pdf->stream('purchase_approve_list_print.pdf');
    }



    public function purchase_cancel_list()
    {

        $data['permitted_store'] = DB::table('store_permissions as sp')
            ->leftJoin('store_permission_details as spd', 'sp.id', 'spd.sp_id')
            ->leftJoin('stores as s', 'spd.store_id', 's.id')
            ->where('sp.status', '1')->where('sp.emp_id', Auth::user()->id)
            ->where('sp.status', '1')
            ->select(
                's.id',
                's.store_name',
            )
            ->get();

        $auth_id = Auth::user()->id;
        $data['storewise_supplier'] = DB::table('supplier_wise_stores as sws')
            ->leftJoin('supplier_wise_store_details as swsd', 'sws.id', 'swsd.sws_id')
            ->leftJoin('suppliers as s', 'sws.supplier_id', 's.id')
            ->whereIn('swsd.store_id', StorePermission::auth_store_permission($auth_id))
            ->select(
                's.id as supplier_id',
                's.supplier_name'
            )
            ->groupBy(
                's.id',
                's.supplier_name'
            )
            ->get();


        return view('dashboard.invoice.purchase.purchase_cancel_list')->with($data);
    }


    public function purchase_cancel_list_show()
    {
        $purchase = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where('p.status', 2)
            ->where(DB::raw("DATE_FORMAT(STR_TO_DATE(p.date, '%d-%m-%Y'), '%Y-%m-%d')"), date('Y-m-d'))
            ->whereIn('p.store', StorePermission::auth_store_permission(Auth::user()->id))
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

    public function purchase_cancel_list_search(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where('p.status', 2)
            ->whereIn('p.store', StorePermission::auth_store_permission(Auth::user()->id))
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

        $purchase = $query->orderBy('p.id', 'desc')->get();

        return response()->json(['message' => 'Show All Data', 'purchase' => $purchase]);
    }

    public function purchase_cancel_list_print(Request $request)
    {
        $fromDate = $request->from_date ? date('Y-m-d', strtotime($request->from_date)) : '';
        $toDate = $request->to_date ? date('Y-m-d', strtotime($request->to_date)) : "";
        $query = DB::table('purchases as p')
            ->leftJoin('stores as st', 'p.store', 'st.id')
            ->where('p.status', 2)
            ->whereIn('p.store', StorePermission::auth_store_permission(Auth::user()->id))
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

        $pdf = Pdf::loadView('dashboard.invoice.purchase.purchase_cancel_list_print', compact('purchase', 'from_date', 'to_date', 'employee', 'store', 'supplier'));
        return $pdf->stream('purchase_cancel_list_print.pdf');
    }
}
