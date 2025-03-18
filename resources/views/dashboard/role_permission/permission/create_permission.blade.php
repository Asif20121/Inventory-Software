@extends('dashboard.admin.layouts.master')
@php
    $data = isset($permission) ? $permission : '';
    $id  = isset($data->id ) ? $data->id  : '';
    $name  = isset($data->name ) ? $data->name  : '';
    $group_name = isset($data->group_name) ? $data->group_name : '';

@endphp

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $id ? 'Edit Permission' : 'Add New Permission' }} </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Permission</a></li>
                            <li class="breadcrumb-item active">Create</li>
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
                                <h3 class="card-title">
                                    Create Permission
                                </h3>
                                <div class="card-tools">
                                            <a class="btn btn-primary" href="{{ route('rpm.permission.list') }}">Permission
                                                List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ $id ? route('rpm.permission.update', $id) : route('rpm.permission.store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div class="col">
                                            <label for="">Name</label> <span class="text-danger">*</span>
                                            <input type="text" name="name" class="form-control bg-light"
                                                placeholder="Permission Name" value="{{ $name }}">
                                            <span class="text-danger">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col">
                                            <label for="">Group Name</label><span class="text-danger">*</span>
                                            <select name="group_name" class="form-control bg-light">
                                                <option value="">Select Group</option>
                                                <option value="admin" {{ $group_name == 'admin' ? 'selected' : '' }} >Admin Manage</option>
                                                <option value="user" {{ $group_name == 'user' ? 'selected' : '' }}>User Manage</option>
                                                <option value="role_permission" {{ $group_name == 'role_permission' ? 'selected' : '' }}>Role and Permission Manage</option>
                                            </select>

                                            <span class="text-danger">
                                                @error('group_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                    </div>

                                    <div class="row mt-4">
                                        <div class="col text-right pt-5">
                                            <button class="btn btn-info">{{ $id ? 'Update' : 'Save' }}</button>
                                        </div>
                                    </div>

                                </form>
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
