@extends('dashboard.admin.layouts.master')

@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin/bdatepicker/datepicker.min.css') }}">
@endpush
@php
    $data = isset($expense_manage) ? $expense_manage : '';
    $expense_date = isset($data->expense_date) && $data->expense_date != '' ? date('d-m-Y', strtotime($data->expense_date)) : '';
    $store_id = isset($data->store_id) && $data->store_id != '' ? $data->store_id : '';
    $expense_type = isset($data->expense_type) && $data->expense_type != '' ? $data->expense_type : '';
    $cost = isset($data->cost) ? $data->cost : '';
    $description = isset($data->description) && $data->description != '' ? $data->description : '';
    $id = isset($data->id) ? $data->id : '';

@endphp

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $id ? 'Edit Expense Manage' : 'Add New Expense Manage' }} </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Expense Manage</a></li>
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
                                    Create Expense Manage
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('admin.expense_manage_list') }}">Expense
                                        Manage
                                        List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form
                                    action="{{ $id ? route('admin.expense_manage_update', $id) : route('admin.expense_manage_store') }}"
                                    method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-4 mt-4">
                                            <label for="">Expense Date</label><span class="text-danger">*</span>
                                            <div class="input-container">
                                                <input type="text" name="expense_date" id="expense_date" class="form-control"
                                                    autocomplete="off" placeholder="dd-mm-yy" value="{{ $expense_date }}">
                                                    <i class="far fa-calendar-alt custom_icon"></i>
                                            </div>
                                            <span class="text-danger">
                                                @error('expense_date')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <label for="">Store Name</label><span class="text-danger">*</span>
                                            <select class="custom-select search_box" name="store_id">
                                                <option value="">Select a Store</option>
                                                @if (isset($pre_store))
                                                    @foreach ($pre_store as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ $value->id == $store_id ? 'selected' : '' }}>
                                                            {{ $value->store_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger">
                                                @error('store_id')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col-md-4 mt-4">
                                            <label for="">Expense Type</label><span class="text-danger">*</span>
                                            <select class="custom-select search_box" name="expense_type">
                                                <option value="">Select Expense Type</option>
                                                @if (isset($pre_expense))
                                                    @foreach ($pre_expense as $key => $value)
                                                        <option value="{{ $value->id }}"
                                                            {{ $value->id == $expense_type ? 'selected' : '' }}>
                                                            {{ $value->type_name }} </option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger">
                                                @error('expense_type')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mt-3">
                                        <div class="col-md-4">
                                            <label for="">Cost</label> <span class="text-danger">*</span>
                                            <input type="number" name="cost" class="form-control bg-light"
                                                placeholder="Cost" value="{{ $cost }}" min="0" oninput="validity.valid||(value='');">
                                            <span class="text-danger">
                                                @error('cost')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-4 col-sm-12 text-left">
                                            <label for="">Description</label>
                                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="1" placeholder="Message"
                                                style="font-size: 16px;">{{ $description }}</textarea>
                                            <span class="text-danger">
                                                @error('description')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="col text-right pt-4">
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
    <script>
        $("#expense_date", ).datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy',
            autoclose: true
        });
    </script>
@endpush
