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
                        <h1 class="m-0">Paid Invoice List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Paid </a></li>
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
                                    <form action="{{ route('admin.print_paid_invoice_list') }}" target="_blank" method="post"
                                        autocomplete="off">
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
                                                <strong>Customer</strong>
                                                <input id="customer" type="text" placeholder="Search Customer"
                                                    class="form-control ">
                                                <input type="hidden" id="customer_id" name="customer_id">
                                                <span class="text-danger" id="err_customer"></span>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <strong>Employee</strong>
                                                <input id="employee" type="text" placeholder="Search employee"
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
                                            <div class="col-lg-4 col-md-4 ml-auto text-right pt-4">
                                                <button class="btn btn-success search_btn" type="button">Search</button>&nbsp;&nbsp;&nbsp;
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

                                    <a class="btn-sm btn-primary" href="{{ route('admin.sales_pos') }}">New POS</a>


                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered search_datatable">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center" style="width: 300px">Invoice Info.
                                                </th>
                                                <th scope="col" class="text-center" style="width: 200px">Customer
                                                    Info.</th>
                                                <th scope="col" class="text-center" style="width: 150px">Payment Info
                                                </th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center" style="width: 200px">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="addRow">
                                        </tbody>

                                    </table>
                                    <table class="float-right mt-4 mb-4 mr-5" style="border: 0px;">
                                        <tbody>
                                            <tr>
                                                <td style="border: 0px;"><b>Total Payable Amount</b></td>
                                                <td style="border: 0px;" id="">&nbsp;:&nbsp; <span
                                                        id="total_payable_amount">0</span> </td>
                                            </tr>
                                            <tr>
                                                <td style="border: 0px;"><b>Total Paid Amount</b></td>
                                                <td style="border: 0px;">&nbsp;:&nbsp; <span
                                                        id="total_paid_amount">0</span></td>
                                            </tr>
                                            <tr>
                                                <td style="border: 0px;"><b>Total Due Amount</b></td>
                                                <td style="border: 0px;">&nbsp;:&nbsp; <span
                                                        id="total_due_amount">0</span></td>
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
        store_wise_invoice_search('#invoice', '#invoice_id', '#err_invoice')
        store_wise_employee_auto('#employee', '#employee_id', '#err_employee')

        // All Data Show
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('.search_datatable')) {
                $('.search_datatable').DataTable().destroy();
            }
            $.ajax({
                async: true,
                type: "get",
                dataType: "json",
                url: "{{ route('admin.paid_invoice_list_show') }}",
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
            $('#total_item').text(res.length)
            if (res.length != 0) {

                let total_payable_amount = 0;
                let total_paid_amount = 0;
                let total_due_amount = 0;

                await $.each(res, function(key, value) {

                    total_payable_amount += (value.total_amount ? value.total_amount : 0);
                    total_paid_amount += (value.paid_amount ? value.paid_amount : 0);
                    total_due_amount += (value.due_amount ? value.due_amount : 0);

                    let edit_invoice = "{{ route('admin.edit_invoice', ':id') }}";
                    edit_invoice = edit_invoice.replace(':id', value.invoice_id);

                    let invoice_details = "{{ route('admin.invoice_details', ':id') }}";
                    invoice_details = invoice_details.replace(':id', value.invoice_id);

                    let invoice_customer_copy_view =
                        "{{ route('admin.invoice_customer_copy_view', ':id') }}";
                    invoice_customer_copy_view = invoice_customer_copy_view.replace(':id', value
                        .invoice_id);

                    let cancel_invoice = "{{ route('admin.cancel_invoice', ':id') }}";
                    cancel_invoice = cancel_invoice.replace(':id', value.invoice_id);

                    let pay_data = '';
                    let j = 0;
                    i++;
                    var d = new Date(value.date);
                    $.each(value.payment_details, function(key, pay) {
                        j++
                        let invoice_per_payment =
                            "{{ route('admin.invoice_per_payment', ':id') }}";
                        invoice_per_payment = invoice_per_payment.replace(':id', pay.id);
                        pay_data +=
                            `<a class="btn-sm px-2  btn-info open_modal"
                            type="button"
                            data-action="${invoice_per_payment}"
                            data-title="Payment Info (Pay-${j}) (Invoice : ${value.invoice_no}) (Date : ${d.getDate()+' '+(d.toLocaleString('default', { month: 'long' }))+' '+d.getFullYear()})"
                            data-modal="common_modal_xl"
                            title="Payment Info"

                            >Pay-${j}</a> <br> <br>`;
                    })

                    let status = ''
                    if (value.paid_status == 1) {
                        status = "<span class='bg-success rounded p-1'>Paid</span>";
                    } else if (value.paid_status == 0) {
                        status = "<span class='bg-warning rounded p-1'>Due</span>";
                    } else if (value.paid_status == 2) {
                        status = "<span class='bg-danger rounded p-1'>Canceled</span>";
                    }

                    data += `
                            <tr>
                                <td scope="col" class="text-center">${i}</td>
                                <td scope="col" class="text-left">
                                    ${d.getDate()+' '+(d.toLocaleString('default', { month: 'long' }))+' '+d.getFullYear()} <br>
                                    <strong>INV :</strong> ${value.invoice_no}<br>
                                    <strong>Store :</strong> ${value.store_name}<br>
                                    <strong>Emp.:</strong>(Card: ${value.added_card_no}) ${value.added_by}<br>
                                </td>
                                <td scope="col" class="text-left">
                                    ${value.customer_name} <br>
                                   <strong>Email :</strong> ${ value.email && value.email != null ? value.email : '' } <br>
                                   <strong>Phone :</strong> ${value.phone}
                                </td>

                                <td scope="col" class="text-left">
                                   <strong>Total Amount :</strong> ${value.total_amount}<br>
                                   <strong>Paid Amount :</strong> ${value.paid_amount}<br>
                                   <strong>Due Amount :</strong> ${value.due_amount}
                                 </td>
                                 <td scope="col" class="text-center">${status}</td>
                                 <td scope="col" class="text-center">
                                     <a type='button' data-action="${invoice_details}" class="btn-sm btn-secondary mb-2 text-white open_modal" data-title="Invoice Details  (Invoice no. : ${value.invoice_no}) (Date : ${d.getDate()+' '+(d.toLocaleString('default', { month: 'long' }))+' '+d.getFullYear()})" data-modal="common_modal_xl" title="Invoice Details"> View</a>  &nbsp;
                                    <a type='button' data-action="${invoice_customer_copy_view}" class="btn-sm btn-warning mb-2 text-white open_modal" data-title="Invoice Info  (Invoice no. : ${value.invoice_no}) (Date : ${d.getDate()+' '+(d.toLocaleString('default', { month: 'long' }))+' '+d.getFullYear()})" data-modal="common_modal_xl" title="Invoice Info"> C.Copy</a> &nbsp;
                                    <a type='button' href="${cancel_invoice}" class="btn-sm btn-danger mb-2 cancel_invoice" > Cancel</a>
                                 </td>
                            </tr>
                            `;
                })

                uiBlockStop()
                $("#total_payable_amount").text(total_payable_amount)
                $("#total_paid_amount").text(total_paid_amount)
                $("#total_due_amount").text(total_due_amount)
                $('#addRow').html(data);
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
                $("#total_payable_amount").text(0)
                $("#total_paid_amount").text(0)
                $("#total_due_amount").text(0)

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
            var customer_id = $('#customer_id').val();
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
                    customer_id: customer_id,
                    employee_id: employee_id,
                    store_id: store_id,
                },
                url: "{{ route('admin.search_paid_invoice_list') }}",
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

        // Confirm Cancel
        $(document).on('click', '.cancel_invoice', function(e) {
            e.preventDefault()
            let url = $(this).attr("href");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't to Cancel This!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, Cancel it!',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Canceled!',
                        'Your file has been Canceled.',
                        'success'
                    )
                    window.location.href = url
                }
            })

        })
    </script>
@endpush
