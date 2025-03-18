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
                        <h1 class="m-0">Purchase List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Purchase</a></li>
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
                                <div class="">
                                    <form action="{{ route('admin.search_purchase_list_print') }}" method="post" autocomplete="off" target="_blank">
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
                                                    @if (count($storewise_supplier) > 0)
                                                    @foreach ($storewise_supplier as $key => $sws)
                                                        <option value="{{ $sws->supplier_id }}">{{ $sws->supplier_name }}</option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                            <div class="col-lg-2 col-md-3">
                                                <strong> Store</strong>
                                                <select name="store_id" id="store_id" class="form-control search_box">
                                                    <option value="">Select Store</option>
                                                    @if (count($permitted_store) > 0)
                                                        @foreach ($permitted_store as $key => $st)
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
                            <div class="card-header">
                                <span id="approve_count" class="bg-success rounded px-1 text-left">0</span>&nbsp;
                                <span id="pending_count" class="bg-warning rounded px-1 text-left">0</span>&nbsp;
                                <span id="cancel_count" class="bg-danger rounded px-1 text-left">0</span>&nbsp;
                                <b>=</b> <span id="total_list_count" class="bg-primary rounded px-1 text-left">0 </span>

                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('admin.purchase_manage_create') }}">Add New
                                        Purchase</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered datatable search_datatable">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Voucher</th>
                                                <th scope="col" class="text-center">Store</th>
                                                <th scope="col" class="text-center">Supplier</th>
                                                <th scope="col" class="text-center">Cost</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Add.By</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody id="addRow">

                                        </tbody>



                                    </table>

                                </div>
                                <div class="row">
                                    <div class="col-md-7 text-center m-auto">
                                        <h3>Total</h3>
                                    </div>
                                    <div class="col-md-5">
                                        <div class="row">
                                            <div class="col-md-4"><strong>Tax</strong></div><div class="col-md-6">: <span id="total_tax">0</span></div>
                                            <div class="col-md-4"><strong>Vat</strong></div><div class="col-md-6">: <span id="total_vat">0</span></div>
                                            <div class="col-md-4"><strong>Shipping cost</strong></div><div class="col-md-6">: <span id="total_shiping_cost">0</span></div>
                                            <div class="col-md-4"><strong>Other cost</strong></div><div class="col-md-6">: <span id="total_other_cost">0</span></div>
                                            <div class="col-md-4"><strong>Discount</strong></div><div class="col-md-6">: <span id="total_discount">0</span></div>
                                            <div class="col-md-4"><strong>Product cost</strong></div><div class="col-md-6">: <span id="total_product_cost">0</span></div>
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
            format: 'dd-mm-yyyy',
            autoclose: true
        });
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
                url: "{{ route('admin.purchase_showdata') }}",
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {
                    pending_showData(res.purchase)
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
            let data = ''
            let total_tax=0
            let total_vat=0
            let total_shiping_cost=0
            let total_other_cost=0
            let total_discount=0
            let total_product_cost=0
            let total_grand_total_cost=0


            let approve_count=0;
            let pending_count=0;
            let cancel_count=0;
            let total_list_count=0;

            if (res.length != 0) {
                await $.each(res, function(key, value) {
                    total_tax=total_tax+ parseFloat(value.tax)
                    total_vat=total_vat+ parseFloat(value.vat)
                    total_shiping_cost=total_shiping_cost+ parseFloat(value.shipping_cost)
                    total_other_cost=total_other_cost+ parseFloat(value.other_cost)
                    total_discount=total_discount+ parseFloat(value.discount)
                    total_product_cost=total_product_cost+ parseFloat(value.product_cost)
                    total_grand_total_cost=total_grand_total_cost+ parseFloat(value.grand_total)

                    let purchase_manage_view = "{{ route('admin.purchase_manage_view', ':id') }}";
                    purchase_manage_view = purchase_manage_view.replace(':id', value.id);



                    if (value.status == 1) {
                        approve_count++
                        status = "<span class='bg-success rounded px-1'>Approved</span>";
                    } else if(value.status == 0) {
                        pending_count++
                        status = "<span class='bg-warning rounded px-1'>Pending</span>";
                    }else if(value.status == 2) {
                        cancel_count++
                        status = "<span class='bg-danger rounded px-1'>Cancel</span>";
                    }

                    data += `
                            <tr>
                                <td scope="col" class="text-center">${key + 1}</td>
                                <td scope="col" class="text-left" style='width:15%;'>
                                    ${value.date}<br>
                                    Voucher: ${value.voucher}
                                </td>
                                <td scope="col" class="text-left">${value.store_name}</td>
                                <td scope="col" class="text-left" style='width: 20%;'>
                                    Name:${value.supplier_name}<br>
                                    Email: ${value.supplier_email}<br>
                                    phone: ${value.supplier_phone}
                                </td>
                                <td scope="col" class="text-left" style='width: 18%;'>
                                    Tax: ${value.tax}<br>
                                    Vat: ${value.vat}<br>
                                    Shipping cost: ${value.shipping_cost}<br>
                                    Other cost: ${value.other_cost}<br>
                                    Discount: ${value.discount}<br>
                                    Product cost: ${value.product_cost}<br>
                                    Grand total: ${value.grand_total}
                                </td>
                                <td scope="col" class="text-center">${status}</td>
                                <td scope="col" class="text-center">
                                    ${value.added_by}<br>
                                </td>
                                <td scope="col" class="text-center">
                                    <a class="dropdown-item open_modal" data-modal="common_modal_xl" title="Purchase Details" data-title="Purchase Details" data-action="${purchase_manage_view}"> <button class="btn btn-warning btn-sm btn-block">View</button> </a>

                                </td>
                            </tr>
                            `;
                })

                uiBlockStop()

                $("#approve_count").text(approve_count)
                $("#pending_count").text(pending_count)
                $("#cancel_count").text(cancel_count)
                $("#total_list_count").text(approve_count+pending_count+cancel_count)

                $("#total_tax").text(total_tax)
                $("#total_vat").text(total_vat)
                $("#total_shiping_cost").text(total_shiping_cost)
                $("#total_other_cost").text(total_other_cost)
                $("#total_discount").text(total_discount)
                $("#total_product_cost").text(total_product_cost)
                $("#total_grand_total_cost").text(total_grand_total_cost)

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

                $("#approve_count").text(0)
                $("#pending_count").text(0)
                $("#cancel_count").text(0)
                $("#total_list_count").text(0)

                $("#total_tax").text(0)
                $("#total_vat").text(0)
                $("#total_shiping_cost").text(0)
                $("#total_other_cost").text(0)
                $("#total_discount").text(0)
                $("#total_product_cost").text(0)
                $("#total_grand_total_cost").text(0)

                data =
                    "<tr><td colspan='12' class='text-center'><h3>No Data Found</h3></td></tr>";
                uiBlockStop()
                $('#addRow').html(data);
            }
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
                url: "{{ route('admin.purchase_search_purchase_list') }}",
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {
                    pending_showData(res.purchase)
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
