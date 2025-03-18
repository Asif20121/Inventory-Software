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

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Purchase Details</title>

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
            font-size: 14px;
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
            font-size: 13px;
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
            bottom: 8px;
            left: 0px;
            right: 0px;
            height: 45px;
            font-size: 17px !important;
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
            <h2 class="name">{{ isset($admin_logos->website_name) ? $admin_logos->website_name : '' }}</h2>
            <div>{{ isset($admin_logos->address) ? $admin_logos->address : '' }}</div>
            <div>
                Phone:&nbsp;{{ isset($admin_logos->contact_number) ? $admin_logos->contact_number : '' }}
            </div>
            <div>E-mail:&nbsp;<a href="#">{{ isset($admin_logos->email) ? $admin_logos->email : '' }}</a>
            </div>
        </div>

        <div class="info">
            <h2>
                <span>Purchase Details</span>
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
                style="margin-left: 1%; width: 50%; float:left; font-size: 13px; font-family: sans-serif; color: #5b5b5b;">
                <p>
                    <strong>Purchases Date</strong> : {{ $date }}<br>
                    <strong>Voucher</strong> : {{ $voucher }}<br>
                    <strong>Store Name</strong> : {{ $store_name }}<br>
                    <strong>Supplier</strong> : {{ $supplier }}<br>
                    <strong>Status</strong> :
                    @if ($data['status'] == 1)
                        <span class="white_color p-1 bg-rounded"
                            style="background-color:#28a745; font-size: 10px;">Active</span>
                    @else
                        <span class="p-1 bg-rounded" style="background-color:#ffc107; font-size: 10px;">Inactive</span>
                    @endif

                </p>
            </div>
            <div
                style="margin-left: 15%; width: 50% float:right; font-size: 13px; font-family: sans-serif; color: #5b5b5b;">
                <p>
                    <strong>Added By</strong> : {{ $added_by }} <br>
                    <strong>Created Date</strong> : ({{ $created_at }})<br>
                    <strong>Updated By</strong> : {{ $updated_by }} <br>
                    <strong>Updated Date</strong> : ({{ $updated_at }})
                </p>
            </div>
        </div>
        @php
            $product_qty = 0;
            $net_total_amount = 0;
        @endphp
        <p style="page-break-after: never;">

        <strong style="color: #5b5b5b;">&nbsp; Product details</strong> <br>
        <table>
            <thead>
                <tr class="bg-blue">
                    <th class="text-center">Sl.No.</th>
                    <th class="text-center">P.Name</th>
                    <th class="text-center">Quantity</th>
                    <th class="text-center">U.Price</th>
                    <th class="text-center">Discount(%)</th>
                    <th class="text-center">UPWD</th>
                    <th class="text-center">T.Price</th>
                    <th class="text-center">Status</th>
                    <th class="text-center">Update</th>
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
                                    <span class="p-1 bg-rounded" style="background-color:#ffc107;">Inactive</span>
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
        </table><br>

        @if (count($cancel_list['purchase_detailsf']) > 0)
            <strong style="color: #dc3545 !important;">&nbsp; <b>Product Cancel List</b></strong> <br>
            <table>
                <thead>
                    <tr class="bg-blue">
                        <th class="text-center">Sl.No.</th>
                        <th class="text-center">P.Name</th>
                        <th class="text-center">Quantity</th>
                        <th class="text-center">U.Price</th>
                        <th class="text-center">Discount(%)</th>
                        <th class="text-center">UPWD</th>
                        <th class="text-center">T.Price</th>
                        <th class="text-center">Status</th>
                        <th class="text-center">Update</th>
                    </tr>
                </thead>
                <tbody>
                    @if (count($cancel_list['purchase_detailsf']) > 0)
                        @foreach ($cancel_list['purchase_detailsf'] as $key => $item)
                            <tr style="background-color: #f39a9af0 !important">
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
                                        <span class="p-1 bg-rounded" style="background-color:#ffc107;">Inactive</span>
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
            </table> <br>
        @endif

        <table class="four_table" style="border: 0px;">
            <tbody>
                <tr>
                    <td style="border: 0px;"><b>Total Item</b></td>
                    <td style="border: 0px;">:&nbsp;{{ $product_qty }}</td>
                </tr>
                <tr>
                    <td style="border: 0px;"><b>Net Total Amount</b></td>
                    <td style="border: 0px;">:&nbsp;{{ $net_total_amount }}</td>
                </tr>
                <tr>
                    <td style="border: 0px;"><b>Tax</b></td>
                    <td style="border: 0px;">:&nbsp;{{ $tax }}</td>
                </tr>
                <tr>
                    <td style="border: 0px;"><b>Vat</b></td>
                    <td style="border: 0px;">:&nbsp;{{ $vat }}</td>
                </tr>
                <tr>
                    <td style="border: 0px;"><b>Shipping Cost</b></td>
                    <td style="border: 0px;">:&nbsp;{{ $shipping_cost }}</td>
                </tr>
                <tr>
                    <td style="border: 0px;"><b>Others Cost</b></td>
                    <td style="border: 0px;">:&nbsp;{{ $other_cost }}</td>
                </tr>
                <tr>
                    <td style="border: 0px;"><b>Discount</b></td>
                    <td style="border: 0px;">:&nbsp;{{ $discount }}</td>
                </tr>
                <tr>
                    <hr style="height:0.5px;border:none;color:#333;background-color:#333; width: 125%">
                </tr>
                <tr>
                    <td style="border: 0px;"><b>Grand Total</b></td>
                    <td style="border: 0px;">:&nbsp;{{ $grand_total }}</td>
                </tr>
            </tbody>
        </table>
        </p>
    </main>
</body>

</html>
