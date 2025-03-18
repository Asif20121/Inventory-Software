@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">All Role In Permission List </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Role In Permission</a></li>
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
                                    Role List
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('rpm.in_role_permission.create') }}">Add New
                                        Role In
                                        Permission
                                    </a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <table class="table border table-bordered datatable">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col" class="text-center">Role Name</th>
                                            <th scope="col" class="text-center">Permission</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($role))
                                            @foreach ($role as $key => $data)
                                                <tr>
                                                    <td scope="col" class="text-center">{{ $key + 1 }}</td>
                                                    <td scope="col" class="text-left" style="width: 14%;">{{ $data->name }}</td>
                                                    <td scope="col" class="text-left">
                                                        <div class="row">

                                                            @foreach ($data->permissions as $d)
                                                                <div class="col m-1">
                                                                    <span style="text-transform: capitalize;"
                                                                        class="p-1  rounded  bg-gradient-secondary">{{ $d->name }}</span>
                                                                </div>
                                                            @endforeach

                                                        </div>
                                                    </td>



                                                    <td scope="col" class="text-center" class="text-center">
                                                        @if ($data->role_type != '5')
                                                            <a href="{{ route('rpm.in_role_permission.edit', $data->id) }}"
                                                                class="h5"><i class="fas fa-edit text-info"></i> </a>
                                                            &nbsp &nbsp
                                                            <a href="{{ route('rpm.in_role_permission.delete', $data->id) }}"
                                                                class="delete_data h5 text-danger"><i
                                                                    class="fas fa-trash-alt"></i></a>
                                                        @endif
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
