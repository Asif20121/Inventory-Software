@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Store Privilege List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Store Privilege</a></li>
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
                                    Store Privilege List &nbsp;
                                    <span class='bg-success rounded px-1'>{{ $active }} </span>&nbsp;
                                    <span class='bg-warning rounded px-1'>{{ $inactive }} </span>
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('admin.room_permission_create') }}">Add New
                                        Store Privilege</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table border table-bordered datatable">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">RP Code</th>
                                                <th scope="col" class="text-center">Employee Info</th>
                                                <th scope="col" class="text-center" style="width: 15%">Store</th>
                                                <th scope="col" class="text-center">Status</th>
                                                {{-- <th scope="col" class="text-center">Create</th> --}}
                                                <th scope="col" class="text-center">Create & Update</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($store_permission as $key => $sp)
                                                <tr>
                                                    <td>{{ $key + 1 }}</td>
                                                    <td>{{ $sp->sm_code }}</td>
                                                    <td>{{ isset($sp['employee']['name']) ? $sp['employee']['name'] : '' }} <br> {{ isset($sp['employee']['email']) ? $sp['employee']['email'] : '' }}
                                                    </td>
                                                    <td class="text-center">
                                                        @foreach ($sp->sp_details as $key => $sto)
                                                            @if (isset($sto->store->status) && $sto->store->status == '1')
                                                                <span class="bg-secondary px-1 rounded ">
                                                                    {{ isset($sto->store->store_name) && $sto->store->store_name != '' ? $sto->store->store_name : '' }}</span> <br>
                                                            @endif
                                                        @endforeach
                                                    </td>

                                                    <td>
                                                        @if ($sp->status == 1)
                                                            <span class="bg-success px-1 rounded">Active</span>
                                                        @else
                                                            <span class="bg-warning px-1 rounded">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td scope="col" class="text-left">
                                                       C.By: {{ $sp->created_employee->name }} <br>
                                                       C.Date: {{ date('d F Y', strtotime($sp->created_at)) }} <br>

                                                        U.By: {{ $sp->updated_employee->name }} <br>
                                                        U.Date: {{ date('d F Y', strtotime($sp->updated_at)) }}
                                                    </td>
                                                    <td scope="col" class="text-center">

                                                        <a href="{{ route('admin.room_permission_edit', $sp->id) }}"
                                                            class="h5"><i class="fas fa-edit text-info"></i> </a>

                                                        <a href="{{ route('admin.room_permission_delete', $sp->id) }}"
                                                            class="delete_data h5 text-danger"><i
                                                                class="fas fa-trash-alt"></i></a>

                                                    </td>
                                                </tr>
                                            @endforeach
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
