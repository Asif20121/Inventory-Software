@extends('dashboard.admin.layouts.master')
@php
    $data = isset($product_sw_edit) ? $product_sw_edit : '';
    $id = isset($data->id) ? $data->id : '';

    $current_sales_price = isset($data->current_sales_price) && $data->current_sales_price != '' ? $data->current_sales_price : '';
    $discount = isset($data->discount) && $data->discount != '' ? $data->discount : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';
    $product_name = isset($data->product_data->product_name) && $data->product_data->product_name != '' ? $data->product_data->product_name : '';
    $product_code = isset($data->product_data->product_code) && $data->product_data->product_code != '' ? $data->product_data->product_code : '';
    $store_name = isset($data->store->store_name) && $data->store->store_name != '' ? $data->store->store_name : '';

@endphp

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Edit Store Wise Product</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Store Wise Product</a></li>
                            <li class="breadcrumb-item active">edit</li>
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
                                    Edit Store Wise Product
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('invoice_setting.product_sw_list') }}">Store Wise Product List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{route('invoice_setting.product_sw_update', $id) }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div  class="col-md-4">
                                            <label for="">Product Name</label>
                                            <input type="text" name="product_name" class="form-control bg-light"
                                                placeholder="Product Name" value="{{$product_name}}" disabled>
                                            <span class="text-danger">
                                                @error('product_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div  class="col-md-4">
                                            <label for="">Product Code</label>
                                            <input type="text" name="product_code" class="form-control bg-light"
                                                placeholder="Product Code" value="{{$product_code}}" disabled>
                                            <span class="text-danger">
                                                @error('product_code')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div  class="col-md-4">
                                            <label for="">Store Name</label>
                                            <input type="text" name="store_name" class="form-control bg-light"
                                                placeholder="Store Name" value="{{$store_name}}" disabled>
                                            <span class="text-danger">
                                                @error('store_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div  class="col-md-4">
                                            <label for="">Sales Price</label>
                                            <input type="number" name="current_sales_price" class="form-control bg-light"
                                                placeholder="Sales Price" value="{{$current_sales_price}}" min="0" oninput="validity.valid||(value='');">
                                            <span class="text-danger">
                                                @error('current_sales_price')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div  class="col-md-4">
                                            <label for="">Discount</label>
                                            <input type="number" name="discount" class="form-control bg-light"
                                                placeholder="Discount" value="{{$discount}}" min="0" oninput="validity.valid||(value='');">
                                            <span class="text-danger">
                                                @error('discount')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col-md-4 col-sm-12 mt-4 text-center">
                                            <input {{$status == 1 ? 'checked' : '' }} name="status" class="form-control" type="checkbox" value="1">
                                            <label class="form-check-label" for=""><strong>Status</strong></label>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col text-right pt-5">
                                            <button class="btn btn-info">Update</button>
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
