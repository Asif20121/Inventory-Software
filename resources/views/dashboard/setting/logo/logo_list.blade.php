@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">LWT List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">LWT</a></li>
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
                                LWT List &nbsp;
                                <span class='bg-success rounded px-1'>{{$active}} </span>&nbsp;
                                <span class='bg-warning rounded px-1'>{{$inactive}} </span>
                                </h3>
                                <div class="card-tools">
                                    @if(count($pre_logo) < 1)
                                        <a class="btn btn-primary" href="{{ route('setting.logo_create') }}">Add New LWT </a>
                                    @endif
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered datatable responsived">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col">W.Name</th>
                                                <th scope="col">Logo Image</th>
                                                <th scope="col">Favicon</th>
                                                <th scope="col">Contact info</th>
                                                <th scope="col">Address</th>
                                                <th scope="col">Status</th>
                                                <th scope="col">Create</th>
                                                <th scope="col">Update</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (isset($pre_logo))
                                                @foreach ($pre_logo as $key => $data)
                                                    <tr>
                                                        <td scope="col" class="text-center">{{ $key + 1 }}</td>
                                                        <td scope="col" class="text-left">{{ $data->website_name }}</td>
                                                        <td scope="col" class="text-left">
                                                            <img id="show_logo_image"
                                                            src="{{ $data->logo_image != '' ? URL::to('storage/logo_image/' . $data->logo_image) : asset('no_image.png') }}"
                                                            style="width: 100px;height:100px" class="rounded elevation-2 m-2"
                                                            alt="No Image">
                                                        </td>
                                                        <td scope="col" class="text-left">
                                                            <img id="show_favicon"
                                                            src="{{ $data->favicon != '' ? URL::to('storage/favicon/' . $data->favicon) : asset('no_image.png') }}"
                                                            style="width: 100px;height:100px" class="rounded elevation-2 m-2"
                                                            alt="No Image">
                                                        </td>
                                                        <td scope="col" class="text-left">
                                                           <b>Phone</b>: {{ $data->contact_number }} <br>
                                                            <b>Email</b>: {{ $data->email }} <br>
                                                            <b>Web Url</b>: {{ $data->web_url }} <br>
                                                            <b>Validity</b>:{{isset($data->validity_date) && $data->validity_date != '' ?  date('d F Y', strtotime($data->validity_date)) : ''}}

                                                        </td>
                                                        <td scope="col" class="text-left">{{ $data->address }}</td>
                                                        <td class="text-left">
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

                                                                <a href="{{ route('setting.logo_edit', $data->id) }}" class="h5"><i class="fas fa-edit text-info"></i> </a>

                                                                <a href="{{ route('setting.logo_delete', $data->id) }}" class="delete_data h5 text-danger"><i class="fas fa-trash-alt"></i></a>

                                                        </td>
                                                    </tr>
                                                @endforeach
                                            @endif
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
@push('admin_js')
    <script >
        image_validation("#logo_image_id", "#show_logo_image", "#error_show", '1024', "Image Size Can't larger than 1024 KB")
        favicon_validation("#favicon_id", "#show_favicon", "#error_favicon", '1024', "Image Size Can't larger than 1024 KB")
    </script>
@endpush
