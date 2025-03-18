@extends('dashboard.admin.layouts.master')

@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Purchase Pending List</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Purchase Pending</a></li>
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
                                    List <span class='bg-warning rounded px-1'>{{ count($purchase) }} </span>
                                </h3>
                                <div class="card-tools">
                                    <a class="btn btn-primary" href="{{ route('admin.purchase_manage_create') }}">Add New
                                        Purchase</a>
                                </div>
                            </div><!-- /.card-header -->
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered datatable">
                                        <thead class="bg-secondary">
                                            <tr>
                                                <th scope="col" class="text-center">#</th>
                                                <th scope="col" class="text-center">Voucher</th>
                                                <th scope="col" class="text-center">Store</th>
                                                <th scope="col" class="text-center">Supplier</th>
                                                <th scope="col" class="text-center">Cost</th>
                                                <th scope="col" class="text-center">Status</th>
                                                <th scope="col" class="text-center">Last Update</th>
                                                <th scope="col" class="text-center">Action</th>
                                            </tr>
                                        </thead>

                                        <tbody>
                                            @if (count($purchase) > 0)
                                                @foreach ($purchase as $key => $pur)
                                                    <tr>
                                                        <td scope="col" class="text-center">{{ $key + 1 }}</td>
                                                        <td scope="col"> {{ $pur->date }} <br>
                                                            <strong>Voucher</strong> : {{ $pur->voucher }} <br> </td>
                                                        <td scope="col">
                                                            {{ isset($pur->store_name) && $pur->store_name != '' ? $pur->store_name : '' }}
                                                        </td>
                                                        <td scope="col">
                                                            {{ isset($pur->supplier_name) && $pur->supplier_name != '' ? $pur->supplier_name : '' }}
                                                            <br>
                                                            Ph :
                                                            {{ isset($pur->supplier_email) && $pur->supplier_email != '' ? $pur->supplier_email : '' }}
                                                            <br>
                                                            Email :
                                                            {{ isset($pur->supplier_phone) && $pur->supplier_phone != '' ? $pur->supplier_phone : '' }}
                                                        </td>
                                                        <td scope="col">
                                                            Tax : {{ $pur->tax != '' ? $pur->tax : '0' }} <br>
                                                            Vat : {{ $pur->vat != '' ? $pur->vat : '0' }} <br>
                                                            Shipping cost :
                                                            {{ $pur->shipping_cost != '' ? $pur->shipping_cost : '0' }} <br>
                                                            Other cost :
                                                            {{ $pur->other_cost != '' ? $pur->other_cost : '0' }} <br>
                                                            Discount : {{ $pur->discount != '' ? $pur->discount : '0' }}
                                                            <br>
                                                            Product cost :
                                                            {{ $pur->product_cost != '' ? $pur->product_cost : '0' }} <br>
                                                            Grand total :
                                                            {{ $pur->grand_total != '' ? $pur->grand_total : '0' }} <br>
                                                        </td>
                                                        <td>
                                                            @if ($pur->status == 1)
                                                                <span class="bg-success px-1 rounded">Approved</span>
                                                            @else
                                                                <span class="bg-warning px-1 rounded">Pending</span>
                                                            @endif
                                                        </td>
                                                        <td scope="col" class="text-left" style='width: 20%;'>
                                                            {{ $pur->updated_by }} <br>
                                                            {{ date('d F Y', strtotime($pur->updated_at)) }}
                                                        </td>
                                                        <td scope="col" class="text-center">
                                                            <div class="dropdown">
                                                                <button class="btn btn-info dropdown-toggle" type="button"
                                                                    id="dropdownMenuButton" data-toggle="dropdown"
                                                                    aria-haspopup="true" aria-expanded="false">
                                                                    Select Operation
                                                                </button>
                                                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                                                    <a class="dropdown-item approve"  href="{{ route('admin.purchase_manage_approve', $pur->id) }}"><button class="btn btn-success btn-sm btn-block">Approve</button></a>
                                                                    <a class="dropdown-item reject"  href="{{ route('admin.purchase_manage_reject', $pur->id) }}"><button class="btn btn-secondary btn-sm btn-block">Reject</button></a>
                                                                    {{-- <a class="dropdown-item" href="#">View Details</a> --}}
                                                                    {{-- <a class="dropdown-item" href="#">Change Quantity</a> --}}
                                                                    <a class="dropdown-item delete_data" href="{{ route('admin.purchase_manage_delete', $pur->id) }}"><button class="btn btn-danger btn-sm btn-block">Delete</button></a>
                                                                </div>
                                                            </div>
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
    <script>
        $(document).on('click', '.approve', function(e) {
            e.preventDefault()
            let url = $(this).attr("href");

            Swal.fire({
                title: 'Are you sure?',
                text: "You won't to Approve This!",
                icon: 'warning',
                showCancelButton: true,
                cancelButtonColor: '#3085d6',
                confirmButtonColor: '#d33',
                confirmButtonText: 'Yes, Approve it!',
                cancelButtonText: 'No',
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Approve!',
                        'Your file has been Approved.',
                        'success'
                    )
                    window.location.href = url
                }
            })

        })
    </script>


<script>
    $(document).on('click', '.reject', function(e) {
        e.preventDefault()
        let url = $(this).attr("href");

        Swal.fire({
            title: 'Are you sure?',
            text: "You won't to Approve This!",
            icon: 'warning',
            showCancelButton: true,
            cancelButtonColor: '#3085d6',
            confirmButtonColor: '#d33',
            confirmButtonText: 'Yes, Approve it!',
            cancelButtonText: 'No',
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire(
                    'Approve!',
                    'Your file has been Approved.',
                    'success'
                )
                window.location.href = url
            }
        })

    })
</script>
@endpush
