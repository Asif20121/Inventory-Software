@extends('dashboard.admin.layouts.master')
@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin/bdatepicker/datepicker.min.css') }}">
@endpush
@section('admin_body')
    <style>
        .icon-section {
            background-color: rgba(19, 124, 33, 0.1);
            color: #2FBA72;
            padding: 15px;
            margin: 5px;
        }

        .section-filter-items {
            /* background-color: #F4F4F4; */
            border-radius: 6px;
            padding: 15px;
            margin: 5px;
            align-content: center;
            transition: 0.6s;
        }

        .section-filter-items:hover {
            background-color: rgba(47, 186, 114, 0.15);

        }

        .section-filter-items span {
            margin-left: 5px;
        }

        button {
            border: none;
        }

        .smbox {
            background-color: white;
            border-radius: 10px;
            padding: 5%;
            /* box-shadow: 1px 1px 10px 0.2px rgb(90, 90, 90); */
        }

        .pre-icon1 {
            background-color: rgba(4, 166, 246, 0.15);
            color: #0dac5a;
            border-radius: 8px;
            padding: 15px;
            margin: 5px;
            align-content: center;
            transition: 0.6s;
        }

        .pre-icon2 {
            background-color: rgba(254, 222, 64, 0.15);
            color: #FD9E40;
            border-radius: 8px;
            padding: 15px;
            margin: 5px;
            align-content: center;
            transition: 0.6s;
        }

        .pre-icon3 {
            background-color: rgba(255, 0, 0, 0.15);
            color: #FF2C2C;
            border-radius: 8px;
            padding: 15px;
            margin: 5px;
            align-content: center;
            transition: 0.6s;
        }

        .pre-icon4 {
            background-color: rgba(4, 166, 246, 0.15);
            color: #27867D;
            border-radius: 8px;
            padding: 15px;
            margin: 5px;
            align-content: center;
            transition: 0.6s;
        }

        .pre-icon5 {
            background-color: rgba(4, 166, 246, 0.15);
            color: #FD9800;
            border-radius: 8px;
            padding: 15px;
            margin: 5px;
            align-content: center;
            transition: 0.6s;
        }

        .pre-icon6 {
            background-color: rgba(255, 0, 0, 0.15);
            color: #FF2C2C;
            border-radius: 8px;
            padding: 15px;
            margin: 5px;
            align-content: center;
            transition: 0.6s;
        }

        .pre-icon7 {
            background-color: rgba(255, 0, 0, 0.15);
            color: #FF2C2C;
            border-radius: 8px;
            padding: 15px;
            margin: 5px;
            align-content: center;
            transition: 0.6s;
        }

        .pre-icon8 {
            background-color: rgba(4, 166, 246, 0.15);
            color: #0dac5a;
            border-radius: 8px;
            padding: 15px;
            margin: 5px;
            align-content: center;
            transition: 0.6s;
        }

        .info-lg {
            background-color: #F6F6F6;
            border-radius: 8px;
            width: 100%;
        }
    </style>
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2 bg-white rounded shadow-sm">
                    <div class="col-md-4">
                        <div class="icon">
                            <i class="fas fa-dice-d6 fa-2x icon-section rounded-circle"></i>
                            <h3 class="d-inline pl-3"><b>Dashboard</b></h3>
                        </div>
                    </div><!-- /.col -->
                    <div class="col-md-8 align-center">
                        <div class="row d-flex justify-content-end">

                            <div class="col-md-4 mt-3" style="width: 100% ">
                                <div class="row">
                                    <div class="col-md-2 m-auto text-right">From</div>
                                    <div class="col-md-10 input-container">
                                        <input class="form-control bg-light datepicker" id="from_date"
                                            value="{{ date('d-m-Y') }}" type="text" placeholder="From Date "
                                            autocomplete="off" value="">
                                        <i class="far fa-calendar-alt custom_icon"></i>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4 mt-3" style="width: 100%">
                                <div class="row">
                                    <div class="col-md-2 m-auto text-right">To</div>
                                    <div class="col-md-10 input-container">
                                        <input name="to_date" class="form-control bg-light datepicker " id="date_to"
                                            value="{{ date('d-m-Y') }}" type="text" placeholder="To Date "
                                            autocomplete="off" value="">
                                        <i class="far fa-calendar-alt custom_icon"></i>
                                    </div>
                                </div>

                            </div>
                            <div class="col-md-4 mt-3">
                                <select name="" class="form-control search_box" id="store">
                                    <option value="">All Store </option>
                                    @if (count($store) > 0)
                                        @foreach ($store as $key => $st)
                                            <option value="{{ $st->id }}">{{ $st->store_name }}
                                            </option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
                    </div><!-- /.col -->
                </div><!-- /.row -->
            </div><!-- /.container-fluid -->
        </div>
        <!-- /.content-header -->

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                <!-- Small boxes (Stat box) -->
                <div class="row ">


                    {{-- Sales overview --}}
                    <div class="col-md-6 col-sm-12 px-3 mb-3 d-block d-flex ">
                        <div class="row smbox shadow-sm ">
                            <div class="col-10">
                                <h5> <b>Sales Overview </b></h5>
                            </div>
                            <div class="col-2">
                                <i class="fas fa-ellipsis-v float-sm-right"></i>
                            </div>

                            <div class="col-6 p-2 border-right border-bottom">
                                <div class="row">
                                    <div class="col-4 d-flex align-items-center">
                                        <i class="fas fa-cart-plus fa-2x pre-icon1"></i>
                                    </div>
                                    <div class="col-8 pl-4">
                                        <p class="m-0">Invoice Amount</p>
                                        <h4 class="Sales"> <b id="total_payable_amount">...</b></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2 border-left border-bottom">
                                <div class="row">
                                    <div class="col-4 d-flex align-items-center">
                                        <i class="fas fa-chart-line fa-2x pre-icon2"></i>
                                    </div>
                                    <div class="col-8 pl-4">
                                        <p class="m-0">Paid Amount</p>
                                        <h4 class="Sales"><b id="total_paid">...</b></h4>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 p-2 border-right border-top">
                                <div class="row">
                                    <div class="col-4 d-flex align-items-center">
                                        <i class="fas fa-file-invoice-dollar fa-2x pre-icon3"></i>
                                    </div>
                                    <div class="col-8 pl-4">
                                        <p class="m-0">Due Amount</p>
                                        <h4 class="Sales"><b id="total_due">...</b></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2 border-left border-top">
                                <div class="row">
                                    <div class="col-4 d-flex align-items-center">
                                        <i class="fas fa-chart-pie fa-2x pre-icon4"></i>
                                    </div>
                                    <div class="col-8 pl-4">
                                        <p class="m-0">T.Cash Receive</p>
                                        <h4 class="Sales"><b id="receive_amount">...</b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>


                    {{-- Purchase Overview --}}
                    <div class="col-md-6 col-sm-12 px-3 mb-3 d-block d-flex">
                        <div class="row smbox shadow-sm">
                            <div class="col-10">
                                <h5><b>Purchase and Expenses</b></h5>
                            </div>
                            <div class="col-2">
                                <i class="fas fa-ellipsis-v float-sm-right"></i>
                            </div>

                            <div class="col-6 p-2 border-right border-bottom">
                                <div class="row">
                                    <div class="col-4 d-flex align-items-center">
                                        <i class="fas fa-box-open fa-2x pre-icon5"></i>
                                    </div>
                                    <div class="col-8 pl-4">
                                        <p class="m-0">Purchase Amount</p>
                                        <h4 class="Sales"><b id="total_purchase_amount">...</b></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2 border-left border-bottom">
                                <div class="row">
                                    <div class="col-4 d-flex align-items-center">
                                        <i class="far fa-calendar-times fa-2x pre-icon6"></i>
                                    </div>
                                    <div class="col-8 pl-4">
                                        <p class="m-0">Pending P.A</p>
                                        <h4 class="Sales"><b id="pending_purchase_amount">...</b></h4>
                                    </div>
                                </div>
                            </div>

                            <div class="col-6 p-2 border-right border-top">
                                <div class="row">
                                    <div class="col-4 d-flex align-items-center">
                                        <i class="fas fa-file-invoice-dollar fa-2x pre-icon7"></i>
                                    </div>
                                    <div class="col-8 pl-4">
                                        <p class="m-0">Approve P.A</p>
                                        <h4 class="Sales"><b id="approve_purchase_amount">...</b></h4>
                                    </div>
                                </div>
                            </div>
                            <div class="col-6 p-2 border-left border-top">
                                <div class="row">
                                    <div class="col-4 d-flex align-items-center">
                                        <i class="fas fa-retweet fa-2x pre-icon8"></i>
                                    </div>
                                    <div class="col-8 pl-4">
                                        <p class="m-0">Expense Amount</p>
                                        <h4 class="Sales"><b id="expense">...</b></h4>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Inventory Summary --}}
                    <div class="col-md-4 col-sm-6 px-3 mb-3 ">
                        <div class="row smbox shadow-sm">

                            <div class="col-10">
                                <h5><b>Profit Loss</b></h5>
                            </div>
                            <div class="col-2">
                                <i class="fas fa-ellipsis-v float-sm-right"></i>
                            </div>

                            <div class="col-md-12">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-md-6   d-block d-flex">
                                        <div class="info-lg p-2">
                                            <i class="fas fa-box-open text-success fa-2x pt-2"></i>
                                            <p class="m-0">Profit</p>
                                            <h4 class="Sales"><b id="profit">...</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6   d-block d-flex">
                                        <div class="info-lg p-2">
                                            <i class="fab fa-avianex text-primary fa-2x pt-2"></i>
                                            <p class="m-0">Loss</p>
                                            <h4 class="Sales"><b id="loss">...</b></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Inventory Summary --}}
                    <div class="col-md-4 col-sm-6 px-3 mb-3 ">
                        <div class="row smbox shadow-sm">

                            <div class="col-10">
                                <h5><b>Cancel Count</b></h5>
                            </div>
                            <div class="col-2">
                                <i class="fas fa-ellipsis-v float-sm-right"></i>
                            </div>

                            <div class="col-md-12">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-md-6   d-block d-flex">
                                        <div class="info-lg p-2">
                                            <i class="fas fa-shopping-cart text-info fa-2x pt-2"></i>
                                            <p class="m-0">Purchase</p>
                                            <h4 class="Sales"><b id="cancel_purchase">...</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6   d-block d-flex">
                                        <div class="info-lg p-2">
                                            <i class="fas fa-file-invoice-dollar text-dark fa-2x pt-2"></i>
                                            <p class="m-0">Invoice</p>
                                            <h4 class="Sales"><b id="cancel_invoice">...</b></h4>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>

                    {{-- Store --}}
                    <div class="col-md-4 col-sm-6 px-3 mb-3 ">
                        <div class="row smbox shadow-sm">
                            <div class="col-10">
                                <h5><b>Employee</b></h5>
                            </div>
                            <div class="col-2">
                                <i class="fas fa-ellipsis-v float-sm-right"></i>
                            </div>

                            <div class="col-md-12">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-md-6  d-block d-flex">
                                        <div class="info-lg p-2">
                                            <i class="fas fa-user-check text-secondary fa-2x pt-2"></i>
                                            <p class="m-0">Active</p>
                                            <h4 class="Sales"><b id="active_employee">...</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6  d-block d-flex">
                                        <div class="info-lg p-2">
                                            <i class="fas fa-user-times text-warning fa-2x pt-2"></i>
                                            <p class="m-0">Inactive</p>
                                            <h4 class="Sales"><b id="inactive_employee">...</b></h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    {{-- Employee --}}
                    <div class="col-md-4 col-sm-6 px-3 mb-3 d-block d-flex">
                        <div class="row smbox shadow-sm" style="width: inherit;">
                            <div class="col-10">
                                <h5><b>Store</b></h5>
                            </div>
                            <div class="col-2">
                                <i class="fas fa-ellipsis-v float-sm-right"></i>
                            </div>
                            <div class="col-md-12">
                                <div class="row d-flex justify-content-between">
                                    <div class="col-md-6   d-block d-flex">
                                        <div class="info-lg p-2">
                                            <i class="fas fa-user-check text-secondary fa-2x pt-2"></i>
                                            <p class="m-0">Active</p>
                                            <h4 class="Sales"><b id="active_store">...</b></h4>
                                        </div>
                                    </div>
                                    <div class="col-md-6   d-block d-flex">
                                        <div class="info-lg p-2">
                                            <i class="fas fa-user-times text-danger fa-2x pt-2"></i>
                                            <p class="m-0">Inactive</p>
                                            <h4 class="Sales"><b id="inactive_store">...</b></h4>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                    </div>

                    {{-- Circuler Graph-1 --}}
                    <div class="col-md-4 col-6 px-3 mb-3 d-block d-flex">
                        <div class="row smbox shadow-sm" style="width: inherit;">

                            <div class="col-10">
                                <h5><b>Sales Overview</b></h5>
                            </div>
                            <div class="col-2">
                                <i class="fas fa-ellipsis-v float-sm-right"></i>
                            </div>

                            <div class="col-md-12">
                                <div class="chart-responsive">
                                    <canvas id="donutChart" height="200" class="chartjs-render-monitor"></canvas>
                                </div>
                                <!-- ./chart-responsive -->


                            </div>


                        </div>
                    </div>

                    {{-- Circuler Graph-2 --}}

                    <div class="col-md-4 col-6 px-3 mb-3 d-block d-flex">
                        <div class="row smbox shadow-sm" style="width: inherit;">

                            <div class="col-6">
                                <h5><b>Purchase and Expenses</b></h5>
                            </div>
                            <div class="col-6">
                                <i class="fas fa-ellipsis-v float-sm-right"></i>
                            </div>

                            <div class="col-md-12">
                                <div class="chart-responsive">
                                    <canvas id="pieChart"
                                        style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%;"></canvas>
                                </div>
                                <!-- ./chart-responsive -->
                            </div>
                        </div>
                    </div>




                </div>
                <!-- /.row -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>
@endsection
@push('admin_js')
    <script src="{{ asset('admin/bdatepicker/bootstrap-datepicker.min.js') }}"></script>

    {{-- Date  --}}
    <script>
        $(".datepicker", ).datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy',
            autoclose: true
        });
    </script>

    {{-- chart --}}
    <script>
        const salaseChart = (total_payable_amount, total_paid, total_due, receive_amount) => {
            'use strict'
            // Get context with jQuery - using jQuery's .get() method.
            var donutChartCanvas = $('#donutChart').get(0).getContext('2d')
            var donutData = {
                labels: [
                    'Invoice Amount',
                    'Paid Amount',
                    'Due Amount',
                    'T.Cash Receive',
                ],
                datasets: [{
                    data: [total_payable_amount, total_paid, total_due, receive_amount],
                    backgroundColor: ['#00a65a', '#FD9E40', '#FF2C2C', '#3c8dbc']
                }]
            }

            var donutOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }
            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(donutChartCanvas, {
                type: 'doughnut',
                data: donutData,
                options: donutOptions
            })
        }

        const purchaseExpense = (total_purchase_amount, pending_purchase_amount, approve_purchase_amount, expense) => {
            'use strict'
            var donutData2 = {
                labels: [
                    'Purchase Amount',
                    'Pending P.A',
                    'Approve P.A',
                    'Expense Amount',
                ],
                datasets: [{
                    data: [total_purchase_amount, pending_purchase_amount, approve_purchase_amount,
                        expense],
                    backgroundColor: ['#FD9800', '#00c0ef', '#3c8dbc', '#d2d6de']
                }]
            }

            var pieChartCanvas = $('#pieChart').get(0).getContext('2d')
            var pieData = donutData2;
            var pieOptions = {
                maintainAspectRatio: false,
                responsive: true,
            }


            //Create pie or douhnut chart
            // You can switch between pie and douhnut using the method below.
            new Chart(pieChartCanvas, {
                type: 'pie',
                data: pieData,
                options: pieOptions
            })

        }
    </script>


    <script>
        // All Data Show
        $(document).ready(function() {
            $.ajax({
                async: true,
                type: "get",
                dataType: "json",
                url: "{{ route('admin.admin_dashboard_show') }}",
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

        const showData = async (res) => {

            let total_payable_amount = res.sales[0].total_payable_amount != null ? res.sales[0]
                .total_payable_amount : 0;
            let total_paid = res.sales[0].total_paid != null ? res.sales[0].total_paid : 0;
            let total_due = res.sales[0].total_due != null ? res.sales[0].total_due : 0;
            let receive_amount = res.receive_amount[0].receive_amount != null ? res.receive_amount[0]
                .receive_amount : 0;

            let total_purchase_amount = res.total_purchase[0].purchase_amount != null ? res.total_purchase[0]
                .purchase_amount : 0;
            let pending_purchase_amount = res.pending_purchase[0].purchase_amount != null ? res
                .pending_purchase[0].purchase_amount : 0;
            let approve_purchase_amount = res.approve_purchase[0].purchase_amount != null ? res.approve_purchase[0]
                .purchase_amount : 0;
            let expense = res.expense[0].expense != null ? res.expense[0].expense : 0;
            let profit = res.profit != null ? res.profit : 0;
            let cancel_purchase = res.cancel_purchase != null ? res.cancel_purchase : 0;
            let cancel_invoice = res.cancel_invoice != null ? res.cancel_invoice : 0;
            let active_store = res.active_store != null ? res.active_store : 0;
            let inactive_store = res.inactive_store != null ? res.inactive_store : 0;
            let active_employee = res.active_employee != null ? res.active_employee : 0;
            let inactive_employee = res.inactive_employee != null ? res.inactive_employee : 0;

            $("#total_payable_amount").text(await total_payable_amount)
            $("#total_paid").text(await total_paid)
            $("#total_due").text(await total_due)
            $("#receive_amount").text(await receive_amount)
            salaseChart(total_payable_amount, total_paid, total_due, receive_amount)

            $("#total_purchase_amount").text(await total_purchase_amount)
            $("#pending_purchase_amount").text(await pending_purchase_amount)
            $("#approve_purchase_amount").text(await approve_purchase_amount)
            $("#expense").text(await expense)
            purchaseExpense(total_purchase_amount, pending_purchase_amount, approve_purchase_amount, expense)

            if (profit < 0) {
                $("#profit").text(0)
                $("#loss").text(Math.abs(profit))

            } else {
                $("#profit").text(Math.abs(profit))
                $("#loss").text(0)
            }

            $("#cancel_purchase").text(await cancel_purchase)
            $("#cancel_invoice").text(await cancel_invoice)
            $("#active_store").text(await active_store)
            $("#inactive_store").text(await inactive_store)
            $("#active_employee").text(await active_employee)
            $("#inactive_employee").text(await inactive_employee)


            uiBlockStop()
        }



        $(document).on('change', '#store,#from_date,#date_to', function() {
            let store = $("#store").val() ? $("#store").val() : '';
            let from_date = $("#from_date").val() ? $("#from_date").val() : '';
            let date_to = $("#date_to").val() ? $("#date_to").val() : '';

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                data: {
                    from_date: from_date,
                    to_date: date_to,
                    store_id: store,
                },
                url: "{{ route('admin.admin_dashboard_search') }}",
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

        });
    </script>
@endpush
