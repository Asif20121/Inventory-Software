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
                        <h1 class="m-0">Edit Invoice</h1>
                    </div><!-- /.col -->
                    <div class="col-sm-6">
                        <ol class="breadcrumb float-sm-right">
                            <li class="breadcrumb-item"><a href="">Edit</a></li>
                            <li class="breadcrumb-item active">Invoice</li>
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
                                <h5>Invoice to</h5>
                                <div class="row">
                                    <div class="col-md-6 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6"><strong>Customer Name</strong></div>
                                            <div class="col-md-6 col-sm-6" id="customer_name">: ...</div>

                                            <div class="col-md-6 col-sm-6"><strong> phone</strong></div>
                                            <div class="col-md-6 col-sm-6" id="customer_phone">: ... </div>

                                            <div class="col-md-6 col-sm-6"><strong> Email</strong></div>
                                            <div class="col-md-6 col-sm-6" id="customer_email">: ...</div>

                                            <div class="col-md-6 col-sm-6"><strong> Address</strong></div>
                                            <div class="col-md-6 col-sm-6" id="customer_address">: ... </div>


                                            <div class="col-md-6 col-sm-6"><strong> Status</strong></div>
                                            <div class="col-md-6 col-sm-6" id="previous_payment_status_show"> : ...</div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-sm-12">
                                        <div class="row">
                                            <div class="col-md-6 col-sm-6"><strong>Invoice No. </strong></div>
                                            <div class="col-md-6 col-sm-6" id="invoice_no">: ...</div>

                                            <div class="col-md-6 col-sm-6"><strong>Date </strong></div>
                                            <div class="col-md-6 col-sm-6" id="invoice_date">: ...</div>



                                            <div class="col-md-6 col-sm-6"><strong> Added By</strong></div>
                                            <div class="col-md-6 col-sm-6" id="added_by"> :...</div>

                                            <div class="col-md-6 col-sm-6"><strong> Updated By</strong></div>
                                            <div class="col-md-6 col-sm-6" id="update_by"> : ...</div>

                                            <div class="col-md-6 col-sm-6"><strong> Updated Date</strong></div>
                                            <div class="col-md-6 col-sm-6" id="updated_adate"> : ...</div>

                                            <div class="col-md-6 col-sm-6"><strong> Store</strong></div>
                                            <div class="col-md-6 col-sm-6" id="store_name">: ...</div>

                                        </div>
                                    </div>

                                </div>
                            </div><!-- /.card-header -->


                            <form id="edit_invoice_form" action="{{ route('admin.edit_invoice_update', $invoice_id) }}"
                                method="post">
                                @csrf

                                <input type="hidden" id="store_id_show" name="store_id">
                                <div class="card-body ">
                                    <div class="row">
                                        <div class="col-12 text-left">
                                            <label for="">Product List</label></span>
                                        </div>
                                        <div class="col-md-12 col-sm-12 ">

                                            <table id="" class="table-sm table-bordered" width="100%">
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
                                                    </tr>
                                                </thead>

                                                <tbody id="product_tr">


                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-12 text-left mt-3">
                                            <label for="">Payment History</label></span>
                                        </div>


                                        <div class="col-md-12 col-sm-12 ">
                                            <table id="" class="table-sm table-bordered" width="100%">
                                                <thead class="bg-dark">
                                                    <tr>
                                                        <th class="text-center">Sl.No.</th>
                                                        <th class="text-center">Paid Amount</th>
                                                        <th class="text-center">Return Amount</th>
                                                        <th class="text-center">Actual Paid</th>
                                                        <th class="text-center">Payment Method</th>
                                                        <th class="text-center">Received By</th>
                                                        <th class="text-center">Cancel By</th>
                                                        <th class="text-center">Cancel</th>
                                                    </tr>
                                                </thead>

                                                <tbody id="payment_tr">

                                                </tbody>
                                            </table>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-2" id="">
                                            <div id="paid_status_err">

                                            </div>
                                            <hr>
                                        </div>

                                        <div class="col-md-4 col-sm-12 ">
                                            <div class="row">
                                                <div class="col-md-12 mt-2">
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <label for="">Special Discount</label>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <input class="form-control form-control-sm" name=""
                                                                type="number" id="special_discount"
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
                                                            <textarea id="description" name="description" class="form-control form-control-sm" cols="10" rows="1"></textarea>
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
                                                        <input class="form-control form-control-sm" type="text"
                                                            id="total_item" value="0" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Total Item Price</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control form-control-sm" type="text"
                                                            readonly id="total_item_price" value="0">
                                                    </div>
                                                </div>
                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Total Item Discount</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control form-control-sm" type="text"
                                                            id="total_item_discount" value="0" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Total Item Price With
                                                                Discount</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control form-control-sm" type="text"
                                                            id="total_item_price_with_discount" value="0" readonly>
                                                    </div>
                                                </div>

                                                <div class="row mt-2">
                                                    <div class="col-md-8">
                                                        <label for=""><strong>Special Discount</strong></label>
                                                    </div>
                                                    <div class="col-md-4">
                                                        <input class="form-control form-control-sm" type="text"
                                                            id="special_discount_show" name="special_discount"
                                                            value="0" readonly>
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
                                                        <input style="width: 60%" readonly type="number"
                                                            name="grand_total" id="grand_total"
                                                            class="form-control form-control-sm" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-2 ">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8"></div>
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Already Paid </strong>
                                                        <input style="width: 60%" readonly type="number"
                                                            name="paid_amount" class="form-control form-control-sm"
                                                            id="already_paid" value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-12 col-sm-12 mt-2 ">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8"></div>
                                                <div class="col-md-4">
                                                    <div class="d-flex justify-content-between">
                                                        <strong>Due Amount</strong>
                                                        <input style="width: 60%" readonly type="number" id="prev_due"
                                                            name="due_amount" class="form-control form-control-sm"
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
                                                        <strong>Return Amount</strong>
                                                        <input id="current_return_amount" name="current_return_amount"
                                                            style="width: 60%" readonly type="number"
                                                            class="form-control form-control-sm " value="0">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-md-12 col-sm-12 mt-2 ">
                                            <div class="row d-flex justify-content-between">
                                                <div class="col-md-8">
                                                    <button type="submit" class="btn btn-info">Update</button>
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

                                        <div id="demo_name"></div>

                                    </div><!-- /.card-body -->
                                </div>
                            </form>

                            <span class="btn btn-primary open_modal d-none" id="open_modal"
                                data-action="{{ route('admin.sales_pos_show') }}" data-modal="common_modal_xl"
                                data-title="Invoice Details">Open Modal</span>
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
        $(document).ready(function() {
            show_edit_data();
        });



        let show_edit_data = async () => {
            let invoice_id = "{{ $invoice_id }}"
            let edit_invoice_show = "{{ route('admin.edit_invoice_show', ':id') }}";
            edit_invoice_show = edit_invoice_show.replace(':id', invoice_id);
            await $.ajax({
                async: true,
                type: "get",
                dataType: "json",
                url: edit_invoice_show,
                beforeSend: function() {
                    uiBlock()
                },
                success: function(res) {


                    $("#demo_name").html(demo_name)


                    let inv_data = res.invoice;
                    $("#store_id_show").val(inv_data.store_id);
                    $("#invoice_no").text(':' + (inv_data.invoice_no ? inv_data.invoice_no : ''));
                    var d = new Date(inv_data.date);
                    $("#invoice_date").text(':' + (inv_data.date ?
                        `${d.getDate()+' '+(d.toLocaleString('default', { month: 'long' }))+' '+d.getFullYear()}` :
                        ''));
                    $("#customer_name").text(':' + (inv_data.customer_name ? inv_data.customer_name :
                        ''));
                    $("#customer_email").text(':' + (inv_data.customer_email ? inv_data.customer_email :
                        ''));
                    $("#customer_phone").text(':' + (inv_data.customer_phone ? inv_data.customer_phone :
                        ''));
                    $("#customer_address").text(':' + (inv_data.customer_address ? inv_data
                        .customer_address : ''));
                    $("#store_name").text(':' + (inv_data.store_name ? inv_data.store_name : ''));
                    $("#added_by").text(': (' + (inv_data.added_card_no ? inv_data.added_card_no : '') +
                        ')' + (inv_data.added_by ? inv_data.added_by : ''));
                    $("#update_by").text(': (' + (inv_data.update_card_no ? inv_data.update_card_no :
                        '') + ')' + (inv_data.update_by ? inv_data.update_by : ''));
                    let payment_status = inv_data.paid_status;
                    if (payment_status == 1) {
                        $('#payment_status_show').html(`<strong class="text-success">Paid</strong>`);
                        $('#previous_payment_status_show').html(
                            `<span class="bg-success rounded px-1">Paid</span>`);
                    } else if (payment_status == 0) {
                        $('#payment_status_show').html(`<strong class="text-warning">Due</strong>`);
                        $('#previous_payment_status_show').html(
                            `<span class="bg-warning rounded px-1">Due</span>`);

                    }

                    var udate = new Date(inv_data.updated_adate);
                    $("#updated_adate").text(':' + (inv_data.updated_adate ?
                        `${udate.getDate()+' '+(udate.toLocaleString('default', { month: 'long' }))+' '+udate.getFullYear()}` :
                        ''));

                    let data_invoice = [];
                    let totalItem = 0;
                    let total_item_price = 0;
                    let total_item_discount = 0;

                    inv_data.invoice_details.map((invd, key) => {

                        totalItem += (invd.remainingqty ? invd.remainingqty : '0');

                        total_item_price += (invd.item_price_wod ? invd.item_price_wod : '0');

                        total_item_discount += (parseFloat(invd.unit_discount ? invd
                                .unit_discount : '0') * parseFloat(invd.remainingqty ? invd
                                .remainingqty : '0') * parseFloat(invd.unit_price ? invd
                                .unit_price : '0')) /
                            100;
                        data_invoice += `
                            <tr>
                                <td class="text-center">${key+1}
                                    <input type="hidden" name="product_id[]" value="${ invd.product_id}">
                                    <input type="hidden" name="product_name[]" value="${ invd.product_name}">
                                    <input type="hidden" name="unit_price[]" value="${ invd.unit_price}">
                                    <input type="hidden" name="unit_discount[]" value="${ invd.unit_discount}">
                                    <input type="hidden" name="unit_price_wd[]" value="${ invd.unit_price_wd}">

                                    </td>
                                <td class="text-center"> ${invd.product_name ? invd.product_name : ''}  </td>
                                <td class="text-center"> <input type="number" name="item_qty[]" class="item_qty form-control form-control-sm "  value="${invd.remainingqty ? invd.remainingqty : '0'}" oninput="validity.valid||(value='0');" min="0"></td>
                                <td class="text-center unit_price"> ${invd.unit_price ? invd.unit_price : '0'} </td>
                                <td class="text-center unit_discount">${invd.unit_discount ? invd.unit_discount : '0'} <input type="hidden" class="item_discount" value="${invd.unit_discount ? invd.unit_discount : '0'}"></td>
                                <td class="text-center unit_price_wd">${invd.unit_price_wd ? invd.unit_price_wd : '0'}</td>
                                <td class="text-center item_price_wod">${invd.item_price_wod ? invd.item_price_wod : '0'}  <input type="hidden" class="item_price" value="${invd.item_price_wod ? invd.item_price_wod : '0'}"></td>
                                <td class="text-center item_price_wd">${invd.item_price_wd ? parseFloat(invd.item_price_wd).toFixed(2) : '0'} <input type="hidden" class="item_price_wd" value="${invd.item_price_wd ? invd.item_price_wd : '0'}"> </td>

                            </tr>
                        `;
                    })

                    $("#total_item").val(totalItem)
                    $("#total_item_price").val(total_item_price)
                    $("#total_item_discount").val(total_item_discount.toFixed(2))
                    $("#total_item_price_with_discount").val((total_item_price - total_item_discount)
                        .toFixed(2))
                    $("#special_discount").val(inv_data.discount_amount ? inv_data.discount_amount : 0)
                    $("#special_discount_show").val(inv_data.discount_amount ? inv_data
                        .discount_amount : 0)
                    $("#description").val(inv_data.description ? inv_data.description : '')
                    let grand_total = total_item_price - total_item_discount - (inv_data
                        .discount_amount ? inv_data.discount_amount : 0)
                    $("#grand_total").val(Math.floor(grand_total))
                    $("#already_paid").val(inv_data.paid_amount ? inv_data.paid_amount : 0)
                    $("#prev_due").val(Math.floor(grand_total - (inv_data.paid_amount ? inv_data
                        .paid_amount : 0)))
                    $("#current_return_amount").val(0)


                    $("#product_tr").html(data_invoice)

                    let data_payment = [];
                    $.each(inv_data.payment_details, function(key, pay) {
                        var pdate = new Date(pay.date);
                        var cpdate = new Date(pay.cancel_date);
                        if (pay.status == 1 && pay.actual_paid >= 0) {
                            data_payment += `
                            <tr>
                                <td class="text-center">${key+1} <input type="hidden" name='payment_id[]' value="${pay.payment_details_id}"></td>
                                <td class="text-center">${pay.current_paid_amount ? pay.current_paid_amount : '0'}  <input type='hidden' class="single_paid_amount_flist" value="${pay.current_paid_amount ? pay.current_paid_amount : '0'}" /></td>
                                <td class="text-center">${pay.refound ? pay.refound : '0'}  <input type='hidden' class="single_refound_amount_flist" value="${pay.refound ? pay.refound : '0'}" /></td>
                                <td class="text-center">${pay.actual_paid ? pay.actual_paid : '0'} <input type='hidden' class="single_actual_paid_flist" value="${pay.actual_paid ? pay.actual_paid : '0'}" /></td>
                                <td class="text-center">${pay.payment_method ? pay.payment_method : ''} </td>
                                <td class="text-center">${pay.date ? (pdate.getDate()+' '+(pdate.toLocaleString('default', { month: 'long' }))+' '+pdate.getFullYear()) : ''}  <br> ${pay.receive_by_name ? pay.receive_by_name : ''}</td>
                                <td class="text-center">${pay.cancel_date ? (cpdate.getDate()+' '+(cpdate.toLocaleString('default', { month: 'long' }))+' '+cpdate.getFullYear()) : ''} <br> ${pay.cancel_by_name ? pay.cancel_by_name : ''} </td>
                                <td class="text-center">  <input  type="checkbox" value="1" class="form-control form-control-sm cancel_payment" style="accent-color: red;"> <input value='1' name='cancel_payment[]' type="hidden" >
                                     </td>
                            </tr>
                        `;
                        } else if (pay.status == 2) {
                            data_payment += `
                            <tr class="bg-danger ">
                                <td class="text-center ">${key+1}</td>
                                <td class="text-center ">${pay.current_paid_amount ? pay.current_paid_amount : '0'}  </td>
                                <td class="text-center ">${pay.refound ? pay.refound : '0'}  </td>
                                <td class="text-center ">${pay.actual_paid ? pay.actual_paid : '0'}  </td>
                                <td class="text-center ">${pay.payment_method ? pay.payment_method : ''} </td>
                                <td class="text-center ">${pay.date ? (pdate.getDate()+' '+(pdate.toLocaleString('default', { month: 'long' }))+' '+pdate.getFullYear()) : ''}  <br> ${pay.receive_by_name ? pay.receive_by_name : ''}</td>
                                <td class="text-center ">${pay.cancel_date ? (cpdate.getDate()+' '+(cpdate.toLocaleString('default', { month: 'long' }))+' '+cpdate.getFullYear()) : ''} <br> ${pay.cancel_by_name ? pay.cancel_by_name : ''} </td>
                                <td class="text-center "></td>
                            </tr>
                        `;
                        } else if (pay.status == 1 && pay.actual_paid < 0) {
                            data_payment += `
                            <tr class="bg-light">
                                <td class="text-center">${key+1} <input type="hidden" name='payment_id[]' value="${pay.payment_details_id}"></td>
                                <td class="text-center">${pay.current_paid_amount ? pay.current_paid_amount : '0'}  <input type='hidden' class="single_paid_amount_flist" value="${pay.current_paid_amount ? pay.current_paid_amount : '0'}" /></td>
                                <td class="text-center">${pay.refound ? pay.refound : '0'}  <input type='hidden' class="single_refound_amount_flist" value="${pay.refound ? pay.refound : '0'}" /></td>
                                <td class="text-center">${pay.actual_paid ? pay.actual_paid : '0'} <input type='hidden' class="single_actual_paid_flist" value="${pay.actual_paid ? pay.actual_paid : '0'}" /></td>
                                <td class="text-center">${pay.payment_method ? pay.payment_method : ''} </td>
                                <td class="text-center">${pay.date ? (pdate.getDate()+' '+(pdate.toLocaleString('default', { month: 'long' }))+' '+pdate.getFullYear()) : ''}  <br> ${pay.receive_by_name ? pay.receive_by_name : ''}</td>
                                <td class="text-center">${pay.cancel_date ? (cpdate.getDate()+' '+(cpdate.toLocaleString('default', { month: 'long' }))+' '+cpdate.getFullYear()) : ''} <br> ${pay.cancel_by_name ? pay.cancel_by_name : ''} </td>
                                <td class="text-center">  <input value='1' name='cancel_payment[]' type="hidden" ></td>
                            </tr>
                        `;
                        }

                    })

                    $("#payment_tr").html(data_payment)

                    uiBlockStop()
                },
                error: function(error) {
                    error_message(error.responseJSON.message)
                    uiBlockStop()
                },
                complete: function() {

                }

            });
        }



        $(document).on('keyup click', ".item_qty", function() {
            let item_qty = $(this).closest("tr").find('.item_qty').val() ? $(this).closest("tr").find('.item_qty')
                .val() : 0;
            let unit_price = $(this).closest("tr").find('.unit_price').text() ? $(this).closest("tr").find(
                '.unit_price').text() : 0;
            let unit_discount = $(this).closest("tr").find('.unit_discount').text() ? $(this).closest("tr").find(
                '.unit_discount').text() : 0;
            let unit_price_wd = $(this).closest("tr").find('.unit_price_wd').text() ? $(this).closest("tr").find(
                '.unit_price_wd').text() : 0;

            $(this).closest("tr").find('.item_price_wod').text(item_qty * unit_price)
            let item_price_wd = (item_qty * unit_price) - (unit_discount * (item_qty * unit_price) / 100);
            $(this).closest("tr").find('.item_price_wd').text(item_price_wd)

            change_data()

        })

        $(document).on('keyup click', '#special_discount', function() {

            change_data()
        })


        $(document).on('change', ".cancel_payment", function() {

            change_data()

            if ($(this).prop('checked')) {
                $(this).closest("tr").find("input[name='cancel_payment[]']").val(0)
            } else {
                $(this).closest("tr").find("input[name='cancel_payment[]']").val(1)
            }
        });


        let change_data = () => {

            let total_item_qty = 0;
            let item_price = 0
            let total_item_price_wod = 0
            let total_item_discount = 0
            let total_item_price_wd = 0

            $($("#product_tr tr")).each(function(index, tr) {
                let per_item = $(this).find('.item_qty').val() ? $(this).find('.item_qty').val() : 0;
                total_item_qty += parseInt(per_item)

                let per_item_price = $(this).find('.unit_price').text() ? $(this).find('.unit_price').text() :
                    0;
                item_price += parseFloat(per_item_price)

                let per_item_discount = $(this).find('.unit_discount').text() ? $(this).find('.unit_discount')
                    .text() : 0;
                total_item_discount += (per_item_discount * per_item * per_item_price) / 100

                total_item_price_wod += (per_item * per_item_price);
                total_item_price_wd += ((per_item * per_item_price) - ((per_item_discount * per_item *
                    per_item_price) / 100));
            })


            $("#total_item").val(total_item_qty)
            $("#total_item_price").val(total_item_price_wod.toFixed(2))
            $("#total_item_discount").val(parseFloat(total_item_discount).toFixed(2))
            $("#total_item_price_with_discount").val(parseFloat(total_item_price_wd).toFixed(2))

            let special_discount = $("#special_discount").val();
            $("#special_discount_show").val(special_discount ? special_discount : 0)

            let grand_total = total_item_price_wd - (special_discount ? special_discount : 0);
            $("#grand_total").val(Math.floor(grand_total))

            let single_paid_amount = 0;
            $($("#payment_tr tr")).each(function(index, tr) {
                if (!($(this).find('.cancel_payment').is(':checked'))) {
                    let single_paid_amount_flist = $(this).find('.single_actual_paid_flist').val() ? $(this)
                        .find('.single_actual_paid_flist').val() : 0;
                    single_paid_amount += parseInt(single_paid_amount_flist)
                }
            })


            let due_amount = Math.floor(grand_total - single_paid_amount);

            if (Math.floor(grand_total) > single_paid_amount && single_paid_amount == 0) {
                $("#already_paid").val(0)
                $("#prev_due").val(due_amount)
                $("#current_return_amount").val(0)
                $('#payment_status_show').html('<strong class="text-warning">Due</strong>');
            } else if (Math.floor(grand_total) > single_paid_amount && single_paid_amount > 0) {
                $("#already_paid").val(single_paid_amount)
                $("#prev_due").val(due_amount)
                $("#current_return_amount").val(0)
                $('#payment_status_show').html('<strong class="text-warning">Due</strong>');
            } else if (Math.floor(grand_total) == single_paid_amount && single_paid_amount > 0) {
                $("#already_paid").val(Math.floor(grand_total))
                $("#prev_due").val(0)
                $("#current_return_amount").val(0)
                $('#payment_status_show').html('<strong class="text-success">Paid</strong>');
            } else if (Math.floor(grand_total) < single_paid_amount && single_paid_amount > 0) {
                $("#already_paid").val(Math.floor(grand_total))
                $("#prev_due").val(0)
                $("#current_return_amount").val(Math.abs(due_amount))
                $('#payment_status_show').html('<strong class="text-success">Paid</strong>');
            }

            if (Math.floor(total_item_price_wd) <= Math.floor(special_discount)) {
                let msg = "Grand Total   must be greater than specialdiscount"
                let error = `<div class="alert alert-warning alert-dismissible fade show" role="alert"> <strong> ${msg} </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                 </div>`
                error_message(msg)

                $('#paid_status_err').html(error)

            } else {

                if (single_paid_amount < 0) {
                    let msg = "Paid Amount Can not be negative"
                    let error = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                 <strong> ${msg} </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                 </div>`
                    error_message(msg)

                    $('#paid_status_err').html(error)
                } else {
                    $('#paid_status_err').html('')
                }
            }





        }







        $(document).ready(function() {
            $("#edit_invoice_form").submit(function() {
                event.preventDefault()
                let grand_total = $("#grand_total").val();
                let already_paid = $("#already_paid").val();

                let single_paid_amount = 0;
                $($("#payment_tr tr")).each(function(index, tr) {
                    if (!($(this).find('.cancel_payment').is(':checked'))) {
                        let single_paid_amount_flist = $(this).find('.single_actual_paid_flist')
                            .val() ? $(this)
                            .find('.single_actual_paid_flist').val() : 0;
                        single_paid_amount += parseInt(single_paid_amount_flist)
                    }
                })


                if (single_paid_amount < 0) {
                    let msg = "Paid Amount Can not be negative"
                    let error = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
                 <strong> ${msg} </strong>
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
                 </div>`
                    error_message(msg)

                    $('#paid_status_err').html(error)
                } else {
                    if (grand_total > 0) {

                        let formData = new FormData($(this)[0]);
                        let action = $(this).attr("action");
                        let method = $(this).attr("method");

                        if (already_paid >= 0) {


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
                                    console.log(res.invoice_id);
                                    $("#open_modal").attr("data-id", res.invoice_id);
                                    $("#open_modal").click();
                                    show_edit_data();
                                    success_message(res.message)
                                    $('#paid_status_err').html('')

                                },
                                error: function(error) {
                                    error_message(error.responseJSON.message)
                                },
                                complete: function() {
                                    uiBlockStop()
                                }
                            });
                            event.stopImmediatePropagation();

                        } else {
                            let msg = "Paid Amount Can not be negative"
                            let error = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
<strong> ${msg} </strong>
<button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
</div>`
                            error_message(msg)

                            $('#paid_status_err').html(error)
                        }

                    } else {

                        let error = `<div class="alert alert-warning alert-dismissible fade show" role="alert">
     <strong>Grand Total amount  must be greater than specialdiscount </strong>
     <button type="button" class="close" data-dismiss="alert" aria-label="Close"> <span aria-hidden="true">&times;</span> </button>
  </div>`

                        $('#paid_status_err').html(error)
                        error_message("Grand Total amount  must be greater than specialdiscount")

                    }
                }




            });
        });
    </script>
@endpush
