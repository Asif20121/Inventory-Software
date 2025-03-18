<?php

namespace App\Http\Controllers\settings;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductDetails;
use App\Models\Store;
use App\Models\Unit;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->middleware(['permission:product.list'])->only(['list', 'product_barcode', 'product_view', 'product_print']);
        $this->middleware(['permission:product.create'])->only(['create', 'store']);
        $this->middleware(['permission:product.edit'])->only(['edit', 'update']);
        $this->middleware(['permission:product.product_wise_store'])->only(['product_wise_store', 'open_product_wise_store', 'open_product_wise_store_save', 'open_product_wise_store_edit', 'open_product_wise_store_update']);
        $this->middleware(['permission:product.store_wise_product_list'])->only(['sw_list', 'sw_view', 'sw_print']);
        $this->middleware(['permission:product.store_wise_product_edit'])->only(['sw_edit', 'sw_update']);
    }

    function list(Request $request) {
        $data['active'] = count(Product::where('status', '1')->get());
        $data['inactive'] = count(Product::where('status', '!=', '1')->get());

        if ($request->ajax()) {
            $product = Product::orderBy('id', 'desc');

            if ($request->category != '') {
                $product->where('category_id', $request->category);
            }

            if ($request->unit != '') {
                $product->where('unit_id', $request->unit);
            }

            return DataTables::eloquent($product)
                ->addIndexColumn()
                ->addColumn('info', function ($data) {
                    $info['product_name'] = isset($data['product_name']) ? $data['product_name'] : '';
                    $info['product_code'] = isset($data['product_code']) ? $data['product_code'] : '';
                    return $info;
                })
                ->addColumn('unit_name', function ($data) {
                    $unit = isset($data['unit']['unit_name']) ? $data['unit']['unit_name'] : '';
                    return $unit;
                })
                ->addColumn('category', function ($data) {
                    $category = isset($data['category']['category_name']) ? $data['category']['category_name'] : '';
                    return $category;
                })
                ->addColumn('update', function ($data) {
                    $name = $data->updated_employee->name;
                    $date = date('d F Y', strtotime($data->updated_at));

                    $create = $name . '<br>' . $date;
                    return $create;
                })

                ->addColumn('action', function ($data) {
                    $route_data['product_view'] = route('invoice_setting.product_view', $data->id);
                    $route_data['editUrl'] = route('invoice_setting.product_edit', $data->id);
                    $route_data['store'] = route('invoice_setting.product_wise_store', $data->id);
                    $route_data['product_barcode'] = route('invoice_setting.product_barcode', $data->id);
                    return $route_data;
                })
                ->rawColumns(['info', 'unit_name', 'create', 'update', 'action'])
                ->toJson();
        }

        $data['category'] = Category::orderBy('category_name', 'asc')->select('id', 'category_name')->get();
        $data['unit'] = Unit::orderBy('unit_name', 'asc')->select('id', 'unit_name')->get();
        return view('dashboard.setting.product.product_list')->with($data);
    }

    public function product_barcode($id)
    {
        $product_code = Product::find($id);

        if ($product_code) {
            $size = array(0, 0, 165, 55);
            $pdf = Pdf::loadView('dashboard.setting.product.product_barcode', compact('product_code'))->setPaper($size);
            return $pdf->stream('product_barcode.pdf');
        } else {
            return abort(404);
        }

    }

    public function product_wise_store($id)
    {

        $data['active'] = count(ProductDetails::where('product_id', $id)->where('status', '1')->get());
        $data['inactive'] = count(ProductDetails::where('product_id', $id)->where('status', '!=', '1')->get());
        $data['product'] = Product::find($id);
        $data['product_wise_store'] = DB::table('product_details as pd')->where('pd.product_id', $id)
            ->leftJoin('stores as s', 'pd.store_id', 's.id')
            ->leftJoin('admins as ac', 'pd.added_by', 'ac.id')
            ->leftJoin('admins as au', 'pd.updated_by', 'au.id')
            ->select(
                'pd.id',
                'pd.qty',
                'pd.current_buying_price',
                'pd.current_sales_price',
                'pd.discount',
                'pd.status',
                'pd.created_at',
                'pd.updated_at',
                's.store_name',
                'ac.name as created_by',
                'au.name as updated_by',
            )
            ->orderBy('pd.id', 'desc')
            ->get();

        return view('dashboard.setting.product.product_wise_store')->with($data);
    }

    public function open_product_wise_store($id)
    {
        $data['product_id'] = $id;
        $data['store'] = Store::orderBy('id', 'desc')->where('status', '1')
            ->whereNotIn('id', function ($query) use ($id) {
                $query->select('store_id')
                    ->from('product_details')
                    ->where('product_id', $id);
            })
            ->get();
        return view('dashboard.setting.product.add_store_wise_product')->with($data);
    }

    public function open_product_wise_store_save(Request $request)
    {

        $request->validate([
            'store' => 'required',
        ]);

        $count = ProductDetails::where('product_id', $request->product_id)->where('store_id', $request->store)->get()->count();

        if ($count > 0) {
            return response()->json(['status' => 404, 'error' => "Store Already Exist"]);
        } else {
            $product_details = new ProductDetails();

            $product_details->product_id = $request->product_id;
            $product_details->store_id = $request->store;
            $product_details->current_buying_price = $request->buying_price != null ? $request->buying_price : '0';
            $product_details->current_sales_price = $request->sales_price != null ? $request->sales_price : '0';
            $product_details->discount = $request->discount != null ? $request->discount : '0';

            $product_details->status = $request->status ? $request->status : '0';
            $product_details->added_by = Auth::user()->id;
            $product_details->updated_by = Auth::user()->id;
            $product_details->save();

            return response()->json(['status' => 200, 'message' => "Data Save Successfully"]);
        }

    }

    public function open_product_wise_store_edit($id)
    {
        $data['product_id'] = $id;
        $data['store'] = Store::orderBy('id', 'desc')->where('status', '1')->get();
        $data['product_details'] = ProductDetails::find($id);
        return view('dashboard.setting.product.add_store_wise_product')->with($data);
    }

    public function open_product_wise_store_update(Request $request, $id)
    {
        $product_details = ProductDetails::find($id);
        $product_details->current_buying_price = $request->buying_price != null ? $request->buying_price : '0';
        $product_details->current_sales_price = $request->sales_price != null ? $request->sales_price : '0';
        $product_details->discount = $request->discount != null ? $request->discount : '0';

        $product_details->status = $request->status ? $request->status : '0';
        $product_details->updated_by = Auth::user()->id;
        $product_details->update();

        return response()->json(['status' => 200, 'message' => "Data Update Successfully"]);
    }

    public function open_product_wise_store_delete($id)
    {
        $product_details = ProductDetails::find($id)->delete();

        if ($product_details) {
            return redirect()->back()->with('success', 'Data Delete Successfulluy');
        }
    }

    public function create()
    {
        $data['unit'] = Unit::orderBy('id', 'desc')->where('status', '1')->get();
        $data['category'] = Category::orderBy('id', 'desc')->where('status', '1')->get();
        $data['store'] = Store::orderBy('id', 'desc')->where('status', '1')->get();
        return view('dashboard.setting.product.create_product')->with($data);
    }

    public function store(Request $request)
    {



        $request->validate([
            'product_name' => 'required|max:100',
            'unit_id' => 'required|numeric|max:100',
            'category_id' => 'required|numeric|max:100',
            'description' => 'max:1000|nullable',
            'reorder_qty' => 'nullable|numeric|max:100',
        ]);


        $count = count(Product::all());
        if ($count == null) {
            $firstReg = '0';
            $product_code = $firstReg + 1;
        } else {
            $product_id = Product::orderBy('id', 'desc')->first()->id;
            $product_code = $product_id + 1;
        }

        $product = new Product();
        $product->product_name = $request->product_name;
        $product->product_code = 'pro-00' . $product_code;
        $product->unit_id = $request->unit_id;
        $product->category_id = $request->category_id;
        $product->description = $request->description;
        $product->status = ($request->status != '' ? '1' : '0');
        $product->reorder_qty = ($request->reorder_qty > 0 ? $request->reorder_qty : 10);

        $product->added_by = Auth::user()->id;
        $product->updated_by = Auth::user()->id;
        $product->save();

        DB::transaction(function () use ($request, $product) {
            if ($product->save()) {
                $store_count = count($request->store_id ? $request->store_id : []);

                if ($store_count != 0) {
                    for ($i = 0; $i < $store_count; $i++) {

                        $product_details = new ProductDetails();

                        $product_details->product_id = $product->id;

                        $product_details->store_id = $request->store_id[$i];
                        $product_details->current_sales_price = $request->sell_price[$i] != null ? $request->sell_price[$i] : '0';
                        $product_details->discount = $request->discount[$i] != null ? $request->discount[$i] : '0';

                        $product_details->status = '1';
                        $product_details->added_by = Auth::user()->id;
                        $product_details->updated_by = Auth::user()->id;
                        $product_details->save();
                    }

                }

            }

        });

        if ($product) {
            return redirect()->route('invoice_setting.product_list')->with('success', 'Product added Successfully');
        } else {
            return redirect()->back()->with('error', 'Product added Failed');
        }
    }

    public function edit($id)
    {

        $data['unit'] = Unit::orderBy('id', 'desc')->where('status', '1')->get();
        $data['category'] = Category::orderBy('id', 'desc')->where('status', '1')->get();
        $data['store'] = Store::orderBy('id', 'desc')->where('status', '1')->get();

        $data['product'] = Product::find($id);
        return view('dashboard.setting.product.create_product')->with($data);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_name' => 'required|max:100',
            'unit_id' => 'required|numeric|max:100',
            'category_id' => 'required|numeric|max:100',
            'description' => 'max:1000|nullable',
        ]);

        $product = Product::find($id);
        $product->product_name = $request->product_name;
        $product->unit_id = $request->unit_id;
        $product->category_id = $request->category_id;
        $product->description = $request->description;

        $product->added_by = Auth::user()->id;
        $product->updated_by = Auth::user()->id;
        $product->status = ($request->status != '' ? '1' : '0');
        $product->reorder_qty = ($request->reorder_qty > 0 ? $request->reorder_qty : 10);
        $product->update();

        if ($product) {
            return redirect()->route('invoice_setting.product_list')->with('success', 'Product Update Successfully');
        } else {
            return redirect()->back()->with('error', 'Product Update Failed');
        }

    }

    public function delete($id)
    {
        $product = Product::find($id)->delete();
        ProductDetails::where('id', $id)->delete();
        if ($product) {
            return redirect()->back()->with('success', 'Product updated Successfully');
        } else {
            return redirect()->back()->with('error', 'Product updated Failed');
        }
    }

    public function sw_list(Request $request)
    {
        $rstore = $request->store;
        $rcategory = $request->category;
        $runit = $request->unit;

        if ($request->ajax()) {

            $sql_cond = "";
            $clause = " where";
            $sql_cond .= $rstore != "" ? " $clause s.id = $rstore" : "";
            $clause = $sql_cond != "" ? " and" : " where";
            $sql_cond .= $rcategory != "" ? " $clause ct.id = $rcategory" : "";
            $clause = $sql_cond != "" ? " and" : " where";
            $sql_cond .= $runit != "" ? " $clause un.id = $runit" : "";

            $query = DB::select("SELECT pd.id,s.store_name,p.product_name,ct.category_name,un.unit_name,pd.qty,pd.current_sales_price,pd.discount,ad_create.name as add_by,up_create.name as update_by,pd.status, DATE_FORMAT(pd.created_at, '%d-%M-%Y') as create_date, DATE_FORMAT(pd.updated_at, '%d-%M-%Y') as update_date from product_details as pd left join products as p on pd.product_id=p.id left join stores as s on s.id=pd.store_id left join units as un on un.id=p.unit_id left join categories as ct on ct.id=p.category_id left join admins as ad_create on ad_create.id=pd.added_by left join admins as up_create on up_create.id=pd.updated_by $sql_cond ");

            return DataTables::collection($query)->addIndexColumn()
                ->addColumn('action', function ($data) {
                    $route_data['editUrl'] = route('invoice_setting.product_sw_edit', $data->id);
                    $route_data['product_sw_view'] = route('invoice_setting.product_sw_view', $data->id);
                    return $route_data;
                })
                ->rawColumns(['action'])
                ->toJson();
        }

        $store = Store::orderBy('store_name', 'asc')->select('id', 'store_name')->get();
        $category = Category::orderBy('category_name', 'asc')->select('id', 'category_name')->get();
        $unit = Unit::orderBy('unit_name', 'asc')->select('id', 'unit_name')->get();

        return view('dashboard.setting.product.store_wise_product_list', compact('store', 'category', 'unit'));
    }

    public function sw_edit($id)
    {

        $product_sw_edit = ProductDetails::find($id);

        return view('dashboard.setting.product.store_wise_product_edit', compact('product_sw_edit'));
    }

    public function sw_update(Request $request, $id)
    {
        $request->validate([
            'current_sales_price' => 'required',
            'discount' => 'required',
            'status' => 'required',
        ]);

        $product_sw_edit = ProductDetails::find($id);
        $product_sw_edit->current_sales_price = $request->current_sales_price != null ? $request->current_sales_price : '0';
        $product_sw_edit->discount = $request->discount != null ? $request->discount : '0';
        $product_sw_edit->status = $request->status ? $request->status : '0';

        $product_sw_edit->updated_by = Auth::user()->id;
        $product_sw_edit->update();

        if ($product_sw_edit) {
            return redirect()->route('invoice_setting.product_sw_list')->with('success', 'Product Update Successfully');
        } else {
            return redirect()->back()->with('error', 'Product Update Failed');
        }
    }

    public function sw_view($id)
    {

        $product_view = ProductDetails::find($id);

        return view('dashboard.setting.product.store_wise_product_view', compact('product_view'));

    }

    public function sw_barcode($id)
    {
         $sw_product_code = ProductDetails::find($id);

        if ($sw_product_code) {
            $size = array(0, 0, 165, 55);
            $pdf = Pdf::loadView('dashboard.setting.product.sw_product_barcode', compact('sw_product_code'))->setPaper($size);
            return $pdf->stream('sw_product_barcode.pdf');
        } else {
            return abort(404);
        }
    }

    public function sw_print($id)
    {
        // return $id;
        $product_view = ProductDetails::find($id);

        $pdf = Pdf::loadView('dashboard.setting.product.store_wise_product_print', compact('product_view'));
        return $pdf->stream('store_wise_product_print.pdf');
    }

    public function product_view($id)
    {
        $product_details_view = Product::with('products_details.store', 'unit', 'category')->find($id);
        return view('dashboard.setting.product.product_details_view', compact('product_details_view'));
    }
    public function product_print($id)
    {
        $product_details_print = Product::with('products_details.store', 'unit', 'category')->find($id);

        $pdf = Pdf::loadView('dashboard.setting.product.product_details_print', compact('product_details_print'));
        return $pdf->stream('product_details_print.pdf');
    }
}
