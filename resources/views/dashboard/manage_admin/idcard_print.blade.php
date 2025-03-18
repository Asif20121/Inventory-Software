<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee IdCard</title>

</head>

<style>
    body {
        font-family: 'verdana';
    }

    .id-card-main {
        width: 84%;
        padding-left: 8%;
        padding-right: 8%;
        position: relative;
    }

    .id-card-font {
        background: url({{ asset('admin/idcard/front.jpg') }}) no-repeat center / cover;
        padding: 10px;
        width: 250px;
        height: 400px;
        border-radius: 10px;
        border: 1px solid black;
        float: left;
    }

    .id-card-back {
        background: url({{ asset('admin/idcard/back.jpg') }}) no-repeat center / cover;
        padding: 10px;
        width: 250px;
        height: 400px;
        border-radius: 10px;
        border: 1px solid black;
        float: right;
    }

    .logo-one img {
        margin-top: 3px;
    }

    .admin img {
        margin-top: 14px;
        border-radius: 100%;
        margin-left: 72px;
    }

    .title {
        line-height: 0%;
        text-align: center;
        margin-top: 18px;
    }

    .title h2 {
        font-size: 23px;
    }

    .line {
        width: 60%;
        height: 1px;
        border: none;
        color: #333;
        background-color: #333;
    }

    .bio {
        text-align: left;
        margin-left: 5px;
        font-size: 12px;
        line-height: 140%;
        font-family: 'Arial Narrow';
    }


    /*......... back page ..........*/

    .logo-two img {
        margin-top: 3px;
    }

    .found {
        text-align: center;
        color: rgb(83, 83, 84);
        font-family: 'Arial Narrow';
        font-size: 70%;
        font-style: italic;

    }

    .qr img {
        margin-top: 38%;
        margin-left: 35%;
        border-style: solid;
        border-width: 2px 2px 0px 2px;
        padding: 1%;
        border-radius: 2px 2px;
    }

    .scan {
        background-color: black;
        color: white;
        text-align: center;
        width: 57px;
        padding: 1px;
        margin-left: 35%;
        font-size: 10px;
        border-radius: 0px 0px 2px 2px;
    }

    .address p {
        font-size: 70%;
        line-height: 140%;
    }

    .line-two {
        width: 50%;
        height: 1px;
        border: none;
        color: #333;
        background-color: #333;
        margin-right: 50%;
    }

    .date {
        font-size: 70%;
        margin-top: 0px;
    }
</style>

@php
    $data = isset($employee_idcard) ? $employee_idcard : '';
    $name = isset($data->name) ? $data->name : '';
    $phone = isset($data->phone) ? $data->phone : '';
    $email = isset($data->email) ? $data->email : '';

    $card_no = isset($data->admin_detail_data->card_no) && $data->admin_detail_data->card_no != '' ? $data->admin_detail_data->card_no : '';
    $designation_name = isset($data->admin_detail_data->designation_data->designation_name) && $data->admin_detail_data->designation_data->designation_name != '' ? $data->admin_detail_data->designation_data->designation_name : '';
    $company_name = isset($data->admin_detail_data->company_data->company_name) && $data->admin_detail_data->company_data->company_name != '' ? $data->admin_detail_data->company_data->company_name : '';
    $bloodgroup_name = isset($data->admin_detail_data->blood_group_data->bloodgroup_name) && $data->admin_detail_data->blood_group_data->bloodgroup_name != '' ? $data->admin_detail_data->blood_group_data->bloodgroup_name : '';
    $image = isset($data->admin_detail_data->image) && $data->admin_detail_data->image != '' ? $data->admin_detail_data->image : '';
    $id = isset($data->id) ? $data->id : '';
@endphp

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
    <div class="id-card-main">
        <div class="id-card-font">
            <div class="logo-one">
                @if ($logo_image == '' || $logo_image == null)
                    <img src="{{ asset('no_image.png') }}" width="60px" height="60px" alt="image">
                @else
                    <img src="{{ URL::to('storage/logo_image', $logo_image) }}" width="60px" height="60px"
                        alt="image">
                @endif
            </div>
            <div class="admin">
                <img src="{{ $image != '' ? URL::to('storage/employee/' . $image) : asset('no_image.png') }}"
                    width="110px" height="110px" alt="image">
            </div>
            <div class="title">
                <h2>{{ $name }}</span></h2>
                <h5>
                    {{ $designation_name }} <br>
                    <hr class="line">
                </h5>
            </div>
            <div class="bio">
                <strong>ID </strong><strong style="margin-left: 12%"> : </strong> {{ $card_no }}<br>
                <strong>Email </strong><strong style="margin-left: 5%"> : </strong> {{ $email }}<br>
                <strong>Phone &nbsp;&nbsp;&nbsp;&nbsp; : </strong> {{ $phone }} <br>
                <strong>Blood G</strong><strong style="margin-left: 2%">&nbsp;: </strong> {{ $bloodgroup_name }}<br>
            </div>

        </div>
        <div class="id-card-back">
            <div class="logo-two">
                @if ($logo_image == '' || $logo_image == null)
                    <img src="{{ asset('no_image.png') }}" width="60px" height="60px" alt="image">
                @else
                    <img src="{{ URL::to('storage/logo_image', $logo_image) }}" width="60px" height="60px"
                        alt="image">
                @endif
            </div>

            <div class="qr">
                <img src="data:image/png;base64, {!! $qrcode !!}"><br>
                <div class="scan"> Scan me</div>
            </div>

            <div class="address">
                <p>
                    <img src="{{ asset('admin/idcard/website.png') }}" width="12px" height="12px"
                        alt="icon">&nbsp;{{ isset($admin_logos->web_url) ? $admin_logos->web_url : 'No web url' }}
                    <br>

                    <img src="{{ asset('admin/idcard/call.png') }}" width="12px" height="12px"
                        alt="icon">&nbsp;Helpline(24/7)
                    :{{ isset($admin_logos->contact_number) ? $admin_logos->contact_number : 'No Contact number' }}
                    <br>

                    <img src="{{ asset('admin/idcard/location.png') }}" width="12px" height="12px"
                        alt="icon">&nbsp;{{ isset($admin_logos->address) ? $admin_logos->address : 'No Address' }}
                </p>
            </div>

            <div>
                <h5>
                    <hr class="line-two">
                    Authorized Signature <br>
                    <span class="date">Validity : {{ date('d F Y', strtotime($admin_logos->validity_date)) }}</span>
                    <br>
                    <span class="found">If found, Please return.</span>
                </h5>
            </div>

        </div>
    </div>
</body>

</html>
