@php
  $customer_name=  isset($payment_details['invoicef']['paymentf']['customerf']['customer_name']) && $payment_details['invoicef']['paymentf']['customerf']['customer_name'] !='' ?$payment_details['invoicef']['paymentf']['customerf']['customer_name'] : '';
  $phone=  isset($payment_details['invoicef']['paymentf']['customerf']['phone']) && $payment_details['invoicef']['paymentf']['customerf']['phone'] !='' ?$payment_details['invoicef']['paymentf']['customerf']['phone'] : '';
  $email=  isset($payment_details['invoicef']['paymentf']['customerf']['email']) && $payment_details['invoicef']['paymentf']['customerf']['email'] !='' ?$payment_details['invoicef']['paymentf']['customerf']['email'] : '';
  $address=  isset($payment_details['invoicef']['paymentf']['customerf']['address']) && $payment_details['invoicef']['paymentf']['customerf']['address'] !='' ?$payment_details['invoicef']['paymentf']['customerf']['address'] : '';
  $invoice_details = isset($payment_details['invoicef']['invoice_detailsf']) && $payment_details['invoicef']['invoice_detailsf'] !=[] ?$payment_details['invoicef']['invoice_detailsf'] :[];
@endphp

<div class="container">
    <h5>Customer Info</h4>
        <div class="row d-flex justify-content-between">
            <div class="col-md-6 col-sm-12">Name <strong>: <span id=""> {{$customer_name}}</span></strong></div>
            <div class="col-md-6 col-sm-12">phone <strong>: <span id="">{{$phone}}</span></strong> </div>
            <div class="col-md-6 col-sm-12">Email <strong>: <span id="">{{$email}}</span></strong></div>
            <div class="col-md-6 col-sm-12">Address <strong>: <span id="">{{$address}}</span></strong></div>
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
                    <tbody >
                        @if ($invoice_details)
                        @foreach ($invoice_details as $key=>$inv_de)
                        <tr>
                            <td class="text-center">{{$key+1}}</td>
                            <td>{{$inv_de->product_name}}</td>
                            <td class="text-center">{{$inv_de->qty}}</td>
                            <td class="text-center">{{$inv_de->unit_price}}</td>
                            <td class="text-center">{{$inv_de->unit_discount}}</td>
                            <td class="text-center">{{$inv_de->unit_price_wd}}</td>
                            <td class="text-center">{{$inv_de->selling_price_wod}}</td>
                            <td class="text-center">{{$inv_de->selling_price_wd}}</td>
                        </tr>

                        @endforeach
                        @endif
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
                            <th><input readonly id="total_item_price_with_discount_modal" type="text"
                                    class="form-control form-control-sm bg-light" placeholder="0"></th>
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
