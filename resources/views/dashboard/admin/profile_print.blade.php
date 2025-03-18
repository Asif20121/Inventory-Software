
@php
    $data = isset($profile_info_print) ? $profile_info_print : '';

    $name = isset($data->name) ? $data->name : '';
    $phone = isset($data->phone) ? $data->phone : '';
    $email = isset($data->email) ? $data->email : '';
    $status = isset($data->status) ? $data->status : '';
    $admin_type = isset($data->admin_type) ? $data->admin_type : '';
    $role_type = isset($data->role_type) ? $data->role_type : '';

    $card_no = isset($data->card_no) && $data->card_no != '' ? $data->card_no : '';
    $designation_name = isset($data->designation_name) && $data->designation_name != '' ? $data->designation_name : '';
    $company_name = isset($data->company_name) && $data->company_name != '' ? $data->company_name : '';
    $department_name = isset($data->department_name) && $data->department_name != '' ? $data->department_name : '';
    $nid_id = isset($data->nid_id) && $data->nid_id != '' ? $data->nid_id : '';
    $dob = isset($data->dob) && $data->dob != '' ? date('d-m-Y', strtotime($data->dob)): '';
    $gender = isset($data->gender) && $data->gender != '' ? $data->gender : '';
    $religion_name = isset($data->religion_name) && $data->religion_name != '' ? $data->religion_name : '';
    $bloodgroup_name = isset($data->bloodgroup_name) && $data->bloodgroup_name != '' ? $data->bloodgroup_name : '';
    $tin = isset($data->tin) && $data->tin != '' ? $data->tin : '';
    $address = isset($data->address) && $data->address != '' ? $data->address : '';
    $ref_by = isset($data->ref_by) && $data->ref_by != '' ? $data->ref_by : '';
    $family_mn = isset($data->family_mn) && $data->family_mn != '' ? $data->family_mn : '';
    $family_mp = isset($data->family_mp) && $data->family_mp != '' ? $data->family_mp : '';
    $source = isset($data->source) && $data->source != '' ? $data->source : '';
    $joining_date = isset($data->joining_date) && $data->joining_date != '' ?  date('d-m-Y', strtotime($data->joining_date)): '';
    $admin_note = isset($data->admin_note) && $data->admin_note != '' ? $data->admin_note : '';
    $image = isset($data->image) && $data->image != '' ? $data->image : '';
    $id = isset($data->id) ? $data->id : '';
@endphp
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Information</title>

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

        h2{
            font-family: sans-serif;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 10px !important;
            float: center;
        }

        table,td {
            padding: 5px;
            font-size: 15px;
        }

        .info{
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
            border-radius:5px;
            font-family: ;
        }
        
        img {
            margin-bottom:8%;
        }
        
    </style>
</head>
<body>
    <header class="clearfix">
        @php
            $admin_logos = '';
            $logo_image='';
            if ( count(DB::table('logo_titles')->where('status', '1')->get(),) != 0) {
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
           <h2 class="name">{{isset($admin_logos->website_name) ? $admin_logos->website_name : "No Name"}}</h2>
           <div>{{isset($admin_logos->address) ? $admin_logos->address : "No Address"}}</div>
           <div>Phone: {{isset($admin_logos->contact_number) ? $admin_logos->contact_number : "No Contact number"}}</div>
           <div><a href="#">{{isset($admin_logos->email) ? $admin_logos->email : "No email"}}</a></div>
        </div>
        <div class="info">
            <h2>Your Information</h2>
        </div>
    </header>
    <hr style="height:1px;border:none;color:#333;background-color:#333;">
    <footer>
            Power By :
            <strong style="color: rgb(14, 14, 101)">{{isset($admin_logos->website_name) ? $admin_logos->website_name : "No Name"}}</strong>&nbsp; Print Date :
            <strong style="color: rgb(14, 14, 101)">{{date('d F Y')}}</strong>  Print by : {{Auth::user()->name}}
    </footer>
    <main>
        <p style="page-break-after: never;">
            <table>
                <tbody>
                    <tr>
                        <td>   
                            <div class="img_shadow">
                                <img src="{{ $image != '' ? URL::to('storage/employee/' . $image) : asset('no_image.png') }}"
                                style="width: 150px;height:150px" alt="No Image">
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td ><b>Name</b></td>
                        <td >:&nbsp; {{$name}}</td>
                        <td ><b>Email</b></td>
                        <td >:&nbsp; {{$email}}</td>
                    </tr>
                    <tr>
                        <td ><b>Phone</b></td>
                        <td >:&nbsp; {{$phone}}</td>
                        <td ><b>Card No</b></td>
                        <td >:&nbsp; {{$card_no}}</td>
                    </tr>
                    <tr>
                        <td ><b>Designation</b></td>
                        <td >:&nbsp; {{$designation_name}}</td>
                        <td ><b>Department</b></td>
                        <td >:&nbsp; {{$department_name}}</td>
                    </tr>
                    <tr>
                        <td ><b>Company</b></td>
                        <td >:&nbsp; {{$company_name}}</td>
                        <td ><b>Nid Id</b></td>
                        <td >:&nbsp; {{$nid_id}}</td>
                    </tr>
                    <tr>
                        <td ><b>Date of Birth</b></td>
                        <td >:&nbsp; {{$dob}}</td>
                        <td ><b>Gender</b></td>
                        <td >:&nbsp; @if ($gender == 1) Male 
                               @elseif ($gender == 2) Female 
                               @elseif($gender == 3) Others
                               @endif
                        </td>
                    </tr>
                    <tr>
                        <td ><b>Religion</b></td>
                        <td >:&nbsp; {{$religion_name}}</td>
                        <td ><b>Blood group</b></td>
                        <td >:&nbsp; {{$bloodgroup_name}}</td>
                    </tr>
                    <tr>
                        <td ><b>Tin No</b></td>
                        <td >:&nbsp; {{$tin}}</td>
                        <td ><b>Address</b></td>
                        <td >:&nbsp; {{$address}}</td>
                    </tr>
                    <tr>
                        <td ><b>Reference By</b></td>
                        <td >:&nbsp; {{$ref_by}}</td>
                        <td ><b>Family Member</b></td>
                        <td >:
                            Name: {{$family_mn}} <br> 
                            &nbsp; Phone: {{$family_mp}}
                        </td>
                    </tr>
                    <tr>
                        <td ><b>Source</b></td>
                        <td >:&nbsp; {{$source}}</td>
                        <td ><b>Joining Date</b></td>
                        <td >:&nbsp; {{$joining_date}}</td>
                    </tr>
                </tbody>
            </table>
        </p>
    </main>
</body>
</html>