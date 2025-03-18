<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reorder List</title>

    <style>
        @page {
            margin: 0px 50px;
        }

        /* @font-face {
            font-family: kalpurush;
            src: url({{ storage_path('fonts/kalpurush.ttf') }});
            font-weight: normal;
        } */



        body {
            margin-top: 6cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 2cm;
            /* font-family: kalpurush,sans-serif; */
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
                {{ isset($admin_logos->website_name) ? $admin_logos->website_name : '' }}&nbsp;({{ isset($store['store_name']) ? $store['store_name'] : '' }})
            </h2>
            <div class="text-left">{{ isset($store['address']) ? $store['address'] : '' }}</div>
            <div>
                @if (isset($store['phone']))
                    Phone : &nbsp;{{ isset($store['phone']) ? $store['phone'] : '' }}
                @else
                @endif
            </div>
            <div>
                @if (isset($store['email']))
                    Email : &nbsp;<a
                        href="#">{{ isset($store['email']) ? $store['email'] : '' }}</a>
                @else
                @endif
            </div>
            <div>
                @if (isset($store['web_url']))
                    Web: &nbsp;<a
                        href="#">{{ isset($store['web_url']) ? $store['web_url'] : '' }}</a>
                @else
                @endif
            </div>
        </div>
        <div class="info">
            <h2>
                <span>Reorder List</span>
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



        <p style="page-break-after: never;">

            @if (isset($category))
            <strong>Category:</strong>{{$category->category_name}}
            @endif

        <table>
            <thead>
                <tr class="bg-blue">
                    <th width="5%">Sl.No.</th>
                    <th width="15%">Store</th>
                    <th width="35%">Product Name</th>
                    <th width="5%">Category</th>
                    <th width="5%">RO.QTY</th>
                    <th width="5%">P.QTY</th>
                    <th width="5%">S.Price</th>
                    <th width="5%">Discount</th>
                </tr>
            </thead>
            <tbody>
                @if (count($reorder_list) > 0)
                    @foreach ($reorder_list as $key => $item)
                        <tr>
                            <td width="5%">{{$key+1}}</td>
                            <td width="15%">{{$item->store_name}}</td>
                            <td width="55%">{{$item->product_name}} ({{$item->product_code}})</td>
                            <td width="5%">{{$item->category_name}}</td>
                            <td width="5%">{{$item->reorder_qty}}</td>
                            <td width="5%">{{$item->qty}}</td>
                            <td width="5%">{{$item->current_sales_price}}</td>
                            <td width="5%">{{$item->discount}}</td>
                        </tr>

                    @endforeach
                @endif
            </tbody>
        </table>

        </p>
    </main>
</body>

</html>
