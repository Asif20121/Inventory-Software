@php
    $data = isset($product_details_view) ? $product_details_view : '';
    $id = isset($data->id) ? $data->id : '';

    $product_name = isset($data->product_name) && $data->product_name != '' ? $data->product_name : '';
    $product_code = isset($data->product_code) && $data->product_code != '' ? $data->product_code : '';
    $description = isset($data->description) && $data->description != '' ? $data->description : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';
    $reorder_qty = isset($data->reorder_qty) && $data->reorder_qty != '' ? $data->reorder_qty : 10;

    $added_by = isset($data->created_employee->name) && $data->created_employee->name != '' ? $data->created_employee->name : '';
    $created_at = isset($data->created_at) && $data->created_at != '' ? date('d F Y', strtotime($data->created_at)) : '';
    $updated_by = isset($data->updated_employee->name) && $data->updated_employee->name != '' ? $data->updated_employee->name : '';
    $updated_at = isset($data->updated_at) && $data->updated_at != '' ? date('d F Y', strtotime($data->updated_at)) : '';
    $category_name = isset($data->category->category_name) && $data->category->category_name != '' ? $data->category->category_name : '';
    $unit_name = isset($data->unit->unit_name) && $data->unit->unit_name != '' ? $data->unit->unit_name : '';
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

            <div class="col-sm-6 col-md-4 mt-2"><strong>Product Name</strong> :&nbsp; {{ $product_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Product Code</strong> :&nbsp; {{ $product_code }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Category Name </strong> :&nbsp; {{ $category_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Unit Name</strong>:&nbsp; {{ $unit_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Status</strong>:&nbsp;
                @if ($data['status'] == 1)
                    <span class="white_color p-1 bg-rounded" style="background-color:#28a745;">Active</span>
                @else
                    <span class="p-1 bg-rounded" style="background-color:#ffc107;">Inactive</span>
                @endif
            </div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Added By</strong>
                :&nbsp;{{ $added_by }}&nbsp;({{ $created_at }})</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Update By</strong>
                :&nbsp;{{ $updated_by }}&nbsp;({{ $updated_at }})</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Description</strong> :&nbsp;{{ $description }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Reorder Qty</strong> :&nbsp;{{ $reorder_qty }}</div>
        </div>
    </div><!-- /.card-body -->
</div>

<div class="card">
    <div class="card-header bg-light"><strong>Product Wise Store</strong></div>
    <div class="card-body p-0">
        <div class="row">
            <div class="col-md-12 p-4">
                <table class="table-sm table-bordered datatable_modal" width="100%">
                    <thead>
                        <tr class="bg-dark">
                            <th class="text-center">Sl.No.</th>
                            <th class="text-center">Store Name</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">Buying Price</th>
                            <th class="text-center">Sales Price</th>
                            <th class="text-center">Discount(%)</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">create</th>
                            <th class="text-center">Update</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($product_details_view['products_details']) > 0)
                            @foreach ($product_details_view['products_details'] as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-center">
                                        {{ $item->store->store_name ? $item->store->store_name : ' ' }}</td>
                                    <td class="text-center">{{ $item->qty ? $item->qty : '0' }}</td>
                                    <td class="text-center">
                                        {{ $item->current_buying_price ? $item->current_buying_price : '0' }}</td>
                                    <td class="text-center">
                                        {{ $item->current_sales_price ? $item->current_sales_price : '0' }} </td>
                                    <td class="text-center">{{ $item->discount ? $item->discount : '0' }}</td>
                                    <td class="text-center">
                                        @if ($item['status'] == 1)
                                            <span class="white_color p-1 bg-rounded"
                                                style="background-color:#28a745;">Active</span>
                                        @else
                                            <span class="p-1 bg-rounded"
                                                style="background-color:#ffc107;">Inactive</span>
                                        @endif
                                    </td>
                                    <td class="text-center">
                                        {{ $item->created_employee->name ? $item->created_employee->name : ' ' }} <br>
                                        {{ date('d F Y', strtotime($item->created_at ? $item->created_at : '')) }}
                                    </td>
                                    <td class="text-center">
                                        {{ $item->updated_employee->name ? $item->updated_employee->name : ' ' }} <br>
                                        {{ date('d F Y', strtotime($item->updated_at ? $item->updated_at : '')) }}
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row p-2">
            <div class="col-md-12 text-right">
                <a type="button" href="{{ route('invoice_setting.product_print', $data['id']) }}"
                    class="btn-sm text-white btn-warning " target="_blank">Print</a>
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function() {
            $('.datatable_modal').DataTable({
                responsive: {

                }
            });
        });
    </script>
</div>
