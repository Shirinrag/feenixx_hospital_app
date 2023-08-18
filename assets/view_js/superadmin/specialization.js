
$('#save_specialization_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#save_specialization_form")[0]);
    var AddSpecializationForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: AddSpecializationForm.attr('action'),
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        beforeSend: function() {
            $('#add_specialization_button').button('loading');
        },
        success: function(response) {
            $('#add_specialization_button').button('reset');
            if (response.status == 'success') {
                $('form#save_specialization_form').trigger('reset');
                $('#Specialization_table').DataTable().ajax.reload(null, false);
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
    table = $('#Specialization_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_specialization_data",
        "columns": [{
                "data": null
            },
            {
                "data": "designation_name"
            },
            {
                "data": "statusdata",
                "className": "change_status",
                render: function(data) {
                    var specialization_status = data.split(",");
                    if (specialization_status[0] == 1) {
                        return '<label class="switch"><input type="checkbox" checked id="switch' + specialization_status[1] + '" onclick="change_status(' + specialization_status[0] + ',' + specialization_status[1] + ');"><span class="slider round"></span></label>';
                    } else {
                        return '<label class="switch"><input type="checkbox" id="switch' + specialization_status[1] + '" onclick="change_status(' + specialization_status[0] + ',' + specialization_status[1] + ');"><span class="slider round"></span></label>';
                    }
                },
            },
            {
                "data": null,
                "className": "edit_diseases_details",
                "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="bi bi-pencil-fill" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#update_specialization_model"></i></a><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="bi-trash-fill" href="#a_delete_user_modal" class="trigger-btn" data-bs-toggle="modal"  data-bs-target="#delete_specialization" aria-hidden="true"></i></a></span>'
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
$(document).on("click","#Specialization_table tbody tr, .edit_diseases_details tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
    $('#edit_id').val(data1.id);
    $('#delete_specialization_id').val(data1.id);
    $('#edit_specialization').val(data1.designation_name);
});
$('#update_specialization_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_specialization_details_form")[0]);
    var UpdateSpecializationForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: UpdateSpecializationForm.attr('action'),
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        beforeSend: function() {
            $('#update_specialization_button').button('loading');
        },
        success: function(response) {
            $('#update_specialization_button').button('reset');
            if (response.status == 'success') {
                $('form#update_specialization_details_form').trigger('reset');
                $('#update_specialization_model').modal('hide');
                $('#Specialization_table').DataTable().ajax.reload(null, false);
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
        url: frontend_path + "superadmin/delete_specialization",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend:function(){
            $('#specialization_del_button').button('loading');
        },
        success: function(data) {
            $('form#delete-form').trigger('reset');
            $('#Specialization_table').DataTable().ajax.reload(null, false);
            swal({
                    title: "success",
                    text: data.msg,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
            $("#delete_specialization").modal('hide');
            $('#specialization_del_button').button('reset');
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
    var id = id;
    $.ajax({
        url: frontend_path + "superadmin/change_specialization_status",
        type: "POST",
        data: {
            'id': id,
            'status': user_status
        },
        dataType: 'json',        
        success: function(data) {
            $('#Specialization_table').DataTable().ajax.reload(null, false);
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