$(document).on("change", "#state", function() {
    var id = $(this).val();
    $.ajax({
        type: "POST",
        url: frontend_path + "superadmin/get_city_data_on_state_id",
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
$('#save_staff_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#save_staff_details_form")[0]);
    var AddstaffForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: AddstaffForm.attr('action'),
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        beforeSend: function() {
            $('#add_staff_button').button('loading');
        },
        success: function(response) {
            $('#add_staff_button').button('reset');
            if (response.status == 'success') {
                $('form#save_staff_details_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#staff_table').DataTable().ajax.reload(null, false);
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
    load_staff_data();
});
function load_staff_data() {
    var dataTable = $('#staff_table').DataTable({
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        "ajax": {
            url: frontend_path + 'superadmin/display_all_staff_data',
            type: "POST"
        },

    });
}

$(document).on("click", ".edit_staff_data", function() {
    var id = $(this).attr("id");
    $.ajax({
        url: frontend_path + "superadmin/get_staff_details_on_id",
        method: "POST",
        data: {
            id: id,
        },
        dataType: "json",
        success: function(data) {
            var info = data['staff_details_data'];           
            var city_details = data['city_data'];
            $("#edit_id").val(info['id']);
            $("#delete_staff_id").val(info['id']);            
            $("#edit_user_type").val(info['user_type']);
            $("#edit_first_name").val(info['first_name']);
            $("#edit_last_name").val(info['last_name']);
            $("#edit_dob").val(info['dob']);
            $("#edit_email").val(info['email']);
            $("#edit_contact_no").val(info['contact_no']);
            $("#edit_address1").val(info['address1']);
            $("#edit_address2").val(info['address2']);
            $("#edit_pincode").val(info['pincode']);
            $("#edit_state").val(info['fk_state_id']);
            $('#edit_state').trigger("chosen:updated"); 
            $('#edit_gender').val(info['fk_gender_id']);
            $('#edit_gender').trigger('chosen:updated');
            $('#last_inserted_aadhar_card_document').val(info['aadhar_card']);
            $('#last_inserted_pancard_document').val(info['pan_card']);

            
            var city_option = "";
            var option_data1 = "";
            $.each(city_details, function(city_details_index, city_details_row) {
                if (city_details_row["id"] == info['fk_city_id']) {
                    option_data1 = "selected";
                } else {
                    option_data1 = "";
                }
                city_option += "<option value=" + city_details_row["id"] + " " + option_data1 + " >" + city_details_row["city"] + "</option>";
            });
            $('#edit_city').html(city_option);
            $('#edit_city').trigger("chosen:updated");
            
             var pan_card = '';
             pan_card = '<img src="' + frontend_path +info['pan_card'] + '" class="" width="150px" height="100px">';
            $('#pancard_doc').html(pan_card);  
             var aadhar_card = '';
             aadhar_card = '<img src="' + frontend_path +info['aadhar_card'] + '" class="" width="150px" height="100px">';
            $('#aadharcard_doc').html(aadhar_card);  
        },
    });
});
$(document).on('click', '.delete_staff', function() {
    var id = $(this).attr("id");
    $('#delete_staff_id').val(id);
});
// 
$('#update_staff_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_staff_details_form")[0]);
    var UpdatestaffForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: UpdatestaffForm.attr('action'),
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
                $('form#update_staff_details_form').trigger('reset');
                $('#update_staff_model').modal('hide');
                $('#staff_table').DataTable().ajax.reload(null, false);
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
        url: frontend_path + "superadmin/delete_staff",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function() {
            $('#staff_del_button').button('loading');
        },
        success: function(data) {
            $('form#delete-form').trigger('reset');
            $('#staff_table').DataTable().ajax.reload(null, false);
           swal({
                    title: "success",
                    text: data.message,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
            $("#delete_staff").modal('hide');
            $('#staff_del_button').button('reset');
        }
    });
}));