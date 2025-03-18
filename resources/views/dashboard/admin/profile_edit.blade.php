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
                        <h1 class="m-0">Edit Your Profile </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Admin</a></li>
                            <li class="breadcrumb-item active">Profile</li>
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
                                    
                                </h3>
                                <div class="card-tools">
                                            <a class="btn btn-primary" href="{{route('admin.profile.view', Auth::user()->id)}}">View Your Profile</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <form action="{{route('admin.profile.update',$id)}}" method="POST" enctype="multipart/form-data">
                                    @csrf
                                    
                                    <input type="hidden" value="{{ $image }}" name="image_id">
                                    <div class="row">
                                        <div  class="col">
                                            <label for="">Name</label>
                                            <input type="text" name="name" class="form-control bg-light" placeholder="Name" value="{{$name}}">
                                            <span class="text-danger">
                                                @error('name')
                                                    {{ $message }}
                                                @enderror
                                            </span>                                           
                                        </div>
                                        <div class="col">
                                            <label for="">Phone</label><span class="text-danger">*</span>
                                            <input type="text" name="phone" class="form-control bg-light" placeholder="Phone" value="{{ $phone }}">
                                            <span class="text-danger">
                                                @error('phone')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col">
                                            <label for="">Family Member</label>
                                            <input type="text" name="family_mn" class="form-control bg-light" placeholder="Name" value="{{ $family_mn }}">
                                            <input type="text" name="family_mp" class="form-control bg-light" placeholder="Phone Number" value="{{ $family_mp }}">
                                        </div>                                                                     
                                    </div>

                                    <div class="row mt-3">
                                        
                                        <div class="col">
                                            <label for="">Photo <span class="text-warning">(Max: 1024 kb)</span></label>
                                            <input type="file" id="image" name="image" class="form-control bg-light " value="" accept="image/*">
                                            <span class="text-danger" id="msg_v"> @error('image')
                                                    {{ $message }}
                                                @enderror
                                            </span>

                                            <div id="">
                                                <img id="show_image"
                                                    src="{{ $image != '' ? URL::to('storage/employee/' . $image) : asset('no_image.png') }}"
                                                    style="width: 200px;height:200px" class="rounded elevation-2 m-2"
                                                    alt="No Image">
                                            </div>
                                        </div>
                                        <div class="col">
                                            <label for="">Address</label>
                                            <input type="text" name="address" class="form-control bg-light" placeholder="Address" value="{{ $address }}">
                                            <span class="text-danger">
                                                @error('address')
                                                    {{ $message }}
                                                @enderror
                                            </span>
                                        </div>
                                        <div class="col text-right mt-5">
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
@push('admin_js')
    <script>
        image_validation("#image", "#show_image", "#msg_v", '1024', "Image Size Can't larger than 1024 KB")
    </script>
@endpush