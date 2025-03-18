<div class="card">
    <div class="card-header bg-light">Invoice Info.</div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3"><strong>Invoice No.</strong></div>
            <div class="col-md-3">: {{ $invoice['invoice_no'] }}</div>
            <div class="col-md-3"><strong>Date</strong></div>
            <div class="col-md-3">: {{ date('d F Y', strtotime($invoice['date'])) }}</div>
            <div class="col-md-3"><strong>Customer Name</strong></div>
            <div class="col-md-3">: {{ isset($invoice['customer_name']) ? $invoice['customer_name'] : '' }}</div>
            <div class="col-md-3"><strong>Email</strong></div>
            <div class="col-md-3">: {{ isset($invoice['customer_email']) ? $invoice['customer_email'] : '' }}
            </div>
            <div class="col-md-3"><strong>Phone</strong></div>
            <div class="col-md-3">: {{ isset($invoice['customer_phone']) ? $invoice['customer_phone'] : '' }}</div>
            <div class="col-md-3"><strong>Store</strong></div>
            <div class="col-md-3">: {{ isset($invoice['store_name']) ? $invoice['store_name'] : '' }}</div>
            <div class="col-md-3"><strong>Added By</strong></div>
            <div class="col-md-3">: ({{ isset($invoice['added_card_no']) ? $invoice['added_card_no'] : '' }}){{ isset($invoice['added_by']) ? $invoice['added_by'] : '' }}</div>
            <div class="col-md-3"><strong>Updated By</strong></div>
            <div class="col-md-3">: ({{ isset($invoice['updated_by_card_no']) ? $invoice['updated_by_card_no'] : '' }}){{ isset($invoice['updated_by']) ? $invoice['updated_by'] : '' }}</div>
            <div class="col-md-3"><strong>Address</strong></div>
            <div class="col-md-3">: {{ isset($invoice['customer_address']) ? $invoice['customer_address'] : '' }}</div>
            <div class="col-md-3"><strong>Updated Date</strong></div>
            <div class="col-md-3">: {{ date('d F Y', strtotime($invoice['updated_date'])) }}</div>
        </div>
    </div>

</div>

@php
    $product_qty = 0;
    $total_item_price = 0;
    $total_item_discount = 0;
@endphp
<div class="card">
    <div class="card-header bg-light">Product List</div>
    <div class="card-body p-0">
        <div class="row">
            <div class="col-md-12">
                <table id="service_table" class="table-sm table-bordered" width="100%">
                    <thead>
                        <tr class="bg-dark">
                            <th class="text-center">Sl.No.</th>
                            <th class="text-center">Product Name</th>
                            <th class="text-center">Qty</th>
                            <th class="text-center">Unit Price</th>
                            <th class="text-center">Discount(%)</th>
                            <th class="text-center">UPWD</th>
                            <th class="text-center">Total UPWOD</th>
                            <th class="text-center">Total Price</th>
                        </tr>
                    </thead>

                    <tbody>
                        @if (count($invoice['invoice_details']) > 0)
                        @foreach ($invoice['invoice_details'] as $key => $item)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">
                                    {{ $item->product_name ? $item->product_name : '0' }}
                                </td>
                                <td class="text-center">
                                    {{ $item->remainingqty ? $item->remainingqty : '0' }}</td>
                                <td class="text-center">
                                    {{ $item->unit_price ? $item->unit_price : '0' }}
                                </td>
                                <td class="text-center">
                                    {{ $item->unit_discount ? $item->unit_discount : '0' }}
                                </td>
                                <td class="text-center">
                                    {{ $item->unit_price_wd ? $item->unit_price_wd : '0' }}
                                </td>
                                <td class="text-center">
                                    {{ $item->item_price_wod ? $item->item_price_wod : '0' }}
                                </td>
                                <td class="text-center">
                                    {{ $item->item_price_wd ? $item->item_price_wd : '0' }}
                                </td>

                            </tr>

                            @php
                                $product_qty = $product_qty + ($item->remainingqty ? $item->remainingqty : '0');
                                $total_item_price = $total_item_price + ($item->item_price_wod ? $item->item_price_wod : '0');
                                $total_item_discount = $total_item_discount + ($item->unit_price * $item->remainingqty * $item->unit_discount) / 100;
                            @endphp
                        @endforeach
                    @endif

                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div>



<div class="card">
    <div class="card-header bg-light">Payment History</div>
    <div class="card-body p-0">
        <div class="row">
            <div class="col-md-12">
                <table id="" class="table-sm table-bordered" width="100%">
                    <thead class="bg-dark">
                        <tr>
                            <th class="text-center">Sl.No.</th>
                            <th class="text-center">Date</th>
                            <th class="text-center">Paid Amount</th>
                            <th class="text-center">Return Amount</th>
                            <th class="text-center">Actual Paid Amount</th>
                            <th class="text-center">Payment Method</th>
                            <th class="text-center">Received By</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (count($invoice['payment_details']) > 0)
                            @foreach ($invoice['payment_details'] as $key => $pd)

                            @if ($pd->status == 1)
                            <tr>
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">
                                    {{ isset($pd->date) ? date('d F Y', strtotime($pd->date)) : '' }}
                                </td>
                                <td class="text-center">
                                    {{ $pd->current_paid_amount != '' ? $pd->current_paid_amount : '0' }}
                                </td>
                                <td class="text-center"> {{ $pd->refound != '' ? $pd->refound : '0' }}</td>
                                <td class="text-center"> {{ $pd->actual_paid != '' ? $pd->actual_paid : '0' }}</td>
                                <td class="text-center">
                                    {{ $pd->payment_method != '' ? $pd->payment_method : '' }}
                                </td>
                                <td class="text-center"> {{ $pd->receive_by_name != '' ? $pd->receive_by_name : '0' }} </td>
                            </tr>
                            @elseif ($pd->status == 2)
                            <tr class="bg-danger">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">
                                    {{ isset($pd->date) ? date('d F Y', strtotime($pd->date)) : '' }}
                                </td>
                                <td class="text-center">
                                    {{ $pd->current_paid_amount != '' ? $pd->current_paid_amount : '0' }}
                                </td>
                                <td class="text-center"> {{ $pd->refound != '' ? $pd->refound : '0' }}</td>
                                <td class="text-center"> {{ $pd->actual_paid != '' ? $pd->actual_paid : '0' }}</td>
                                <td class="text-center">
                                    {{ $pd->payment_method != '' ? $pd->payment_method : '' }}
                                </td>
                                <td class="text-center"> {{ $pd->receive_by_name != '' ? $pd->receive_by_name : '0' }} </td>
                            </tr>
                              @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>


    </div>

</div>

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6"><strong>Total Item</strong></div>
                    <div class="col-md-6">: {{ $product_qty }}</div>
                    <div class="col-md-6"><strong>Total Item Price</strong></div>
                    <div class="col-md-6">: {{ $total_item_price }}</div>
                    <div class="col-md-6"><strong>Total Item Discount</strong></div>
                    <div class="col-md-6">: {{ number_format($total_item_discount, 2) }}</div>
                    <div class="col-md-6"><strong>Total Item Price With Discount</strong></div>
                    <div class="col-md-6">: {{ number_format($total_item_price - $total_item_discount, 2) }}</div>
                    <div class="col-md-6"><strong>Special Discount Amount</strong></div>
                    <div class="col-md-6">: {{ $invoice['discount_amount'] ? $invoice['discount_amount'] : '0' }}</div>
                    <div class="col-md-6"><strong>Description</strong></div>
                    <div class="col-md-6">: {{ isset($invoice['description']) ? $invoice['description'] : '...' }}</div>
                </div>
            </div>
            @php
                $grand_total = floor($total_item_price - $total_item_discount) - ($invoice['discount_amount'] ? $invoice['discount_amount'] : '0');
            @endphp
            <div class="col-md-6">
                <div class="row">
                    <div class="col-md-6"><strong>Grand Total</strong></div>
                    <div class="col-md-6">: {{ $grand_total }}</div>
                    <div class="col-md-6"><strong>Paid Amount</strong></div>
                    <div class="col-md-6">: {{ $invoice['paid_amount'] ? $invoice['paid_amount'] : '0' }}</div>
                    <div class="col-md-6"><strong>Due Amount</strong></div>
                    <div class="col-md-6">:{{ $grand_total - ($invoice['paid_amount'] ? $invoice['paid_amount'] : '0') }}</div>
                    <div class="col-md-6"><strong>Payment Status</strong></div>
                    <div class="col-md-6">: @if ($grand_total - ($invoice['paid_amount'] ? $invoice['paid_amount'] : '0') > 0)
                            <span class="bg-warning px-2 rounded">Due</span>
                        @else
                            <span class="bg-success px-2 rounded">Paid</span>
                        @endif
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12 text-right">
                <a type="button" href="{{route('admin.sales_pos_show_print',$invoice['invoice_id'])}}" class="btn-sm text-white btn-warning " target="_blank">Print</a>
            </div>
        </div>
    </div>
</div>
