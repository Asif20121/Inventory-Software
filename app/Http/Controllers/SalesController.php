<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Invoice;
use App\Models\InvoiceDetails;
use App\Models\Payment;
use App\Models\PaymentDetails;
use App\Models\PaymentType;
use App\Models\ProductDetails;
use App\Repo\InvoiceRepository;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SalesController extends Controller
{

    private $invrep;
    public function __construct(InvoiceRepository $invrepo)
    {
        $this->invrep = $invrepo;
        $this->middleware(['permission:salese_manage.menue'])->only(['salese_manage.menue']);
        $this->middleware(['permission:salese_manage.pos'])->only(['sales_pos','new_customer','new_customer_store','sales_pos_show','sales_pos_show_print','sales_pos_store']);
    }
    public function sales_pos()
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

        $data['payment_type'] = PaymentType::where('status', '1')->get();
        return view('dashboard.invoice.salese.add_new_salese')->with($data);
    }


    public function sales_pos_show(Request $request){
        $data['invoice'] = count($this->invrep->invoice_view($request->id)) > 0 ? $this->invrep->invoice_view($request->id)[0] : false;

        if ($data['invoice'] != false) {
            return view('dashboard.invoice.salese.sales_pos_show')->with($data);
        } else {
            return abort(404);
        }
    }

    public function sales_pos_show_print($id)
    {
        $invoice = count($this->invrep->invoice_view($id)) > 0 ? $this->invrep->invoice_view($id)[0] : false;

        if ($invoice != false) {

            $pdf = Pdf::loadView('dashboard.invoice.salese.invoice_customer_copy_print', compact('invoice'));
            return $pdf->stream('invoice_customer_copy_print.pdf');

        } else {
            return abort(404);
        }
    }

    public function sales_pos_store(Request $request)
    {
        $request->validate([
            'customer_id' => 'required',
            'store' => 'required|max:50',
            'product_name' => 'required',
            'buying_qty' => 'required|max:100000',
            'unit_price' => 'required|max:100000',
            'discount' => 'required|max:100000',
            'upwd' => 'required|max:100000',
            'total_upod' => 'required|max:100000',
            'total_buying_unit_price' => 'required|max:100000',
        ]);

        //Invoice No Generate
        $invoice_number_generate = Invoice::orderBy('id', 'desc')->first();
        $invoice_no = time() + ($invoice_number_generate ? $invoice_number_generate->invoice_no : 0);

        $invoice = new Invoice();
        $invoice->invoice_no = $invoice_no;
        $invoice->date = date('Y-m-d');
        $invoice->description = $request->description;
        $invoice->store_id = $request->store;
        $invoice->status = '1';
        $invoice->created_by = Auth::user()->id;
        $invoice->updated_by = Auth::user()->id;

        $payments_data = DB::transaction(function () use ($request, $invoice) {

            if ($invoice->save()) {
                $product_count = count($request->product_id);
                for ($i = 0; $i < $product_count; $i++) {
                    // Stock quentity
                    $product_details = ProductDetails::where('product_id', $request->product_id[$i])->where('store_id',$request->store)->first();
                    $stock_qty = $product_details->qty;
                    $sell_qty = $request->buying_qty[$i];
                    $current_stock = $stock_qty - $sell_qty;
                    $product_details->qty = $current_stock;
                    $product_details->update();

                    //Invoice Details
                    $invoice_details = new InvoiceDetails();
                    $invoice_details->date = date('Y-m-d');
                    $invoice_details->invoice_id = $invoice->id;
                    $invoice_details->product_id = $request->product_id[$i];
                    $invoice_details->product_name = $request->product_name[$i];
                    $invoice_details->qty = $request->buying_qty[$i];
                    $invoice_details->unit_price = $request->unit_price[$i];
                    $invoice_details->unit_discount = $request->discount[$i];
                    $invoice_details->unit_price_wd = $request->upwd[$i];
                    $invoice_details->selling_price_wod = $request->total_upod[$i];
                    $invoice_details->selling_price_wd = $request->total_buying_unit_price[$i];
                    $invoice_details->status = '1';
                    $invoice_details->created_by = Auth::user()->id;
                    $invoice_details->updated_by = Auth::user()->id;
                    $invoice_details->save();
                }

                $paid_amount = $request->recent_paid_amount_show - (isset($request->refound) ? $request->refound : 0);
                $special_discount = isset($request->special_dis) && $request->special_dis != null ? $request->special_dis : 0;
                $due_amount_sub = $request->grand_total - $paid_amount;


                $payment_details = new PaymentDetails();

                $current_paid_amount=$request->recent_paid_amount_show !='' ? $request->recent_paid_amount_show : 0;
                $refound = $request->refound != '' ? $request->refound : 0;
                $actual_paid = ($current_paid_amount -  $refound) ;

                $payment_details->invoice_id = $invoice->id;
                $payment_details->date = date('Y-m-d');
                $payment_details->current_paid_amount = $current_paid_amount;
                $payment_details->refound = $refound;
                $payment_details->actual_paid = $actual_paid;

                $payment_details->payment_method = $request->payment_method;
                $payment_details->updated_by = Auth::user()->id;
                if($current_paid_amount>0){
                    $payment_details->save();
                }

                $payment = new Payment();

                $payment->invoice_id = $invoice->id;
                $payment->customer_id = $request->customer_id;
                $payment->total_amount = $request->grand_total;
                $payment->paid_amount = $paid_amount;
                $payment->discount_amount = $special_discount;
                $payment->due_amount = $due_amount_sub;
                $payment->paid_status = $due_amount_sub > 0 ? 0 : 1;
                $payment->save();
            }

            return $payment;

        });

        // $data = [
        //     'invoice' => Invoice::with('storef')->find($invoice->id),
        //     'invoice_details' => InvoiceDetails::where('invoice_id', $invoice->id)->get(),
        //     'payment' => Payment::with('customerf')->where('invoice_id', $invoice->id)->first(),
        //     'payment_details' => $payment_details_data,
        // ];

        $invoice_data_id =$payments_data->invoice_id;

        if ($payments_data) {
            return response()->json(['status' => 200, 'message' => "Sales Successfully", 'invoice_data_id' => $invoice_data_id]);
        }

    }

    public function new_customer()
    {

        return view('dashboard.invoice.salese.sales_new_customer');
    }

    public function new_customer_store(Request $request)
    {
        $request->validate([
            'customer_name' => 'max:100|nullable',
            'email' => 'email|max:100|nullable',
            'phone' => 'required|max:20',
            'address' => 'max:250|nullable',
        ]);

        $customer = new Customer();
        $customer->customer_name = $request->customer_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;

        $customer->added_by = Auth::user()->id;
        $customer->updated_by = Auth::user()->id;
        $customer->status = 1;
        $customer->save();

        if ($customer) {
            return response()->json(['customer' => $customer, 'message' => "Data Save Successfully"]);
        }
    }

}
