@extends('dashboard.admin.layouts.master')
@php
    $data = isset($product) ? $product : '';
    $id = isset($data->id) && $data->id != '' ? $data->id : '';
    $product_name = isset($data->product_name) && $data->product_name != '' ? $data->product_name : '';
    $unit_id = isset($data->unit_id) && $data->unit_id != '' ? $data->unit_id : '';
    $category_id = isset($data->category_id) && $data->category_id != '' ? $data->category_id : '';
    $quantity = isset($data->quantity) && $data->quantity != '' ? $data->quantity : '';
    $current_buy_price = isset($data->current_buy_price) && $data->current_buy_price != '' ? $data->current_buy_price : '';
    $current_sales_price = isset($data->current_sales_price) && $data->current_sales_price != '' ? $data->current_sales_price : '';
    $discount = isset($data->discount) && $data->discount != '' ? $data->discount : '';
    $description = isset($data->description) && $data->description != '' ? $data->description : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';
    $reorder_qty = isset($data->reorder_qty) && $data->reorder_qty != '' ? $data->reorder_qty : 10;
@endphp

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $id ? 'Edit Product' : 'Add New Product' }} </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Product</a></li>
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
                                    Create Product
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('invoice_setting.product_list') }}">Product
                                        List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form id="product_form"
                                    action="{{ $id ? route('invoice_setting.product_update', $id) : route('invoice_setting.product_store') }}"
                                    method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-12 mt-2 col-sm-12 mt-2 text-left">
                                                    <label for="">Product Name</label><span
                                                        class="text-danger">*</span>
                                                    <input type="text" name="product_name" class="form-control bg-light"
                                                        placeholder="Product Name" value="{{ $product_name }}">
                                                    <span class="text-danger">
                                                        @error('product_name')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>

                                                <div class="col-md-12 mt-2 col-sm-12 mt-2 text-left">
                                                    <label for="">Unit Name</label><span
                                                        class="text-danger">*</span>
                                                    <select name="unit_id" class="form-control search_box">
                                                        <option value="">Select Unit</option>
                                                        @foreach ($unit as $un)
                                                            <option value="{{ $un->id }}"
                                                                {{ $un->id == $unit_id ? 'selected' : '' }}>
                                                                {{ $un->unit_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger">
                                                        @error('unit_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>

                                                <div class="col-md-12 mt-2 col-sm-12 mt-2 text-left">
                                                    <label for="">Category Name</label><span
                                                        class="text-danger">*</span>
                                                    <select name="category_id" class="form-control search_box">
                                                        <option value="">Select Category</option>
                                                        @foreach ($category as $cat)
                                                            <option value="{{ $cat->id }}"
                                                                {{ $cat->id == $category_id ? 'selected' : '' }}>
                                                                {{ $cat->category_name }}</option>
                                                        @endforeach
                                                    </select>
                                                    <span class="text-danger">
                                                        @error('category_id')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>

                                                <div class="col-md-12 mt-2 col-sm-12 mt- text-left">
                                                    <label for="">Description</label>
                                                    <textarea class="form-control" name="description" id="exampleFormControlTextarea1" rows="1"
                                                        placeholder="Description" style="font-size: 16px;">{{ $description }}</textarea>
                                                    <span class="text-danger">
                                                        @error('description')
                                                            {{ $message }}
                                                        @enderror
                                                    </span>
                                                </div>

                                                <div class="col-md-12 mt-2 col-sm-12 mt-2 text-left">
                                                    <label for="">Reorder QTY</label>
                                                    <input type="number" min="1" oninput="validity.valid||(value='');" name="reorder_qty" class="form-control bg-light" placeholder="10" value="{{ $reorder_qty }}">
                                                    <span class="text-danger"> @error('reorder_qty') {{ $message }} @enderror</span>
                                                </div>


                                            </div>
                                        </div>

                                        @if ($id == '')
                                            <div class="col-md-1">

                                                <div style="border-left: 1px solid rgb(50, 50, 50); height: 100%;"></div>
                                            </div>


                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <h5>Store Privilege</h5>
                                                    </div>
                                                    <div class="col-md-5">
                                                        <label for="">Store</label>
                                                        <select id="store" class="form-control search_box">
                                                            <option value="">Select Store</option>
                                                            @foreach ($store as $st)
                                                                <option value="{{ $st->id }}">
                                                                    {{ $st->store_name }}</option>
                                                            @endforeach
                                                        </select>
                                                    </div>
                                                    <div class="col-md-3">
                                                        <label for="">Seeling Price</label>
                                                        <input type="number" class="form-control sell_price" value="0"
                                                            id="sell_price" oninput="validity.valid||(value='');"
                                                            min="0">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label for="">Discount(%)</label>
                                                        <input type="number" class="form-control discount" value="0"
                                                            id="discount" oninput="validity.valid||(value='');"
                                                            min="0">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <button type="button" class="btn btn-sm btn-outline-success"
                                                            id="add_store" style="margin-top: 33px;">+ Add</button>
                                                    </div>
                                                    <div class="col-md-12">
                                                        <span id="no_data" class="text-danger"></span>
                                                    </div>

                                                    <div class="col-md-12 mt-4">
                                                        <table class="table table-striped">
                                                            <thead class="bg-secondary">
                                                                <tr>
                                                                    <th scope="col">#</th>
                                                                    <th scope="col">Store </th>
                                                                    <th scope="col">Selling Price</th>
                                                                    <th scope="col">Discount(%)</th>
                                                                    <th scope="col">Action</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody id="addRow">
                                                            </tbody>
                                                        </table>
                                                    </div>
                                                </div>

                                            </div>
                                        @endif
                                    </div>

                                    <div class="row mt-2">
                                        <div class="col-md-6 col-sm-12 mt-5 text-center">
                                            <input {{ $status == 1 ? 'checked' : '' }} name="status"
                                                class="form-control" type="checkbox" value="1">
                                            <label class="form-check-label text-center"
                                                for=""><strong>Status</strong></label>
                                        </div>

                                        <div class="col-md-6 text-right pt-5">
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
<script src="{{ asset('admin') }}/plugins/jquery-validation/jquery.validate.min.js"></script>

    <script id="document_template" type="text/x-handlebars-template">
    <tr class="delete_add_more_item" id="delete_add_more_item">
    <td >@{{ sl_no }}</td>
    <td> <input type="hidden" class="store_id" name="store_id[]" value="@{{store_id}}" style="width: 100%;"> @{{ store_name }}</td>
    <td><input type="number"  class="sell_price" name="sell_price[]" value="@{{sell_price}}" oninput="validity.valid||(value='');" min="0" style="width: 100%;"></td>
    <td><input type="number"  class="discount" name="discount[]" value="@{{discount}}" oninput="validity.valid||(value='');" min="0" style="width: 100%;"></td>
    <td><i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i></td>
    </tr>
  </script>


    <script>
        let sl_no = 0;
        $(document).on("click", "#add_store", function() {
            event.preventDefault()
            $("#no_data").text('');
            var store_id = $("#store").val();
            var store_name = $("#store").find('option:selected').text();
            var sell_price = $("#sell_price").val() ? $("#sell_price").val() : 0;
            var discount = $("#discount").val() ? $("#discount").val() : 0;
            let count_data = 0;
            $('#addRow tr').each(function() {
                var foreach_id = $(this).find('input.store_id').val();
                if (store_id == foreach_id) {
                    count_data++

                }
            });

            if (store_id) {
                if (count_data == 0) {
                    sl_no++
                    var source = $("#document_template").html();
                    var tamplate = Handlebars.compile(source);
                    var data = {
                        store_id: store_id,
                        store_name: store_name,
                        sell_price: sell_price,
                        discount: discount,
                        sl_no: sl_no,
                    };
                    var html = tamplate(data);
                    $("#addRow").append(html);

                } else {
                    $("#no_data").text('Store Already Exist');
                }
            } else {
                $("#no_data").text('Please Select a Store');
            }

        });


        $(document).on("click", ".removeeventmore", function(event) {
            $(this).closest(".delete_add_more_item").remove();
        });
    </script>

    <script>
           $('#product_form').validate({
                    rules: {
                        product_name: {  required: true, minlength: 3, maxlength: 200 },
                        unit_id: {  required: true},
                        category_id: {  required: true}
                    },

                });
    </script>
@endpush
