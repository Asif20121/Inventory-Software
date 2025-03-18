<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Expense List</title>

    <style>
        @page {
            margin: 0px 50px;
        }

        body {
            margin-top: 6cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 1cm;
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
            font-size: 16px;
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
            background-color: #737CA1;
            color: #fff;
            font-weight: normal;
            font-family: Verdana;
        }

        .total {
            /* background-color:#625D5D; */
            /* color: #fff; */
        }

        .info {
            line-height: 10px;
            text-align: center;
            margin-top: 20%;
            color: #625D5D;
            font-family: Futara;
            font-size: 14px;
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

        .second_table {

            width: 50%;
            float: right;
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
        @if (isset($store))
            <div id="company">
                <span class="pagenum"></span>
                <h2 class="name">
                    {{ isset($admin_logos->website_name) ? $admin_logos->website_name : '' }}&nbsp;({{ $store->store_name != '' ? $store->store_name : '' }})
                </h2>
                <div>{{ $store->address != '' ? $store->address : '' }}</div>
                <div>
                    @if (isset($store->phone))
                        Phone: &nbsp;{{ $store->phone != '' ? $store->phone : '' }}
                    @else
                    @endif
                </div>
                <div>
                    @if (isset($store->email))
                        E-mail: &nbsp;<a href="#">{{ $store->email != '' ? $store->email : '' }}</a>
                    @else
                    @endif
                </div>
                <div>
                    @if (isset($store->web_url))
                        Web: &nbsp;<a href="#">{{ $store->web_url != '' ? $store->web_url : '' }}</a>
                    @else
                    @endif
                </div>
            </div>
        @else
            <div id="company">
                <span class="pagenum"></span>
                <h2 class="name">{{ isset($admin_logos->website_name) ? $admin_logos->website_name : '' }}</h2>
                <div>{{ isset($admin_logos->address) ? $admin_logos->address : 'No Address' }}</div>
                <div>
                    Phone:&nbsp;{{ isset($admin_logos->contact_number) ? $admin_logos->contact_number : '' }}
                </div>
                <div>E-mail:&nbsp;<a
                        href="#">{{ isset($admin_logos->email) ? $admin_logos->email : '' }}</a></div>
            </div>
        @endif
        <div class="info">
            <h2><span>Expense Summery Report</span></h2>
            <h5>
                Date :
                {{ $from_date_expense && $from_date_expense != '' ? date('d F Y', strtotime($from_date_expense)) : '' }}
                -
                {{ $to_date_expense && $to_date_expense != '' ? date('d F Y', strtotime($to_date_expense)) : '' }}
            </h5>
        </div>
    </header>
    <footer>
        Power By :
        <strong
            style="color: rgb(14, 14, 101)">{{ isset($admin_logos->website_name) ? $admin_logos->website_name : '' }}</strong>&nbsp;
        Print Date :
        <strong style="color: rgb(14, 14, 101)">{{ date('d F Y') }}</strong> Print by : {{ Auth::user()->name }}
    </footer>
    @php
        $total_cost = 0;
    @endphp
    <main>
        <p style="page-break-after: never;">
            @if (isset($employee))
                <div style="background-color: #faf8f8;padding:1%; width: 96%; margin-left: 1%;">
                    <div style="margin-left: 1%;  font-size: 14px; font-family: sans-serif; color: #5b5b5b;">
                        @if (isset($employee))
                            <h4 class="title">
                                &nbsp; <b>E.Name :</b>&nbsp; {{ $employee->name != '' ? $employee->name : '' }}
                                ({{ $employee->card_no != '' ? $employee->card_no : '' }})
                            </h4>
                        @endif
                    </div>
                </div>
            @endif

            <table  style="width: 80%; margin: 0 auto; border: 0px;" >
                <tbody>

                    <tr>
                        <td style="border: 0px;"><h3>Total Cost</h3></td>
                        <td style="border: 0px;"><h3>: {{isset($expense_manage[0]->total_cost) && $expense_manage[0]->total_cost !=null ? $expense_manage[0]->total_cost : 0 }}</h3></td>
                    </tr>
                </tbody>
            </table>
        </p>
    </main>
</body>

</html>
