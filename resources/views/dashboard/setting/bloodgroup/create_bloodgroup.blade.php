@extends('dashboard.admin.layouts.master')
@php
    $data = isset($bloodgroup) ? $bloodgroup : '';
    $id = isset($data->id) && $data->id != '' ? $data->id : '';
    $bloodgroup_name = isset($data->bloodgroup_name) && $data->bloodgroup_name != '' ? $data->bloodgroup_name : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';
@endphp

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">{{ $id ? 'Edit Blood Group' : 'Add New Blood Group' }} </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Blood Group</a></li>
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
                                    Create Blood Group
                                </h3>
                                <div class="card-tools">
                                            <a class="btn btn-primary" href="{{ route('setting.bloodgroup_list') }}">Blood Group
                                                List</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{ $id ? route('setting.bloodgroup_update', $id) : route('setting.bloodgroup_store') }}" method="POST">
                                    @csrf
                                    <div class="row">
                                        <div  class="col-md-8 col-sm-12 mt- text-left">
                                            <label for="">Blood Group Name</label> <span class="text-danger">*</span>
                                            <input type="text" name="bloodgroup_name" class="form-control bg-light"
                                                placeholder="Blood Group Name" value="{{$bloodgroup_name}}">
                                            <span class="text-danger">
                                                @error('bloodgroup_name')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                            
                                        </div>

                                        <div class="col-md-4 col-sm-12 mt-5 text-center">
                                            <input {{$status == 1 ? 'checked' : '' }} name="status" class="form-control" type="checkbox" value="1">
                                            <label class="form-check-label" for=""><strong>Status</strong></label>
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
