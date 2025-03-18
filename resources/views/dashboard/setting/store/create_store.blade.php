@extends('dashboard.admin.layouts.master')
@php
    $data = isset($store) ? $store : '';
    $id = isset($data->id) && $data->id != '' ? $data->id : '';
    $store_name = isset($data->store_name) && $data->store_name != '' ? $data->store_name : '';
    $phone = isset($data->phone) && $data->phone != '' ? $data->phone : '';
    $email = isset($data->email) && $data->email != '' ? $data->email : '';
    $web_url = isset($data->web_url) && $data->web_url != '' ? $data->web_url : '';
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
                        <h1 class="m-0">{{ $id ? 'Edit Store' : 'Add New Store' }} </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Store</a></li>
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
                                    Create Store
                                </h3>
                                <div class="card-tools">
                                            <a class="btn btn-primary" href="{{ route('invoice_setting.store_list') }}">Store
                                                List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ $id ? route('invoice_setting.store_update', $id) : route('invoice_setting.store_store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div  class="col-md-4 col-sm-12 mt- text-left">
                                            <label for="">Store Name</label><span class="text-danger">*</span>
                                            <input type="text" name="store_name" class="form-control bg-light"
                                                placeholder="Store Name" value="{{$store_name}}">
                                            <span class="text-danger">
                                                @error('store_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div  class="col-md-4 col-sm-12 mt- text-left">
                                            <label for="">Phone</label>
                                            <input type="text" name="phone" class="form-control bg-light"
                                                placeholder="Phone" value="{{$phone}}">
                                            <span class="text-danger">
                                                @error('phone')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div  class="col-md-4 col-sm-12 mt- text-left">
                                            <label for="">Email</label>
                                            <input type="text" name="email" class="form-control bg-light"
                                                placeholder="Email" value="{{$email}}">
                                            <span class="text-danger">
                                                @error('email')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div  class="col-md-4 col-sm-12 mt- text-left">
                                            <label for="">Web Url</label>
                                            <input type="text" name="web_url" class="form-control bg-light"
                                                placeholder="web_url" value="{{$web_url}}">
                                            <span class="text-danger">
                                                @error('web_url')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div  class="col-md-4 col-sm-12 mt- text-left">
                                            <label for="">Address</label>
                                            <textarea class="form-control bg-light" name="address" id="exampleFormControlTextarea1" rows="1" placeholder="Address" style="font-size: 16px;">{{$address}}</textarea>
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

                                    <div class="row mt-3">
                                        <div  class="col-md-8 col-sm-12 mt- text-left">
                                            <label for="">Description</label>
                                            <textarea class="form-control bg-light" name="description" id="exampleFormControlTextarea1" rows="4" placeholder="Message" style="font-size: 16px;">{{$description}}</textarea>
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
