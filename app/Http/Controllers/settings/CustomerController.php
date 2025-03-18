<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class CustomerController extends Controller
{

    public function __construct()
    {
        $this->middleware(['permission:customer.list'])->only(['list']);
        $this->middleware(['permission:customer.create'])->only(['create','store']);
        $this->middleware(['permission:customer.edit'])->only(['edit','update']);
        $this->middleware(['permission:customer.delete'])->only(['delete']);
    }

    function list(Request $request) {
        $customer = Customer::orderBy('id', 'desc');

        $data['active'] = count(Customer::where('status', '1')->get());
        $data['inactive'] = count(Customer::where('status', '!=', '1')->get());

        if ($request->ajax()) {
            return DataTables::eloquent($customer)
                ->addIndexColumn()
                ->addColumn('contact', function ($data) {
                    $contact['email']  =isset($data['email']) ? $data['email'] : '';
                    $contact['phone']  =isset($data['phone']) ? $data['phone'] : '';
                     return $contact;
                 })

                 ->addColumn('create', function ($data) {
                    $name =$data->created_employee->name;
                    $date = date('d F Y', strtotime($data->created_at));

                    $create=$name.'<br>'.$date;
                     return $create;
                 })
                 ->addColumn('update', function ($data) {
                    $name =$data->updated_employee->name;
                    $date = date('d F Y', strtotime($data->updated_at));

                    $create=$name.'<br>'.$date;
                     return $create;
                 })

                 ->addColumn('action', function ($data) {
                    $route_data['editUrl'] = route('invoice_setting.customer_edit', $data->id);
                    $route_data['deleteUrl'] = route('invoice_setting.customer_delete', $data->id);
                    return $route_data;
                })
                ->rawColumns(['contact','create','update','action'])
                ->toJson();
        }

        return view('dashboard.setting.customer.customer_list')->with($data);
    }

    public function create()
    {

        return view('dashboard.setting.customer.create_customer');
    }

    public function store(Request $request)
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
        $customer->status = ($request->status != '' ? '1' : '0');
        $customer->save();

        if ($customer) {
            return redirect()->route('invoice_setting.customer_list')->with('success', 'customer added Successfully');
        } else {
            return redirect()->back()->with('error', 'customer added Failed');
        }
    }

    public function edit($id)
    {
        $customer = Customer::find($id);
        return view('dashboard.setting.customer.create_customer', compact('customer'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'customer_name' => 'max:100|nullable',
            'email' => 'email|max:100|nullable',
            'phone' => 'required|max:20',
            'address' => 'max:250|nullable',
        ]);

        $customer = Customer::find($id);
        $customer->customer_name = $request->customer_name;
        $customer->email = $request->email;
        $customer->phone = $request->phone;
        $customer->address = $request->address;

        $customer->updated_by = Auth::user()->id;
        $customer->status = ($request->status != '' ? '1' : '0');
        $customer->update();

        if ($customer) {
            return redirect()->route('invoice_setting.customer_list')->with('success', 'customer updated Successfully');
        } else {
            return redirect()->back()->with('error', 'customer updated Failed');
        }

    }

    public function delete($id)
    {
        $count = Payment::where('customer_id', $id)->get()->count();
        if ($count == 0) {
            $category = Customer::find($id)->delete();
            if ($category) {
                return redirect()->route('invoice_setting.customer_list')->with('success', 'Customer Deleted Successfully');
            }else{
                return redirect()->back()->with('error', 'Customer Deleted Failed');
            }
        }
        return redirect()->back()->with('error', 'Customer Already Use in Another Module');

    }
}
