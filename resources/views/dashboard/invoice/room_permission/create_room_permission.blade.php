@extends('dashboard.admin.layouts.master')
@php
    $data = isset($edit_sp) ? $edit_sp : '';
    $id = isset($data->id) && $data->id != '' ? $data->id : '';
    $store_id = isset($data->store_id) && $data->store_id != '' ? $data->store_id : '';
    $emp_id = isset($data->emp_id) && $data->emp_id != '' ? $data->emp_id : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';

    $emp_name = '';
    if ($emp_id != '' || $emp_id != null) {
        $emp_name = DB::table('admins')
            ->where('id', $emp_id)
            ->first()->name;
    }

@endphp

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $id ? 'Edit Store Privilege' : 'Add New Store Privilege' }} </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Store Privilege</a></li>
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
                                @if (Session::has('error'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>{{ session::get('error') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @elseif(Session::has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ session::get('success') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif
                                <h3 class="card-title">
                                    Create Store Privilege
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('admin.room_permission_list') }}">Store
                                        Privilege
                                        List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form
                                    action="{{ $id ? route('admin.room_permission_update', $id) : route('admin.room_permission_store') }}"
                                    method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-1 col-sm-12 mt-2 text-left">
                                            <label for="">Employee<span class="text-danger">*</span>
                                        </div>
                                        <div class="col-md-11 col-sm-12 mt-2 text-left">
                                            <input type="text" class="form-control" value="{{ $emp_name }}"
                                                placeholder="Search Employee" id="search_employee">
                                            <span class="text-danger" id="show_error"> @error('employee')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            <input type="hidden" id="show_emp" name="employee">
                                        </div>
                                    </div>
                                    <hr style="width: 100%">
                                    <div class="row">

                                        <div class="col-md-12">
                                            <input type="checkbox" class="" id="all_permission">
                                            <label class="form-check-label" for="all_permission">
                                                <strong> All Store Permission</strong>
                                            </label>
                                            <span class="text-danger"> @error('store')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        @foreach ($store as $key => $st)
                                            <div class="col-md-4 col-sm-12 text-left">
                                                <div class="row mt-5 ">
                                                    <div class="col-md-6"> <label for="">
                                                            <strong>{{ $key + 1 }}.
                                                                {{ $st->store_name }}</strong></label>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <input name="store[]" class="form-control store_check"
                                                            type="checkbox" value="{{ $st->id }}">
                                                    </div>
                                                </div>

                                            </div>
                                        @endforeach
                                    </div>

                                    <div class="row mt-4">
                                        <div class="col-md-2 col-sm-12 mt-4 text-center">
                                            <input {{ $status == 1 ? 'checked' : '' }} name="status" class="form-control"
                                                type="checkbox" value="1">
                                            <label class="form-check-label" for=""><strong>Status</strong></label>
                                        </div>

                                        <div class="col-md-10 text-right pt-5">
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
    <script>
        employee_search("#search_employee", "#show_emp", "#show_error")
    </script>

    <script>
        $("#all_permission").click(function() {
            if ($(this).is(':checked')) {
                $('.store_check').prop('checked', true)
            } else {
                $('.store_check ').prop('checked', false)
            }
        })
    </script>
@endpush
