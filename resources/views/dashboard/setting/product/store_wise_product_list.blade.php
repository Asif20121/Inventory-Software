@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Store Wise Product List</h1>
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
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="y_datatable">
                                        <thead class="bg-light">

                                            <tr>
                                                <th  class="text-center">#</th>
                                                <th  class="text-center" >P. Name</th>
                                                <th  class="text-center">
                                                    <select id="store_filter" class="form-control search_box " style="width: 200px">
                                                        <option value="">Store</option>
                                                        @if (count($store) > 0)
                                                            @foreach ($store as $key => $s)
                                                                <option value="{{ $s->id }}">{{ $key + 1 }}.
                                                                    {{ $s->store_name }}</option>
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
                                                <th  class="text-center">Qty</th>
                                                <th  class="text-center">Sales Price</th>
                                                <th  class="text-center">Discount</th>
                                                <th  class="text-center">Status</th>
                                                <th  class="text-center"> L.Update</th>
                                                <th  class="text-center">Action</th>
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
        //Fetch Data
        $(function() {
            fetchData('', '', '');
        })

        let fetchData = async (store = '', category = '', unit = '') => {
            var table = await $('#y_datatable').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [10, 25, 50, 100, 500, 1000],
                ajax: {
                    url: "{{ route('invoice_setting.product_sw_list') }}",
                    data: {
                        store: store,
                        category: category,
                        unit: unit
                    }
                },
                columns: [{
                        className: "text-center",
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        className: "text-left",
                        data: 'product_name',
                        name: 'product_name'
                    },
                    {
                        className: "text-left",
                        data: 'store_name',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        className: "text-left",
                        data: 'category_name',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        className: "text-left",
                        data: 'unit_name',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        className: "text-center",
                        data: 'qty',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        className: "text-center",
                        data: 'current_sales_price',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        className: "text-center",
                        data: 'discount',
                        'orderable': false,
                        'searchable': false
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
                        'searchable': false
                    },
                    {
                        className: "text-center",
                        data: 'update_date'
                    },
                    {
                        className: "text-center",
                        data: 'action',
                        render: function(data, type, full, meta) {
                            var editUrl = data.editUrl;
                            var product_sw_view = data.product_sw_view;
                            let action = ''
                            action +=
                                `
                                <a type="button" data-action="${product_sw_view}" data-modal="common_modal_xl" title="Product Details" data-title="Product Details" class="btn-sm btn-secondary open_modal"><i class="fas fa-eye"></i></a>
                                &nbsp;&nbsp; <a href="${editUrl}" class="btn-sm btn-info"><i class="fas fa-edit "></i></a>
                                `;


                            return `${action}`;
                        },
                        orderable: false
                    },

                ]
            })
        }


        $(document).on('change', '#store_filter,#category_filter,#unit_filter', function() {
            let store_filter = $("#store_filter").val();
            let category_filter = $("#category_filter").val();
            let unit_filter = $("#unit_filter").val();
            $('#y_datatable').DataTable().destroy();
            fetchData(store_filter,category_filter,unit_filter)
        });
    </script>
@endpush
