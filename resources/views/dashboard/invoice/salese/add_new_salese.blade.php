@extends('dashboard.admin.layouts.master')
@push('admin_css')
    <link href="https://unpkg.com/gijgo@1.9.14/css/gijgo.min.css" rel="stylesheet" type="text/css" />
@endpush
@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0"> New Sales </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Sales</a></li>
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

                    <form id="add_product_form" action="{{ route('admin.sales_pos_store') }}" method="POST">
                        @csrf
                        <section class="col-lg-12 connectedSortable">
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="card">
                                <div class="card-header">
                                    <div class="row d-flex justify-content-between">


                                        <div class="col-md-6 col-sm-6 text-left">
                                            <label for="">Customer</label><span class="text-danger">*</span>
                                            <a type="button" class="btn-sm btn-warning py-0 open_modal"
                                            data-action="{{ route('admin.new_customer') }}"
                                            data-title="Add New Customer"
                                            data-modal="common_modal_lg"
                                            title="Add New Customer"
                                            >New</a>
                                            <input type="text" class="form-control" placeholder="Search Customer"
                                                id="customer">
                                            <span class="text-danger error_text customer-error"></span>
                                            <div id="customer_info"> </div>
                                            <input type="hidden" id="customer_id" name="customer_id">
                                        </div>


                                        <div class="col-md-2 col-sm-6 text-left">
                                            <label for="">Store</label> <span class="text-danger">*</span>
                                            <select class="form-control search_box" id="store" name="store">
                                                @foreach ($store as $key => $s)
                                                    <option value="{{ $s->id }}">{{ $key + 1 }}.
                                                        {{ $s->store_name }}</option>
                                                @endforeach
                                            </select>

                                            <span class="text-danger error_text store-error"></span>
                                        </div>

                                    </div>
                                </div><!-- /.card-header -->



                                <div class="card-header bg-light">
                                    <div class="row">
                                        <div class="col-1 text-left">
                                            <label for="">Product</label><span class="text-danger">*</span>
                                        </div>
                                        <div class="col-11 text-left">
                                            <input type="text" class="form-control"
                                                placeholder="Search Product"id="search_product">
                                            <span id="no_data" class="text-danger"></span>
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
                                                        <th class="text-center">Product Name</th>
                                                        <th class="text-center">Qty</th>
                                                        <th class="text-center">Unit Price</th>
                                                        <th class="text-center">Discount(%)</th>
                                                        <th class="text-center">UPWD</th>
                                                        <th class="text-center">Total UPWOD</th>
                                                        <th class="text-center">Total Price</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="addRow" class="addRow"></tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-5">
                                            <hr>
                                        </div>
                                        <div class="col-md-4 col-sm-12 ">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Special Discount</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control" type="number" id="special_discount"
                                                                oninput="validity.valid||(value='');" min="0"
                                                                value="0">
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12 mt-2">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Description</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <textarea id="description" name="description" class="form-control" id="" cols="10" rows="1"></textarea>
                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="col-md-12 mt-5">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Payment Method</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select name="payment_method" id="payment_method"
                                                                class="form-select form-control search_box">
                                                                <option value="">Select Method</option>
                                                                @foreach ($payment_type as $key => $p_type)
                                                                    <option value="{{ $p_type->type_name }}">
                                                                        {{ $key + 1 }}. {{ $p_type->type_name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-12 mt-5">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Payment</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <select id="paid_status" class="form-select form-control">
                                                                <option value="">Select Payment </option>
                                                                <option value="partial_paid">Partial Paid </option>
                                                                <option value="full_paid">Paid </option>
                                                                <option value="full_due">Due</option>
                                                            </select>
                                                            <input type="number" placeholder="0"
                                                                class="form-control recent_paid_amount" value="0"
                                                                style="display:none;" id="recent_paid_amount" min=0
                                                                oninput="validity.valid||(value='');">

                                                            <span class="text-danger" id="paid_status_err"></span>
                                                        </div>

                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="col-md-4 col-sm-12 ">


                                        </div>
                                        <div class="col-md-4 col-sm-12 ">
                                            <div class="col-md-12 mt-2">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Total Item</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" id="total_item"
                                                            name="total_item" value="0" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Total Item Price</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" id="estimated_amount"
                                                            name="product_cost" value="0" readonly>
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Total Item Discount</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text"
                                                            id="total_item_discount" name="total_item_discount"
                                                            value="0" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Total Item Price With
                                                                Discount</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" id="total_item_pwd"
                                                            name="total_item_pwd" value="0" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Special Discount
                                                                Amount</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control" type="text" id="special_dis"
                                                            name="special_dis" value="0" readonly>
                                                    </div>
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
                                                            value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-2 ">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8"></div>
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Paid Amount</strong>
                                                        <input style="width: 60%" id="recent_paid_amount_show" readonly
                                                            name="recent_paid_amount_show" type="number"
                                                            class="form-control" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-2 ">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8">
                                                    <button type="button" onclick="clearData()"
                                                        class="btn btn-danger mr-2">Clear Data</button>
                                                    <button type="submit" class="btn btn-info">Save</button>
                                                </div>
                                                <div class="col-md-4">
                                                    <div class="row">
                                                        <div class="col-md-6"><strong>Payment Status</strong></div>
                                                        <div class="col-md-6">
                                                            <div id="payment_status_show" class="ml-5"
                                                                style="align-items: center"> <strong
                                                                    class="text-info">None</strong></div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                    </div><!-- /.card-body -->
                                </div>
                                <!-- /.card -->
                        </section>

                    </form>

                    <span class="btn btn-primary open_modal d-none"  id="open_modal" data-action="{{route('admin.sales_pos_show')}}" data-modal="common_modal_xl" data-title="Invoice Details" >Open Modal</span>
                    <!-- right col -->
                </div>
                <!-- /.row (main row) -->
            </div><!-- /.container-fluid -->
        </section>
        <!-- /.content -->
    </div>


    {{-- <div class="modal fade" id="myModal" style="top: 10%">
        <div class="modal-dialog modal-xl">
            <div class="modal-content" style="margin-bottom: 9rem">
                <!-- Modal Header -->
                <div class="modal-header dark_blue_gradient text-light py-1">
                    <h4 class="modal-title">Invoice Info <span class="text-secondary">
                        (Invoice no. : <span id="invoice_no_modal"></span>)
                        (Store : <span id="invoice_store_modal"></span>)
                        (Date : <span id="invoice_date_modal"></span>)
                    </span>
                    </h4>
                    <button type="button" class="close text-light" data-dismiss="modal">&times;</button>
                </div>
                <!-- Modal body -->
                <div class="modal-body">
                    <div class="container">
                        <h5>Customer Info</h4>
                            <div class="row d-flex justify-content-between">
                                <div class="col-md-6 col-sm-12">Name <strong>: <span
                                            id="customer_name_modal"></span></strong></div>
                                <div class="col-md-6 col-sm-12">phone <strong>: <span
                                            id="customer_phone_modal"></span></strong> </div>
                                <div class="col-md-6 col-sm-12">Email <strong>: <span
                                            id="customer_email_modal"></span></strong></div>
                                <div class="col-md-6 col-sm-12">Address <strong>: <span
                                            id="customer_address_modal"></span></strong></div>
                            </div>

                            <h5 class="mt-3">Product Info</h4>
                                <div class="table-responsive">

                                    <table class="table table-bordered">
                                        <thead class="text-center bg-light">
                                            <tr>
                                                <th>Sl.No.</th>
                                                <th>Product Name</th>
                                                <th>Qty</th>
                                                <th>Unit Price</th>
                                                <th>Discount(%)</th>
                                                <th>UPWD</th>
                                                <th>Total UPWOD</th>
                                                <th>Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody id="product_list_modal">
                                        </tbody>

                                        <tbody>
                                            <tr>
                                                <th colspan="6"></th>
                                                <th>Total Item</th>
                                                <th><input readonly id="item_qty_modal" type="text"
                                                        class="form-control form-control-sm bg-light" placeholder="0">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="6"></th>
                                                <th>Total Item Price</th>
                                                <th><input readonly type="text" id="total_item_price_modal"
                                                        class="form-control form-control-sm bg-light" placeholder="0">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="6"></th>
                                                <th>Total Item Discount</th>
                                                <th><input readonly type="text" id="total_item_discount_modal"
                                                        class="form-control form-control-sm bg-light" placeholder="0">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="6"></th>
                                                <th>Total Item Price With Discount</th>
                                                <th><input readonly id="total_item_price_with_discount_modal"
                                                        type="text" class="form-control form-control-sm bg-light"
                                                        placeholder="0"></th>
                                            </tr>
                                            <tr>
                                                <th colspan="6"></th>
                                                <th>Special Discount Amount</th>
                                                <th><input readonly type="text" id="specialdiscount_amount_modal"
                                                        class="form-control form-control-sm bg-light" placeholder="0">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="6"></th>
                                                <th>Grand Total</th>
                                                <th><input id="grand_total_modal" readonly type="text"
                                                        class="form-control form-control-sm bg-light" placeholder="0">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="6"></th>
                                                <th>Paid Amount</th>
                                                <th><input id="paid_amount_modal" readonly type="text"
                                                        class="form-control form-control-sm bg-light" placeholder="0">
                                                </th>
                                            </tr>
                                            <tr>
                                                <th colspan="6"></th>
                                                <th>Payment Status</th>
                                                <th>
                                                    <div id="paid_status_modal"><span class="text-primary">None</span>
                                                    </div>
                                                </th>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer d-flex justify-content-between py-1">
                    <a id="print_modal" href="" type="button" class="btn btn-warning btn-sm" target="_blank">Print</a>
                    <button  type="button" class="btn btn-secondary btn-sm" data-dismiss="modal">Close</button>
                </div>

            </div>
        </div>
    </div> --}}
@endsection


@push('admin_js')
    <script src="{{ asset('admin/datepicker/date_picker.js') }}"></script>
    <script>
        $("#date", ).datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy',
        });
    </script>

    <script id="document_template" type="text/x-handlebars-template">
    <tr class="delete_add_more_item" id="delete_add_more_item">
       <td>@{{ sl_no }}</td>
       <td>
        <input type="hidden" class="product_id" name="product_id[]" value="@{{id}}">
        <input type="hidden" class="name" name="product_name[]"  value="@{{name}}"> @{{ name }}
    </td>
       <td><input type="number" style="display: inherit;width: 80%;" class="form-control buying_qty" value="1" name="buying_qty[]"  oninput="validity.valid||(value='');" min="1"> <strong class="mt-2" style="float: right;">@{{unit_name}}</strong></td>
       <td><input readonly type="number" class="form-control unit_price" value="@{{current_sales_price}}" name="unit_price[]"  oninput="validity.valid||(value='');" min="0"></td>
       <td><input readonly type="number" class="form-control discount" value="@{{discount}}" name="discount[]"  oninput="validity.valid||(value='');" min="0"></td>
       <td><input readonly type="number" class="form-control upwd" value="@{{upwd}}" name="upwd[]"  oninput="validity.valid||(value='');" min="0"></td>
       <td><input type="number" class="form-control total_upod" value="@{{total_upod}}" readonly name="total_upod[]"  oninput="validity.valid||(value='');" min="0"></td>
       <td><input type="number" class="form-control total_buying_unit_price" value="@{{upwd}}" readonly name="total_buying_unit_price[]"  oninput="validity.valid||(value='');" min="0"></td>
       <td><i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i></td>
      </tr>
  </script>


    <script>

// $(document).on("click", "#open_modal", function(event) {
// console.log("Working");
// })
        // Add To Product List
        let sl_no = 0;
        let addProduct = (id = '', name = '', unit_name = '', current_sales_price = 0, discount = 0) => {
            let tr_data = $("#addRow")

            let count_data = 0;
            $('#addRow tr').each(function() {
                var foreach_id = $(this).find('input.product_id').val();
                if (id == foreach_id) {
                    count_data++

                }
            });

            if(current_sales_price > 0){

            if (count_data == 0) {
                sl_no++

                let upwd = parseFloat(current_sales_price).toFixed(2) - ((parseFloat(discount).toFixed(2) * parseFloat(
                    current_sales_price).toFixed(2)) / 100);

                var source = $("#document_template").html();
                var tamplate = Handlebars.compile(source);
                var data = {
                    id: id,
                    name: name,
                    unit_name: unit_name,
                    sl_no: sl_no,
                    discount: discount,
                    current_sales_price: current_sales_price,
                    upwd: upwd,
                    total_upod: current_sales_price,
                };
                var html = tamplate(data);
                $("#addRow").append(html);
                totalAmountPrice()
            } else {
                $("#no_data").text('Product Already Exist');
            }

        }else{
            $("#no_data").text('Please first Set Product Price');
        }
        }
        // Remove Product
        $(document).on("click", ".removeeventmore", function(event) {
            $(this).closest(".delete_add_more_item").remove();
            totalAmountPrice()
            if ($('#addRow tr').length == 0) {
                sl_no = 0;
            }
        });

        $(document).on('keyup click', '.buying_qty', function() {
            $("#no_data").text('');

            var unit_price = $(this).closest("tr").find("input.unit_price").val();
            var qty = $(this).closest("tr").find("input.buying_qty").val();
            var discount = $(this).closest("tr").find("input.discount").val();

            if (unit_price * qty != "NaN") {

                let upwd = parseFloat(unit_price).toFixed(2) - ((parseFloat(discount).toFixed(2) * parseFloat(
                    unit_price).toFixed(2)) / 100);
                let total = upwd * qty;

                $(this).closest("tr").find("input.total_upod").val(parseFloat((parseFloat(unit_price) * qty))
                    .toFixed(2));
                $(this).closest("tr").find("input.total_buying_unit_price").val(parseFloat(total).toFixed(2));
                $(this).closest("tr").find("input.upwd").val(parseFloat(upwd).toFixed(2));
                totalAmountPrice();


            }

        });

        $(document).on('keyup click', '#special_discount,#recent_paid_amount', function() {
            if ($('#addRow tr').length != 0) {
                totalAmountPrice()
            }
        })

        //Payment
        $(document).on('change', '#paid_status', function() {
            $('#paid_status_err').text("")
            if ($('#addRow tr').length != 0) {
                totalAmountPrice()
            }
        });

        async function totalAmountPrice() {
            if ($('#addRow tr').length == 0) {
                $('#special_discount').val(0);
                $('#recent_paid_amount').val(0);
            }

            var purchase_price = 0;
            $(".total_upod").each(function() {
                var value = $(this).val();
                if (!isNaN(value) && value.length != 0) {
                    purchase_price += parseFloat(value);
                }
            });

            var item = 0;
            $(".buying_qty").each(function() {
                var value = $(this).val();
                if (!isNaN(value) && value.length != 0) {
                    item += parseFloat(value);
                }
            });
            var discount = 0;
            $(".discount").each(function() {
                var dis_val = $(this).val();
                var qty = $(this).closest("tr").find("input.buying_qty").val();
                var unit_price = $(this).closest("tr").find("input.unit_price").val();
                if (!isNaN(dis_val) && dis_val.length != 0) {
                    discount += parseFloat((dis_val * qty * unit_price) / 100);
                }
            });

            $('#total_item').val(item);
            $('#estimated_amount').val(parseFloat(purchase_price).toFixed(2));
            $('#total_item_discount').val(discount);
            $('#total_item_pwd').val(parseFloat(purchase_price - discount).toFixed(2));

            let special_discount = $('#special_discount').val() ? $('#special_discount').val() : 0;
            $('#special_dis').val(special_discount);
            let grand_total = Math.floor(purchase_price - discount - special_discount);
            $('#grand_total').val(grand_total);


            var paid_status = $("#paid_status").val();

            if (paid_status == 'partial_paid') {
                $('.recent_paid_amount').show();

                let recent_paid_amount_show = $('#recent_paid_amount').val();
                $('#recent_paid_amount_show').val(recent_paid_amount_show ? recent_paid_amount_show : 0);

                if (grand_total == recent_paid_amount_show) {
                    $('#payment_status_show').html(`<strong class="text-success">Full Paid</strong>`);
                } else if (grand_total > recent_paid_amount_show) {
                    $('#payment_status_show').html(
                        `<strong class="text-warning">Due : ${grand_total - recent_paid_amount_show}</strong>`);
                } else if (grand_total < recent_paid_amount_show) {
                    $('#payment_status_show').html(
                        `
                        <strong class="text-primary" >  <input name='refound' type='hidden' value="${recent_paid_amount_show - grand_total}" >Return : ${recent_paid_amount_show - grand_total}</strong><br>
                        <strong class="text-success" >Actual Paid : ${recent_paid_amount_show - (recent_paid_amount_show - grand_total)}</strong>
                        `
                    );
                }


            } else if (paid_status == 'full_paid') {
                $('.recent_paid_amount').hide();
                $('#payment_status_show').html('<strong class="text-success">Full Paid</strong>');
                let recent_paid_amount_show = $('#recent_paid_amount').val();
                $('#recent_paid_amount_show').val(grand_total);
            } else if (paid_status == 'full_due') {
                $('.recent_paid_amount').hide();
                $('#payment_status_show').html('<strong class="text-info">Full Due</strong>');
                $('#recent_paid_amount_show').val(0);
            } else {
                $('.recent_paid_amount').hide();
                $('#payment_status_show').html('<strong class="text-info">None</strong>');
                $('#recent_paid_amount_show').val(0);
            }

        }


        // Search Product

        let product_search = (store) => {
            $("#search_product").autocomplete({
                source: function(request, response) {
                    if (store) {
                        $("#no_data").text('');

                        $.ajax({
                            async: true,
                            url: "{{ route('admin.store_wise_product_search') }}",
                            type: 'get',
                            dataType: "json",
                            data: {
                                product: request.term,
                                store: store,
                            },
                            success: function(data) {
                                if (data.length == 0) {
                                    $("#no_data").text('Data Not Found')
                                }
                                var array = $.map(data, function(row) {
                                    return {
                                        value: row.product_name,
                                        label: '(' + row.product_code + ')' + ' ' +
                                            row.product_name + ' ' + '(Qty= ' + row
                                            .qty +
                                            ')',
                                        product_id: row.product_id,
                                        product_name: row.product_name,
                                        unit_name: row.unit_name,
                                        current_sales_price: row.current_sales_price,
                                        discount: row.discount,
                                    }
                                })
                                response($.ui.autocomplete.filter(array, request.term));
                            }
                        })
                    }

                },
                select: function(event, ui) {
                    let id = ui.item.product_id;
                    let product_name = ui.item.product_name;
                    let unit_name = ui.item.unit_name;
                    let current_sales_price = ui.item.current_sales_price;
                    let discount = ui.item.discount;
                    addProduct(id, product_name, unit_name, current_sales_price, discount)
                },
                minLength: 1,
                delay: 500
            });
        }

        $(document).on('change', "#store", function() {
            let store = $(this).val();
            $('#addRow').html('')
            totalAmountPrice()
            product_search(store)

        });
        product_search($("#store").val())
        //End Search Product


        //Submit Form
        $("#add_product_form").submit(function(event) {

            event.preventDefault();
            let formData = new FormData($(this)[0]);
            let action = $(this).attr("action");
            let method = $(this).attr("method");
            $("#no_data").text('');
            if ($('#addRow tr').length > 0) {

                let count_data = 0;
                $('#addRow tr').each(function() {
                    var buying_qty = $(this).find('input.buying_qty').val();
                    if (buying_qty == null || buying_qty == '' || buying_qty == 0) {
                        count_data++
                        $("#no_data").text('Quantity can not be zero or null');
                        error_message('Quantity can not be zero or null')
                    }
                });
                if (count_data == 0) {
                    if ($("#customer_id").val()) {
                        if ($("#paid_status").val()) {

                            $.ajax({
                                async: true,
                                type: method,
                                url: action,
                                data: formData,
                                cache: false,
                                contentType: false,
                                processData: false,
                                beforeSend: function() {
                                    uiBlock()
                                },
                                success: (res) => {

                                    if (res.status = 200) {
                                        $("#open_modal").attr("data-id",res.invoice_data_id);
                                        $("#open_modal").click();
                                        clearData()
                                        // showModalData(res.data)
                                        success_message(res.message)
                                    } else {
                                        error_message(res.error)
                                    }
                                },
                                error: function(error) {
                                    $(document).find('span.error_text').text('');
                                    $.each(error.responseJSON.errors, function(prefix, val) {
                                        $('span.' + prefix + '-error').text(val[0]);
                                    })
                                    error_message(error.responseJSON.message)
                                },
                                complete: function() {
                                    uiBlockStop()
                                }
                            });
                            event.stopImmediatePropagation();

                        } else {
                            $('#paid_status_err').text("Please Pay Some Amount")
                            error_message('Please Pay Some Amount')
                        }

                    } else {
                        $('#customer_info').html("<span class='text-danger'>Please Enter Customer</span>")
                        error_message('Please Enter Customer')
                    }
                }
            } else {
                $("#no_data").text('Please Select Minimum One Product');
                error_message('Please Select Minimum One Product')
            }

        });


        let clearData = async () => {
            $(document).find('span.error_text').text('');
            $('#addRow').html('')
            totalAmountPrice()
            $('#payment_status_show').html(`<strong class="text-success">None</strong>`);
            $('#customer_info').html('');
            $('#customer').val('');
            $('#search_product').val('');
            $('#customer_id').val('');
            sl_no = 0
        }

        // Search Customer
        $("#customer").autocomplete({
            source: function(request, response) {
                $(".customer-error").text('');
                $('#customer_info').html('')

                $.ajax({
                    async: true,
                    url: "{{ route('admin.customer_search') }}",
                    type: 'get',
                    dataType: "json",
                    data: {
                        product: request.term,
                    },
                    success: function(data) {
                        if (data.length == 0) {
                            $(".customer-error").text('Data Not Found')
                        }
                        var array = $.map(data, function(row) {
                            return {
                                value: row.customer_name,
                                label: row.customer_name + '--' +
                                    row.email + '(ph-' + row.phone +
                                    ')',
                                id: row.id,
                                customer_name: row.customer_name,
                                customer_email: row.email,
                                customer_phone: row.phone,
                                customer_address: row.address,
                            }
                        })
                        response($.ui.autocomplete.filter(array, request.term));
                    }
                })

            },
            select: function(event, ui) {
                let id = ui.item.id;
                let customer_name = ui.item.customer_name;
                let customer_email = ui.item.customer_email;
                let customer_phone = ui.item.customer_phone;
                let customer_address = ui.item.customer_address;
                let customer_info = `
                <p>
                    <span class='text-info'>Name :</span> <strong class=''>${customer_name}</strong>,
                    <span class='text-info'>Email :</span> <strong class=''>${customer_email}</strong> ,
                    <span class='text-info'>Phone :</span> <strong class=''>${customer_phone}</strong><br>
                    <span class='text-info'>Address :</span> <strong class=''>${customer_address}</strong>
                </p>
                `

                $('#customer_info').html(customer_info)
                $("#customer_id").val(id)
            },
            minLength: 1,
            delay: 500
        });
    </script>
@endpush
