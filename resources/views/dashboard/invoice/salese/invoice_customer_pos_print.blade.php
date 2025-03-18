<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Pos Print</title>
    <style>
        @media print {

            .hidden-print,
            .hidden-print * {
                display: none !important;
            }
        }

        body {
            font-family: 'VCR OSD Mono';
            color: #000;
            text-align: center;
            display: flex;
            justify-content: center;
            font-size: 9px;
        }

        .bill {
            width: 200px;
        }

        .flex {
            display: flex;
        }

        .justify-between {
            justify-content: space-between;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table .header {
            border-top: 1px dashed #000;
            border-bottom: 1px dashed #000;
        }

        .table {
            text-align: center;
        }

        .product {
            text-align: left;
        }

        .table .total td:first-of-type {
            border-top: none;
            border-bottom: none;
        }

        .table .total td {
            border-top: 1px dashed #000;
        }

        .table .net-amount td:first-of-type {
            border-top: none;
        }

        .table .net-amount td {
            border-top: 1px dashed #000;
        }

        .table .net-amount {
            border-bottom: 1px dashed #000;
        }

        .brand {
            font-size: 1.8em;
            border-bottom: 1px dashed #000;
            margin-bottom: 10px;
            padding-bottom: 8px;
        }

        .address {
            margin-bottom: 10px;
        }
    </style>
</head>
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

<body>
    <div class="bill">

        <div class="brand">
            {{ isset($admin_logos->website_name) ? $admin_logos->website_name : '' }}&nbsp;({{ isset($invoice['store_name']) ? $invoice['store_name'] : '' }})
        </div>
        <div class="address">
            @if (isset($invoice['store_address']))
                {{ isset($invoice['store_address']) ? $invoice['store_address'] : '' }}<br>
            @else
            @endif
            {{ isset($invoice['customer_name']) ? $invoice['customer_name'] : '' }}<br>
            @if (isset($invoice['customer_email']))
                {{ isset($invoice['customer_email']) ? $invoice['customer_email'] : '' }}<br>
            @else
            @endif
            {{ isset($invoice['customer_phone']) ? $invoice['customer_phone'] : '' }}<br>
            Invoice No: {{ $invoice['invoice_no'] }}<br>
            Date: {{ date('d F Y', strtotime($invoice['date'])) }}
        </div>

        <table class="table">
            <tr class="header">
                <th>Item</th>
                <th>Qty</th>
                <th>Dis</th>
                <th>Amount</th>
            </tr>

            @php
                $product_qty = 0;
                $total_item_price = 0;
                $total_item_discount = 0;
            @endphp

            @if (count($invoice['invoice_details']) > 0)
                @foreach ($invoice['invoice_details'] as $key => $item)
                    <tr>
                        <td class="product">{{ $key + 1 }}. {{ $item->product_name ? $item->product_name : '' }}
                        </td>
                        <td>{{ $item->remainingqty ? $item->remainingqty : '0' }}</td>
                        <td>{{ $item->unit_discount ? $item->unit_discount : '0' }}</td>
                        <td>{{ $item->unit_price_wd ? $item->unit_price_wd : '0' }}</td>
                    </tr>

                    @php
                        $product_qty = $product_qty + ($item->remainingqty ? $item->remainingqty : '0');
                        $total_item_price = $total_item_price + ($item->item_price_wod ? $item->item_price_wod : '0');
                        $total_item_discount = $total_item_discount + ($item->unit_price * $item->remainingqty * $item->unit_discount) / 100;
                    @endphp
                @endforeach
            @endif

            @php
                $grand_total = floor($total_item_price - $total_item_discount) - ($invoice['discount_amount'] ? $invoice['discount_amount'] : '0');
            @endphp

            <tr class="total">
                <td></td>
                <td>Total</td>
                <td></td>
                <td>{{ $total_item_price }}</td>
            </tr>
            <tr class="dis">
                <td></td>
                <td>T.Dis</td>
                <td></td>
                <td>{{ number_format($total_item_discount, 2) }}</td>
            </tr>
            <tr class="net-amount">
                <td></td>
                <td>Net Amnt</td>
                <td></td>
                <td>{{ number_format($total_item_price - $total_item_discount, 2) }}</td>
            </tr>

        </table>
        <div class="legalcopy">
            <p><strong>Thank You!</strong><br>
                Visit Again.
            </p>
        </div>
    </div>
</body>

</html>
