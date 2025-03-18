<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Payment;
use App\Models\PaymentDetails;
use App\Models\PaymentType;
use App\Models\ProductDetails;
use App\Models\Store;
use App\Repo\InvoiceRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class InvoiceController extends Controller
{
    private $invrep;
    public function __construct(InvoiceRepository $invrepo)
    {
        $this->invrep = $invrepo;
        $this->middleware(['permission:salese_manage.invoice_list'])->only(['invoice_list', 'search_invoice_list', 'invoice_list_show', 'invoice_details', 'invoice_details_print']);
        $this->middleware(['permission:salese_manage.edit_invoice'])->only(['edit_invoice', 'edit_invoice_show', 'edit_invoice_update']);
        $this->middleware(['permission:salese_manage.date_wise_cashier_report'])->only(['date_wise_cashier_report', 'date_wise_cashier_report_show', 'date_wise_cashier_report_details', 'date_wise_cashier_report_details_print']);
        $this->middleware(['permission:salese_manage.paid_invoice_list'])->only(['paid_invoice_list', 'paid_invoice_list_show', 'search_paid_invoice_list', 'print_paid_invoice_list']);
        $this->middleware(['permission:salese_manage.due_list'])->only(['due_list', 'due_invoice_list_show', 'due_search_invoice_list', 'due_print_invoice_list']);
        $this->middleware(['permission:salese_manage.due_collection'])->only(['due_collection', 'due_collection_update']);
        $this->middleware(['permission:salese_manage.cancel_invoice'])->only(['cancel_invoice']);
        $this->middleware(['permission:salese_manage.cancel_invoice_list'])->only(['cancel_invoice_list', 'cancel_invoice_list_show', 'cancel_search_invoice_list', 'cancel_print_invoice_list', 'cancel_invoice_details', 'cancel_invoice_details_print']);
        $this->middleware(['permission:salese_manage.reorder_list'])->only(['reorder_list']);
    }
    public function invoice_list()
    {
        $auth_id = Auth::user()->id;

        $store = DB::select("select s.id,s.store_name
         from store_permissions as sp
         left join store_permission_details as spd on spd.sp_id = sp.id
         left join stores as s on spd.store_id = s.id
         where sp.emp_id = $auth_id and sp.status = '1'
         ORDER BY s.id asc
         ");

        return view('dashboard.invoice.salese.invoice_list', compact('store'));
    }

    public function search_invoice_list(Request $request)
    {

        $invoice_details_arr = $this->invrep->inv_search_list($request);

        return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);
    }

    public function invoice_list_show()
    {

        $invoice_details_arr = $this->invrep->inv_list();

        return response()->json(['message' => 'Show All Data', 'invoice_details_arr' => $invoice_details_arr]);
    }

    public function invoice_details($id)
    {
        $data['invoice'] = count($this->invrep->invoice_view($id)) > 0 ? $this->invrep->invoice_view($id)[0] : false;

        if ($data['invoice'] != false) {
            return view('dashboard.invoice.salese.invoice_details_view')->with($data);
        } else {
            return abort(404);
        }
    }

    public function invoice_details_print($id)
    {
        $invoice = count($this->invrep->invoice_view($id)) > 0 ? $this->invrep->invoice_view($id)[0] : false;

        if ($invoice != false) {
            $pdf = Pdf::loadView('dashboard.invoice.salese.invoice_details_print', compact('invoice'));
            return $pdf->stream('invoice_details_print.pdf');

        } else {
            return abort(404);
        }
    }

    public function invoice_customer_copy_view($id)
    {
        $data['invoice'] = count($this->invrep->invoice_view($id)) > 0 ? $this->invrep->invoice_view($id)[0] : false;

        if ($data['invoice'] != false) {
            return view('dashboard.invoice.salese.invoice_customer_copy_view')->with($data);
        } else {
            return abort(404);
        }
    }
    public function invoice_customer_pos_print($id)
    {
        $invoice = count($this->invrep->invoice_view($id)) > 0 ? $this->invrep->invoice_view($id)[0] : false;

        $counting_large_name = 0;
        if (count($invoice['invoice_details']) > 0) {
            foreach ($invoice['invoice_details'] as $item) {
                if (strlen($item->product_name) > 24) {
                    $counting_large_name++;
                }
            }
        }

        $quantity = count($invoice['invoice_details']);
        $totalHeight = ($quantity * 10) + 255 + ($counting_large_name * 10);

        if ($invoice != false) {
            $pdf = Pdf::loadView('dashboard.invoice.salese.invoice_customer_pos_print', compact('invoice'))->setPaper([18, 0, 200, $totalHeight]);
            return $pdf->stream('invoice_customer_pos_print.pdf');
        } else {
            return abort(404);
        }
    }

    public function invoice_customer_copy_view_print($id)
    {
        $invoice = count($this->invrep->invoice_view($id)) > 0 ? $this->invrep->invoice_view($id)[0] : false;

        if ($invoice != false) {
            // return  $invoice;

            $pdf = Pdf::loadView('dashboard.invoice.salese.invoice_customer_copy_print', compact('invoice'));
            return $pdf->stream('invoice_customer_copy_print.pdf');

        } else {
            return abort(404);
        }
    }

    public function print_invoice_list(Request $request)
    {

        $invoice_details_arr = $this->invrep->inv_search_list($request);

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
        $invoice = Invoice::where('id', $request->invoice_id)->select("invoice_no")->first();
        $store = Store::where('id', $request->store_id)->select("store_name", "phone", "email", "web_url", "address")->first();
        $from_date = isset($request->from_date) ? date("Y-m-d", strtotime($request->from_date)) : '';
        $to_date = isset($request->to_date) ? date("Y-m-d", strtotime($request->to_date)) : '';
        $paid_status = isset($request->status_id) && $request->status_id != '' ? $request->status_id : '';

        $pdf = Pdf::loadView('dashboard.invoice.salese.invoice_list_print', compact('invoice_details_arr', 'from_date', 'to_date', 'employee', 'employee', 'customer', 'invoice', 'store', 'paid_status'));
        return $pdf->stream('invoice_list.pdf');

    }

    public function edit_invoice($id)
    {
        $invoice_id = $id;
        $data['invoice_id'] = $invoice_id;

        return view('dashboard.invoice.salese.edit_invoice')->with($data);

    }

    public function edit_invoice_show($id)
    {
        $invoice_id = $id;
        $invoice = count($this->invrep->invoice_edit($invoice_id)) > 0 ? $this->invrep->invoice_edit($invoice_id)[0] : false;

        if ($invoice != false) {
            return response()->json(['message' => 'Show All Data', 'invoice' => $invoice]);
        } else {
            return response()->json(['message' => 'Show All Data', 'invoice' => []]);
        }
    }

    public function edit_invoice_update(Request $request, $id)
    {
        $inv_dett_id_count = count($request->product_id);

        for ($i = 0; $i < $inv_dett_id_count; $i++) {
            $cancel_invd = InvoiceDetails::where('invoice_id', $id)->where('product_id', $request->product_id[$i])->where('status', 2)->selectRaw('sum(qty) as quentity,invoice_id,product_id')->groupBy('invoice_id', 'product_id', 'status')->first();
            $sell_invd = InvoiceDetails::where('invoice_id', $id)->where('product_id', $request->product_id[$i])->where('status', 1)->selectRaw('sum(qty) as quentity,invoice_id,product_id')->groupBy('invoice_id', 'product_id', 'status')->first();

            $exist_items = (isset($sell_invd->quentity) && $sell_invd->quentity != '' ? $sell_invd->quentity : 0) - (isset($cancel_invd->quentity) && $cancel_invd->quentity != '' ? $cancel_invd->quentity : 0);

            $current_item = $exist_items - $request->item_qty[$i];

            $invoice_details = new InvoiceDetails();
            $invoice_details->date = date('Y-m-d');
            $invoice_details->invoice_id = $id;
            $invoice_details->product_id = $request->product_id[$i];
            $invoice_details->product_name = $request->product_name[$i];
            $invoice_details->qty = abs($current_item);
            $invoice_details->unit_price = $request->unit_price[$i];
            $invoice_details->unit_discount = $request->unit_discount[$i];
            $invoice_details->unit_price_wd = $request->unit_price_wd[$i];
            $invoice_details->created_by = Auth::user()->id;
            $invoice_details->updated_by = Auth::user()->id;

            $selling_price_wod = abs($current_item) * $request->unit_price[$i];
            $invoice_details->selling_price_wod = $selling_price_wod;

            $selling_price_wd = (abs($current_item) * $request->unit_price[$i]) - ((abs($current_item) * $request->unit_price[$i] * $request->unit_discount[$i]) / 100);
            $invoice_details->selling_price_wd = $selling_price_wd;

            $product_details = ProductDetails::where('product_id', $request->product_id[$i])->where('store_id', $request->store_id)->first();
            $store_qty = $product_details->qty;

            if ($current_item > 0) {
                $invoice_details->status = 2;
                $invoice_details->save();

                $product_details->qty = $store_qty + abs($current_item);
                $product_details->update();

            } else if ($current_item < 0) {
                $invoice_details->status = 1;
                $invoice_details->save();

                $product_details->qty = $store_qty - abs($current_item);
                $product_details->update();

            }
        }

        $cancel_payment = $request->cancel_payment ? $request->cancel_payment : [];
        $payment_d_id = $request->payment_id ? $request->payment_id : [];
        $payment_d_id_count = count($payment_d_id);
        for ($j = 0; $j < $payment_d_id_count; $j++) {
            if ($cancel_payment[$j] == 0) {
                $payment_details = PaymentDetails::find($payment_d_id[$j]);
                $payment_details->cancel_date = date('Y-m-d');
                $payment_details->cancel_by = Auth::user()->id;
                $payment_details->status = 2;
                $payment_details->update();
            }
        }
        $current_return_amount = $request->current_return_amount != '' ? $request->current_return_amount : 0;

        if ($current_return_amount > 0 && $request->due_amount == 0) {

            $payment_details_for_return = new PaymentDetails();
            $payment_details_for_return->invoice_id = $id;
            $payment_details_for_return->date = date('Y-m-d');
            $payment_details_for_return->current_paid_amount = 0;
            $payment_details_for_return->refound = $current_return_amount;
            $payment_details_for_return->actual_paid = (-$current_return_amount);
            $payment_details_for_return->updated_by = Auth::user()->id;
            $payment_details_for_return->status = 1;

            $payment_details_for_return->save();

        }

        $payable_amount = $request->grand_total != '' ? $request->grand_total : 0;
        $paid_amount = $request->paid_amount != '' ? $request->paid_amount : 0;

        $payment = Payment::where('invoice_id', $id)->first();
        $payment->total_amount = $payable_amount;
        $payment->paid_amount = $paid_amount;
        $payment->discount_amount = $request->special_discount != '' ? $request->special_discount : 0;
        $payment->due_amount = $request->due_amount != '' ? $request->due_amount : 0;

        if ($request->due_amount == 0 || $request->due_amount == '') {
            $payment->paid_status = 1;
        } else {
            $payment->paid_status = 0;
        }
        $payment->update();

        $invoice = Invoice::find($id);

        $invoice->description = $request->description;
        $invoice->updated_by = Auth::user()->id;
        $invoice->updated_at = date('Y-m-d');
        $invoice->update();
        return response()->json(['message' => 'Save successfully', 'invoice_id' => $invoice->id]);
    }

    public function date_wise_cashier_report()
    {

        $auth_id = Auth::user()->id;

        $store = DB::select("select s.id,s.store_name
         from store_permissions as sp
         left join store_permission_details as spd on spd.sp_id = sp.id
         left join stores as s on spd.store_id = s.id
         where sp.emp_id = $auth_id and sp.status = '1'
         ORDER BY s.id asc
         ");

        return view('dashboard.invoice.salese.date_wise_casire_report', compact('store'));
    }

    public function date_wise_cashier_report_show()
    {
        $invoice_details_arr = $this->invrep->date_wise_cashier_report();

        return response()->json(['message' => 'Show All Data', 'invoice_details_arr' => $invoice_details_arr]);
    }

    public function date_wise_cashier_report_details($id)
    {
        $data['invoice'] = count($this->invrep->invoice_view($id)) > 0 ? $this->invrep->invoice_view($id)[0] : false;

        if ($data['invoice'] != false) {
            return view('dashboard.invoice.salese.date_wise_cashier_report_details')->with($data);
        } else {
            return abort(404);
        }
    }

    public function date_wise_cashier_report_details_print($id)
    {
        $invoice = count($this->invrep->invoice_view($id)) > 0 ? $this->invrep->invoice_view($id)[0] : false;

        if ($invoice != false) {
            $pdf = Pdf::loadView('dashboard.invoice.salese.date_wise_cashier_report_details_print', compact('invoice'));
            return $pdf->stream('date_wise_cashier_report_details_print.pdf');

        } else {
            return abort(404);
        }
    }

    public function search_date_wise_cashier_report(Request $request)
    {

        $invoice_details_arr = $this->invrep->search_date_wise_cashier_report($request);

        return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);
    }

    public function print_date_wise_cashier_report(Request $request)
    {

        $invoice_details_arr = $this->invrep->search_date_wise_cashier_report($request);

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

        $pdf = Pdf::loadView('dashboard.invoice.salese.date_wise_casire_report_list_print', compact('invoice_details_arr', 'from_date', 'to_date', 'employee', 'invoice', 'store'));
        return $pdf->stream('invoice_details_arr.pdf');

    }
    public function paid_invoice_list()
    {
        $auth_id = Auth::user()->id;

        $store = DB::select("select s.id,s.store_name
         from store_permissions as sp
         left join store_permission_details as spd on spd.sp_id = sp.id
         left join stores as s on spd.store_id = s.id
         where sp.emp_id = $auth_id and sp.status = '1'
         ORDER BY s.id asc
         ");

        return view('dashboard.invoice.salese.paid_invoice_list', compact('store'));
    }
    public function paid_invoice_list_show()
    {

        $invoice_details_arr = $this->invrep->paid_inv_list();

        return response()->json(['message' => 'Show All Data', 'invoice_details_arr' => $invoice_details_arr]);
    }

    public function search_paid_invoice_list(Request $request)
    {
        $invoice_details_arr = $this->invrep->paid_inv_search_list($request);

        return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);
    }

    public function print_paid_invoice_list(Request $request)
    {

        $invoice_details_arr = $this->invrep->paid_inv_search_list($request);

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

        $pdf = Pdf::loadView('dashboard.invoice.salese.paid_invoice_list_print', compact('invoice_details_arr', 'from_date', 'to_date', 'employee', 'employee', 'customer', 'invoice', 'store', 'paid_status'));
        return $pdf->stream('paid_invoice_list_print.pdf');

    }

    public function invoice_per_payment($id)
    {
        $payment_details = PaymentDetails::with(['invoicef.invoice_detailsf', 'invoicef.paymentf.customerf', 'invoicef.storef'])->find($id);
        return view('dashboard.invoice.salese.invoice_per_payment', compact('payment_details'));
    }

    public function due_list()
    {
        $auth_id = Auth::user()->id;

        $store = DB::select("select s.id,s.store_name
         from store_permissions as sp
         left join store_permission_details as spd on spd.sp_id = sp.id
         left join stores as s on spd.store_id = s.id
         where sp.emp_id = $auth_id and sp.status = '1'
         ORDER BY s.id asc
         ");

        return view('dashboard.invoice.salese.due_list', compact('store'));
    }

    public function due_invoice_list_show()
    {
        $invoice_details_arr = $this->invrep->due_inv_list();

        return response()->json(['message' => 'Show All Data', 'invoice_details_arr' => $invoice_details_arr]);
    }

    public function due_search_invoice_list(Request $request)
    {

        $invoice_details_arr = $this->invrep->search_due_inv_list($request);

        return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);
    }
    public function due_print_invoice_list(Request $request)
    {
        // return $request->all();

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

        $invoice_details_arr = $this->invrep->search_due_inv_list($request);

        // return $invoice_details_arr;
        $pdf = Pdf::loadView('dashboard.invoice.salese.due_invoice_list_print', compact('invoice_details_arr', 'from_date', 'to_date', 'employee', 'employee', 'customer', 'invoice', 'store'));
        return $pdf->stream('invoice_details_arr.pdf');
    }

    public function due_collection($id)
    {
        $data['invoice'] = count($this->invrep->due_collection($id)) > 0 ? $this->invrep->due_collection($id)[0] : false;

        $data['payment_type'] = PaymentType::where('status', '1')->get();
        if ($data['invoice'] != false) {
            return view('dashboard.invoice.salese.due_collection')->with($data);
        } else {
            return abort(404);
        }

    }

    public function due_collection_update(Request $request)
    {

        $current_paid_amount = $request->current_paid_amount != '' ? $request->current_paid_amount : 0;
        $refound = isset($request->refound) && $request->refound != '' ? $request->refound : 0;
        $actual_paid = ($current_paid_amount - $refound);

        $payment_details = new PaymentDetails();

        $payment_details->invoice_id = $request->invoice_id;
        $payment_details->date = date('Y-m-d');
        $payment_details->current_paid_amount = $current_paid_amount;
        $payment_details->refound = $refound;
        $payment_details->actual_paid = $actual_paid;
        $payment_details->payment_method = $request->payment_method;
        $payment_details->updated_by = Auth::user()->id;
        $payment_details->status = 1;
        $payment_details->save();

        $payment = Payment::where('invoice_id', $request->invoice_id)->first();
        $prev_total_amount = $payment->total_amount;
        $prev_paid_amount = $payment->paid_amount;

        $final_paid_amount = $prev_paid_amount + ($request->current_paid_amount - (isset($request->refound) ? $request->refound : 0));
        $final_due_amount = $prev_total_amount - $final_paid_amount;
        $final_paid_status = $final_due_amount > 0 ? 0 : 1;

        $payment->paid_amount = $final_paid_amount;
        $payment->due_amount = $final_due_amount;
        $payment->paid_status = $final_paid_status;
        $payment->update();

        if ($payment_details && $payment) {
            return redirect()->route('admin.due_list')->with('success', 'Due Collection Successfully');
        } else {
            return redirect()->back()->with('error', 'Due Collection Failed');
        }
    }

    public function due_invoice_details($id)
    {
        $data['invoice'] = count($this->invrep->due_collection($id)) > 0 ? $this->invrep->due_collection($id)[0] : false;

        if ($data['invoice'] != false) {
            return view('dashboard.invoice.salese.due_invoice_details_view')->with($data);
        } else {
            return abort(404);
        }
    }

    public function due_invoice_details_print($id)
    {
        $invoice = count($this->invrep->due_collection($id)) > 0 ? $this->invrep->due_collection($id)[0] : false;

        if ($invoice != false) {
            // return $data['invoice'];
            $pdf = Pdf::loadView('dashboard.invoice.salese.due_invoice_details_print', compact('invoice'));
            return $pdf->stream('due_invoice_details_print.pdf');

        } else {
            return abort(404);
        }
    }

    public function due_invoice_customer_copy_view($id)
    {
        $data['invoice'] = count($this->invrep->due_collection($id)) > 0 ? $this->invrep->due_collection($id)[0] : false;

        if ($data['invoice'] != false) {
            return view('dashboard.invoice.salese.due_invoice_customer_copy_view')->with($data);
        } else {
            return abort(404);
        }
    }

    public function due_invoice_customer_copy_view_print($id)
    {
        $invoice = count($this->invrep->due_collection($id)) > 0 ? $this->invrep->due_collection($id)[0] : false;

        if ($invoice != false) {
            // return  $invoice;

            $pdf = Pdf::loadView('dashboard.invoice.salese.due_invoice_customer_copy_print', compact('invoice'));
            return $pdf->stream('due_invoice_customer_copy_print.pdf');

        } else {
            return abort(404);
        }
    }

    public function cancel_invoice($id)
    {

        $invoice = Invoice::with('paymentf')->findOrFail($id);

        $invoice_details = InvoiceDetails::where('invoice_id', $id)->select('id', 'invoice_id', 'product_id', 'product_name', 'qty')->get();

        foreach ($invoice_details as $ind) {
            $cancel_invd = InvoiceDetails::where('invoice_id', $id)->where('product_id', $ind->product_id)->where('status', 2)->selectRaw('sum(qty) as quentity,invoice_id,product_id')->groupBy('invoice_id', 'product_id', 'status')->first();
            $sell_invd = InvoiceDetails::where('invoice_id', $id)->where('product_id', $ind->product_id)->where('status', 1)->selectRaw('sum(qty) as quentity,invoice_id,product_id')->groupBy('invoice_id', 'product_id', 'status')->first();

            $exist_items = (isset($sell_invd->quentity) && $sell_invd->quentity != '' ? $sell_invd->quentity : 0) - (isset($cancel_invd->quentity) && $cancel_invd->quentity != '' ? $cancel_invd->quentity : 0);

            $product_details = ProductDetails::where('product_id', $ind->product_id)->where('store_id', $invoice->store_id)->first();
            $store_qty = $product_details->qty;

            $product_details->qty = ($store_qty + $exist_items);
            $product_details->update();

        }

        $invoice->status = 2;
        $invoice->updated_by = Auth::user()->id;
        $invoice->update();

        $payment = Payment::where('invoice_id', $id)->first();
        $payment->paid_status = 2;
        $payment->update();

        if ($product_details && $payment && $invoice) {
            return redirect()->back()->with('success', 'Invoice Cancel Success');
        } else {
            return redirect()->back()->with('error', 'Invoice Cancel Fail');
        }

    }

    public function cancel_invoice_list()
    {
        $auth_id = Auth::user()->id;

        $store = DB::select("select s.id,s.store_name
         from store_permissions as sp
         left join store_permission_details as spd on spd.sp_id = sp.id
         left join stores as s on spd.store_id = s.id
         where sp.emp_id = $auth_id and sp.status = '1'
         ORDER BY s.id asc
         ");

        return view('dashboard.invoice.salese.cancel_list', compact('store'));
    }

    public function cancel_invoice_list_show()
    {
        $invoice_details_arr = $this->invrep->cancel_inv_list();

        return response()->json(['message' => 'Show All Data', 'invoice_details_arr' => $invoice_details_arr]);
    }

    public function cancel_search_invoice_list(Request $request)
    {

        $invoice_details_arr = $this->invrep->search_cancel_inv_list($request);

        return response()->json(['message' => 'Show All Data', 'invoice_list' => $invoice_details_arr]);
    }

    public function cancel_print_invoice_list(Request $request)
    {
        // return $request->all();

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

        $invoice_details_arr = $this->invrep->search_cancel_inv_list($request);

        // return $invoice_details_arr;
        $pdf = Pdf::loadView('dashboard.invoice.salese.cancel_invoice_list_print', compact('invoice_details_arr', 'from_date', 'to_date', 'employee', 'employee', 'customer', 'invoice', 'store'));
        return $pdf->stream('cancel_invoice_list_print.pdf');
    }

    public function cancel_invoice_details($id)
    {
        $data['invoice'] = count($this->invrep->cancel_inv_details($id)) > 0 ? $this->invrep->cancel_inv_details($id)[0] : false;

        if ($data['invoice'] != false) {
            return view('dashboard.invoice.salese.cancel_invoice_details_view')->with($data);
        } else {
            return abort(404);
        }
    }

    public function cancel_invoice_details_print($id)
    {
        $invoice = count($this->invrep->cancel_inv_details($id)) > 0 ? $this->invrep->cancel_inv_details($id)[0] : false;

        if ($invoice != false) {
            $pdf = Pdf::loadView('dashboard.invoice.salese.cancel_invoice_details_print', compact('invoice'));
            return $pdf->stream('cancel_invoice_details_print.pdf');

        } else {
            return abort(404);
        }
    }

    public function reorder_list(Request $request)
    {
        $rstore = $request->store;
        $rcategory = $request->category;

        if ($request->ajax()) {

            $sql_cond = "";
            $clause = " and";
            $sql_cond .= $rstore != "" ? " $clause s.id = $rstore" : "";
            $clause = " and";
            $sql_cond .= $rcategory != "" ? " $clause ct.id = $rcategory" : "";

            $auth_id = Auth::user()->id;
            $query = DB::select("SELECT pd.id,s.store_name,p.product_name,p.product_code,p.reorder_qty,ct.category_name,un.unit_name,pd.qty,pd.current_sales_price,pd.discount,ad_create.name as add_by,up_create.name as update_by,pd.status, DATE_FORMAT(pd.created_at, '%d-%M-%Y') as create_date, DATE_FORMAT(pd.updated_at, '%d-%M-%Y') as update_date from product_details as pd left join products as p on pd.product_id=p.id left join stores as s on s.id=pd.store_id left join units as un on un.id=p.unit_id left join categories as ct on ct.id=p.category_id left join admins as ad_create on ad_create.id=pd.added_by left join admins as up_create on up_create.id=pd.updated_by where p.status=1 and pd.status = 1 and pd.store_id IN (select s.id from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id left join stores as s on spd.store_id = s.id where sp.emp_id = $auth_id and sp.status = '1' ) and   p.reorder_qty>pd.qty $sql_cond ORDER BY p.product_name ASC ");

            return DataTables::collection($query)->addIndexColumn()->toJson();
        }

        $auth_id = Auth::user()->id;
        $store = DB::select("select s.id,s.store_name  from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id left join stores as s on spd.store_id = s.id where sp.emp_id = $auth_id and sp.status = '1' ORDER BY s.id asc ");
        $category = Category::orderBy('category_name', 'asc')->select('id', 'category_name')->get();

        return view('dashboard.invoice.salese.reorder_list', compact('store', 'category'));
    }

    public function reorder_list_print(Request $request)
    {
        $rstore = $request->store_filter;
        $rcategory = $request->category_filter;

        $sql_cond = "";
        $clause = " and";
        $sql_cond .= $rstore != "" ? " $clause s.id = $rstore" : "";
        $clause = " and";
        $sql_cond .= $rcategory != "" ? " $clause ct.id = $rcategory" : "";

        $auth_id = Auth::user()->id;
        $reorder_list = DB::select("SELECT pd.id,s.store_name,p.product_name,p.product_code,p.reorder_qty,ct.category_name,un.unit_name,pd.qty,pd.current_sales_price,pd.discount from product_details as pd left join products as p on pd.product_id=p.id left join stores as s on s.id=pd.store_id left join units as un on un.id=p.unit_id left join categories as ct on ct.id=p.category_id left join admins as ad_create on ad_create.id=pd.added_by left join admins as up_create on up_create.id=pd.updated_by where p.status=1 and pd.status = 1 and pd.store_id IN (select s.id from store_permissions as sp left join store_permission_details as spd on spd.sp_id = sp.id left join stores as s on spd.store_id = s.id where sp.emp_id = $auth_id and sp.status = '1' ) and   p.reorder_qty>pd.qty $sql_cond ORDER BY p.product_name ASC ");

        $store = Store::find($rstore);
        $category = Category::find($rcategory);



        if ($reorder_list) {
            $pdf = Pdf::loadView('dashboard.invoice.salese.reorder_list_print', compact('reorder_list', 'store', 'category'));
            return $pdf->stream('reorder_list_print.pdf');
        } else {
            return abort(404);
        }

    }
}
