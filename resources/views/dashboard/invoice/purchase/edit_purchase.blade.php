@extends('dashboard.admin.layouts.master')
@section('admin_body')
    @php
        $data = isset($purchase) ? $purchase : '';
        $date = $data->date != '' ? date('d F Y', strtotime($data->date)) : '';
        $voucher = $data->voucher != '' ? $data->voucher : '';
        $purchase_id = $data->id != '' ? $data->id : '';
        $tax = $data->tax != '' ? $data->tax : '';
        $vat = $data->vat != '' ? $data->vat : '';
        $shipping_cost = $data->shipping_cost != '' ? $data->shipping_cost : '';
        $other_cost = $data->other_cost != '' ? $data->other_cost : '';
        $discount = $data->discount != '' ? $data->discount : '';
        $description = $data->description != '' ? $data->description : '';
        $grand_total = $data->grand_total != '' ? $data->grand_total : '';

        $store_name = $data->storef->store_name != '' ? $data->storef->store_name : '';
        $supplier_name = $data->supplierf->supplier_name != '' ? $data->supplierf->supplier_name : '';

    @endphp
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">EditPurchase </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Purchase</a></li>
                            <li class="breadcrumb-item active">Edit</li>
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

                    <form id="update_purchase_form" method="POST">
                        @csrf
                        <input type="hidden" value="{{ $purchase_id }}" name="purchase_id">
                        <section class="col-lg-12 connectedSortable">
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-6 text-left">
                                            <label for="">Date</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control" disabled value="{{ $date }}"
                                                name="date">
                                        </div>

                                        <div class="col-md-2 col-sm-6 text-left">
                                            <label for="">Voucher</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control" value="{{ $voucher }}" disabled>
                                        </div>


                                        <div class="col-md-4 col-sm-6 text-left">
                                            <label for="">Store</label> <span class="text-danger">*</span>
                                            <input type="text" class="form-control " value="{{ $store_name }}"
                                                disabled>
                                        </div>

                                        <div class="col-md-4 col-sm-6 text-left">
                                            <label for="">Supplier</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control " value="{{ $supplier_name }}"
                                                disabled>
                                        </div>

                                    </div>
                                </div><!-- /.card-header -->



                                <div class="card-body ">

                                    @csrf
                                    <div class="row">
                                        <div class="col-md-12 col-sm-12 ">
                                            <table id="service_table" class="table-sm table-bordered" width="100%">
                                                <thead>
                                                    <tr class="bg-dark">
                                                        <th class="text-center">Sl.No.</th>
                                                        <th class="text-center" style="width: 20%">Product Name</th>
                                                        <th class="text-center">Buying Qty</th>
                                                        <th class="text-center">Unit Price</th>
                                                        <th class="text-center">Discount</th>
                                                        <th class="text-center">UPWD</th>
                                                        <th class="text-center">Total Price</th>
                                                    </tr>
                                                </thead>

                                                @php
                                                    $total_item = 0;
                                                    $total_price = 0;
                                                @endphp
                                                <tbody id="addRow" class="addRow">
                                                    @if (count($purchase['purchase_detailsf']) > 0)
                                                        @foreach ($purchase['purchase_detailsf'] as $key => $pd)
                                                            <tr>
                                                                <td>{{ $key + 1 }}</td>
                                                                <td>
                                                                    {{ isset($pd['productf']['product_name']) && $pd['productf']['product_name'] != null ? $pd['productf']['product_name'] : '' }}
                                                                    <input type="hidden" name="product_id[]" value="{{ isset($pd['productf']['id']) && $pd['productf']['id'] != null ? $pd['productf']['id'] : '' }}">
                                                                </td>
                                                                <td class="text-center"><input
                                                                        class="form-control buying_qty "
                                                                        oninput="validity.valid||(value='');" min="0"
                                                                        type="number"
                                                                        name="buying_qty[]"
                                                                        value="{{ isset($pd['buying_qty']) && $pd['buying_qty'] != null ? $pd['buying_qty'] : '0' }}">
                                                                </td>
                                                                <td class="text-center"><input
                                                                        class="form-control unit_price "
                                                                        oninput="validity.valid||(value='');" min="0"
                                                                        type="number"
                                                                        name="unit_price[]"
                                                                        value="{{ isset($pd['unit_price']) && $pd['unit_price'] != null ? $pd['unit_price'] : '0' }}">
                                                                </td>
                                                                <td class="text-center"><input class="form-control discount"
                                                                        oninput="validity.valid||(value='');" min="0"
                                                                        type="number"
                                                                        name="discount[]"
                                                                        value="{{ isset($pd['discount']) && $pd['discount'] != null ? $pd['discount'] : '0' }}">
                                                                </td>
                                                                <td class="text-center"><input class="form-control upwd"
                                                                        readonly type="number" name="upwd[]"
                                                                        value="{{ isset($pd['upwd']) && $pd['upwd'] != null ? $pd['upwd'] : '0' }}">
                                                                </td>
                                                                <td class="text-center">
                                                                    <input type="number" class="form-control tupwd" name="total_price[]"
                                                                        readonly
                                                                        value="{{ isset($pd['total_price']) && $pd['total_price'] != null ? $pd['total_price'] : '0' }}">
                                                                </td>
                                                            </tr>

                                                            @php
                                                                $total_item = $total_item + ($pd['buying_qty'] != null ? $pd['buying_qty'] : '0');
                                                                $total_price = $total_price + ($pd['total_price'] != null ? $pd['total_price'] : '0');
                                                            @endphp
                                                        @endforeach
                                                    @endif

                                                </tbody>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="5"></td>
                                                        <td><strong>Total Item</strong></td>
                                                        <td><input class="form-control" type="text" id="total_item"
                                                                name="total_item" value="{{ $total_item }}" readonly>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5"></td>
                                                        <td><strong>Net Total Amount</strong></td>
                                                        <td><input class="form-control" type="text" id="total_item_price"
                                                                name="product_cost" value="{{ $total_price }}" readonly>
                                                        </td>
                                                        <td></td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-12 col-sm-12 ">
                                            <hr>
                                        </div>
                                        <div class="col-md-12 col-sm-12 ">
                                            <div class="row">
                                                <div class="col-md-2 col-sm-6 mt-2">
                                                    <label for="">Tax</label>
                                                    <input class="form-control" type="number" id="tax"
                                                        oninput="validity.valid||(value='');" min="0"
                                                        name="tax" value="{{ $tax }}">
                                                </div>

                                                <div class="col-md-2 col-sm-6 mt-2">
                                                    <label for="">Vat</label>
                                                    <input class="form-control" type="number" id="vat"
                                                        oninput="validity.valid||(value='');" min="0"
                                                        name="vat" value="{{ $vat }}">
                                                </div>

                                                <div class="col-md-2 col-sm-6 mt-2">
                                                    <label for="">Shipping Cost</label>
                                                    <input class="form-control" type="number" id="shipping_cost"
                                                        oninput="validity.valid||(value='');" min="0"
                                                        name="shipping_cost" value="{{ $shipping_cost }}">
                                                </div>
                                                <div class="col-md-2 col-sm-6 mt-2">
                                                    <label for="">Other Cost</label>
                                                    <input class="form-control" type="number" id="other_cost"
                                                        oninput="validity.valid||(value='');" min="0"
                                                        name="other_cost" value="{{ $other_cost }}">
                                                </div>
                                                <div class="col-md-2 col-sm-6 mt-2">
                                                    <label for="">Discount</label>
                                                    <input class="form-control" type="number" id="special_discount"
                                                        oninput="validity.valid||(value='');" min="0"
                                                        name="special_discount" value="{{ $discount }}">
                                                </div>

                                                <div class="col-md-2 col-sm-6 mt-2">
                                                    <label for="">Description</label>
                                                    <textarea id="description" name="description" class="form-control" id="" cols="10" rows="1">{{ $description }}</textarea>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-5">
                                            <hr>
                                        </div>

                                        <div class="col-md-12 col-sm-12 ">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8"></div>
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Grand Total</strong>
                                                        <input style="width: 60%" id="grand_total" readonly
                                                            name="grand_total" type="number" class="form-control"
                                                            value="{{ $grand_total }}">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 col-sm-12 mt-3">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8"> <button type="submit" class="btn btn-info">Update
                                                        Purchase</button></div>
                                                <div class="col-md-4 ">

                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </section>

                    </form>
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
        $(document).on('keyup click', '.buying_qty,.unit_price,.discount', function() {
            var buying_qty = $(this).closest("tr").find("input.buying_qty").val();
            var unit_price = $(this).closest("tr").find("input.unit_price").val();
            var discount = $(this).closest("tr").find("input.discount").val();

            var unit_total_price = ((unit_price * buying_qty) - discount);
            // if ((unit_price) > 0) {
                // console.log(buying_qty, unit_price, discount, upwd)
                if (buying_qty > 0) {
                    var upwd = ((unit_price * buying_qty - discount) / buying_qty);
                    $(this).closest("tr").find("input.upwd").val(parseFloat(upwd).toFixed(2));
                    $(this).closest("tr").find("input.tupwd").val(unit_total_price);
                    total_data()
                } else {
                    $(this).closest("tr").find("input.upwd").val(0);
                    $(this).closest("tr").find("input.tupwd").val(0);
                    total_data()
                }
            // } else {
                // error_message('Unit Price can not zero or empty')
            // }

        })
        $(document).on('keyup click', '#tax,#vat,#shipping_cost,#other_cost,#special_discount', function() {
            total_data()
        })

        let total_data = async () => {
            var total_qty = 0;
            $(".buying_qty").each(function() {
                var value = $(this).val() ? $(this).val() : 0;
                total_qty += parseFloat(value);
            });

            var total_item_amount = 0;
            $(".tupwd").each(function() {
                var value = $(this).val() ? $(this).val() : 0;
                total_item_amount += parseFloat(value);
            });

            $(".unit_price").each(function() {
                var value = $(this).val() ? $(this).val() : 0;
                if(value <1){
                    error_message('Unit Price can not zero or empty')
                }
            });

            $("#total_item").val(total_qty)
            $("#total_item_price").val(total_item_amount)

            let tax = $('#tax').val() ? $('#tax').val() : 0;
            let vat = $('#vat').val() ? $('#vat').val() : 0;
            let shipping_cost = $('#shipping_cost').val() ? $('#shipping_cost').val() : 0;
            let other_cost = $('#other_cost').val() ? $('#other_cost').val() : 0;
            let special_discount = $('#special_discount').val() ? $('#special_discount').val() : 0;

            if(total_item_amount < special_discount){
                error_message('Total item price must be greater then special discount')
            }

            let grand_total = (parseFloat(total_item_amount) + parseFloat(vat) + parseFloat(tax) + parseFloat(
                shipping_cost) + parseFloat(other_cost) - parseFloat(special_discount));

            $('#grand_total').val(grand_total);
        }



        $("#update_purchase_form").submit(function(event) {
            //
            let total_item_price = $('#total_item_price').val() ? $('#total_item_price').val() : 0;
            let special_discount = $('#special_discount').val() ? $('#special_discount').val() : 0;

            var unit_price = 0;
            $(".unit_price").each(function() {
                var value = $(this).val() ? $(this).val() : 0;
                if(value <1){
                    unit_price ++
                }
                if(unit_price>0){
                    event.preventDefault();
                    error_message('Unit Price can not zero or empty')
                }else{
                    if(parseFloat(total_item_price) > parseFloat(special_discount)){
                        $('#update_purchase_form').attr('action', "{{ route('admin.purchase_manage_update') }}");
                    }else{
                    event.preventDefault();
                    error_message('Total item price must be greater then special discount')
                    }
                }
            });
        })
    </script>
@endpush
