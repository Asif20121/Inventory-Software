@extends('dashboard.admin.layouts.master')
@php
    $data = isset($profile_edit) ? $profile_edit : '';
    $name = isset($data->name) ? $data->name : '';
    $phone = isset($data->phone) ? $data->phone : '';
    $email = isset($data->email) ? $data->email : '';
    $image = isset($data->admin_detail_data->image) && $data->admin_detail_data->image != '' ? $data->admin_detail_data->image : '';
    $address = isset($data->admin_detail_data->address) && $data->admin_detail_data->address != '' ? $data->admin_detail_data->address : '';
    $family_mn = isset($data->admin_detail_data->family_mn) && $data->admin_detail_data->family_mn != '' ? $data->admin_detail_data->family_mn : '';
    $family_mp = isset($data->admin_detail_data->family_mp) && $data->admin_detail_data->family_mp != '' ? $data->admin_detail_data->family_mp : '';
    $id = isset($data->id) ? $data->id : '';
@endphp

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Change Your Password </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Profile</a></li>
                            <li class="breadcrumb-item active">Change Password</li>
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
                                <h3 class="card-title"></h3>
                                <div class="card-tools">
                                    <a class="btn btn-danger" href="{{route('admin.profile.view', Auth::user()->id)}}">View Your Profile</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                            <form action="{{route('admin.profile.update_password',Auth::user()->id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row">
                                        <div class="col">                                    
                                            <label for="">Old Password</label>
                                            <input name="old_password" type="password" class="form-control bg-light"  placeholder="Old Password">
                                            <span class="text-danger">
                                                @error('old_password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col">                                    
                                            <label for="">New Password</label>
                                            <input name="new_password" type="password" class="form-control bg-light"  placeholder="New Password">
                                            <span class="text-danger">
                                                @error('new_password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>

                                        <div class="col">                                    
                                            <label for="">Confirm New Password</label>
                                            <input name="confirm_new_password" type="password" class="form-control bg-light"  placeholder="Confirm New Password">
                                            <span class="text-danger">
                                                @error('confirm_new_password')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                    </div>
                                    <div class="row mt-4">
                                        <div class="col text-right pt-5">
                                            <button class="btn btn-info">Update</button>
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