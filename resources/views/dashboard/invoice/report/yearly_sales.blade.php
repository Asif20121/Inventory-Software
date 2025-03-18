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
                        <h1 class="m-0">Yearly Sales</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Yearly </a></li>
                            <li class="breadcrumb-item active">Sales</li>
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
                                    <form action="{{ route('admin.yearly_sales_print') }}" target="_blank" method="post"
                                        autocomplete="off">
                                        @csrf
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-lg-2 col-md-3">
                                                <strong>From Date</strong>
                                                <div class="input-container">
                                                    <input name="from_date" type="text" id="from_date"
                                                        value="{{ date('Y') }}" placeholder="dd-mm-yy"
                                                        class="form-control datepicker">
                                                        <i class="far fa-calendar-alt custom_icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <strong>To Date</strong>
                                                <div class="input-container">
                                                    <input name="to_date" type="text" id="to_date"
                                                        value="{{ date('Y') }}" placeholder="dd-mm-yy"
                                                        class="form-control datepicker">
                                                        <i class="far fa-calendar-alt custom_icon"></i>
                                                </div>
                                            </div>

                                            <div class="col-lg-2 col-md-3">
                                                <strong>Customer</strong>
                                                <input id="customer" type="search" placeholder="Search Customer"
                                                    class="form-control ">
                                                <input type="hidden" id="customer_id" name="customer_id">
                                                <span class="text-danger" id="err_customer"></span>
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
                                        <h6>Total Payable Amount</h6>
                                    </div>
                                    <div class="col-md-4 text-left">
                                        <h6>: <span id="total_payable_amount"> 0</span> </h6>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-left">
                                        <h6>Total Paid Amount</h6>
                                    </div>
                                    <div class="col-md-4 text-left">
                                        <h6>: <span id="total_paid"> 0</span> </h6>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-4"></div>
                                    <div class="col-md-4 text-left">
                                        <h6>Total Due Amount</h6>
                                    </div>
                                    <div class="col-md-4 text-left">
                                        <h6>: <span id="total_due"> 0</span> </h6>
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
            format: "yyyy",
            viewMode: "years",
            minViewMode: "years",
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
                url: "{{ route('admin.yearly_sales_show') }}",
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {
                    showData(res.invoice_details_arr)
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


            let total_payable_amount = res[0].total_payable_amount != null ? res[0].total_payable_amount : 0;
            let total_paid = res[0].total_paid != null ? res[0].total_paid : 0;
            let total_due = res[0].total_due != null ? res[0].total_due : 0;
            uiBlockStop()
            $("#total_payable_amount").text(total_payable_amount)
            $("#total_paid").text(total_paid)
            $("#total_due").text(total_due)
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
                url: "{{ route('admin.yearly_sales_search') }}",
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
