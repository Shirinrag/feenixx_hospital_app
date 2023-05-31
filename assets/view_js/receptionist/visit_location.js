$(document).on("change", "#state", function() {
    var id = $(this).val();
    $.ajax({
        type: "POST",
        url: frontend_path + "receptionist/get_city_data_on_state_id",
        data: {
            state: id
        },
        dataType: "json",
        cache: false,
        success: function(result) {
            if (result["status"] == "success") {
                var city_data = result.city_data;
                var html = "";
                html += '<option value=""></option>';
                $.each(city_data, function(city_data_index, city_data_row) {
                    html += '<option value="' + city_data_row.id + '">' + city_data_row.city + "</option>";
                });
                $("#city").html(html);
                $("#city").trigger("chosen:updated");
            } else if (result["status"] == "failure") {
                $("#city").html("");
                $("#city").trigger("chosen:updated");
            } else if (result["status"] == "login_failure") {
                window.location.replace(result["url"]);
            } else {

            }
        },
    });
});
$('#save_location_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#save_location_details_form")[0]);
    var AddVisitLocationForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: AddVisitLocationForm.attr('action'),
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        beforeSend: function() {
            $('#add_patient_button').button('loading');
        },
        success: function(response) {
            $('#add_patient_button').button('reset');
            if (response.status == 'success') {
                $('form#save_location_details_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#location_table').DataTable().ajax.reload(null, false);
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
    table = $('#location_table').DataTable({
        "ajax": frontend_path + "receptionist/display_all_location_data",
        
        "columns": [{
                "data": null
            },
            {
                "data": "place_name",
                  
            },
            {
                "data": "address1",
                "render": function ( data, type, row, meta ) {
                  
                    var html="";
                     html += data+" "+row.address2;
                     html += data+" "+row.name;
                     html += data+" "+row.city_name;
                     return html;
                  },
            },
            {
                 "data": null,
                "className": "edit_location_details",
                "defaultContent": '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="bi bi-pencil-fill" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#update_location_model"></i></a><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Delete Details" class="remove-row"><i class="bi-trash-fill" href="#a_delete_user_modal" class="trigger-btn" data-bs-toggle="modal"  data-bs-target="#delete_location" aria-hidden="true"></i></a></span>'
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
$(document).on("click","#location_table tbody tr, .edit_location_details tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
    
    $('#edit_id').val(data1.id);
    $('#edit_place_name').val(data1.place_name);
    $('#edit_address1').val(data1.address1);
    $('#edit_address2').val(data1.address2);
    $('#edit_state').val(data1.fk_state_id);
    $('#edit_state').trigger('chosen:updated');
    // $('#edit_city').val(data1.fk_city_id);
    // $('#edit_city').trigger('chosen:updated');
    $('#edit_pincode').val(data1.pincode);

    var html = "";
    var city_data = data1.city_data;
    html += '<option value=""></option>';
                $.each(city_data, function(city_data_index, city_data_row) {
                    if (city_data_row.id == data1.fk_city_id) {
                        html += '<option value="' + city_data_row.id + '" selected>' + city_data_row.city + "</option>";
                    } else {
                        html += '<option value="' + city_data_row.id + '">' + city_data_row.city + "</option>";
                    }
                });
                $("#edit_city").html(html);
                $("#edit_city").trigger("chosen:updated");

});
$(document).on('click', '.delete_patient', function() {
    var id = $(this).attr("id");
    $('#delete_patient_id').val(id);
});
// 
$('#update_location_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_location_details_form")[0]);
    var UpdatePatientForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: UpdatePatientForm.attr('action'),
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
                $('form#update_location_details_form').trigger('reset');
                $('#update_location_model').modal('hide');
                $('#location_table').DataTable().ajax.reload(null, false);
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
        url: frontend_path + "receptionist/delete_patient",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function() {
            $('#patient_del_button').button('loading');
        },
        success: function(data) {
            $('form#delete-form').trigger('reset');
            $('#location_table').DataTable().ajax.reload(null, false);
           swal({
                    title: "success",
                    text: data.message,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
            $("#delete_patient").modal('hide');
            $('#patient_del_button').button('reset');
        }
    });
}));