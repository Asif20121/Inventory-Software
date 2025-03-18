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
                        <h1 class="m-0">Income Summery Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Income Summery </a></li>
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
                        <div class="card">
                            <div class="card-header">
                                <div class="">
                                    <form action="{{ route('admin.income_summery_report_print') }}" target="_blank"
                                        method="post" autocomplete="off">
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
                                                <strong>Invoice</strong>
                                                <input id="invoice" type="text" placeholder="Search Invoice"
                                                    class="form-control ">
                                                <input type="hidden" id="invoice_id" name="invoice_id">
                                                <span class="text-danger" id="err_invoice"></span>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <strong>Employee</strong>
                                                <input id="employee" type="search" placeholder="Search employee"
                                                    class="form-control ">
                                                <input type="hidden" id="employee_id" name="employee_id">
                                                <span class="text-danger" id="err_employee"></span>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <strong> Store</strong>
                                                <select name="store_id" id="store_id" class="form-control search_box">
                                                    <option value="">Select Store</option>
                                                    @if (count($store) > 0)
                                                        @foreach ($store as $key => $st)
                                                            <option value="{{ $st->id }}">{{ $st->store_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-4 text-right pt-4">
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
                            <div class="card-body" style="text-align:center;">

                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-left">
                                        <h6>Total Receive Amount</h6>
                                    </div>
                                    <div class="col-md-4 text-left">
                                        <h6>: <span id="receive_amount"> 0</span> </h6>
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


        // Search Customer
        $('input#customer').bind("change keyup input", function() {
            if ($(this).val() == '' || $(this).val() == null) {
                $("#customer_id").val('')
            }
        });

        $("#customer").autocomplete({
            source: function(request, response) {
                $.ajax({
                    async: true,
                    url: "{{ route('admin.customer_search') }}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        product: request.term,
                    },
                    success: function(data) {
                        if (data.length == 0) {
                            $('#err_customer').text("Data Not Found")
                        } else {
                            $('#err_customer').text("")

                        }
                        var array = $.map(data, function(row) {
                            return {
                                value: row.customer_name,
                                label: row.customer_name + '--' +
                                    row.email + '(ph-' + row.phone +
                                    ')',
                                id: row.id,
                                customer_name: row.customer_name,
                                customer_email: row.email,
                                customer_phone: row.phone,
                                customer_address: row.address,
                            }
                        })
                        response($.ui.autocomplete.filter(array, request.term));
                    }
                })

            },
            select: function(event, ui) {
                let id = ui.item.id;
                $("#customer_id").val(id)
            },
            minLength: 1,
            delay: 500
        });


        //Search Invoice
        invoice_search('#invoice', '#invoice_id', '#err_invoice')
        employee_search('#employee', '#employee_id', '#err_employee')



        // All Data Show
        $(document).ready(function() {
            $.ajax({
                async: true,
                type: "get",
                dataType: "json",
                url: "{{ route('admin.income_summery_report_show') }}",
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {
                    showData(res.invoice_details_arr)
                    // console.log(res);
                },
                error: function(error) {
                    error_message(error.responseJSON.message)
                    uiBlockStop()
                },
                complete: function() {}

            });
        });

        //Data Show Function
        let showData = async (res) => {
           let receive_amount = res[0].receive_amount !=null ? res[0].receive_amount : 0;
           uiBlockStop()
           $("#receive_amount").text(receive_amount)
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
                    invoice_id: invoice_id,
                    customer_id: customer_id,
                    employee_id: employee_id,
                    status_id: status_id,
                    store_id: store_id,
                },
                url: "{{ route('admin.income_summery_report_search') }}",
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {
                    showData(res.invoice_list)
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
