@extends('dashboard.admin.layouts.master')
@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin/bdatepicker/datepicker.min.css') }}">
@endpush
@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Purchase Summery Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Purchase</a></li>
                            <li class="breadcrumb-item active">Summery</li>
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
                                <div class="">
                                    <form action="{{ route('admin.daily_purchase_summery_search_print') }}" method="post" autocomplete="off" target="_blank">
                                        @csrf
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-lg-2 col-md-3">
                                                <strong>From Date</strong>
                                                <div class="input-container">
                                                    <input name="from_date" type="text" id="from_date"
                                                        value="{{ date('Y-m') }}"
                                                        class="form-control datepicker">
                                                        <i class="far fa-calendar-alt custom_icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <strong>To Date</strong>
                                                <div class="input-container">
                                                    <input name="to_date" type="text" id="to_date"
                                                        value="{{ date('Y-m') }}"
                                                        class="form-control datepicker">
                                                        <i class="far fa-calendar-alt custom_icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <strong>Employee</strong>
                                                <input id="employee" type="text" placeholder="Search employee"
                                                    class="form-control ">
                                                <input type="hidden" id="employee_id" name="employee_id">
                                                <span class="text-danger" id="err_employee"></span>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <strong> Supplier</strong>
                                                <select name="supplier_id" id="supplier_id" class="form-control search_box">
                                                    <option value="">Select Supplier</option>
                                                    @if (count($supplier_search_data) > 0)
                                                    @foreach ($supplier_search_data as $key => $sws)
                                                        <option value="{{ $sws->supplier_id }}">{{ $sws->supplier_name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <strong> Store</strong>
                                                <select name="store_id" id="store_id" class="form-control search_box">
                                                    <option value="">Select Store</option>
                                                    @if (count($store_search_data) > 0)
                                                        @foreach ($store_search_data as $key => $st)
                                                            <option value="{{ $st->id }}">{{ $st->store_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>

                                            <div class="col-lg-2 col-md-3">
                                                <strong> Status</strong>
                                                <select id="purchase_status" name="purchase_status" class="form-control search_box">
                                                    <option value="">Select status</option>
                                                    <option value="approve">Approve</option>
                                                    <option value="pending">Pending</option>
                                                    <option value="cancel">Cancel</option>

                                                </select>
                                            </div>

                                            <div class="col-lg-3 col-md-4 ml-auto text-right pt-4">
                                                <button class="btn btn-success search_btn"
                                                    type="button">Search</button>&nbsp;&nbsp;&nbsp;
                                                <button class="btn btn-warning" type="submit">Print</button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <div class="card">

                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-12">
                                        <div class="row" style="justify-content: center">
                                            <div class="col-md-4"><strong>Tax</strong></div><div class="col-md-6">: <span id="total_tax">0</span></div>
                                            <div class="col-md-4"><strong>Vat</strong></div><div class="col-md-6">: <span id="total_vat">0</span></div>
                                            <div class="col-md-4"><strong>Shipping cost</strong></div><div class="col-md-6">: <span id="total_shiping_cost">0</span></div>
                                            <div class="col-md-4"><strong>Other cost</strong></div><div class="col-md-6">: <span id="total_other_cost">0</span></div>
                                            <div class="col-md-4"><strong>Discount</strong></div><div class="col-md-6">: <span id="total_discount">0</span></div>
                                            <div class="col-md-4"><strong>Product cost</strong></div><div class="col-md-6">: <span id="total_product_cost">0</span></div>
                                            <div class="col-md-12">
                                                <hr>
                                            </div>
                                            <div class="col-md-4"><strong>Grand total</strong></div><div class="col-md-6">: <span id="total_grand_total_cost">0</span></div>
                                        </div>
                                    </div>
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
    <script src="{{ asset('admin/bdatepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(".datepicker", ).datepicker({
            uiLibrary: 'bootstrap4',
            format: "yyyy-mm",
            startView: "months",
            minViewMode: "months",
            autoclose: true
        });

        employee_search('#employee', '#employee_id', '#err_employee')

        // All Data Show
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('.search_datatable')) {
                $('.search_datatable').DataTable().destroy();
            }
            $.ajax({
                async: true,
                type: "get",
                dataType: "json",
                url: "{{ route('admin.daily_purchase_summery_data') }}",
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {
                    pending_showData(res.purchase[0])
                },
                error: function(error) {
                    error_message(error.responseJSON.message)
                    uiBlockStop()
                },
                complete: function() {}

            });
        });

        //Data Show Function
        async function pending_showData(res) {
                $("#total_tax").text(res.total_tax !=null ? res.total_tax : 0 )
                $("#total_vat").text(res.total_vat !=null ? res.total_vat : 0 )
                $("#total_shiping_cost").text(res.total_shipping_cost !=null ? res.total_shipping_cost : 0 )
                $("#total_other_cost").text(res.total_other_cost !=null ? res.total_other_cost : 0 )
                $("#total_discount").text(res.total_discount !=null ? res.total_discount : 0 )
                $("#total_product_cost").text(res.total_product_cost !=null ? res.total_product_cost : 0 )
                $("#total_grand_total_cost").text(res.total_grand_total !=null ? res.total_grand_total : 0 )
                uiBlockStop()
        }



// Search Data
        $(".search_btn").click(function() {
            if ($.fn.DataTable.isDataTable('.search_datatable')) {
                $('.search_datatable').DataTable().destroy();
            }
            event.preventDefault()
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var employee_id = $('#employee_id').val();
            var supplier_id = $('#supplier_id').val();
            var store_id = $('#store_id').val();
            var purchase_status = $('#purchase_status').val();

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    supplier_id: supplier_id,
                    employee_id: employee_id,
                    store_id: store_id,
                    purchase_status: purchase_status,
                },
                url: "{{ route('admin.daily_purchase_summery_search') }}",
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {

                    pending_showData(res.purchase[0])
                },
                error: function(error) {
                    error_message(error.responseJSON.message)
                },
                complete: function() {
                    uiBlockStop()
                }
            });

        })

    </script>
@endpush
