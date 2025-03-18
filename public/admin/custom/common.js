$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

//Data Table
$(document).ready(function () {
    var table = $('.datatable').DataTable();
});


//Delete Notification
$(document).on('click', '.delete_data', function (e) {
    e.preventDefault()
    let url = $(this).attr("href");

    Swal.fire({
        title: 'Are you sure?',
        text: "You won't to Delete This!",
        icon: 'warning',
        showCancelButton: true,
        cancelButtonColor: '#3085d6',
        confirmButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire(
                'Deleted!',
                'Your file has been deleted.',
                'success'
            )
            window.location.href = url
        }
    })

})



//Select2
$('.search_box').select2({
    theme: 'bootstrap4'
});


// Image Validation
 async function image_validation(
    image_id,
    show_image,
    message,
    size = "",
    custom_v_m = ""
) {
    $(image_id).change(function (e) {
        $(show_image).attr("src", "");
        $(show_image).closest("img").hide();
        let file_val = $(this).val();
        let file_size = this.files[0].size / 1024;
        let required_size = size != "" ? size : 1024;

        var fileExt = file_val.split(".").pop();

        if (fileExt == "jpg" || fileExt == "jpeg" || fileExt == "png") {
            if (file_size > required_size) {
                let msg =
                    custom_v_m != ""
                        ? custom_v_m
                        : parseFloat(file_size).toFixed(2) +
                        " kb Size is too large from required size";
                $(message).html(`<span class="text-danger">${msg}</span>`);
                return false;
            } else {
                $(message).html(
                    `<span class="text-success">Valid Image</span>`
                );
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(show_image).closest("img").show();
                    $(show_image).attr("src", e.target.result);
                };
                reader.readAsDataURL(e.target.files["0"]);
                event.stopImmediatePropagation();
            }
        } else {
            $(message).html(
                `<span class="text-danger">Invalid File Format</span>`
            );
        }
    });
}

// Fav Icon Validation
async function favicon_validation(
    image_id,
    show_image,
    message,
    size = "",
    custom_v_m = ""
) {
    $(image_id).change(function (e) {
        $(show_image).attr("src", "");
        $(show_image).closest("img").hide();
        let file_val = $(this).val();
        let file_size = this.files[0].size / 1024;
        let required_size = size != "" ? size : 1024;

        var fileExt = file_val.split(".").pop();

        if (fileExt == "ico" || fileExt == "png") {
            if (file_size > required_size) {
                let msg =
                    custom_v_m != ""
                        ? custom_v_m
                        : parseFloat(file_size).toFixed(2) +
                        " kb Size is too large from required size";
                $(message).html(`<span class="text-danger">${msg}</span>`);
                return false;
            } else {
                $(message).html(
                    `<span class="text-success">Valid Image</span>`
                );
                var reader = new FileReader();
                reader.onload = function (e) {
                    $(show_image).closest("img").show();
                    $(show_image).attr("src", e.target.result);
                };
                reader.readAsDataURL(e.target.files["0"]);
                event.stopImmediatePropagation();
            }
        } else {
            $(message).html(
                `<span class="text-danger">Invalid File Format</span>`
            );
        }
    });
}

$(document).on('click', '.open_modal', function () {
    var id = $(this).attr("data-id");
    var action = $(this).attr("data-action");
    var title = $(this).attr("data-title");
    var modal = $(this).attr("data-modal");
    uiBlock()
    $.ajax({
        async: true,
        url: action,
        data: {
            id: id
        },
        type: "get",
        beforeSend: function () {
            $('.' + modal).modal('show');
            $('.' + modal + ' .modal-body').html("<h3>Loading...</h3>");
            $('.' + modal + ' .modal_title').html(title);
        },
        success: function (data) {
            $('.' + modal + ' .modal-body').html(data);

        },
        complete: function (data) {
            uiBlockStop()
        }

    });
    event.stopImmediatePropagation();
})






//Invoice Auto
let invoice_search = async (invoice = '', show_id, error_show) => {

    $(invoice).bind("change keyup input", function() {
        if ($(this).val() == '' || $(this).val() == null) {
            $(show_id).val('')
            $(error_show).text("")
        }
    });

    $(invoice).autocomplete({
        source: function(request, response) {
            $.ajax({
                async: true,
                url: invoice_search_auto.routes.zone,
                type: 'get',
                dataType: "json",
                data: {
                    invoice: request.term,
                },
                success: function(data) {
                    if (data.length == 0) {
                        $(error_show).text("Data Not Found")
                    } else {
                        $(error_show).text("")

                    }
                    var array = $.map(data, function(row) {
                        return {
                            value: row.invoice_no,
                            label: 'Inv:' + row.invoice_no + '--' + row
                                .customer_name + '(ph-' + row.phone + ')',
                            id: row.invoice_id
                        }
                    })
                    response($.ui.autocomplete.filter(array, request.term));
                }
            })

        },
        select: function(event, ui) {
            let id = ui.item.id;
            $(show_id).val(id)
        },
        minLength: 1,
        delay: 500
    });

}


//Store wise Invoice
let store_wise_invoice_search = async (invoice = '', show_id, error_show) => {

    $(invoice).bind("change keyup input", function() {
        if ($(this).val() == '' || $(this).val() == null) {
            $(show_id).val('')
            $(error_show).text("")
        }
    });

    $(invoice).autocomplete({
        source: function(request, response) {
            $.ajax({
                async: true,
                url: store_wise_invoice_auto.routes.zone,
                type: 'get',
                dataType: "json",
                data: {
                    invoice: request.term,
                },
                success: function(data) {
                    if (data.length == 0) {
                        $(error_show).text("Data Not Found")
                    } else {
                        $(error_show).text("")

                    }
                    var array = $.map(data, function(row) {
                        return {
                            value: row.invoice_no,
                            label: 'Inv:' + row.invoice_no + '--' + row
                                .customer_name + '(ph-' + row.phone + ')',
                            id: row.invoice_id
                        }
                    })
                    response($.ui.autocomplete.filter(array, request.term));
                }
            })

        },
        select: function(event, ui) {
            let id = ui.item.id;
            $(show_id).val(id)
        },
        minLength: 1,
        delay: 500
    });

}


// Search Employee
function employee_search(search_id, submit_input = '', not_found = '') {

    $(search_id).bind("change keyup input", function() {
        if ($(this).val() == '' || $(this).val() == null) {
            $(submit_input).val('')
            $(not_found).text("")
        }
    });

    $(search_id).autocomplete({
        source: function (request, response) {
            $(not_found).text('');
            $.getJSON(employee_auto.routes.zone+request.term, function (data) {
                if (data.length == 0) {
                    $(not_found).text('Data Not Found')
                }
                var array = $.map(data, function (row) {
                    return {
                        value: row.name,
                        label: row.card_no + '--' + row.name + ' (' + row.email + ') '+ ' (' + row.phone + ')',
                        emp_id: row.id,
                    }
                })
                response($.ui.autocomplete.filter(array, request.term));
            })
        },
        select: function (event, ui) {
            $(submit_input).val(ui.item.emp_id)
        },
        minLength: 1,
        delay: 500
    });

}

//Store wise store_wise_employee_auto
let store_wise_employee_auto = async (invoice = '', show_id, error_show) => {

    $(invoice).bind("change keyup input", function() {
        if ($(this).val() == '' || $(this).val() == null) {
            $(show_id).val('')
            $(error_show).text("")
        }
    });

    $(invoice).autocomplete({
        source: function(request, response) {
            $.ajax({
                async: true,
                url: store_wise_employee_auto_search.routes.zone,
                type: 'get',
                dataType: "json",
                data: {
                    employee: request.term,
                },
                success: function(data) {
                    if (data.length == 0) {
                        $(error_show).text("Data Not Found")
                    } else {
                        $(error_show).text("")

                    }
                    var array = $.map(data, function(row) {
                        return {
                            value: row.name,
                            label: `${row.name} (  ${row.card_no} )(${row.phone })`,
                            id: row.id,
                        }
                    })
                    response($.ui.autocomplete.filter(array, request.term));
                }
            })

        },
        select: function(event, ui) {
            let id = ui.item.id;
            $(show_id).val(id)
        },
        minLength: 1,
        delay: 500
    });

}




// Preloader Function
const uiBlock = () => {
    $('#loading').addClass('loading')
    $('#loading_content').addClass('loading_content')
}

const uiBlockStop = () => {
    $('#loading').removeClass('loading')
    $('#loading_content').removeClass('loading_content')
}
