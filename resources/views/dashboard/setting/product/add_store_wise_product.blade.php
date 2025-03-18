@php
    $data = isset($product_details) && $product_details != null ? $product_details : [];
    $store_id = isset($data->store_id) && $data->store_id != '' ? $data->store_id : '';
    $current_buying_price = isset($data->current_buying_price) && $data->current_buying_price != '' ? $data->current_buying_price : '';
    $current_sales_price = isset($data->current_sales_price) && $data->current_sales_price != '' ? $data->current_sales_price : '';
    $discount = isset($data->discount) && $data->discount != '' ? $data->discount : '';
    $status = isset($data->status) && $data->status != '' ? $data->status : '';
    $id = isset($data->id) && $data->id != '' ? $data->id : '';
@endphp

<form id="product_wise_store_form"
    action="{{ $id ? route('invoice_setting.open_product_wise_store_update', $id) : route('invoice_setting.open_product_wise_store_save') }}"
    method="POST">
    @csrf
    <input type="hidden" name="product_id" value="{{ $product_id }}">
    <div class="row">
        <div class="col-md-4 mt-2">
            <label for="">Store</label>
            <select name="store" class="form-control search_box" {{ $id ? 'disabled' : '' }}>
                <option value="">Please Select Store</option>
                @foreach ($store as $key => $st)
                    <option value="{{ $st->id }}" {{ $st->id == $store_id ? 'selected' : '' }} sele>
                        {{ $key + 1 }}. {{ $st->store_name }} </option>
                @endforeach
            </select>
            <span class="text-danger error_text store-error"></span>
        </div>

        <div class="col-md-4 mt-2">
            <label for="">Buying Price</label>
            <input name="buying_price" type="number" class="form-control"
                value="{{ $current_buying_price != '' ? $current_buying_price : '0' }}"
                oninput="validity.valid||(value='');" min="0">
        </div>
        <div class="col-md-4 mt-2">
            <label for="">Sales Price</label>
            <input name="sales_price" type="number" class="form-control"
                value="{{ $current_sales_price != '' ? $current_sales_price : '0' }}"
                oninput="validity.valid||(value='');" min="0">
        </div>
        <div class="col-md-4 mt-2">
            <label for="">Default Discount (%)</label>
            <input name="discount" type="number" class="form-control" value="{{ $discount != '' ? $discount : '0' }}"
                oninput="validity.valid||(value='');" min="0">
        </div>
        <div class="col-md-4 mt-4 text-center">
            <input name="status" class="form-control" type="checkbox" value="1"
                {{ $status == 1 ? 'checked' : '' }}>
            <label class="text-center" for=""><strong>Status</strong></label>
        </div>

        <div class="col-md-12 mt-5 text-right">
            <input class="btn btn-sm btn-info" type="submit" value="{{ $id ? 'Update' : 'Save' }}">
        </div>
    </div>
</form>
<script>
    $('.search_box').select2({
        theme: 'bootstrap4',
    });


    $(document).ready(function() {
        $("#product_wise_store_form").submit(function(event) {
            event.preventDefault();
            let formData = new FormData($(this)[0]);
            let action = $(this).attr("action");
            let method = $(this).attr("method");
            let id = "{{ $id }}" ? "{{ $id }}" : '';

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

                        success_message(res.message)

                        location.reload();
                        // $("#q_table").load(location.href + ' ' + "#q_table");
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
