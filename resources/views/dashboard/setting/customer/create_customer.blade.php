@extends('dashboard.admin.layouts.master')
@php
    $data = isset($customer) ? $customer : '';
    $id = isset($data->id) && $data->id != '' ? $data->id : '';
    $customer_name = isset($data->customer_name) && $data->customer_name != '' ? $data->customer_name : '';
    $email = isset($data->email) && $data->email != '' ? $data->email : '';
    $phone = isset($data->phone) && $data->phone != '' ? $data->phone : '';
    $address = isset($data->address) && $data->address != '' ? $data->address : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';
@endphp

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $id ? 'Edit Customer' : 'Add New Customer' }} </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Customer</a></li>
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
                                    Create Customer
                                </h3>
                                <div class="card-tools">
                                            <a class="btn btn-primary" href="{{ route('invoice_setting.customer_list') }}">Customer
                                                List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ $id ? route('invoice_setting.customer_update', $id) : route('invoice_setting.customer_store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div  class="col-md-4 col-sm-12 mt- text-left">
                                            <label for="">Customer Name</label>
                                            <input type="text" name="customer_name" class="form-control bg-light"
                                                placeholder="Customer Name" value="{{$customer_name}}">
                                            <span class="text-danger">
                                                @error('customer_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div  class="col-md-4 col-sm-12 mt- text-left">
                                            <label for="">Email</label>
                                            <input type="text" name="email" class="form-control bg-light"
                                                placeholder="Enter Email" value="{{$email}}">
                                            <span class="text-danger">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div  class="col-md-4 col-sm-12 mt- text-left">
                                            <label for="">Phone</label> <span class="text-danger">*</span>
                                            <input type="text" name="phone" class="form-control bg-light"
                                                placeholder="phone" value="{{$phone}}">
                                            <span class="text-danger">
                                                @error('phone')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>

                                    <div class="row mt-3">
                                        <div  class="col-md-4 col-sm-12 mt- text-left">
                                            <label for="">Address</label>
                                            <input type="text" name="address" class="form-control bg-light"
                                                placeholder="Address " value="{{$address}}">
                                            <span class="text-danger">
                                                @error('address')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-2 col-sm-12 mt-4 text-center">
                                            <input {{$status == 1 ? 'checked' : '' }} name="status" class="form-control" type="checkbox" value="1">
                                            <label class="form-check-label" for=""><strong>Status</strong></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                        <div class="col text-right pt-3">
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
