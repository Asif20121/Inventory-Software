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
                        <h1 class="m-0">Expense List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Expense</a></li>
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
                                    <form action="{{ route('admin.expense_manage_search_print') }}" target="_blank" method="post" autocomplete="off">
                                        @csrf
                                        <div class="row d-flex justify-content-between">
                                            <div class="col-lg-2 col-md-3">
                                                <strong>From Date</strong>
                                                <div class="input-container">
                                                    <input name="from_date" type="text" id="from_date" value="{{ date('d-m-Y') }}" placeholder="dd-mm-yy" class="form-control datepicker">
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

                                @if (Session::has('error'))
                                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                                        <strong>{{ session::get('error') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @elseif(Session::has('success'))
                                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                                        <strong>{{ session::get('success') }}</strong>
                                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                @endif

                                <h3 class="card-title">
                                    Expense: &nbsp;<span id="total_item" class="bg-success rounded px-1 text-left">0</span>
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('admin.expense_manage_create') }}">Add New
                                        Expense</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered datatable search_datatable">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">E.Date</th>
                                                <th scope="col" class="text-center">S.Name</th>
                                                <th scope="col" class="text-center">E.Type</th>
                                                <th scope="col" class="text-center">Cost</th>
                                                <th scope="col" class="text-center">Description</th>
                                                <th scope="col" class="text-center">Added By</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="addRow">

                                        </tbody>
                                        <tbody>
                                            <tr class="bg-light">
                                                <td colspan="6" class="text-right"><strong>Total Cost</strong></td>
                                                <td colspan="2" class="text-center"><strong id="total_cost">0</strong></td>
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

        // All Data Show
        $(document).ready(function() {
            if ($.fn.DataTable.isDataTable('.search_datatable')) {
                $('.search_datatable').DataTable().destroy();
            }
            $.ajax({
                async: true,
                type: "get",
                dataType: "json",
                url: "{{ route('admin.expense_showdata') }}",
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {
                    showData(res.expense_manage)
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
            let total_cost = 0
            let data = ''
            $('#total_item').text(res.length)
            if (res.length != 0) {

                $.each(res, function(key, value) {
                    total_cost+=parseFloat(value.cost)
                    let expense_manage_edit = "{{ route('admin.expense_manage_edit', ':id') }}";
                    expense_manage_edit = expense_manage_edit.replace(':id', value.id);

                    let expense_manage_delete = "{{ route('admin.expense_manage_delete', ':id') }}";
                    expense_manage_delete = expense_manage_delete.replace(':id', value.id);

                    if (value.status == 1) {
                        status = "<span class='bg-success rounded p-1'>Active</span>";
                    } else {
                        status = "<span class='bg-warning rounded p-1'>Inactive</span>";
                    }


                    var d = new Date(value.expense_date);
                    var created_at = new Date(value.created_at);
                    data += `
                            <tr>
                                <td scope="col" class="text-center">${key + 1}</td>
                                <td scope="col" class="text-left">${d.getDate()+' '+(d.toLocaleString('default', { month: 'long' }))+' '+d.getFullYear()}</td>
                                <td scope="col" class="text-left">${value.store_name}</td>
                                <td scope="col" class="text-left">${value.type_name}</td>
                                <td scope="col" class="text-left">${value.cost}</td>
                                <td scope="col" class="text-left">
                                    <textarea class="form-control" rows="3" cols="17" disabled>${value.description}</textarea>
                                </td>
                                <td scope="col" class="text-center">
                                     ${value.name}<br>
                                     ${created_at.getDate()+' '+(created_at.toLocaleString('default', { month: 'long' }))+' '+created_at.getFullYear()}
                                </td>
                                <td scope="col" class="text-center">
                                    <a href="${expense_manage_edit}" class="btn-sm btn-info"><i class="fas fa-edit "></i></a> <br>
                                    <a href="${expense_manage_delete}" class="btn-sm btn-danger delete_data"><i class="fas fa-trash-alt mt-3"></i></a>
                                </td>
                            </tr>
                            `;
                })

                uiBlockStop()
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
                data =
                    "<tr><td colspan='12' class='text-center'><h3>No Data Found</h3></td></tr>";
                uiBlockStop()
                $('#addRow').html(data);
            }
            $("#total_cost").text(total_cost)
        }


        store_wise_employee_auto('#employee', '#employee_id', '#err_employee')
        //Search Data
        $(".search_btn").click(function() {
            event.preventDefault()
            if ($.fn.DataTable.isDataTable('.search_datatable')) {
                $('.search_datatable').DataTable().destroy();
            }
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
                url: "{{ route('admin.expense_manage_search') }}",
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {
                    showData(res.expense_manage)
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
