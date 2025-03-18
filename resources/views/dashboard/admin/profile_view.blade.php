@extends('dashboard.admin.layouts.master')

@php
    $data = isset($profile_view) ? $profile_view : '';

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

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Your Profile </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Your</a></li>
                            <li class="breadcrumb-item active">Profile</li>
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
                                <h3 class="card-title">

                                </h3>
                                <div class="card-tools">
                                            <a target="_blank" href="{{route('admin.profile_print')}}" class="btn btn-warning px-5 ">Print</a>&nbsp&nbsp
                                            <a class="btn btn-primary" href="{{route('admin.profile.edit')}}">Update Your Profile</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">

                                    <div class="row px-3">

                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Name</strong>  :&nbsp :{{$name}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Email</strong> :&nbsp {{$email}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Phone</strong> :&nbsp {{$phone}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Card No</strong>:&nbsp {{$card_no}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Designation</strong>:&nbsp {{$designation_name}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Department</strong>:&nbsp {{$department_name}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Company</strong> :&nbsp{{$company_name}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Nid Id</strong>:&nbsp{{$nid_id}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Date of Birth</strong>:&nbsp {{$dob}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Gender</strong> :&nbsp
                                            @if ($gender == 1) Male
                                            @elseif ($gender == 2) Female
                                            @elseif ($gender == 3) Others
                                            @endif
                                       </div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Religion</strong> :&nbsp{{$religion_name}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Blood group</strong>:&nbsp{{$bloodgroup_name}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Tin No</strong>  :&nbsp{{$tin}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Address</strong> :&nbsp{{$address}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Reference By</strong>:&nbsp {{$ref_by}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2">
                                            <strong>Family Member</strong>: <br/>
                                            Name:{{$family_mn}} <br>
                                            Phone: {{$family_mp}}
                                        </div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Source</strong>:&nbsp {{$source}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Joining Date</strong>:&nbsp {{$joining_date}}</div>
                                        <div class="col-sm-6 col-md-4 mt-2"><strong>Photo</strong>
                                            <div id="">
                                                <img id="show_image"
                                                    src="{{ $image != '' ? URL::to('storage/employee/' . $image) : asset('no_image.png') }}"
                                                    style="width: 200px;height:200px" class="rounded elevation-2 m-2"
                                                    alt="No Image">
                                            </div>
                                        </div>

                                    </div>

                            </div><!-- /.card-body -->
                        </div>
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
        image_validation("#image", "#show_image", "#msg_v", '1024', "Image Size Can't larger than 1024 KB")
    </script>
@endpush
