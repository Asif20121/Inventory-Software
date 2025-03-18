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
                        <h1 class="m-0">D.W. Cashier Report</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Invoice </a></li>
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
                        <div class="card">
                            <div class="card-header">
                                <div class="">
                                    <form action="{{ route('admin.date_wise_cashier_list_print') }}" target="_blank"
                                        method="post" autocomplete="off">
                                        @csrf
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-lg-2 col-md-3">
                                                <strong>From Date</strong>
                                                <div class="input-container">
                                                    <input name="from_date" type="text" id="from_date"
                                                        value="{{ date('d-m-Y') }}" placeholder="dd-mm-yy"
                                                        class="form-control datepicker">
                                                        <i class="far fa-calendar-alt custom_icon"></i>
                                                </div>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <strong>To Date</strong>
                                                <div class="input-container">
                                                    <input name="to_date" type="text" id="to_date"
                                                        value="{{ date('d-m-Y') }}" placeholder="dd-mm-yy"
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
                                                <input id="employee" type="text" placeholder="Search employee"
                                                    class="form-control ">
                                                <input type="hidden" id="employee_id" name="employee_id">
                                                <span class="text-danger" id="err_employee"></span>
                                            </div>
                                            <div class="col-lg-2 col-md-3 ">
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
                                            <div class="col-lg-2 col-md-4 ml-auto text-right pt-4">
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
                            <div class="card-header">
                                Invoice: <span id="total_item" class="bg-success rounded px-1 text-left">0 </span>
                                <div class="card-tools">
                                    {{-- <a class="btn-sm btn-primary" href="{{ route('admin.sales_pos') }}">New POS</a> --}}
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered search_datatable">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center" style="width:25%">R.Date </th>
                                                <th scope="col" class="text-center" style="width: 25%">EMP.Info</th>
                                                <th scope="col" class="text-center" style="width: 25%">Inv.Info</th>
                                                <th scope="col" class="text-center">R.Amount</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="addRow">
                                        </tbody>


                                        <tbody>
                                            <tr class="bg-light">
                                                <td colspan="4" class="text-right"><strong>Total Receive Amount</strong>
                                                </td>
                                                <td colspan="2" class="text-center"><strong
                                                        id="total_receive_amount">0</strong></td>
                                            </tr>
                                        </tbody>

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
    <script src="{{ asset('admin/bdatepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $(".datepicker", ).datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy',
            autoclose: true
        });


        //Search Invoice
        // store_wise_invoice_search('#invoice', '#invoice_id', '#err_invoice')
        // store_wise_employee_auto('#employee', '#employee_id', '#err_employee')

        //Search Invoice
        invoice_search('#invoice', '#invoice_id', '#err_invoice')
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
                url: "{{ route('admin.date_wise_cashier_show') }}",
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
            let data = ''
            let i = 0;
            let total_receive_amount = 0;
            $('#total_item').text(res.length)
            if (res.length != 0) {
                await $.each(res, function(key, value) {
                    i++;
                    let invoice_details = "{{ route('admin.date_wise_cashier_details', ':id') }}";
                    invoice_details = invoice_details.replace(':id', value.inv_id);
                    var receive_date = new Date(value.receive_date);
                    var inv_date = new Date(value.inv_date);
                    total_receive_amount += (value.receive_amount ? value.receive_amount : 0)

                    data += `
                            <tr>
                                <td scope="col" class="text-center">${i}</td>
                                <td scope="col" class="text-center"> ${receive_date.getDate()+' '+(receive_date.toLocaleString('default', { month: 'long' }))+' '+receive_date.getFullYear()} </td>
                                <td scope="col" class="text-left"><strong>Card No. :</strong> ${value.card_no}<br><strong>Emp.:</strong> ${value.name}</td>
                                <td scope="col" class="text-left">
                                     ${inv_date.getDate()+' '+(inv_date.toLocaleString('default', { month: 'long' }))+' '+inv_date.getFullYear()}, <strong>Inv. No. :</strong> ${value.invoice_no}, <strong>Store :</strong> ${value.store_name}   </td>
                                <td scope="col" class="text-center"> ${value.receive_amount}  </td>
                                <td scope="col" class="text-center"><a type='button' data-action="${invoice_details}" class="btn-sm btn-secondary mb-2 text-white open_modal" data-title="Invoice Details  (Invoice no. : ${value.invoice_no}) (Date : ${inv_date.getDate()+' '+(inv_date.toLocaleString('default', { month: 'long' }))+' '+inv_date.getFullYear()})" data-modal="common_modal_xl" title="Invoice Details"> View</a> <br></td>
                            </tr>
                            `;
                })

                uiBlockStop()

                $('#addRow').html(data);
                $("#total_receive_amount").text(total_receive_amount)
                $(document).ready(function() {
                    var table = $('.search_datatable').DataTable({
                        "pageLength": 10,
                        "aLengthMenu": [
                            [10, 25, 50, 100, -1],
                            [10, 25, 50, 100, 'All'],
                        ],
                    });
                });

            } else {
                $("#total_receive_amount").text(0)
                data = "<tr><td colspan='12' class='text-center'><h3>No Data Found</h3></td></tr>";
                uiBlockStop()
                $('#addRow').html(data);
            }
        }




        //Search Data


        $(".search_btn").click(function() {
            if ($.fn.DataTable.isDataTable('.search_datatable')) {
                $('.search_datatable').DataTable().destroy();
            }
            event.preventDefault()
            var from_date = $('#from_date').val();
            var to_date = $('#to_date').val();
            var invoice_id = $('#invoice_id').val();
            var employee_id = $('#employee_id').val();
            var store_id = $('#store_id').val();

            $.ajax({
                async: true,
                type: "POST",
                dataType: "json",
                data: {
                    from_date: from_date,
                    to_date: to_date,
                    invoice_id: invoice_id,
                    employee_id: employee_id,
                    store_id: store_id,
                },
                url: "{{ route('admin.search_date_wise_cashier') }}",
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
