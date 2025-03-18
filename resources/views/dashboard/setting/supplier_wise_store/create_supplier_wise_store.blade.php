@extends('dashboard.admin.layouts.master')
@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> Add New Supplier Wise Store </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Supplier Wise Store</a></li>
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
                                    Add New Supplier Wise Store
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('invoice_setting.supplier_wise_store_list') }}">Supplier
                                        Wise Store
                                        List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ route('invoice_setting.supplier_wise_store_store') }}" method="POST">
                                    @csrf

                                    <div class="row">
                                        <div class="col-md-1 col-sm-12 mt-2 text-left">
                                            <label for="">Supplier<span class="text-danger">*</span>
                                        </div>
                                        <div class="col-md-11 col-sm-12 mt-2 text-left">
                                            <select name="supplier" class="form-control search_box ">
                                                <option value="">Select Supplier</option>
                                                @if (count($suppliers) > 0)
                                                    @foreach ($suppliers as $key => $supplier)
                                                        <option value="{{$supplier->id}}">{{$key+1}}. {{$supplier->supplier_name}}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger"> @error('supplier')
                                                    {{ $message }}
                                                @enderror
                                            </span>
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
                                            <input name="status" class="form-control" type="checkbox" value="1">
                                            <label class="form-check-label" for=""><strong>Status</strong></label>
                                        </div>

                                        <div class="col-md-10 text-right pt-5">
                                            <button class="btn btn-info">Save</button>
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
        $("#all_permission").click(function() {
            if ($(this).is(':checked')) {
                $('.store_check').prop('checked', true)
            } else {
                $('.store_check ').prop('checked', false)
            }
        })
    </script>
@endpush
