@extends('dashboard.admin.layouts.master')
@push('admin_css')
    <link rel="stylesheet" href="{{ asset('admin/bdatepicker/datepicker.min.css') }}">
@endpush
@section('admin_body')
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">Add New Purchase </h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Purchase</a></li>
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

                    <form id="add_product_form" action="{{ route('admin.purchase_manage_store') }}" method="POST">
                        @csrf
                        <section class="col-lg-12 connectedSortable">
                            <!-- Custom tabs (Charts with tabs)-->
                            <div class="card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-md-2 col-sm-6 text-left">
                                            <label for="">Date</label><span class="text-danger">*</span>
                                            <div  class="input-container">
                                                <input type="text" class="form-control" placeholder="dd-mm-yy"
                                                    value="{{ date('d-m-Y') }}" id="date" name="date">
                                                    <i class="far fa-calendar-alt custom_icon"></i>

                                            </div>
                                        </div>

                                        <div class="col-md-2 col-sm-6 text-left">
                                            <label for="">Voucher</label><span class="text-danger">*</span>
                                            <input type="text" class="form-control" placeholder="Voucher Number"
                                                id="voucher" name="voucher">
                                            <span class="text-danger error_text voucher-error"></span>
                                        </div>


                                        <div class="col-md-4 col-sm-6 text-left">
                                            <label for="">Store</label> <span class="text-danger">*</span>
                                            <select class="custom-select search_box" id="store" name="store">
                                                <option value="">Select a Store</option>

                                                @foreach ($store as $key => $s)
                                                    <option value="{{ $s->id }}">{{ $key + 1 }}.
                                                        {{ $s->store_name }}</option>
                                                @endforeach

                                            </select>

                                            <span class="text-danger error_text store-error"></span>
                                        </div>

                                        <div class="col-md-4 col-sm-6 text-left">
                                            <label for="">Supplier</label><span class="text-danger">*</span>
                                            <select class="custom-select search_box" name="supplier" id="supplier">
                                                <option value="">Select a Supplier</option>

                                            </select>

                                            <span class="text-danger error_text supplier-error"></span>
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
                                                        <th class="text-center">Buying Qty</th>
                                                        <th class="text-center">Unit Price</th>
                                                        <th class="text-center">Discount</th>
                                                        <th class="text-center">UPWD</th>
                                                        <th class="text-center">Total Price</th>
                                                        <th class="text-center">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="addRow" class="addRow"></tbody>
                                                <tbody>
                                                    <tr>
                                                        <td colspan="5"></td>
                                                        <td><strong>Total Item</strong></td>
                                                        <td><input class="form-control" type="text" id="total_item"
                                                                name="total_item" value="0" readonly></td>
                                                        <td></td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="5"></td>
                                                        <td><strong>Net Total Amount</strong></td>
                                                        <td><input class="form-control" type="text" id="estimated_amount"
                                                                name="product_cost" value="0" readonly></td>
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
                                                        name="tax" value="0">
                                                </div>

                                                <div class="col-md-2 col-sm-6 mt-2">
                                                    <label for="">Vat</label>
                                                    <input class="form-control" type="number" id="vat"
                                                        oninput="validity.valid||(value='');" min="0"
                                                        name="vat" value="0">
                                                </div>

                                                <div class="col-md-2 col-sm-6 mt-2">
                                                    <label for="">Shipping Cost</label>
                                                    <input class="form-control" type="number" id="shipping_cost"
                                                        oninput="validity.valid||(value='');" min="0"
                                                        name="shipping_cost" value="0">
                                                </div>
                                                <div class="col-md-2 col-sm-6 mt-2">
                                                    <label for="">Other Cost</label>
                                                    <input class="form-control" type="number" id="other_cost"
                                                        oninput="validity.valid||(value='');" min="0"
                                                        name="other_cost" value="0">
                                                </div>
                                                <div class="col-md-2 col-sm-6 mt-2">
                                                    <label for="">Discount</label>
                                                    <input class="form-control" type="number" id="final_discount"
                                                        oninput="validity.valid||(value='');" min="0"
                                                        name="final_discount" value="0">
                                                </div>

                                                <div class="col-md-2 col-sm-6 mt-2">
                                                    <label for="">Description</label>
                                                    <textarea id="description" name="description" class="form-control" id="" cols="10" rows="1"></textarea>
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


                                        <div class="col-md-12 col-sm-12 mt-3">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8"> <button type="submit" class="btn btn-info">Add
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
    <script src="{{ asset('admin/bdatepicker/bootstrap-datepicker.min.js') }}"></script>
    <script>
        $("#date", ).datepicker({
            uiLibrary: 'bootstrap4',
            format: 'dd-mm-yyyy',
            autoclose: true
        });
    </script>

    <script id="document_template" type="text/x-handlebars-template">
    <tr class="delete_add_more_item" id="delete_add_more_item">
       <td>@{{ sl_no }}</td>
       <td>
        <input type="hidden" class="product_id" name="product_id[]" value="@{{id}}">
        <input type="hidden" class="name"  value="@{{name}}"> @{{ name }}</td>
       <td><input type="number" style="display: inherit;width: 80%;" class="form-control buying_qty" value="1" name="buying_qty[]"  oninput="validity.valid||(value='');" min="1"> <strong class="mt-2" style="float: right;">@{{unit_name}}</strong></td>
       <td><input type="number" class="form-control unit_price" value="0" name="unit_price[]"  oninput="validity.valid||(value='');" min="0"></td>
       <td><input type="number" class="form-control discount" value="0" name="discount[]"  oninput="validity.valid||(value='');" min="0"></td>
       <td><input readonly type="number" class="form-control upwd" value="0" name="upwd[]"  oninput="validity.valid||(value='');" min="0"></td>
       <td><input type="number" class="form-control total_buying_unit_price" value="0" readonly name="total_buying_unit_price[]"  oninput="validity.valid||(value='');" min="0"></td>
       <td><i class="btn btn-danger btn-sm fas fa-window-close removeeventmore"></i></td>
      </tr>
  </script>


    <script>
        // Add To Product List
        let sl_no = 0;
        let addProduct = (id = '', name = '', unit_name = '') => {
            let tr_data = $("#addRow")

            let count_data = 0;
            $('#addRow tr').each(function() {
                var foreach_id = $(this).find('input.product_id').val();
                if (id == foreach_id) {
                    count_data++

                }
            });

            if (count_data == 0) {
                sl_no++
                var source = $("#document_template").html();
                var tamplate = Handlebars.compile(source);
                var data = {
                    id: id,
                    name: name,
                    unit_name: unit_name,
                    sl_no: sl_no,
                };
                var html = tamplate(data);
                $("#addRow").append(html);



                // Item Count
                var item = 0;
                $(".buying_qty").each(function() {
                    var value = $(this).val();
                    if (!isNaN(value) && value.length != 0) {
                        item += parseFloat(value);
                    }
                });
                $('#total_item').val(item);
            } else {
                $("#no_data").text('Product Already Exist');
                error_message('Product Already Exist')
            }


        }
        // Remove Product
        $(document).on("click", ".removeeventmore", function(event) {
            $(this).closest(".delete_add_more_item").remove();
            totalAmountPrice()
        });

        $(document).on('keyup click', '.unit_price,.buying_qty,.discount', function() {
            $("#no_data").text('');

            var unit_price = $(this).closest("tr").find("input.unit_price").val();
            var qty = $(this).closest("tr").find("input.buying_qty").val();
            var discount = $(this).closest("tr").find("input.discount").val();
            var profit = $(this).closest("tr").find("input.profit").val();
            var total = (unit_price * qty - discount);

            if (unit_price * qty != "NaN") {
                if ((unit_price * qty) >= discount) {


                    var upwd = ((unit_price * qty - discount) / qty);

                    $(this).closest("tr").find("input.total_buying_unit_price").val(total);
                    $(this).closest("tr").find("input.upwd").val( parseFloat(upwd).toFixed(2));
                    totalAmountPrice();

                } else {
                    $("#no_data").text('Discount Anount Must Be Less than Total Price');
                    error_message('Discount Anount Must Be Less than Total Price')

                }

            }

        });

        $(document).on('keyup click', '#tax,#vat,#shipping_cost,#other_cost,#final_discount', function() {
            totalAmountPrice()

        })


        function totalAmountPrice() {

            var purchase_price = 0;
            $(".total_buying_unit_price").each(function() {
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
            $('#total_item').val(item);
            $('#estimated_amount').val(purchase_price);



            let vat = $('#vat').val() ? $('#vat').val() : 0;
            let tax = $('#tax').val() ? $('#tax').val() : 0;
            let shipping_cost = $('#shipping_cost').val() ? $('#shipping_cost').val() : 0;
            let other_cost = $('#other_cost').val() ? $('#other_cost').val() : 0;
            let final_discount = $('#final_discount').val() ? $('#final_discount').val() : 0;

            let grand_total = (parseFloat(purchase_price) + parseFloat(vat) + parseFloat(tax) + parseFloat( shipping_cost) + parseFloat(other_cost) - parseFloat(final_discount));

            $('#grand_total').val(grand_total);




        }



        // Find Supplier
        $(document).on('change', "#store", function() {
            $("#addRow").html('')
            $('#vat').val('0')
            $('#tax').val('0')
            $('#shipping_cost').val('0')
            $('#other_cost').val('0')
            $('#final_discount').val('0')

            totalAmountPrice()
            $('#grand_total').val('0');


            var store = $(this).val();
            $.ajax({
                async: true,
                url: "{{ route('admin.store_wise_supplier') }}",
                type: "GET",
                data: {
                    store: store
                },
                beforeSend: function() {
                    $("#supplier").html('<option value="">Loading....</option>');
                },
                success: function(data) {
                    var html = '<option value="">Select Supplier</option>';
                    $.each(data, function(key, v) {
                        html += '<option value=" ' + v.supplier_id + ' "> ' + v.supplier_name +
                            '</option>';
                    });
                    $("#supplier").html(html);

                }
            });
            event.stopImmediatePropagation();

        });

        // Search Product
        $(document).on('change', "#store", function() {
            let store = $(this).val();

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
                                        label: '(' + row.product_code + ')' + '--' +
                                            row.product_name + '(QTY-' + row.qty +
                                            ')',
                                        product_id: row.product_id,
                                        product_name: row.product_name,
                                        unit_name: row.unit_name,
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
                    addProduct(id, product_name, unit_name)
                },
                minLength: 1,
                delay: 500
            });

        });





        $("#add_product_form").submit(function(event) {
            event.preventDefault();
            let formData = new FormData($(this)[0]);
            let action = $(this).attr("action");
            let method = $(this).attr("method");
            $("#no_data").text('');

            var product_id = $(this).find('input.product_id').val()


            let count_data = 0;
            $('#addRow tr').each(function() {

                var buying_qty = $(this).find('input.buying_qty').val();
                var unit_price = $(this).find('input.unit_price').val();

                if (buying_qty < 1 || unit_price < 1) {
                    count_data++
                    $("#no_data").text('Buying Quantity and Unit Price can not be zero or null');
                }
            });

            if (count_data == 0) {

                if (product_id != undefined) {
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
                                success_message(res.message)
                                $(document).find('span.error_text').text('');

                                $("#addRow").html('')
                                $('#vat').val('0')
                                $('#tax').val('0')
                                $('#shipping_cost').val('0')
                                $('#other_cost').val('0')
                                $('#final_discount').val('0')
                                $('#grand_total').val('0');
                                $('#total_item').val('0');
                                $('#estimated_amount').val('0');
                                $('#description').val('');
                                $('#voucher').val('');
                                $('#search_product').val('');
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
                    $("#no_data").text('Please Select Minimum One Item');
                }


            }
        });
    </script>
@endpush
