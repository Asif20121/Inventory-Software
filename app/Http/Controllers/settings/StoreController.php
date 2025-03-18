<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Store;
use Illuminate\Support\Facades\Auth;

class StoreController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:store.list'])->only(['list','view']);
        $this->middleware(['permission:store.create'])->only(['create','store']);
        $this->middleware(['permission:store.edit'])->only(['edit','update']);
    }


    public function view($id){

        $store_info = Store::find($id);

        return view('dashboard.setting.store.store_view',compact('store_info'));

    }
    public function list(){
        $data['store'] = Store::orderBy('id','desc')->get();
        $data['active'] = count(Store::where('status','1')->get());
        $data['inactive'] = count(Store::where('status','!=','1')->get());

        return view('dashboard.setting.store.store_list')->with($data);
    }


    public function create(){

        return view('dashboard.setting.store.create_store');
    }

    public function store(Request $request){
        $request->validate([
            'store_name' => 'required|max:100|nullable',
            'address' => 'max:1000|nullable',
            'description' => 'max:1000|nullable',
        ]);
        $store = new Store();
        $store->store_name = $request->store_name;
        $store->phone = $request->phone;
        $store->email = $request->email;
        $store->web_url = $request->web_url;
        $store->address = $request->address;
        $store->description = $request->description;

        $store->added_by = Auth::user()->id;
        $store->updated_by = Auth::user()->id;
        $store->status = ( $request->status !='' ? '1':'0');
        $store->save();

        if ($store) {
            return redirect()->route('invoice_setting.store_list')->with('success', 'store added Successfully');
        } else {
            return redirect()->back()->with('error', 'store added Failed');
        }
    }

    public function edit($id){
        $store = Store::find($id);
        return view('dashboard.setting.store.create_store',compact('store'));
    }

    public function update(Request $request,$id){
        $request->validate([
            'store_name' => 'required|max:100|nullable',
            'address' => 'max:1000|nullable',
            'description' => 'max:1000|nullable',
        ]);

        $store = Store::find($id);
        $store->store_name = $request->store_name;
        $store->phone = $request->phone;
        $store->email = $request->email;
        $store->web_url = $request->web_url;
        $store->address = $request->address;
        $store->description = $request->description;

        $store->updated_by = Auth::user()->id;
        $store->status = ( $request->status !='' ? '1':'0');
        $store->update();

        if ($store) {
            return redirect()->route('invoice_setting.store_list')->with('success', 'Store updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Store updated Failed');
        }

    }

    public function delete($id){
        $store = Store::find($id)->delete();
        if ($store) {
            return redirect()->route('invoice_setting.store_list')->with('success', 'Store Deleted Successfully');
        } else {
            return redirect()->back()->with('error', 'Store Deleted Failed');
        }
    }
}
