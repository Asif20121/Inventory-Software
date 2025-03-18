@extends('dashboard.admin.layouts.master')
@php
    $data = isset($supplier) ? $supplier : '';
    $id = isset($data->id) && $data->id != '' ? $data->id : '';
    $supplier_name = isset($data->supplier_name) && $data->supplier_name != '' ? $data->supplier_name : '';
    $email = isset($data->email) && $data->email != '' ? $data->email : '';
    $phone = isset($data->phone) && $data->phone != '' ? $data->phone : '';
    $address = isset($data->address) && $data->address != '' ? $data->address : '';
    $description = isset($data->description) && $data->description != '' ? $data->description : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';
@endphp

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $id ? 'Edit Supplier' : 'Add New Supplier' }} </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Supplier</a></li>
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
                                    Create Supplier
                                </h3>
                                <div class="card-tools">
                                            <a class="btn btn-primary" href="{{ route('invoice_setting.supplier_list') }}">Supplier
                                                List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ $id ? route('invoice_setting.supplier_update', $id) : route('invoice_setting.supplier_store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div  class="col-md-4 col-sm-12 mt- text-left">
                                            <label for="">Supplier Name</label><span class="text-danger">*</span>
                                            <input type="text" name="supplier_name" class="form-control bg-light"
                                                placeholder="Supplier Name" value="{{$supplier_name}}">
                                            <span class="text-danger">
                                                @error('supplier_name')
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
                                        <div class="col-md-4 col-sm-12 mt-4 text-center">
                                            <input {{$status == 1 ? 'checked' : '' }} name="status" class="form-control" type="checkbox" value="1">
                                            <label class="form-check-label" for=""><strong>Status</strong></label>
                                        </div>
                                    </div>

                                    <div class="row">
                                    <div  class="col-md-8 col-sm-12 text-left">
                                            <label for="">Description</label>
                                            <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="5" placeholder="Message" style="font-size: 16px;">{{$description}}</textarea>
                                            <span class="text-danger">
                                                @error('description')
                                                    {{ $message }}
                                                @enderror
                                            </span>
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
