$(document).on("change", "#patient_id", function() {
    var id = $(this).val();
    $.ajax({
        type: "POST",
        url: frontend_path + "doctor/get_patient_details_on_patient_id",
        data: {
            id: id
        },
        dataType: "json",
        cache: false,
        success: function(result) {
            if (result["status"] == "success") {
                var info = result.patient_data;
               $('.hide_data').show();
               $('#first_name').text(info['first_name']);
               $('#last_name').text(info['last_name']);
               $('#email').text(info['email']);
               $('#contact_no').text(info['contact_no']);
               $('#blood_group').text(info['blood_group']);
               $('#gender').text(info['gender']);
               $('#patient_id_1').val(info['patient_id']);
                
            } else if (result["status"] == "failure") {
               $('.hide_data').hide();
            } else if (result["status"] == "login_failure") {
                window.location.replace(result["url"]);
            } else {

            }
        },
    });
});
$('#save_appointment_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#save_appointment_details_form")[0]);
    var AddPatientForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: AddPatientForm.attr('action'),
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
                $('form#save_appointment_details_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#patient_table').DataTable().ajax.reload(null, false);
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
    load_patient_data();
});
function load_patient_data() {
    var dataTable = $('#patient_table').DataTable({
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        "ajax": {
            url: frontend_path + 'superadmin/display_all_patient_data',
            type: "POST"
        },

    });
}

$(document).on("click", ".edit_patient_data", function() {
    var id = $(this).attr("id");
    $.ajax({
        url: frontend_path + "superadmin/get_patient_details_on_id",
        method: "POST",
        data: {
            id: id,
        },
        dataType: "json",
        success: function(data) {
            var info = data['patient_details_data'];           
            var city_details = data['city_data'];
            $("#edit_id").val(info['id']);
            $("#delete_patient_id").val(info['id']);            
            $("#edit_patient_id").val(info['patient_id']);
            $("#edit_first_name").val(info['first_name']);
            $("#edit_last_name").val(info['last_name']);
            $("#edit_dob").val(info['dob']);
            $("#edit_email").val(info['email']);
            $("#edit_contact_no").val(info['contact_no']);
            $("#edit_address1").val(info['address1']);
            $("#edit_address2").val(info['address2']);
            $("#edit_pincode").val(info['pincode']);
            $("#edit_state").val(info['state']);
            $('#edit_state').trigger("chosen:updated");
           $('#edit_marital_status').val(info['fk_marital_status_id']);
            $('#edit_marital_status').trigger('chosen:updated');
            $('#edit_blood_group').val(info['fk_blood_group_id']);
            $('#edit_blood_group').trigger('chosen:updated');
          $('#edit_gender').val(info['fk_gender_id']);
            $('#edit_gender').trigger('chosen:updated');
          $('#edit_emergency_contact_name').val(info['emergency_contact_name']);
          $('#edit_emergency_contact_phone').val(info['emergency_contact_phone']);
            
            var city_option = "";
            var option_data1 = "";
            $.each(city_details, function(city_details_index, city_details_row) {
                if (city_details_row["id"] == info['city']) {
                    option_data1 = "selected";
                } else {
                    option_data1 = "";
                }
                city_option += "<option value=" + city_details_row["id"] + " " + option_data1 + " >" + city_details_row["city"] + "</option>";
            });
            $('#edit_city').html(city_option);
            $('#edit_city').trigger("chosen:updated");
            
             var image = '';
             image = '<img src="' + frontend_path +info['image'] + '" class="" width="150px" height="150px">';
            $('#image_data').html(image);  
        },
    });
});
$(document).on('click', '.delete_patient', function() {
    var id = $(this).attr("id");
    $('#delete_patient_id').val(id);
});
// 
$('#update_patient_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_patient_details_form")[0]);
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
                $('form#update_patient_details_form').trigger('reset');
                $('#update_patient_model').modal('hide');
                $('#patient_table').DataTable().ajax.reload(null, false);
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
        url: frontend_path + "superadmin/delete_patient",
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
            $('#patient_table').DataTable().ajax.reload(null, false);
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