@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Expense Type List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Expense Type</a></li>
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
                                Expense Type List &nbsp;
                                <span class='bg-success rounded px-1'>{{$active}} </span>&nbsp;
                                <span class='bg-warning rounded px-1'>{{$inactive}} </span>
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('invoice_setting.expense_create') }}">Add New Expense Type </a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <table class="table table-bordered datatable">
                                    <thead class="bg-secondary">
                                        <tr>
                                            <th scope="col" class="text-center">#</th>
                                            <th scope="col" class="text-center">Type Name</th>
                                            <th scope="col" class="text-center">Status</th>
                                            <th scope="col" class="text-center">Create</th>
                                            <th scope="col" class="text-center">Update</th>
                                            <th scope="col" class="text-center">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($expense))
                                            @foreach ($expense as $key => $data)
                                                <tr>
                                                    <td scope="col" class="text-center">{{ $key + 1 }}</td>
                                                    <td scope="col" class="text-left">{{ $data->type_name }}</td>
                                                    <td class="text-center">
                                                        @if ($data->status == 1)
                                                        <span class="bg-success rounded px-1">Active</span>
                                                        @else
                                                        <span class="bg-warning rounded px-1">Inactive</span>
                                                        @endif
                                                    </td>
                                                    <td scope="col" class="text-left">
                                                        By: {{ $data->created_employee->name }} <br>
                                                        Date: {{ date('d F Y', strtotime($data->created_at)) }}
                                                    </td>

                                                    <td scope="col" class="text-left">
                                                        By: {{ $data->updated_employee->name }} <br>
                                                        Date: {{ date('d F Y', strtotime($data->updated_at)) }}
                                                    </td>
                                                    <td scope="col" class="text-center" class="text-center">

                                                            <a href="{{ route('invoice_setting.expense_edit', $data->id) }}"
                                                                class="h5"><i class="fas fa-edit text-info"></i> </a>

                                                            <a href="{{ route('invoice_setting.expense_delete', $data->id) }}"
                                                                class="delete_data h5 text-danger"><i
                                                                    class="fas fa-trash-alt"></i></a>

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
