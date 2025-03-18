@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Manage Employees </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Employee</a></li>
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
                                    Employee List
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('admin.admin_create') }}">Add New Employee
                                    </a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <table class="table border table-bordered" id="y_datatable">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col" class="text-center">Image</th>
                                            <th scope="col" class="text-center">Name</th>

                                            <th class="text-center">
                                                <select id="designation_filter" class="form-control search_box "
                                                    style="width: 200px">
                                                    <option value="">Designation</option>
                                                    @if (count($designation) > 0)
                                                        @foreach ($designation as $key => $desi)
                                                            <option value="{{ $desi->id }}">
                                                                {{ $key + 1 }}.{{ $desi->designation_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </th>


                                            <th class="text-center">
                                                <select id="department_filter" class="form-control search_box "
                                                    style="width: 200px">
                                                    <option value="">Department</option>
                                                    @if (count($department) > 0)
                                                        @foreach ($department as $key => $dep)
                                                            <option value="{{ $dep->id }}">
                                                                {{ $key + 1 }}.{{ $dep->department_name }}</option>
                                                        @endforeach
                                                    @endif
                                                </select>

                                            </th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Role</th>
                                            <th scope="col" class="text-center">Entry Data</th>
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
        $(function() {
            fetchData('', '');
        })
        //Fetch Data
        let fetchData = async (designation = '', department = '') => {
            var table = await $('#y_datatable').DataTable({
                processing: true,
                serverSide: true,
                "lengthMenu": [10, 25, 50, 100, 500, 1000],
                ajax: {
                    url: "{{ route('admin.admin_list') }}",
                    data: {
                        designation: designation,
                        department: department
                    }
                },
                columns: [{
                        data: 'DT_RowIndex',
                        name: 'DT_RowIndex',
                        'orderable': false,
                        'searchable': false
                    },
                    {
                        className: "text-center",
                        data: 'img',
                        width: '5%',
                        render: function(data, type, full, meta) {

                            let img = data ?
                                `<img src="{{ URL::to('/storage') }}/employee_thum/${data}"  style="width: 100%;" class='img-thumbnail rounded elevation-2' />` :
                                `<img src="{{ asset('no_image.png') }}" style="width: 100%;" class='img-thumbnail rounded elevation-2' alt="No Image">`;
                            return `${img}`;
                        },
                        orderable: false
                    },
                    {
                        data: 'emp_info',
                        name: 'name',
                        render: function(data, type, full, meta) {
                            let emp_info = `
                       <strong>${data.name}</strong>  </br>
                       (
                        <strong>  Card:</strong> ${data.card_no},&nbsp;
                        <strong>  Em:</strong> ${data.email},&nbsp;
                        <strong>  Ph:</strong> ${data.phone}
                       )
                       `;
                            return `${emp_info}`;
                        },
                        orderable: false
                    },
                    {
                        className: "text-left",
                        data: 'designation',
                        name: 'email',
                        orderable: false
                    },
                    {
                        className: "text-left",
                        data: 'department',
                        name: 'admin_detail_data.card_no',
                        orderable: false
                    },

                    {
                        className: "text-center",
                        data: 'status',
                        name: 'phone',

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
                        className: "text-center ",
                        data: 'roles',
                        render: function(data, type, full, meta) {

                            let role = data ? `<span class="bg-info p-1 rounded ">${data}</span>` :
                                '';
                            return `${role}`;
                        },
                        orderable: false
                    },
                    {
                        className: "text-center",
                        data: 'created_at',
                        render: function(data, type, full, meta) {
                            var d = new Date(data);
                            return `${d.getDate()+' '+(d.toLocaleString('default', { month: 'long' }))+' '+d.getFullYear()}`;
                        },
                        orderable: false
                    },
                    {
                        className: "text-center",
                        data: 'action',
                        render: function(data, type, full, meta) {
                            var editUrl = data.editUrl;
                            // var delete_url = data.deleteUrl;
                            var admin_view = data.admin_view;
                            let action =
                                `<a type="button" data-action="${admin_view}" data-modal="common_modal_xl" title="View Employee"
                                                            data-title="View Employee" class="btn-sm btn-secondary open_modal"><i class="fas fa-eye"></i></a>&nbsp;`

                            action +=
                                `@if (Auth::guard('admin')->user()->can('admin.edit')) <a href="${editUrl}" class="btn-sm btn-info"><i class="fas fa-edit "></i></a> @endif `;



                            return `${action}`;
                        },
                        orderable: false
                    },

                ]
            })
        }



        $(document).on('change', '#designation_filter,#department_filter', function() {
            let designation_filter = $("#designation_filter").val();
            let department_filter = $("#department_filter").val();
            $('#y_datatable').DataTable().destroy();
            fetchData(designation_filter, department_filter)
        });
    </script>
@endpush
