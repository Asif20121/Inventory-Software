@php
    $data = isset($product_view) ? $product_view : '';
    $id = isset($data->id) ? $data->id : '';

    $qty = isset($data->qty) && $data->qty != '' ? $data->qty : '';
    $current_sales_price = isset($data->current_sales_price) && $data->current_sales_price != '' ? $data->current_sales_price : '';
    $current_buying_price = isset($data->current_buying_price) && $data->current_buying_price != '' ? $data->current_buying_price : '';
    $discount = isset($data->discount) && $data->discount != '' ? $data->discount : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';
    $added_by = isset($data->created_employee->name) && $data->created_employee->name != '' ? $data->created_employee->name : '';
    $created_at = isset($data->created_at) && $data->created_at != '' ? date('d F Y', strtotime($data->created_at)) : '';
    $updated_by = isset($data->updated_employee->name) && $data->updated_employee->name != '' ? $data->updated_employee->name : '';
    $updated_at = isset($data->updated_at) && $data->updated_at != '' ? date('d F Y', strtotime($data->updated_at)) : '';
    $product_name = isset($data->product_data->product_name) && $data->product_data->product_name != '' ? $data->product_data->product_name : '';
    $product_code = isset($data->product_data->product_code) && $data->product_data->product_code != '' ? $data->product_data->product_code : '';
    $description = isset($data->product_data->description) && $data->product_data->description != '' ? $data->product_data->description : '';
    $store_name = isset($data->store->store_name) && $data->store->store_name != '' ? $data->store->store_name : '';
    $unit_name = isset($data->product_data->unit->unit_name) && $data->product_data->unit->unit_name != '' ? $data->product_data->unit->unit_name : '';
    $category_name = isset($data->product_data->category->category_name) && $data->product_data->category->category_name != '' ? $data->product_data->category->category_name : '';
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Store Wise Product</title>

    <style>
        @page {
            margin: 0px 50px;
        }

        body {
            margin-top: 5cm;
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
            text-align: center;
            line-height: 18px;
            padding: 10px 0;
        }

        h2 {
            font-family: sans-serif;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px !important;
            float: center;
        }

        table,
        td {
            padding: 5px;
            font-size: 15px;
        }

        .info {
            line-height: 10px;
            text-align: center;
            margin-top: 20%;
            color: #625D5D;
            font-family: Futara;
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
            width: 34%;
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

        img {
            margin-bottom: 8%;
        }
        .white_color{
            color: white;
        }
        .p-1{
            padding: 5px;
        }
        .bg-rounded{
            border-radius: 10px;
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
            <h2 class="name">{{ isset($admin_logos->website_name) ? $admin_logos->website_name : '' }}</h2>
            <div>{{ isset($admin_logos->address) ? $admin_logos->address : '' }}</div>
            <div>Phone: {{ isset($admin_logos->contact_number) ? $admin_logos->contact_number : '' }}
            </div>
            <div><a href="#">{{ isset($admin_logos->email) ? $admin_logos->email : '' }}</a></div>
        </div>
        <div class="info">
            <h2>Store Wise Product</h2>
        </div>
    </header>
    <hr style="height:1px;border:none;color:#333;background-color:#333;">
    <footer>
        Power By :
        <strong
            style="color: rgb(14, 14, 101)">{{ isset($admin_logos->website_name) ? $admin_logos->website_name : '' }}</strong>&nbsp;
        Print Date :
        <strong style="color: rgb(14, 14, 101)">{{ date('d F Y') }}</strong> Print by : {{ Auth::user()->name }}
    </footer>
    <main>
        <p style="page-break-after: never;">
        <table>
            <tbody>
                <tr>
                    <td><b>Product Name</b></td>
                    <td>:&nbsp; {{ $product_name }}</td>
                    <td><b>Product Code</b></td>
                    <td>:&nbsp; {{ $product_code }}</td>
                </tr>
                <tr>
                    <td><b>Store Name</b></td>
                    <td>:&nbsp; {{ $store_name }}</td>
                    <td><b>Quantity</b></td>
                    <td>:&nbsp; {{ $qty }}</td>
                </tr>
                <tr>
                    <td><b>Buying Price</b></td>
                    <td>:&nbsp; {{ $current_buying_price }}</td>
                    <td><b>Sales Price</b></td>
                    <td>:&nbsp; {{ $current_sales_price }}</td>
                </tr>
                <tr>
                    <td><b>Unit Name</b></td>
                    <td>:&nbsp; {{ $unit_name }}</td>
                    <td><b>Discount</b></td>
                    <td>:&nbsp; {{ $discount }}</td>
                </tr>
                <tr>
                    <td><b>Category Name</b></td>
                    <td>:&nbsp; {{ $category_name }}</td>
                </tr>
                <tr>
                    <td><b>Added By</b></td>
                    <td>:&nbsp; {{$added_by}}&nbsp;({{ $created_at }})</td>
                    <td><b>Status</b></td>
                    <td>:&nbsp;
                        @if ($data['status'] == 1)
                            <span class="white_color p-1 bg-rounded" style="background-color:#28a745;">Active</span>
                        @else
                            <span class="p-1 bg-rounded" style="background-color:#ffc107;">Inactive</span>
                        @endif
                    </td>
                </tr>
                <tr>
                    <td><b>Update By</b></td>
                    <td>:&nbsp; {{$updated_by}}&nbsp;({{ $updated_at }})</td>
                    <td><b>Description</b></td>
                    <td>:&nbsp; {{ $description }}</td>
                </tr>
            </tbody>
        </table>
        </p>
    </main>
</body>

</html>
