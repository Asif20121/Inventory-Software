<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Invoice Details</title>

    <style>
        @page {
            margin: 0px 50px;
        }

        body {
            margin-top: 6cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 2cm;
        }

        header {
            position: fixed;
            top: 15px;
            left: 0px;
            right: 0px;
            font-size: 15px !important;
            /* background:red; */
            text-align: center;
            line-height: 18px;
            padding: 10px 0;
        }

        h4.title {
            font-size: 1em;
            font-weight: normal;
            margin: 0;
            font-family: Futara;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        p,
        span,
        label {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px !important;
        }

        table thead th {
            height: 28px;
            text-align: left;
            font-size: 15px;
            font-family: sans-serif;
        }

        table th:first-child {
            border-radius: 5px 0 0 5px;
        }

        table th:last-child {
            border-radius: 0 5px 5px 0;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
            padding: 6px;
            font-size: 14px;
        }

        .heading {
            font-size: 24px;
            margin-top: 12px;
            margin-bottom: 12px;
            font-family: sans-serif;
        }

        .small-heading {
            font-size: 18px;
            font-family: sans-serif;
        }

        .total-heading {
            font-size: 18px;
            font-weight: 700;
            font-family: sans-serif;
        }

        .text-start {
            text-align: left;
        }

        .text-end {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .company-data span {
            margin-bottom: 4px;
            display: inline-block;
            font-family: sans-serif;
            font-size: 14px;
            font-weight: 400;
        }

        .no-border {
            border: 1px solid #fff !important;
        }

        .bg-blue {
            background-color: #979aa1;
            color: #fff;
            font-weight: normal;
            font-family: Verdana;
            text-align: center;
        }

        .info {
            line-height: 10px;
            text-align: center;
            margin-top: 23%;
            color: #625D5D;
            font-family: Futara;
            font-size: 12px;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #0087C3;
            text-decoration: none;
        }

        h2.name {
            font-size: 1.4em;
            font-weight: normal;
            margin: 0;
            margin-top: 8px;
            margin-bottom: 6px;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            height: 80px;
            width: 90px;
        }

        #company {
            float: right;
            text-align: right;
            width: 30%;
            font-size: 13px;
            line-height: 15px;
        }

        footer {
            position: fixed;
            bottom: 10px;
            left: 0px;
            right: 0px;
            height: 50px;
            font-size: 19px !important;
            background-color: #008B8B;
            color: white;
            text-align: center;
            line-height: 35px;
            border-radius: 5px;
            font-family: ;
        }

        .pagenum:before {
            content: counter(page);
            background-color: #008B8B;
            color: white;
            padding: 5px;
            border-radius: 5px;
        }

        .white_color {
            color: white;
        }

        .p-1 {
            padding: 5px;
        }

        .bg-rounded {
            border-radius: 10px;
        }

        .third_table {
            width: 50%;
            float: left;
            line-height: 45%;
        }

        .four_table {
            width: 50%;
            float: right;
            line-height: 45%;
        }
    </style>
</head>

@php
    $product_qty = 0;
    $total_item_price = 0;
    $total_item_discount = 0;
@endphp

<body>
    <header class="clearfix">
        @php
            $admin_logos = '';
            $logo_image = '';
            if (
                count(
                    DB::table('logo_titles')
                        ->where('status', '1')
                        ->get(),
                ) != 0
            ) {
                $admin_logos = DB::table('logo_titles')->first();
                $logo_image = $admin_logos->logo_image;
            }
        @endphp
        <div id="logo">
            <!-- <img src="{{ public_path('no_image.png') }}"> -->
            @if ($logo_image == '' || $logo_image == null)
                <img src="{{ asset('no_image.png') }}">
            @else
                <img src="{{ URL::to('storage/logo_image', $logo_image) }}">
            @endif
        </div>
        <div id="company">
            <span class="pagenum"></span>
            <h2 class="name">
                {{ isset($admin_logos->website_name) ? $admin_logos->website_name : '' }}&nbsp;({{ isset($invoice['store_name']) ? $invoice['store_name'] : '' }})
            </h2>
            <div>{{ isset($invoice['store_address']) ? $invoice['store_address'] : '' }}</div>
            <div>
                @if (isset($invoice['store_phone']))
                    Phone : &nbsp;{{ isset($invoice['store_phone']) ? $invoice['store_phone'] : '' }}
                @else
                @endif
            </div>
            <div>
                @if (isset($invoice['store_email']))
                    Email : &nbsp;<a
                        href="#">{{ isset($invoice['store_email']) ? $invoice['store_email'] : '' }}</a>
                @else
                @endif
            </div>
            <div>
                @if (isset($invoice['store_web_url']))
                    Web: &nbsp;<a
                        href="#">{{ isset($invoice['store_web_url']) ? $invoice['store_web_url'] : '' }}</a>
                @else
                @endif
            </div>
        </div>
        <div class="info">
            <h2>
                <span>INVOICE DETAILS</span>
            </h2>
        </div>
    </header>
    <footer>
        Power By :
        <strong
            style="color: rgb(14, 14, 101)">{{ isset($admin_logos->website_name) ? $admin_logos->website_name : '' }}</strong>&nbsp;
        Print Date :
        <strong style="color: rgb(14, 14, 101)">{{ date('d F Y') }}</strong> Print by : {{ Auth::user()->name }}
    </footer>

    <main>

        <div style="background-color: #faf8f8;padding:2%;">
            <div
                style="margin-left: 1%; width: 50%; float:left; font-size: 14px; font-family: sans-serif; color: #5b5b5b;">
                <p>
                    <b>INVOICED TO</b>
                </p>
                <p>
                    {{ isset($invoice['customer_name']) ? $invoice['customer_name'] : '' }}<br>
                    {{ isset($invoice['customer_email']) ? $invoice['customer_email'] : '' }}<br>
                    {{ isset($invoice['customer_phone']) ? $invoice['customer_phone'] : '' }}<br>
                    {{ isset($invoice['customer_address']) ? $invoice['customer_address'] : '' }}<br>

                </p>
            </div>
            <div
                style="margin-left: 15%; width: 50% float:right; font-size: 14px; font-family: sans-serif; color: #5b5b5b;">
                <p>
                    <b>INVOICE NO# &nbsp;{{ $invoice['invoice_no'] }}</b>
                </p>
                <p>
                    Invoice Date: {{ date('d F Y', strtotime($invoice['date'])) }}<br>
                    Updated Date: {{ date('d F Y', strtotime($invoice['updated_date'])) }}<br>
                    Added By:
                    ({{ isset($invoice['added_card_no']) ? $invoice['added_card_no'] : '' }}){{ isset($invoice['added_by']) ? $invoice['added_by'] : '' }}<br>
                    Updated By:
                    ({{ isset($invoice['updated_by_card_no']) ? $invoice['updated_by_card_no'] : '' }}){{ isset($invoice['updated_by']) ? $invoice['updated_by'] : '' }}
                </p>
            </div>
        </div>
        <p style="page-break-after: never;">

            <strong style="color: #5b5b5b;">&nbsp; Product List</strong> <br>
        <table>
            <thead>
                <tr class="bg-blue">
                    <th width="05%">Sl.No.</th>
                    <th width="20%">Product Name</th>
                    <th width="5%">Qty</th>
                    <th width="15%">Unit Price</th>
                    <th width="15%">Discount(%)</th>
                    <th width="10%">UPWD</th>
                    <th width="20%">Total UPWOD</th>
                    <th width="25%">Total Price</th>
                </tr>
            </thead>
            <tbody>
                @if (count($invoice['invoice_details']) > 0)
                    @foreach ($invoice['invoice_details'] as $key => $item)
                        <tr>
                            <td class="text-center">{{ $key + 1 }}</td>
                            <td class="text-center">{{ $item->product_name ? $item->product_name : '' }}</td>
                            <td class="text-center">{{ $item->remainingqty ? $item->remainingqty : '0' }}</td>
                            <td class="text-center">{{ $item->unit_price ? $item->unit_price : '0' }}</td>
                            <td class="text-center">{{ $item->unit_discount ? $item->unit_discount : '0' }}</td>
                            <td class="text-center">{{ $item->unit_price_wd ? $item->unit_price_wd : '0' }}</td>
                            <td class="text-center">{{ $item->item_price_wod ? $item->item_price_wod : '0' }}
                            </td>
                            <td class="text-center">{{ $item->item_price_wd ? $item->item_price_wd : '0' }}</td>
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

        @if (count($invoice['cancel_invoice_list']) > 0)
        <strong style="color: #dc3545 !important;">&nbsp; <b>Product Cancel List</b></strong> <br>
            <table>
                <thead>
                    <tr class="bg-blue">
                        <th>Sl.No.</th>
                        <th>Product Name</th>
                        <th>Qty</th>
                        <th>Unit Price</th>
                        <th>Discount(%)</th>
                        <th>UPWD</th>
                        <th>Total UPWOD</th>
                        <th>Total Price</th>
                        <th>Cancel By</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($invoice['cancel_invoice_list']) > 0)
                        @foreach ($invoice['cancel_invoice_list'] as $key => $item)
                            <tr style="background-color: #f39a9af0 !important">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">{{ $item->product_name ? $item->product_name : '' }}</td>
                                <td class="text-center">{{ $item->qty ? $item->qty : '0' }}</td>
                                <td class="text-center">{{ $item->unit_price ? $item->unit_price : '0' }}</td>
                                <td class="text-center">{{ $item->unit_discount ? $item->unit_discount : '0' }}</td>
                                <td class="text-center">{{ $item->unit_price_wd ? $item->unit_price_wd : '0' }}</td>
                                <td class="text-center">{{ $item->selling_price_wod ? $item->selling_price_wod : '0' }}
                                </td>
                                <td class="text-center">{{ $item->selling_price_wd ? $item->selling_price_wd : '0' }}
                                </td>
                                <td class="text-center">
                                    {{ date('d F Y', strtotime($item->cancel_date ? $item->cancel_date : '')) }} <br>
                                    ({{ $item->cancel_by_card_no ? $item->cancel_by_card_no : '' }})
                                    {{ $item->cancel_by ? $item->cancel_by : '' }}
                                </td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        @endif

        <strong style="color: #5b5b5b;">&nbsp; Payment History</strong>
        <table>
            <thead>
                <tr class="bg-blue">
                    <th width="05%">Sl.No.</th>
                    <th width="15%">Date</th>
                    <th width="10%">Paid Amount</th>
                    <th width="10%">Return Amount</th>
                    <th width="20%">Payment Method</th>
                    <th width="20%">Received By</th>
                    <th width="15%">Cancel By</th>
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
                                    {{ $pd->current_paid_amount != '' ? $pd->current_paid_amount : '0' }}</td>
                                <td class="text-center">{{ $pd->refound != '' ? $pd->refound : '0' }}</td>
                                <td class="text-center">{{ $pd->payment_method != '' ? $pd->payment_method : '' }}</td>
                                <td class="text-center">{{ $pd->receive_by_name != '' ? $pd->receive_by_name : '0' }}
                                </td>
                                <td class="text-center">
                                    {{ isset($pd->cancel_date) ? date('d F Y', strtotime($pd->cancel_date)) : '' }}<br>
                                    {{ $pd->cancel_by_name != '' ? $pd->cancel_by_name : '' }}
                                </td>
                            </tr>
                        @elseif ($pd->status == 2)
                            <tr style="background-color: #f39a9af0 !important">
                                <td class="text-center">{{ $key + 1 }}</td>
                                <td class="text-center">
                                    {{ isset($pd->date) ? date('d F Y', strtotime($pd->date)) : '' }}
                                </td>
                                <td class="text-center">
                                    {{ $pd->current_paid_amount != '' ? $pd->current_paid_amount : '0' }}</td>
                                <td class="text-center">{{ $pd->refound != '' ? $pd->refound : '0' }}</td>
                                <td class="text-center">{{ $pd->payment_method != '' ? $pd->payment_method : '' }}</td>
                                <td class="text-center">{{ $pd->receive_by_name != '' ? $pd->receive_by_name : '0' }}
                                </td>
                                <td class="text-center">
                                    {{ isset($pd->cancel_date) ? date('d F Y', strtotime($pd->cancel_date)) : '' }}<br>
                                    {{ $pd->cancel_by_name != '' ? $pd->cancel_by_name : '' }}
                                </td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            </tbody>
        </table>

        <table style="border: 0px;">
            <table class="third_table" style="border: 0px;">
                <tbody>
                    <tr>
                        <td style="border: 0px;"><b>Total Item</b></td>
                        <td style="border: 0px;">:&nbsp;{{ $product_qty }}</td>
                    </tr>
                    <tr>
                        <td style="border: 0px;"><b>Total Item Price</b></td>
                        <td style="border: 0px;">:&nbsp;{{ $total_item_price }}</td>
                    </tr>
                    <tr>
                        <td style="border: 0px;"><b>Total Item Discount</b></td>
                        <td style="border: 0px;">:&nbsp;{{ number_format($total_item_discount, 2) }}</td>
                    </tr>
                    <tr>
                        <td style="border: 0px;"><b>Total Item Price With Discount</b></td>
                        <td style="border: 0px;">
                            :&nbsp;{{ number_format($total_item_price - $total_item_discount, 2) }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 0px;"><b>Special Discount Amount</b></td>
                        <td style="border: 0px;">
                            :&nbsp;{{ $invoice['discount_amount'] ? $invoice['discount_amount'] : '0' }}</td>
                    </tr>
                    <tr>
                        <td style="border: 0px;"><b>Description</b></td>
                        <td style="border: 0px;">
                            :&nbsp;{{ isset($invoice['description']) ? $invoice['description'] : '...' }}</td>
                    </tr>
                </tbody>
            </table>
            @php
                $grand_total = floor($total_item_price - $total_item_discount) - ($invoice['discount_amount'] ? $invoice['discount_amount'] : '0');
            @endphp
            <table class="four_table" style="border: 0px;">
                <tbody>
                    <tr>
                        <td style="border: 0px;"><b>Grand Total</b></td>
                        <td style="border: 0px;">:&nbsp;{{ $grand_total }}</td>
                    </tr>
                    <tr>
                        <td style="border: 0px;"><b>Paid Amount</b></td>
                        <td style="border: 0px;">:&nbsp;{{ $invoice['paid_amount'] ? $invoice['paid_amount'] : '0' }}
                        </td>
                    </tr>
                    <tr>
                        <td style="border: 0px;"><b>Due Amount</b></td>
                        <td style="border: 0px;">
                            :&nbsp;{{ $grand_total - ($invoice['paid_amount'] ? $invoice['paid_amount'] : '0') }}</td>
                    </tr>
                    <tr>
                        <td style="border: 0px;"><b>Payment Status</b></td>
                        <td style="border: 0px;">:&nbsp;
                            @if ($grand_total - ($invoice['paid_amount'] ? $invoice['paid_amount'] : '0') > 0)
                                <span class="p-1 bg-rounded" style="background-color:#ffc107;">Due</span>
                            @else
                                <span class="white_color p-1 bg-rounded" style="background-color:#17a2b8;">Paid</span>
                            @endif
                        </td>
                    </tr>

                </tbody>
            </table>
        </table>
        </p>
    </main>
</body>

</html>
