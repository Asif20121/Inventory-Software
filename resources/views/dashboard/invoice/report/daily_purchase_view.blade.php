@php
    $data = isset($purchase) ? $purchase : '';
    $id = isset($data->id) ? $data->id : '';

    $store_name = isset($data->storef->store_name) && $data->storef->store_name != '' ? $data->storef->store_name : '';
    $date = isset($data->date) && $data->date != '' ? date('d F Y', strtotime($data->date)) : '';
    $voucher = isset($data->voucher) && $data->voucher != '' ? $data->voucher : '';
    $supplier = isset($data->supplierf->supplier_name) && $data->supplierf->supplier_name != '' ? $data->supplierf->supplier_name : '';
    $description = isset($data->description) && $data->description != '' ? $data->description : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';
    $added_by = isset($data->created_employee->name) && $data->created_employee->name != '' ? $data->created_employee->name : '';
    $created_at = isset($data->created_at) && $data->created_at != '' ? date('d F Y', strtotime($data->created_at)) : '';
    $updated_by = isset($data->updated_employee->name) && $data->updated_employee->name != '' ? $data->updated_employee->name : '';
    $updated_at = isset($data->updated_at) && $data->updated_at != '' ? date('d F Y', strtotime($data->updated_at)) : '';

    $tax = isset($data->tax) && $data->tax != '' ? $data->tax : '';
    $vat = isset($data->vat) && $data->vat != '' ? $data->vat : '';
    $shipping_cost = isset($data->shipping_cost) && $data->shipping_cost != '' ? $data->shipping_cost : '';
    $other_cost = isset($data->other_cost) && $data->other_cost != '' ? $data->other_cost : '';
    $discount = isset($data->discount) && $data->discount != '' ? $data->discount : '';
    $description_other = isset($data->description) && $data->description != '' ? $data->description : '';
    $grand_total = isset($data->grand_total) && $data->grand_total != '' ? $data->grand_total : '';

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

            <div class="col-sm-6 col-md-4 mt-2"><strong> Purchases Date</strong> :&nbsp; {{ $date }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Voucher</strong> :&nbsp; {{ $voucher }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Store Name </strong> :&nbsp; {{ $store_name }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Supplier</strong>:&nbsp; {{ $supplier }}</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Status</strong>:&nbsp;
                @if ($data['status'] == 1)
                    <span class="white_color p-1 bg-rounded" style="background-color:#28a745;">Approved</span>
                @elseif ($data['status'] == 0)
                    <span class="p-1 bg-rounded" style="background-color:#ffc107;">Pending</span>
                    @elseif ($data['status'] == 2)
                    <span class="p-1 bg-rounded" style="background-color:#ff0707;">Cancelled</span>
                @endif
            </div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Added By</strong>
                :&nbsp;{{ $added_by }}&nbsp;({{ $created_at }})</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Update By</strong>
                :&nbsp;{{ $updated_by }}&nbsp;({{ $updated_at }})</div>
            <div class="col-sm-6 col-md-4 mt-2"><strong>Description</strong> :&nbsp;{{ $description }}</div>
        </div>
    </div><!-- /.card-body -->
</div>
@php
    $product_qty = 0;
    $net_total_amount = 0;
@endphp
<div class="card">
    <div class="card-header bg-light"><strong>Product details </strong></div>
    <div class="card-body p-0">
        <div class="row">
            <div class="col-md-12 p-4">
                <table class="table-sm table-bordered datatable_modal" width="100%">
                    <thead>
                        <tr class="bg-dark">
                            <th class="text-center">Sl.No.</th>
                            <th class="text-center">P.Name</th>
                            <th class="text-center">Quantity</th>
                            <th class="text-center">U.Price</th>
                            <th class="text-center">Discount(%)</th>
                            <th class="text-center">UPWD</th>
                            <th class="text-center">T.Price</th>
                            <th class="text-center">Status</th>
                            <th class="text-center">L.Update</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($purchase['purchase_detailsf']) > 0)
                            @foreach ($purchase['purchase_detailsf'] as $key => $item)
                                <tr>
                                    <td class="text-center">{{ $key + 1 }}</td>
                                    <td class="text-center">
                                        {{ $item->productf->product_name ? $item->productf->product_name : ' ' }}</td>
                                    <td class="text-center">{{ $item->buying_qty ? $item->buying_qty : '0' }}</td>
                                    <td class="text-center">{{ $item->unit_price ? $item->unit_price : '0' }}</td>
                                    <td class="text-center">{{ $item->discount ? $item->discount : '0' }}</td>
                                    <td class="text-center">{{ $item->upwd ? $item->upwd : '0' }} </td>
                                    <td class="text-center">{{ $item->total_price ? $item->total_price : '0' }} </td>
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
                                        {{ $item->updated_employee->name ? $item->updated_employee->name : '' }} <br>
                                        {{ date('d F Y', strtotime($item->updated_at ? $item->updated_at : '')) }}
                                    </td>
                                </tr>
                                @php
                                    $product_qty = $product_qty + ($item->buying_qty ? $item->buying_qty : '0');
                                    $net_total_amount = $net_total_amount + ($item->total_price ? $item->total_price : '0');
                                @endphp
                            @endforeach
                        @endif
                    </tbody>
                </table>
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

@if (count($cancel_list['purchase_detailsf']) > 0)
    <div class="card">
        <div class="card-header" style="color: #dc3545 !important;"><b>Product Cancel List</b></div>
        {{-- <div class="card-header bg-light"><strong>Product details </strong></div> --}}
        <div class="card-body p-0">
            <div class="row">
                <div class="col-md-12 p-4">
                    <table class="table-sm table-bordered datatable_modal" width="100%">
                        <thead>
                            <tr class="bg-dark">
                                <th class="text-center">Sl.No.</th>
                                <th class="text-center">P.Name</th>
                                <th class="text-center">Quantity</th>
                                <th class="text-center">U.Price</th>
                                <th class="text-center">Discount(%)</th>
                                <th class="text-center">UPWD</th>
                                <th class="text-center">T.Price</th>
                                <th class="text-center">Status</th>
                                <th class="text-center">Cancel By</th>
                            </tr>
                        </thead>

                        <tbody>
                            @if (count($cancel_list['purchase_detailsf']) > 0)
                                @foreach ($cancel_list['purchase_detailsf'] as $key => $item)
                                    <tr style="background-color: #f39a9af0 !important">
                                        <td class="text-center">{{ $key + 1 }}</td>
                                        <td class="text-center">
                                            {{ $item->productf->product_name ? $item->productf->product_name : ' ' }}
                                        </td>
                                        <td class="text-center">{{ $item->buying_qty ? $item->buying_qty : '0' }}</td>
                                        <td class="text-center">{{ $item->unit_price ? $item->unit_price : '0' }}</td>
                                        <td class="text-center">{{ $item->discount ? $item->discount : '0' }}</td>
                                        <td class="text-center">{{ $item->upwd ? $item->upwd : '0' }} </td>
                                        <td class="text-center">{{ $item->total_price ? $item->total_price : '0' }}
                                        </td>
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
                                            {{ $item->updated_employee->name ? $item->updated_employee->name : '' }}
                                            <br>
                                            {{ date('d F Y', strtotime($item->updated_at ? $item->updated_at : '')) }}
                                        </td>
                                    </tr>
                                    @php
                                        $product_qty = $product_qty + ($item->buying_qty ? $item->buying_qty : '0');
                                        $net_total_amount = $net_total_amount + ($item->total_price ? $item->total_price : '0');
                                    @endphp
                                @endforeach
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endif

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6"></div>
                    <div class="col-md-6"></div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6"><strong>Total Item</strong></div>
                    <div class="col-md-6">: {{ $product_qty }}</div>
                    <div class="col-md-6"><strong>Net Total Amount</strong></div>
                    <div class="col-md-6">: {{ $net_total_amount }}</div>
                    <div class="col-md-6"><strong>Tax</strong></div>
                    <div class="col-md-6">: {{ $tax }}</div>
                    <div class="col-md-6"><strong>Vat</strong></div>
                    <div class="col-md-6">: {{ $vat }}</div>
                    <div class="col-md-6"><strong>Shipping Cost</strong></div>
                    <div class="col-md-6">: {{ $shipping_cost }}</div>
                    <div class="col-md-6"><strong>Other Cost</strong></div>
                    <div class="col-md-6">: {{ $other_cost }}</div>
                    <div class="col-md-6"><strong>Discount</strong></div>
                    <div class="col-md-6">: {{ $discount }}</div>
                    <hr style="width: 100%">
                    <div class="col-md-6"><strong>Grand Total</strong></div>
                    <div class="col-md-6">: {{ $grand_total }}</div>
                </div>
            </div>
        </div>

        <div class="row p-2 mt-3">
            <div class="col-md-12 text-right">
                <a type="button" href="{{ route('admin.daily_purchase_view_print', $data['id']) }}"
                    class="btn-sm text-white btn-warning " target="_blank">Print</a>
            </div>
        </div>
    </div>
</div>
