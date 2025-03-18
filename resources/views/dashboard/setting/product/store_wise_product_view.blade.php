@php
    $data = isset($product_view) ? $product_view : '';
    $id = isset($data->id) ? $data->id : '';

    $qty = isset($data->qty) && $data->qty != '' ? $data->qty : '';
    $current_sales_price = isset($data->current_sales_price) && $data->current_sales_price != '' ? $data->current_sales_price : '';
    $current_buying_price = isset($data->current_buying_price) && $data->current_buying_price != '' ? $data->current_buying_price : '';
    $discount = isset($data->discount) && $data->discount != '' ? $data->discount : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';
    $added_by = isset($data->created_employee->name) && $data->created_employee->name != '' ? $data->created_employee->name : '';
    $created_at = isset($data->created_at) && $data->created_at != '' ? date('d F Y', strtotime($data->created_at)) : '';
    $updated_by = isset($data->updated_employee->name) && $data->updated_employee->name != '' ? $data->updated_employee->name : '';
    $updated_at = isset($data->updated_at) && $data->updated_at != '' ? date('d F Y', strtotime($data->updated_at)) : '';
    $product_name = isset($data->product_data->product_name) && $data->product_data->product_name != '' ? $data->product_data->product_name : '';
    $product_code = isset($data->product_data->product_code) && $data->product_data->product_code != '' ? $data->product_data->product_code : '';
    $description = isset($data->product_data->description) && $data->product_data->description != '' ? $data->product_data->description : '';
    $store_name = isset($data->store->store_name) && $data->store->store_name != '' ? $data->store->store_name : '';
    $unit_name = isset($data->product_data->unit->unit_name) && $data->product_data->unit->unit_name != '' ? $data->product_data->unit->unit_name : '';
    $category_name = isset($data->product_data->category->category_name) && $data->product_data->category->category_name != '' ? $data->product_data->category->category_name : '';
@endphp
<style>
    .white_color {
        color: white;
    }

    .p-1 {
        padding: 5px;
    }

    .bg-rounded {
        border-radius: 10px;
    }
</style>
<div class="card">
    <div class="card-body">
        <div class="row px-3">

            <div class="col-sm-6 col-md-4 mt-2"><strong>Product Name</strong> :&nbsp; :{{ $product_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Product Code</strong> :&nbsp; :{{ $product_code }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Category Name </strong> :&nbsp; {{ $category_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Store Name</strong> :&nbsp; {{ $store_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Quantity</strong>:&nbsp;{{ $qty }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Buying Price</strong>:&nbsp;{{ $current_buying_price }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Sales Price</strong>:&nbsp;{{ $current_sales_price }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Unit Name</strong>:&nbsp; {{ $unit_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Discount</strong> :&nbsp;{{ $discount }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Status</strong>:&nbsp;
                @if ($data['status'] == 1)
                    <span class="white_color p-1 bg-rounded" style="background-color:#28a745;">Active</span>
                @else
                    <span class="p-1 bg-rounded" style="background-color:#ffc107;">Inactive</span>
                @endif
            </div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Added By</strong> :&nbsp;{{$added_by}}&nbsp;({{ $created_at }})</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Update By</strong> :&nbsp;{{$updated_by}}&nbsp;({{ $updated_at }})</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Description</strong> :&nbsp;{{ $description }}</div>
        </div>
        <div class="row">
            <div class="col-md-12 text-right">
                <a type="button" href="{{ route('invoice_setting.product_sw_barcode', $data['id']) }}" class="btn-sm text-white " target="_blank" style="background-color: #4e421e">BarCode Print</a> &nbsp;
                <a type="button" href="{{ route('invoice_setting.product_sw_print', $data['id']) }}"
                    class="btn-sm text-white btn-warning " target="_blank">Print</a>
            </div>
        </div>
    </div><!-- /.card-body -->
</div>
