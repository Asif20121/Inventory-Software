<form id="sales_new_customer_form" action="{{ route('admin.new_customer_store') }}" method="POST">
    @csrf
    <div class="row">
        <div class="col-md-6 mt-2">
            <label for="">Customer Name</label>
            <input name="customer_name" type="text" class="form-control" placeholder="Customer Name">
            <span class="text-danger error_text customer_name-error"></span>
        </div>
        <div class="col-md-6 mt-2">
            <label for="">Email</label>
            <input name="email" type="text" class="form-control" placeholder="Enter Email">
            <span class="text-danger error_text email-error"></span>
        </div>
        <div class="col-md-6 mt-2">
            <label for="">Phone</label>
            <input name="phone" type="number" class="form-control" placeholder="Enter Phone Number">
            <span class="text-danger error_text phone-error"></span>
        </div>
        <div class="col-md-6 mt-2">
            <label for="">Address</label>
            <input name="address" type="text" class="form-control" placeholder="Address">
            <span class="text-danger error_text address-error"></span>
        </div>

        <div class="col-md-12 mt-5 text-right">
            <input class="btn btn-sm btn-info" type="submit" value="Save">
        </div>
    </div>
</form>

<script>
    $(document).ready(function() {
        $("#sales_new_customer_form").submit(function(event) {
            event.preventDefault();
            let formData = new FormData($(this)[0]);
            let action = $(this).attr("action");
            let method = $(this).attr("method");

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
                    if (res.status != 404) {
                        $(document).find('span.error_text').text('');
                        $('.modal').modal('hide');



                        let customer_info = `
                                            <p>
                                                <span class='text-info'>Name :</span> <strong class=''>${res.customer.customer_name}</strong>,
                                                <span class='text-info'>Email :</span> <strong class=''>${res.customer.email}</strong> ,
                                                <span class='text-info'>Phone :</span> <strong class=''>${res.customer.phone}</strong><br>
                                                <span class='text-info'>Address :</span> <strong class=''>${res.customer.address}</strong>
                                            </p>
                                            `

                        $('#customer_info').html(customer_info)
                        $("#customer_id").val(res.customer.id)

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

        });
    });
</script>
