@extends('dashboard.admin.layouts.master')
@push('admin_css')
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Due Collection (Invoice No : <strong>{{ $invoice['invoice_no'] }}</strong> , Date : <strong>{{ date('d F Y', strtotime($invoice['date']))}}</strong> )
                        </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Due</a></li>
                            <li class="breadcrumb-item active">Collection</li>
                        </ol>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->
        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Main row -->
                <div class="row">
                    <!-- Left col -->



                    <section class="col-lg-12 connectedSortable">
                        <!-- Custom tabs (Charts with tabs)-->
                        <div class="card">
                            <div class="card-header">
                                <div class="row d-flex justify-content-between">
                                   <div class="col-md-12">
                                    <label for="">Customer Info</label> <br>
                                   </div>
                                    <div class="col-6 text-left">

                                        <span>Name : <strong
                                                class="text-info">{{ isset($invoice['customer_name']) ? $invoice['customer_name'] : '' }}</strong></span>
                                        &nbsp; &nbsp;
                                        <span>Phone : <strong
                                                class="text-info">{{ isset($invoice['customer_email']) ? $invoice['customer_email'] : '' }}</strong></span>&nbsp;
                                        &nbsp;
                                        <span>Email : <strong
                                                class="text-info">{{ isset($invoice['customer_phone']) ? $invoice['customer_phone'] : '' }}</strong></span>&nbsp;
                                        &nbsp;
                                        <span>Address : <strong
                                                class="text-info">{{ isset($invoice['customer_address']) ? $invoice['customer_address'] : '' }}</strong></span>
                                    </div>


                                    <div class="col-md-2 col-sm-6 text-left">
                                        <label for="">Store</label> <span class="text-danger">*</span>
                                        <input type="text" class="form-control" disabled
                                            value="{{ isset($invoice['store_name']) ? $invoice['store_name'] : '' }}">
                                    </div>

                                </div>
                            </div><!-- /.card-header -->


                            <form action="" id="due_collection_form" method="post">
                                <input name="invoice_id" type="hidden" value="{{ $invoice['invoice_id'] }}">
                                <input name="date" type="hidden" value="{{ $invoice['date'] }}">
                                @csrf
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-1 text-left">
                                            <label for="">Product List</label></span>
                                        </div>
                                        <div class="col-md-12 col-sm-12 ">
                                            @php
                                                $product_qty = 0;
                                                $total_item_price = 0;
                                                $total_item_discount = 0;
                                            @endphp
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

                                        <div class="col-1 text-left mt-3">
                                            <label for="">Payment History</label></span>
                                        </div>


                                        <div class="col-md-12 col-sm-12 ">
                                            <table id="" class="table-sm table-bordered" width="100%">
                                                <thead class="bg-dark">
                                                    <tr>
                                                        <th class="text-center">Sl.No.</th>
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
                                                                {{ $pd->current_paid_amount != '' ? $pd->current_paid_amount : '0' }}
                                                            </td>
                                                            <td class="text-center"> {{ $pd->refound != '' ? $pd->refound : '0' }}</td>
                                                            <td class="text-center"> {{ $pd->actual_paid != '' ? $pd->actual_paid : '0' }}</td>
                                                            <td class="text-center">
                                                                {{ $pd->payment_method != '' ? $pd->payment_method : '' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $pd->receive_by_name != '' ? $pd->receive_by_name : '0' }}
                                                                <br>
                                                                {{ isset($pd->date) ? date('d F Y', strtotime($pd->date)) : '' }}
                                                             </td>
                                                        </tr>
                                                        @elseif ($pd->status == 2)
                                                        <tr class="bg-danger">
                                                            <td class="text-center">{{ $key + 1 }}</td>
                                                            <td class="text-center">
                                                                {{ $pd->current_paid_amount != '' ? $pd->current_paid_amount : '0' }}
                                                            </td>
                                                            <td class="text-center"> {{ $pd->refound != '' ? $pd->refound : '0' }}</td>
                                                            <td class="text-center"> {{ $pd->actual_paid != '' ? $pd->actual_paid : '0' }}</td>
                                                            <td class="text-center">
                                                                {{ $pd->payment_method != '' ? $pd->payment_method : '' }}
                                                            </td>
                                                            <td class="text-center">
                                                                {{ $pd->receive_by_name != '' ? $pd->receive_by_name : '0' }}
                                                                <br>
                                                                {{ isset($pd->date) ? date('d F Y', strtotime($pd->date)) : '' }}
                                                                 </td>
                                                        </tr>
                                                          @endif
                                                        @endforeach
                                                    @endif
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-5">
                                            <hr>
                                        </div>

                                        <div class="col-md-4 col-sm-12 ">
                                            <div class="row">
                                                <div class="col-md-12 mt-2">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Description</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <textarea disabled class="form-control" cols="10" rows="1">{{ $invoice['description'] ? $invoice['description'] : '' }}</textarea>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12 mt-5">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Payment Method</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select name="payment_method" id="payment_method"
                                                                class="form-select form-control search_box">
                                                                <option value="">Select Method</option>
                                                                @foreach ($payment_type as $key => $p_type)
                                                                    <option value="{{ $p_type->type_name }}">
                                                                        {{ $key + 1 }}. {{ $p_type->type_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-5">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Payment</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select id="paid_status" class="form-select form-control">
                                                                <option value="">Select Payment </option>
                                                                <option value="partial_paid">Partial Paid </option>
                                                                <option value="full_paid">Paid </option>
                                                            </select>
                                                            <input type="number" placeholder="0"
                                                                class="form-control recent_paid_amount" value="0"
                                                                style="display:none;" id="recent_paid_amount" min=0
                                                                oninput="validity.valid||(value='');">

                                                            <span class="text-danger" id="paid_status_err"></span>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 ">


                                        </div>
                                        <div class="col-md-4 col-sm-12 ">
                                            <div class="col-md-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Total Item</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text"
                                                            value="{{ $product_qty }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Total Item Price</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" readonly
                                                            value="{{ $total_item_price }}">
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Total Item Discount</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text"
                                                            value="{{ number_format($total_item_discount, 2) }}" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Total Item Price With
                                                                Discount</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control"
                                                            type="text"value="{{ number_format($total_item_price - $total_item_discount, 2) }}"
                                                            readonly>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Special Discount
                                                                Amount</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text"
                                                            value="{{ $invoice['discount_amount'] ? $invoice['discount_amount'] : '0' }}"
                                                            readonly>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-5">
                                            <hr>
                                        </div>
                                        @php
                                            $grand_total = floor($total_item_price - $total_item_discount) - ($invoice['discount_amount'] ? $invoice['discount_amount'] : '0');
                                        @endphp

                                        <div class="col-md-12 col-sm-12 ">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8"></div>
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Grand Total</strong>
                                                        <input style="width: 60%" readonly type="number"
                                                            class="form-control" value="{{ $grand_total }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-2 ">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8"></div>
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Already Paid </strong>
                                                        <input style="width: 60%" readonly type="number"
                                                            class="form-control"
                                                            value="{{ $invoice['paid_amount'] ? $invoice['paid_amount'] : '0' }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-2 ">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8"></div>
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Due Amount</strong>
                                                        <input style="width: 60%" readonly type="number" id="prev_due"
                                                            class="form-control"
                                                            value="{{ $grand_total - ($invoice['paid_amount'] ? $invoice['paid_amount'] : '0') }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-2 ">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8"></div>
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Current Paid Amount</strong>
                                                        <input id="recent_paid_amount_show" name="current_paid_amount" style="width: 60%" readonly
                                                            type="number" class="form-control" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-2 ">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8">
                                                    <button type="submit" class="btn btn-info">Save</button>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6"><strong>Payment Status</strong></div>
                                                        <div class="col-md-6">
                                                            <div id="payment_status_show" class="ml-5"
                                                                style="align-items: center"> <strong
                                                                    class="text-info">None</strong></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- /.card-body -->
                                </div>
                            </form>
                            <!-- /.card -->
                    </section>
                    <!-- right col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>

@endsection


@push('admin_js')
    <script>
        $(document).on('change', '#paid_status', function() {
            $('#paid_status_err').text("")
            payment()
        });

        $(document).on('keyup click', '#recent_paid_amount', function() {
            $('#paid_status_err').text("")
            payment()
        })


        const payment = async () => {
            var paid_status = $("#paid_status").val();
            var prev_due = Math.floor($("#prev_due").val());

            if (paid_status == 'partial_paid') {
                $('.recent_paid_amount').show();

                let recent_paid_amount_show = Math.floor($('#recent_paid_amount').val());
                $('#recent_paid_amount_show').val(recent_paid_amount_show ? recent_paid_amount_show : 0);

                if (prev_due == recent_paid_amount_show) {
                    $('#payment_status_show').html(`<strong class="text-success">Full Paid</strong>`);
                } else if (prev_due > recent_paid_amount_show) {

                    $('#payment_status_show').html(
                        `<strong class="text-warning">Due : ${prev_due - recent_paid_amount_show}</strong>`);
                } else if (prev_due < recent_paid_amount_show) {

                    $('#payment_status_show').html(
                        `  <strong class="text-primary" >  <input name='refound' type='hidden' value="${recent_paid_amount_show - prev_due}" >Return : ${recent_paid_amount_show - prev_due}</strong><br>
                           <strong class="text-success" >Actual Paid : ${recent_paid_amount_show - (recent_paid_amount_show - prev_due)}</strong>
                        `
                    );
                }


            } else if (paid_status == 'full_paid') {
                $('.recent_paid_amount').hide();
                $('#payment_status_show').html('<strong class="text-success">Full Paid</strong>');
                let recent_paid_amount_show = $('#recent_paid_amount').val();
                $('#recent_paid_amount_show').val(prev_due);
            } else {
                $('.recent_paid_amount').hide();
                $('#payment_status_show').html('<strong class="text-info">None</strong>');
                $('#recent_paid_amount_show').val(0);
            }
        }

        $(document).ready(function() {
            $("#due_collection_form").submit(function() {
                let recent_paid_amount = $("#recent_paid_amount").val()
                let paid_status = $("#paid_status").val()
                if (recent_paid_amount > 0 || paid_status=='full_paid') {
                    $('#due_collection_form').attr('action', "{{ route('admin.due_collection_update') }}");
                } else {
                    event.preventDefault()
                    $("#paid_status_err").text('Please Pay Sum of Amount')
                }

            });
        });
    </script>
@endpush
