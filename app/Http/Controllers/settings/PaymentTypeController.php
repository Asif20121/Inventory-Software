<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\PaymentType;
use Auth;

class PaymentTypeController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:payment_type.list'])->only(['list']);
        $this->middleware(['permission:payment_type.create'])->only(['create','store']);
        $this->middleware(['permission:payment_type.edit'])->only(['edit','update']);
        $this->middleware(['permission:payment_type.delete'])->only(['delete']);
    }


    public function list(){
        $data['payment'] = PaymentType::orderBy('id','desc')->get();
        $data['active'] = count(PaymentType::where('status','1')->get());
        $data['inactive'] = count(PaymentType::where('status','!=','1')->get());
        return view('dashboard.setting.payment.payment_list')->with($data);
    }


    public function create(){

        return view('dashboard.setting.payment.create_payment');
    }

    public function store(Request $request){
        $request->validate([
            'type_name' => 'required|max:100',
        ]);
        $payment = new PaymentType();
        $payment->type_name = $request->type_name;
        $payment->added_by = Auth::user()->id;
        $payment->updated_by = Auth::user()->id;
        $payment->status = ( $request->status !='' ? '1':'0');
        $payment->save();

        if ($payment) {
            return redirect()->route('invoice_setting.payment_list')->with('success', 'payment Type added Successfully');
        } else {
            return redirect()->back()->with('error', 'payment Type added Failed');
        }
    }

    public function edit($id){
        $payment = PaymentType::find($id);
        return view('dashboard.setting.payment.create_payment',compact('payment'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'type_name' => 'required|max:100',
        ]);
        $payment = PaymentType::find($id);
        $payment->type_name = $request->type_name;
        $payment->updated_by = Auth::user()->id;
        $payment->status = ( $request->status !='' ? '1':'0');
        $payment->update();

        if ($payment) {
            return redirect()->route('invoice_setting.payment_list')->with('success', 'Payment Type updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Payment Type updated Failed');
        }

    }

    public function delete($id){
        $payment = PaymentType::find($id)->delete();
        if ($payment) {
            return redirect()->route('invoice_setting.payment_list')->with('success', 'Payment Type updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Payment Type updated Failed');
        }
    }
}
