@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Store Wise Employees </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Store Wise Employee</a></li>
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
                                    Store Wise Employee List
                                </h3>
                                <div class="card-tools">
                                    {{-- <a class="btn btn-primary" href="{{ route('admin.admin_create') }}">Add New Employee
                                    </a> --}}
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body table-responsive">
                                <table class="table table-bordered datatable">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col" class="text-center">Image</th>
                                            <th scope="col" class="text-center">Name</th>
                                            <th scope="col" class="text-center">Contact</th>
                                            <th scope="col" class="text-center">Job Info.</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Role</th>
                                            <th scope="col" class="text-center" style="width: 12%">Entry Data</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($employee_manage_data))
                                            @foreach ($employee_manage_data as $key => $data)
                                                <tr>
                                                    <td scope="col" class="text-center">{{ $key + 1 }}</td>
                                                    <td scope="col" class="text-left">
                                                        <img id="show_image"
                                                            src="{{ $data['image'] != '' ? URL::to('storage/employee_thum/' . $data['image']) : asset('no_image.png') }}"
                                                            style="width: 80px;height:80px" class="rounded elevation-2 m-2"
                                                            alt="No Image">
                                                    </td>
                                                    <td scope="col" class="text-left">
                                                        {{ (isset($data['name']) && $data['name']) != '' ? $data['name'] : '' }}
                                                    </td>
                                                    <td scope="col" class="text-left">
                                                        <strong>Phone</strong>:
                                                        {{ (isset($data['phone']) && $data['phone']) != '' ? $data['phone'] : '' }}
                                                        <br>
                                                        <strong>Email</strong>:
                                                        {{ (isset($data['email']) && $data['email']) != '' ? $data['email'] : '' }}
                                                    </td>
                                                    <td scope="col" class="text-left">
                                                        <strong>Card No</strong>:
                                                        {{ (isset($data['card_no']) && $data['card_no']) != '' ? $data['card_no'] : '' }}
                                                        <br>
                                                        <strong>Designation </strong>:
                                                        {{ (isset($data['designation_name']) && $data['designation_name']) != '' ? $data['designation_name'] : '' }}
                                                        <br>
                                                        <strong>Department </strong>:
                                                        {{ (isset($data['department_name']) && $data['department_name']) != '' ? $data['department_name'] : '' }}
                                                    </td>
                                                    <td class="text-left">
                                                        @if ($data['status'] == 1)
                                                            <span class="bg-success rounded px-1">Active</span>
                                                        @else
                                                            <span class="bg-warning rounded px-1">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td style="width: 13%">
                                                        @foreach ($data['role_data'] as $roles)
                                                            <span class="bg-dark rounded p-1">{{ $roles->role != '' ? $roles->role : '' }}</span>
                                                        @endforeach
                                                    </td>
                                                    <td scope="col" class="text-left">
                                                        {{ date('d F Y', strtotime($data['created_at'])) }}
                                                    </td>
                                                    <td scope="col" class="text-center" class="text-center">

                                                        <a type="button"
                                                            data-action="{{ route('admin.employe_view', $data['id']) }}"
                                                            class="btn-sm btn-secondary open_modal"
                                                            data-modal="common_modal_xl" title="View Store Wise Employee"
                                                            data-title="View Store Wise Employee"><i
                                                                class="fas fa-eye"></i></a>

                                                    </td>
                                                </tr>
                                            @endforeach
                                        @endif
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
