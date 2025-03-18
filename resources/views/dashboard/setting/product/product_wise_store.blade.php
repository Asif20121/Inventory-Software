@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product Wise Store </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Product Wise Store</a></li>
                            <li class="breadcrumb-item active">List</li>
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
                        <div class="card ">
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
                                    Store List &nbsp;
                                    <span class='bg-success rounded px-1'>{{ $active }} </span>&nbsp;
                                    <span class='bg-warning rounded px-1'>{{ $inactive }}
                                    </span>&nbsp;&nbsp;&nbsp;&nbsp;
                                    Product Name : <strong>{{ $product->product_name }}</strong>,
                                    Code : <strong>{{ $product->product_code }}</strong>

                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary open_modal"
                                        data-action="{{ route('invoice_setting.open_product_wise_store', $product->id) }}"
                                        data-title="Add Product Wise Store (<strong>{{ $product->product_name }}</strong>)"
                                        data-modal="common_modal_lg">Add Product Wise Store
                                    </a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive ">
                                    <table class="table  datatable" id="q_table" style="width: 100%">
                                        <thead class="table-bordered bg-light">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th>Store Name</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Buying Price</th>
                                                <th class="text-center">Sales Price</th>
                                                <th class="text-center">Discount (%)</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Create</th>
                                                <th class="text-center">Update</th>
                                                <th class="text-center" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody class="table-bordered ">
                                            @foreach ($product_wise_store as $key => $pws)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $pws->store_name }}</td>
                                                    <td class="text-center">{{ $pws->qty }}</td>
                                                    <td class="text-center">{{ $pws->current_buying_price }}</td>
                                                    <td class="text-center">{{ $pws->current_sales_price }}</td>
                                                    <td class="text-center">{{ $pws->discount }}</td>
                                                    <td class="text-center">
                                                        @if ($pws->status == 1)
                                                            <span class="bg-success rounded px-1">Active</span>
                                                        @else
                                                            <span class="bg-warning rounded px-1">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $pws->created_by }} <br>
                                                        {{ date('d F Y', strtotime($pws->created_at)) }}
                                                    </td>
                                                    <td class="text-center">
                                                        {{ $pws->updated_by }} <br>
                                                        {{ date('d F Y', strtotime($pws->updated_at)) }}
                                                    </td>
                                                    <td class="text-center">
                                                        <a type="button" class="h5 open_modal"
                                                            data-action="{{ route('invoice_setting.open_product_wise_store_edit', $pws->id) }}"
                                                            data-title="Edit Product Wise Store"
                                                            data-modal="common_modal_lg"><i
                                                                class="fas fa-edit text-info"></i> </a>

                                                        {{-- <a href="{{ route('invoice_setting.open_product_wise_store_delete', $pws->id) }}"
                                                            class="delete_data h5 text-danger"><i
                                                                class="fas fa-trash-alt"></i></a> --}}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                        <tfoot class="table-bordered ">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th>Store Name</th>
                                                <th class="text-center">Quantity</th>
                                                <th class="text-center">Buying Price</th>
                                                <th class="text-center">Sales Price</th>
                                                <th class="text-center">Discount (%)</th>
                                                <th class="text-center">Status</th>
                                                <th class="text-center">Create</th>
                                                <th class="text-center">Update</th>
                                                <th class="text-center" class="text-center">Action</th>
                                            </tr>
                                        </tfoot>
                                    </table>
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
@endpush
