
$('#save_diseases_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#save_diseases_form")[0]);
    var AddDoctorForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: AddDoctorForm.attr('action'),
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        beforeSend: function() {
            $('#add_diseases_button').button('loading');
        },
        success: function(response) {
            $('#add_diseases_button').button('reset');
            if (response.status == 'success') {
                $('form#save_diseases_form').trigger('reset');
                $('#diseases_table').DataTable().ajax.reload(null, false);
                swal({
                    title: "success",
                    text: response.msg,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
            } else if (response.status == 'failure') {
                error_msg(response.error)
            } else {
                window.location.replace(response['url']);
            }
        },
        error: function(error, message) {

        }
    });
    return false;
});
$(document).ready(function() {
    table = $('#diseases_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_diseases_data",
        "columns": [{
                "data": null
            },
            {
                "data": "diseases_name"
            },
            {
                "data": "statusdata",
                "className": "change_status",
                render: function(data) {
                    var diseases_status = data.split(",");
                    if (diseases_status[0] == 1) {
                        return '<label class="switch"><input type="checkbox" checked id="switch' + diseases_status[1] + '" onclick="change_status(' + diseases_status[0] + ',' + diseases_status[1] + ');"><span class="slider round"></span></label>';
                    } else {
                        return '<label class="switch"><input type="checkbox" id="switch' + diseases_status[1] + '" onclick="change_status(' + diseases_status[0] + ',' + diseases_status[1] + ');"><span class="slider round"></span></label>';
                    }
                },
            },
            {
                "data": null,
                "className": "edit_diseases_details",
                "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="bi bi-pencil-fill" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#update_diseases_model"></i></a><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="bi-trash-fill" href="#a_delete_user_modal" class="trigger-btn" data-bs-toggle="modal"  data-bs-target="#delete_diseases" aria-hidden="true"></i></a></span>'
            },
        ],
        "order": [
            [0, 'desc']
        ]
    });
    table.on('order.dt search.dt', function() {
        table.column(0, {
            search: 'applied',
            order: 'applied'
        }).nodes().each(function(cell, i) {
            cell.innerHTML = i + 1;
        });

    }).draw();
});
$(document).on("click","#diseases_table tbody tr, .edit_diseases_details tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
    $('#edit_id').val(data1.id);
    $('#delete_diseases_id').val(data1.id);
    $('#edit_diseases').val(data1.diseases_name);
});
$('#update_diseases_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_diseases_details_form")[0]);
    var InvoiceTypeForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: InvoiceTypeForm.attr('action'),
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        beforeSend: function() {
            $('#update_doctor_button').button('loading');
        },
        success: function(response) {
            $('#update_doctor_button').button('reset');
            if (response.status == 'success') {
                $('form#update_diseases_details_form').trigger('reset');
                $('#update_diseases_model').modal('hide');
                $('#diseases_table').DataTable().ajax.reload(null, false);
                swal({
                    title: "success",
                    text: response.msg,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
            } else if (response.status == 'failure') {
                error_msg(response.error)
            } else {
                window.location.replace(response['url']);
            }
        },
        error: function(error, message) {

        }
    });
    return false;
});
$("#delete-form").on('submit', (function(e) {
    e.preventDefault();
    $.ajax({
        url: frontend_path + "superadmin/delete_diseases",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend:function(){
            $('#diseases_del_button').button('loading');
        },
        success: function(data) {
            $('form#delete-form').trigger('reset');
            $('#diseases_table').DataTable().ajax.reload(null, false);
            swal({
                    title: "success",
                    text: data.msg,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
            $("#delete_diseases").modal('hide');
            $('#diseases_del_button').button('reset');
        }
    });
}));
function change_status(status, id) {
    var status = status;
    if (status == 1) {
        var user_status = 0;
    } else {
        var user_status = 1;
    }
    var user_id = id;
    //console.log(domain_id);
    $.ajax({
        url: frontend_path + "superadmin/change_diseases_status",
        type: "POST",
        data: {
            'id': user_id,
            'status': user_status
        },
        dataType: 'json',
        // beforeSend:function(){
        //     document.getElementById('header_loader').style.visibility = "visible";
        // },
        success: function(data) {
            // document.getElementById('header_loader').style.visibility = "hidden";
            $('#diseases_table').DataTable().ajax.reload(null, false);
            swal({
                title: "success",
                text: data.message,
                icon: "success",
                dangerMode: true,
                timer: 1500
            });
        }
    });
}