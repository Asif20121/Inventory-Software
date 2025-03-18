@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Product List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Product</a></li>
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
                                    Product List &nbsp;
                                    <span class='bg-success rounded px-1'>{{ $active }} </span>&nbsp;
                                    <span class='bg-warning rounded px-1'>{{ $inactive }} </span>
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('invoice_setting.product_create') }}">Add New
                                        Product</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="y_datatable">
                                        <thead class="bg-light">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Product info</th>
                                                <th  class="text-center">
                                                    <select id="unit_filter" class="form-control search_box " style="width: 200px">
                                                        <option value="">Unit</option>
                                                        @if (count($unit) > 0)
                                                            @foreach ($unit as $key => $u)
                                                                <option value="{{ $u->id }}">{{ $key + 1 }}.
                                                                    {{ $u->unit_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                </th>
                                                <th  class="text-center" >
                                                    <select id="category_filter" class="form-control search_box " style="width: 200px">
                                                        <option value="">Category</option>
                                                        @if (count($category) > 0)
                                                            @foreach ($category as $key => $c)
                                                                <option value="{{ $c->id }}">{{ $key + 1 }}.
                                                                    {{ $c->category_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>

                                                </th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">L.Update</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>

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
    <script>
        $(function() {
            fetchData('', '');
        })
        let fetchData = async (category = '', unit = '') => {
            var table = await $('#y_datatable').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [10, 25, 50, 100, 500, 1000],
                ajax: {
                    url: "{{ route('invoice_setting.product_list') }}",
                    data: {
                        category: category,
                        unit: unit
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        className: "text-left w-25",
                        data: 'info',
                        name: 'product_name',
                        render: function(data, type, full, meta) {
                            let info = `
                       <strong>Code</strong> : ${data.product_code} </br>
                       <strong>Name</strong> : ${data.product_name} </br>
                       `;
                            return `${info}`;
                        },
                        orderable: false
                    },
                    {
                        data: 'unit_name',
                        name: 'product_code',
                        orderable: false
                    },
                    {
                        data: 'category',
                        'orderable': false,
                    },
                    {
                        className: "text-center",
                        data: 'status',
                        render: function(data, type, full, meta) {
                            let status = '';
                            if (data == 1) {
                                status = '<span class="bg-success rounded px-1">Active</span>'
                            } else if (data == 0) {
                                status = '<span class="bg-warning rounded px-1">Inactive</span>'
                            }
                            return `${status}`;
                        },
                        orderable: false
                    },
                    {
                        className: "text-left",
                        data: 'update',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        className: "text-center",
                        data: 'action',
                        render: function(data, type, full, meta) {
                            var product_view = data.product_view;
                            var editUrl = data.editUrl;
                            var store_url = data.store;
                            var product_barcode = data.product_barcode;
                            let action = ''
                            action +=
                                `
                                <div class="dropdown dropleft">
                                    <button class="btn-sm btn-info dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Select One</button>
                                    <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                      <a type="button" class="dropdown-item open_modal" data-action="${product_view}" data-modal="common_modal_xl" title="Product Details" data-title="Product Details" ><button  class="btn btn-warning">Product Details</button></a>
                                      <a class="dropdown-item" href="${store_url}"><button  class="btn btn-info">Product Wise Store</button></a>
                                      <a class="dropdown-item" href="${editUrl}"><button  class="btn btn-info">Edit Product</button></a>
                                      <a class="dropdown-item" href="${product_barcode}" target="blank" ><button  class="btn btn-secondary">BarCode</button></a>

                                    </div>

                                  </div>
                                            `;


                            return `${action}`;
                        },
                        'orderable': false,
                        'searchable': false
                    },

                ]
            })
        }


        $(document).on('change', '#category_filter,#unit_filter', function() {
            let category_filter = $("#category_filter").val();
            let unit_filter = $("#unit_filter").val();
            $('#y_datatable').DataTable().destroy();
            fetchData(category_filter,unit_filter)
        });
    </script>
@endpush
