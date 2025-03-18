@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Reorder List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Reorder</a></li>
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

                                <form id="reorder_list_print" method="post" autocomplete="off">
                                    @csrf
                                    <div class="row d-flex justify-content-between align-items-center ">

                                        <div class="col-md-5 col-sm-12">
                                            <strong> Store</strong>
                                            <select id="store_filter" name="store_filter" class="form-control search_box " style="width: 100%">
                                                <option value="">All Store</option>
                                                @if (count($store) > 0)
                                                    @foreach ($store as $key => $s)
                                                        <option value="{{ $s->id }}">{{ $key + 1 }}.{{ $s->store_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-md-5 col-sm-12">
                                            <strong> Category</strong>
                                            <select id="category_filter" name="category_filter" class="form-control search_box "
                                                style="width: 100%">
                                                <option value="">All Category</option>
                                                @if (count($category) > 0)
                                                    @foreach ($category as $key => $c)
                                                        <option value="{{ $c->id }}">{{ $key + 1 }}.{{ $c->category_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>

                                        <div class="col-md-2  col-sm-12 text-right">
                                            <button class="btn btn-warning mt-3">Print </button>

                                        </div>

                                    </div>
                                    <div class="row">
                                        <div class="col-md-12">
                                            <span class="text-danger" id="store_validation"></span>
                                        </div>
                                    </div>
                                </form>
                            </div>



                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive">
                                        <table class="table table-bordered" id="y_datatable">
                                            <thead class="bg-light">

                                                <tr>
                                                    <th class="text-center">#</th>
                                                    <th class="text-center">P. Code</th>
                                                    <th class="text-center">P. Name</th>
                                                    <th class="text-center">Store</th>
                                                    <th class="text-center">Category</th>
                                                    <th class="text-center">Reminder QTY</th>
                                                    <th class="text-center">Qty</th>
                                                    <th class="text-center">Sales Price</th>
                                                    <th class="text-center">Discount</th>
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

        let fetchData = async (store = '', category = '') => {
            let datatable = await $('#y_datatable').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [10, 25, 50, 100, 500, 1000],
                ajax: {
                    url: "{{ route('admin.reorder_list') }}",
                    data: {
                        store: store,
                        category: category,
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
                        data: 'product_code',
                        name: 'product_code'
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
                        className: "text-center",
                        data: 'reorder_qty',
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
                    }

                ]
            })
        }


        $(document).on('change', '#store_filter,#category_filter', function() {
            let store_filter = $("#store_filter").val();
            let category_filter = $("#category_filter").val();
            $('#y_datatable').DataTable().destroy();
            fetchData(store_filter, category_filter)
        });



        $(document).ready(function() {
            $("#reorder_list_print").submit(function() {
                $("#store_validation").text("")

                let store_filter = $("#store_filter").val();

                if (store_filter) {
                    $(this).attr("target", "_blank");
                    $(this).attr("action", "{{ route('admin.reorder_list_print') }}");
                } else {
                    event.preventDefault()
                    $("#store_validation").text("Please Select Store")
                }


            });
        });
    </script>
@endpush
