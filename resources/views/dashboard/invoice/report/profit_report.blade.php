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
                        <h1 class="m-0">Profit Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Profit </a></li>
                            <li class="breadcrumb-item active">Report</li>
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
                                    <form action="{{ route('admin.profit_report_print') }}" target="_blank"
                                        method="post" autocomplete="off">
                                        @csrf
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-lg-3 col-md-3">
                                                <strong>From Date</strong>
                                                <div class="input-container">
                                                    <input name="from_date" type="text" id="from_date"
                                                        value="{{ date('Y-m') }}" placeholder="dd-mm-yy"
                                                        class="form-control datepicker">
                                                        <i class="far fa-calendar-alt custom_icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <strong>To Date</strong>
                                                <div class="input-container">
                                                    <input name="to_date" type="text" id="to_date"
                                                        value="{{ date('Y-m') }}" placeholder="dd-mm-yy"
                                                        class="form-control datepicker">
                                                        <i class="far fa-calendar-alt custom_icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-3 col-md-3">
                                                <strong> Store</strong>
                                                <select name="store_id" id="store_id" class="form-control search_box">
                                                    <option value="">Select Store</option>
                                                    @if (count($pre_store) > 0)
                                                        @foreach ($pre_store as $key => $st)
                                                            <option value="{{ $st->id }}">{{ $st->store_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
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
                                        <div class="row" style="justify-content: center;font-size:120%;">

                                            <div class="col-md-4"><strong> Total Seell </strong></div>
                                            <div class="col-md-6">: <span id="total_seeling_amount">0</span></div>
                                            <div class="col-md-4"><strong> Total Purchase </strong></div>
                                            <div class="col-md-6">: <span id="total_purchase_price">0</span></div>
                                            <div class="col-md-4"><strong> Total Expenses </strong></div>
                                            <div class="col-md-6">: <span id="total_cost">0</span></div>
                                            <div class="col-md-10 m-auto">
                                                <hr>
                                            </div>

                                            <div class="col-md-12" id="profit">
                                                <div class="row" style="justify-content: center;">
                                                    <div class="col-md-4"> <strong> Profit</strong></div>
                                                    <div class="col-md-6">: <span>0</span></div>
                                                </div>

                                            </div>



                                        </div>
                                    </div>
                                </div>
                            </div>
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

        // All Data Show
        $(document).ready(function() {
            $.ajax({
                async: true,
                type: "get",
                dataType: "json",
                url: "{{ route('admin.profit_report_show') }}",
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {
                    showData(res)
                },
                error: function(error) {
                    error_message(error.responseJSON.message)
                    uiBlockStop()
                },
                complete: function() {}

            });
        });

        //Data Show Function
        async function showData(res) {
            uiBlockStop()


            let total_seeling_amount = res.salese[0].total_sales_amount != null ? res.salese[0].total_sales_amount : 0;
            let total_purchase_price = res.purchases[0].total_purchase_price != null ? res.purchases[0].total_purchase_price : 0;
            let total_cost = res.expense_manages[0].total_cost != null ? res.expense_manages[0].total_cost : 0;
            let profit_amount = total_seeling_amount - (total_purchase_price + total_cost)

            let profit='';
            if (profit_amount >= 0) {
                 profit =
                    `<div class="row" style="justify-content: center;"> <div class="col-md-4">  <strong> Profit</strong></div><div class="col-md-6">: <span>${profit_amount}</span></div></div>`;
            } else {
                 profit =
                    `<div class="row text-danger" style="justify-content: center;" > <div class="col-md-4">  <strong> Loss</strong></div><div class="col-md-6">: <span>${Math.abs(profit_amount)}</span></div></div>`;
            }
            $("#total_seeling_amount").text(total_seeling_amount)
            $("#total_purchase_price").text(total_purchase_price)
            $("#total_cost").text(total_cost)

            $("#profit").html(profit)
        }

        //Search Data
        $(".search_btn").click(function() {
            event.preventDefault()

            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var invoice_id = $('#invoice_id').val();
            var customer_id = $('#customer_id').val();
            var employee_id = $('#employee_id').val();
            var status_id = $('#status_id').val();
            var store_id = $('#store_id').val();

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    employee_id: employee_id,
                    store_id: store_id,
                },
                url: "{{ route('admin.profit_report_search') }}",
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {
                    showData(res)
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
