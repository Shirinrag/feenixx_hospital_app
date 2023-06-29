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
$('#save_doctor_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#save_doctor_details_form")[0]);
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
            $('#add_doctor_button').button('loading');
        },
        success: function(response) {
            $('#add_doctor_button').button('reset');
            if (response.status == 'success') {
                $('form#save_doctor_details_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#Doctor_table').DataTable().ajax.reload(null, false);
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
    load_doctor_data();
});
function load_doctor_data() {
    var dataTable = $('#Doctor_table').DataTable({
        "columnDefs": [
      { "width": "10px", "targets": 0 },
      { "width": "30px", "targets": 5 },
      
    ],
        // dom: 'lBfrtip',
        rowReorder: {
            selector: 'td:nth-child(2)'
        },
        responsive: true,
        "ajax": {
            url: frontend_path + 'superadmin/display_all_doctor_data',
            type: "POST"
        },

    });
}

$(document).on("click", ".edit_doctor_data", function() {
    var id = $(this).attr("id");
    $.ajax({
        url: frontend_path + "superadmin/get_doctor_details_on_id",
        method: "POST",
        data: {
            id: id,
        },
        dataType: "json",
        success: function(data) {
            var info = data['doctor_details_data'];           
            var city_details = data['city_data'];
            $("#edit_id").val(info['id']);
            $("#delete_doctor_id").val(info['id']);            
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
           $('#edit_specialization').val(info['fk_designation_id']);
            $('#edit_specialization').trigger('chosen:updated');
          $('#edit_gender').val(info['fk_gender_id']);
            $('#edit_gender').trigger('chosen:updated');
            
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

$('#update_doctor_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_doctor_details_form")[0]);
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
                $('form#update_doctor_details_form').trigger('reset');
                $('#update_doctor_model').modal('hide');
                $('#Doctor_table').DataTable().ajax.reload(null, false);
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
$(document).on('click', '.delete_doctor', function() {
    var id = $(this).attr("id");
    $('#delete_doctor_id').val(id);
});
$("#delete-form").on('submit', (function(e) {
    e.preventDefault();
    $.ajax({
        url: frontend_path + "superadmin/delete_doctor",
        type: "POST",
        data: new FormData(this),
        contentType: false,
        processData: false,
        dataType: 'json',
        beforeSend: function() {
            $('#doctor_del_button').button('loading');
        },
        success: function(data) {
            $('form#delete-form').trigger('reset');
            $('#Doctor_table').DataTable().ajax.reload(null, false);
           swal({
                    title: "success",
                    text: data.message,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
            $("#delete_doctor").modal('hide');
            $('#doctor_del_button').button('reset');
        }
    });
}));

// $(document).ready(function() {
//       $("#dob").change(function() {
//         var birthdate = $("#dob").val();
//         var currentDate = new Date();
//         var inputDate = new Date(birthdate);

//         // Calculate the age difference in milliseconds
//         var ageDiff = currentDate - inputDate;

//         // Convert the age difference to years
//         var age = Math.floor(ageDiff / (1000 * 60 * 60 * 24 * 365.25));

//         if (age >= 18) {
//           alert("Valid: You are above 18 years old.");
//         } else {
//           alert("Invalid: You are below 18 years old.");
//         }
//       });
//     });