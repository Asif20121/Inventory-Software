<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Summery Reports</title>

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

        .all{
            line-height: 60%;
            margin-left: 20%;
            margin-top: 2%;
            font-size: 1.5em;
            font-family: 'Roboto';
        }
        .total_one {
            width: 100%;
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
                <h2 class="name">{{ isset($admin_logos->website_name) ? $admin_logos->website_name : '' }}</h2>
                <div>{{ isset($admin_logos->address) ? $admin_logos->address : '' }}</div>
                <div>
                    Phone:&nbsp;{{ isset($admin_logos->contact_number) ? $admin_logos->contact_number : '' }}
                </div>
                <div>E-mail:&nbsp;<a
                        href="#">{{ isset($admin_logos->email) ? $admin_logos->email : '' }}</a></div>
            </div>
        @endif
        <div class="info">
            <h2><span>Income Summery Report</span></h2>
            <h5>
                Date : {{ $from_date && $from_date != '' ? $from_date : '' }}
                -
                {{ $to_date && $to_date != '' ? $to_date : '' }}
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
    <main>
        <p style="page-break-after: never;">
            @if (isset($employee) || isset($invoice))
                <div style="background-color: #faf8f8;padding:1%; width: 96%; margin-left: 1%;">
                    <div style="margin-left: 1%;  font-size: 14px; font-family: sans-serif; color: #5b5b5b;">
                        @if (isset($employee))
                            <h4 class="title">
                                &nbsp; <b>E.Name :</b>&nbsp; {{ $employee->name != '' ? $employee->name : '' }}
                                ({{ $employee->card_no != '' ? $employee->card_no : '' }})
                            </h4>
                        @endif
                        @if (isset($invoice))
                            <h4 class="title">
                                &nbsp; <b>Invoice no
                                    :</b>&nbsp;{{ $invoice->invoice_no != '' ? $invoice->invoice_no : '' }}
                            </h4>
                        @endif
                    </div>
                </div>
                <br>
            @endif

            <div class="all">
                <div class="total_one">
                    <div style="width: 45%; float: left;">Total Receive Amount</div>
                    <div style="width: 45%; float: right;">: &nbsp;{{ $invoice_details_arr[0]->receive_amount != '' ? $invoice_details_arr[0]->receive_amount : '0' }}</div>
                </div>
            </div>
        </p>

    </main>
</body>

</html>
