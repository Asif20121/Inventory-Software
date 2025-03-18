@extends('dashboard.admin.layouts.master')

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin/bdatepicker/datepicker.min.css') }}">

@endpush
@php
    $data = isset($edit_data) ? $edit_data : '';

    $name = isset($data->name) ? $data->name : '';
    $phone = isset($data->phone) ? $data->phone : '';
    $email = isset($data->email) ? $data->email : '';
    $status = isset($data->status) ? $data->status : '';
    $admin_type = isset($data->admin_type) ? $data->admin_type : '';
    $role_type = isset($data->role_type) ? $data->role_type : '';

    $card_no = isset($data->admin_detail_data->card_no) && $data->admin_detail_data->card_no != '' ? $data->admin_detail_data->card_no : '';
    $designation_id = isset($data->admin_detail_data->designation_id) && $data->admin_detail_data->designation_id != '' ? $data->admin_detail_data->designation_id : '';
    $department_id = isset($data->admin_detail_data->department_id) && $data->admin_detail_data->department_id != '' ? $data->admin_detail_data->department_id : '';
    $company_id = isset($data->admin_detail_data->company_id) && $data->admin_detail_data->company_id != '' ? $data->admin_detail_data->company_id : '';
    $nid_id = isset($data->admin_detail_data->nid_id) && $data->admin_detail_data->nid_id != '' ? $data->admin_detail_data->nid_id : '';
    $dob = isset($data->admin_detail_data->dob) && $data->admin_detail_data->dob != '' ? date('d-m-Y', strtotime($data->admin_detail_data->dob)) : '';
    $gender = isset($data->admin_detail_data->gender) && $data->admin_detail_data->gender != '' ? $data->admin_detail_data->gender : '';
    $religion = isset($data->admin_detail_data->religion) && $data->admin_detail_data->religion != '' ? $data->admin_detail_data->religion : '';
    $b_group = isset($data->admin_detail_data->b_group) && $data->admin_detail_data->b_group != '' ? $data->admin_detail_data->b_group : '';
    $tin = isset($data->admin_detail_data->tin) && $data->admin_detail_data->tin != '' ? $data->admin_detail_data->tin : '';
    $address = isset($data->admin_detail_data->address) && $data->admin_detail_data->address != '' ? $data->admin_detail_data->address : '';
    $ref_by = isset($data->admin_detail_data->ref_by) && $data->admin_detail_data->ref_by != '' ? $data->admin_detail_data->ref_by : '';
    $family_mn = isset($data->admin_detail_data->family_mn) && $data->admin_detail_data->family_mn != '' ? $data->admin_detail_data->family_mn : '';
    $family_mp = isset($data->admin_detail_data->family_mp) && $data->admin_detail_data->family_mp != '' ? $data->admin_detail_data->family_mp : '';
    $source = isset($data->admin_detail_data->source) && $data->admin_detail_data->source != '' ? $data->admin_detail_data->source : '';
    $joining_date = isset($data->admin_detail_data->joining_date) && $data->admin_detail_data->joining_date != '' ? date('d-m-Y', strtotime($data->admin_detail_data->joining_date)) : '';
    $admin_note = isset($data->admin_detail_data->admin_note) && $data->admin_detail_data->admin_note != '' ? $data->admin_detail_data->admin_note : '';
    $image = isset($data->admin_detail_data->image) && $data->admin_detail_data->image != '' ? $data->admin_detail_data->image : '';

    $id = isset($data->id) ? $data->id : '';

@endphp

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $id ? 'Edit Employee' : 'Add New Employee' }} </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Employee</a></li>
                            <li class="breadcrumb-item active">Create</li>
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
                                    Create Employee
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('admin.admin_list') }}">Employee
                                        List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form id="employee_form"
                                    action="{{ $id ? route('admin.admin_update', $id) : route('admin.admin_store') }}"
                                    method="POST" enctype="multipart/form-data">
                                    @csrf

                                    <input type="hidden" value="{{ $admin_type }}" name="admin_type">
                                    <input type="hidden" name="image_id" value="{{ $image }}">

                                    <div class="row">
                                        <div class="col-md-4">
                                            <label for="">Name</label> <span class="text-danger">*</span>
                                            <input type="text" name="name" class="form-control bg-light"
                                                placeholder="Name" value="{{ $name }}">
                                            <span class="text-danger">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-4">
                                            <label for="">Phone</label><span class="text-danger">*</span>
                                            <input type="text" name="phone" class="form-control bg-light"
                                                placeholder="Phone" value="{{ $phone }}">
                                            <span class="text-danger">
                                                @error('phone')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>


                                        <div class="col-md-4">
                                            <label for="">Email</label><span class="text-danger">*</span>
                                            <input name="email" type="email" class="form-control bg-light"
                                                value="{{ $email }}" {{ $id == '' ? '' : 'disabled' }}
                                                placeholder="Email">
                                            <span class="text-danger">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-4 mt-4 ">
                                            <label for="">Card No</label><span class="text-danger">*</span>
                                            <input name="card_no" type="text" class="form-control bg-light"
                                                value="{{ $card_no }}" {{ $id == '' ? '' : 'disabled' }}
                                                placeholder="Card No">
                                            <span class="text-danger">
                                                @error('card_no')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>



                                        <div class="col-md-4 mt-4 {{ $role_type == '5' ? 'd-none' : '' }}">
                                            <label for="">Password</label>
                                            @if ($id == '')
                                                <span class="text-danger">*</span>
                                            @endif
                                            <input name="password" type="password" class="form-control bg-light"
                                                autocomplete="off" placeholder="password">
                                            <span class="text-danger">
                                                @error('password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>



                                        <div class="col-md-4 mt-4 text-center {{ $role_type == '5' ? 'd-none' : '' }} ">
                                            <input {{ $status == 1 ? 'checked' : '' }} name="status"
                                                class="form-control mt-5" type="checkbox" value="1"
                                                id="flexCheckDefault">
                                            <label class="form-check-label" for=""><strong>Status</strong></label>
                                        </div>



                                        <div class="col-md-4 mt-4 {{ $role_type == '5' ? 'd-none' : '' }}">
                                            <label for="">Admin Role</label>
                                            <select name="role" class="form-control bg-light search_box">
                                                <option value="">Select A Role</option>
                                                @if (isset($role))
                                                    @foreach ($role as $key => $r)
                                                        <option value="{{ $r->id }}"
                                                            @if ($data) {{ $data->hasRole($r->id) ? 'selected' : '' }} @endif>
                                                            {{ $r->name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>


                                        <div class="col-md-4 mt-4">
                                            <label for="">Designation</label>
                                            <select class="custom-select search_box" name="designation_id">
                                                <option value="">Select a Designation</option>
                                                @if (isset($designation))
                                                    @foreach ($designation as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ $value->id == $designation_id ? 'selected' : '' }}>
                                                            {{ $value->designation_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger">
                                                @error('designation_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <label for="">Department</label>
                                            <select class="custom-select search_box" name="department_id">
                                                <option value="">Select a Department</option>
                                                @if (isset($department))
                                                    @foreach ($department as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ $value->id == $department_id ? 'selected' : '' }}>
                                                            {{ $value->department_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger">
                                                @error('department_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <label for="">Company</label>
                                            <select class="custom-select search_box" name="company_id">
                                                <option value="">Select a Company</option>
                                                @if (isset($company))
                                                    @foreach ($company as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ $value->id == $company_id ? 'selected' : '' }}>
                                                            {{ $value->company_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger">
                                                @error('company_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <label for="">Nid Id</label>
                                            <input type="text" name="nid_id" class="form-control bg-light"
                                                placeholder="Nid Id" value="{{ $nid_id }}">
                                            <span class="text-danger">
                                                @error('nid_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>



                                        <div class="col-md-4 mt-4">
                                            <label for="">Date of Birth</label>
                                            <div class="input-container">
                                                <input type="text" name="dob" id="dob"
                                                    class="form-control datepicker" autocomplete="off"
                                                    placeholder="dd-mm-yy" value="{{ $dob }}">
                                                <i class="far fa-calendar-alt custom_icon"></i>
                                            </div>
                                            <span class="text-danger">
                                                @error('dob')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>


                                        <div class="col-md-4 mt-4">
                                            <label for="">Gender</label>
                                            <select class="custom-select search_box" name="gender">
                                                <option value="">Select Gender</option>
                                                <option value="1" {{ $gender == 1 ? 'selected' : '' }}>Male </option>
                                                <option value="2" {{ $gender == 2 ? 'selected' : '' }}>Female
                                                </option>
                                                <option value="3" {{ $gender == 3 ? 'selected' : '' }}>Others
                                                </option>
                                            </select>
                                            <span class="text-danger">
                                                @error('gender')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>


                                        <div class="col-md-4 mt-4">
                                            <label for="">Religion</label>
                                            <select class="custom-select search_box" name="religion">
                                                <option value="">Select a Religion</option>
                                                @if (isset($pre_religion))
                                                    @foreach ($pre_religion as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ $value->id == $religion ? 'selected' : '' }}>
                                                            {{ $value->religion_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>

                                            <span class="text-danger">
                                                @error('religion')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <label for="">Blood group</label>
                                            <select class="custom-select search_box" name="b_group">
                                                <option value="">Select a B.Group</option>
                                                @if (isset($blood_group))
                                                    @foreach ($blood_group as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ $value->id == $b_group ? 'selected' : '' }}>
                                                            {{ $value->bloodgroup_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger">
                                                @error('b_group')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>


                                        <div class="col-md-4 mt-4">
                                            <label for="">Tin No</label>
                                            <input type="text" name="tin" class="form-control bg-light"
                                                placeholder="Tin No" value="{{ $tin }}">
                                            <span class="text-danger">
                                                @error('tin')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <label for="">Address</label>
                                            <input type="text" name="address" class="form-control bg-light"
                                                placeholder="Address" value="{{ $address }}">
                                            <span class="text-danger">
                                                @error('address')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <label for="">Reference By</label>
                                            <input type="text" name="ref_by" class="form-control bg-light"
                                                placeholder="Reference By" value="{{ $ref_by }}">
                                        </div>


                                        <div class="col-md-4 mt-4">
                                            <label for="">Family Member</label>
                                            <input type="text" name="family_mn" class="form-control bg-light"
                                                placeholder="Name" value="{{ $family_mn }}">
                                            <input type="text" name="family_mp" class="form-control bg-light"
                                                placeholder="Phone Number" value="{{ $family_mp }}">
                                        </div>


                                        <div class="col-md-4 mt-4">
                                            <label for="">Source</label>
                                            <input type="text" name="source" class="form-control bg-light"
                                                placeholder="Source" value="{{ $source }}">
                                        </div>
                                        <div class="col-md-4 mt-4">
                                            <label for="">Joining Date</label>
                                            <div class="input-container">
                                                <input type="text" name="joining_date" id="joining_date"
                                                    class="form-control  datepicker" autocomplete="off"
                                                    placeholder="dd-mm-yy" value="{{ $joining_date }}">
                                                <i class="far fa-calendar-alt custom_icon"></i>
                                            </div>
                                            <span class="text-danger">
                                                @error('joining_date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        {{-- class="custom-file-input" --}}
                                        <div class="col-md-4 mt-4">
                                            <label for="">Photo <span class="text-warning">(Max: 1024
                                                    kb)</span></label>
                                            <input type="file" id="image" name="image"
                                                class="form-control bg-light " value="" accept="image/*">
                                            <span class="text-danger" id="msg_v"> @error('image')
                                                    {{ $message }}
                                                @enderror
                                            </span>

                                            <div id="">
                                                <img id="show_image"
                                                    src="{{ $image != '' ? URL::to('storage/employee/' . $image) : asset('no_image.png') }}"
                                                    style="width: 200px;height:200px" class="rounded elevation-2 m-2"
                                                    alt="No Image">
                                            </div>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <label for="">Admin Note</label>
                                            <textarea name="admin_note" class="form-control bg-light" id="" cols="30" rows="2"
                                                placeholder="Admin Note">{{ $admin_note }}</textarea>
                                        </div>

                                        <div class="col text-right pt-5">
                                            <button class="btn btn-info">{{ $id ? 'Update' : 'Save' }}</button>
                                        </div>
                                    </div>

                                </form>
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
    <script src="{{ asset('admin/bdatepicker/bootstrap-datepicker.min.js') }}"></script>
    <script src="{{ asset('admin') }}/plugins/jquery-validation/jquery.validate.min.js"></script>
    <script>
        $(".datepicker", ).datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy',
            autoclose: true
        });
    </script>

    <script>
        image_validation("#image", "#show_image", "#msg_v", '1024', "Image Size Can't larger than 1024 KB")
    </script>

    <script>
        $(function() {

            let id = "{{ $id }}";

            if (id) {
                $('#employee_form').validate({
                    rules: {
                        name: {
                            required: true,
                            minlength: 3,
                            maxlength: 200
                        },
                        phone: {
                            required: true,
                            minlength: 8,
                            maxlength: 50
                        },
                        email: {
                            required: true,
                            email: true,
                            maxlength: 200
                        },
                        card_no: {
                            required: true,
                            maxlength: 200
                        },
                        password: {
                            maxlength: 200,
                            minlength: 6,
                            strongPassword: true
                        },
                    },
                });

                $.validator.addMethod("strongPassword", function(value, element) {
                    // Allow null or empty values
                    if (value === null || value.trim() === "") {
                        return true;
                    }

                    // Check for strong password criteria
                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/.test(value);
                }, "Must have a capital and small letter, special character, and number.");


            } else {

                $('#employee_form').validate({
                    rules: {
                        name: {
                            required: true,
                            minlength: 3,
                            maxlength: 200
                        },
                        phone: {
                            required: true,
                            minlength: 8,
                            maxlength: 50
                        },
                        email: {
                            required: true,
                            email: true,
                            maxlength: 200
                        },
                        card_no: {
                            required: true,
                            maxlength: 200
                        },
                        password: {
                            required: true,
                            maxlength: 200,
                            minlength: 6,
                            strongPassword: true
                        },
                    },

                });
                $.validator.addMethod("strongPassword", function(value, element) {
                    return /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]/.test(value);
                }, "Mustbe capital and small letter, special character , and number.");
            }



        });
    </script>
@endpush
