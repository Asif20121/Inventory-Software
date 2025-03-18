@php
    $data = isset($store_info) ? $store_info : '';
    $id = isset($data->id) && $data->id != '' ? $data->id : '';
    $store_name = isset($data->store_name) && $data->store_name != '' ? $data->store_name : '';
    $phone = isset($data->phone) && $data->phone != '' ? $data->phone : '';
    $email = isset($data->email) && $data->email != '' ? $data->email : '';
    $web_url = isset($data->web_url) && $data->web_url != '' ? $data->web_url : '';
    $address = isset($data->address) && $data->address != '' ? $data->address : '';
    $description = isset($data->description) && $data->description != '' ? $data->description : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';
@endphp



<section class="content">
    <div class="container-fluid">
        <!-- Main row -->
        <div class="row">
            <!-- Left col -->
            <section class="col-lg-12 connectedSortable">
                <!-- Custom tabs (Charts with tabs)-->
                <div class="card">

                    <div class="card-body">
                        <div class="row px-3">
                            <div class="col-sm-6 col-md-4 mt-3"><strong>Store Name</strong> :&nbsp; :{{ $store_name }}</div>
                            <div class="col-sm-6 col-md-4 mt-3"><strong>Phone</strong> :&nbsp; :{{ $phone }}</div>
                            <div class="col-sm-6 col-md-4 mt-3"><strong>Email</strong> :&nbsp; {{ $email }}</div>
                            <div class="col-sm-6 col-md-4 mt-3"><strong>Web Url</strong> :&nbsp; <a href="{{ $web_url }}">{{ $web_url }}</a></div>
                            <div class="col-sm-6 col-md-4 mt-3"><strong>Status</strong>:&nbsp;
                                @if ($status == 1)
                                    <span class="bg-success rounded px-1">Active</span>
                                @else
                                    <span class="bg-warning rounded px-1">Inactive</span>
                                @endif
                            </div>
                            <div class="col-sm-6 col-md-4 mt-3"><strong>Create At</strong>:&nbsp;({{ date('d F Y', strtotime($data->created_at)) }})&nbsp;{{ $data->created_employee->name }}</div>
                            <div class="col-sm-6 col-md-4 mt-3"><strong>Update At</strong>:&nbsp;({{ date('d F Y', strtotime($data->updated_at)) }})&nbsp;{{ $data->updated_employee->name }}</div>
                            <div class="col-sm-6 col-md-12 mt-4" style="text-align: justify;text-justify: inter-word;"> <strong>Address</strong>:&nbsp; {!! $address !!}</div>
                            <div class="col-sm-6 col-md-12 mt-4" style="text-align: justify;text-justify: inter-word;"><strong>Description</strong>:&nbsp; {!! $description !!}</div>
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
