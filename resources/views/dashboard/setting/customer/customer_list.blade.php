@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Customer List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Customer</a></li>
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
                                Unit List   &nbsp;
                                <span class='bg-success rounded px-1'>{{$active}} </span>&nbsp;
                                <span class='bg-warning rounded px-1'>{{$inactive}} </span>
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('invoice_setting.customer_create') }}">Add New Customer </a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered" id="y_datatable">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col" class="text-center">Customer Name</th>
                                            <th scope="col" class="text-center">Contact</th>
                                            <th scope="col" class="text-center">Address</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Create</th>
                                            <th scope="col" class="text-center">Update</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    </tbody>
                                </table>
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
        var table = $('#y_datatable').DataTable({
            processing: true,
            serverSide: true,
            "lengthMenu": [10, 25, 50, 100, 500,1000 ],
            ajax: "{{ route('invoice_setting.customer_list') }}",
            columns: [
                {
                 data: 'DT_RowIndex',
                 name: 'DT_RowIndex',
                'orderable': false,
                'searchable': false
                 },
                {
                    data: 'customer_name',
                    name: 'customer_name',
                },
                {
                    className: "text-left",
                    data: 'contact',
                    name: 'email',
                    render: function(data, type, full, meta) {
                       let contact=`
                       <strong>Email</strong> : ${data.email} </br>
                       <strong>Phone</strong> : ${data.phone}
                       `;
                        return `${contact}`;
                    },
                    orderable: false
                },
                {
                    data: 'address',
                    name: 'phone',
                },
                {
                    className: "text-center",
                    data: 'status',
                    render: function(data, type, full, meta) {
                        let status = '';
                        if (data == 1) {
                            status = '<span class="bg-success rounded px-1">Active</span>'
                        } else if (data == 0) {
                            status = '<span class="bg-warning rounded px-1">Inactive</span>'
                        }
                        return `${status}`;
                    },
                    orderable: false
                },
                {
                    className: "text-left",
                    data: 'create',
                },
                {
                    className: "text-left",
                    data: 'update',
                },
                {
                    className: "text-center",
                    data: 'action',
                    render: function(data, type, full, meta) {
                            var editUrl = data.editUrl;
                            var delete_url = data.deleteUrl;
                            let action=''
                                 action += `<a href="${editUrl}" class="h5"><i class="fas fa-edit text-info"></i></a>
                                            <a href="${delete_url}" class="h5 delete_data"><i class="fas fa-trash-alt text-danger"></i></a> `;


                            return `${action}`;
                        },
                        orderable: false
                    },

            ]
        })
    })
</script>

@endpush
