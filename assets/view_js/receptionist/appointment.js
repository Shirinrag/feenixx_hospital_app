$(document).on("change", "#admission_type", function() {
    var id = $(this).val();
    $.ajax({
        type: "POST",
        url: frontend_path + "receptionist/get_sub_type_data_on_appoitment_id",
        data: {
            admission_type: id
        },
        dataType: "json",
        cache: false,
        success: function(result) {
            if (result["status"] == "success") {
                var appointment_sub_type = result.appointment_sub_type;
                var html = "";
                html += '<option value=""></option>';
                $.each(appointment_sub_type, function(appointment_sub_type_index, appointment_sub_type_row) {
                    html += '<option value="' + appointment_sub_type_row.id + '">' + appointment_sub_type_row.sub_type + "</option>";
                });
                $("#admission_sub_type").html(html);
                $("#admission_sub_type").trigger("chosen:updated");
                $("#hide_admission_sub_type").show();
                $("#hide_fk_visit_location_id").show();
            } else if (result["status"] == "failure") {
                $("#admission_sub_type").html("");
                $("#admission_sub_type").trigger("chosen:updated");
                $("#hide_admission_sub_type").hide();
                $("#hide_fk_visit_location_id").hide();
            } else if (result["status"] == "login_failure") {
                window.location.replace(result["url"]);
            } else {

            }
        },
    });
});

$(document).on("change", "#patient_id", function() {
    var id = $(this).val();
    $.ajax({
        type: "POST",
        url: frontend_path + "receptionist/get_patient_details_on_patient_id",
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
            $('#add_appointment_button').button('loading');
        },
        success: function(response) {
            $('#add_appointment_button').button('reset');
            if (response.status == 'success') {
                $('form#save_appointment_details_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#appointment_table').DataTable().ajax.reload(null, false);
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
    table = $('#appointment_table').DataTable({
        "ajax": frontend_path + "receptionist/display_all_appointment_details",
        
        "columns": [{
                "data": null
            },
            {
                "data": "doctor_first_name",
                  "render": function ( data, type, row, meta ) {
                  
                    var html="";
                     html= data+" "+row.doctor_last_name;
                     return html;
                  },
            },
            {
                "data": "patient_id"
            },
            {
                "data": "first_name",
                "render": function ( data, type, row, meta ) {
                  
                    var html="";
                     html= data+" "+row.last_name;
                     return html;
                  },
            },
            { "data": "email"},
            { "data": "contact_no"},
            { "data": "appointment_date"},
            { "data": "appointment_time"},
            {
                "data": null,
                "className": "update_appointment_details",
                 "render": function ( data, type, row, meta ) {
                     var html="";
                     if(row.payment_details == null){
                        html += '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reschedule_appointment">Reschedule Appointment</button>';
                     }else{
                        html += '';
                     }
                     return html;
                  },
                               
            },
            {
                "data": null,
                "className": "view_appointment_details",
                "render": function ( data, type, row, meta ) {
                     var html="";
                     if(row.fk_payment_id == null){
                        html += '<span><span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="bi bi-pencil-fill edit_doctor_data" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#view_appointment_model"></i></a></span>';
                       
                     }else{
                         html += '<span><span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Update Payment" ><i class="bi bi-pencil-fill" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#update_payment_model"></i></a></span>';
                     }
                     return html;
                  },
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
$(document).on("click","#appointment_table tbody tr, .view_appointment_details tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
      $('#edit_id').val(data1.id);
      $('#fk_patient_id').val(data1.fk_patient_id);
      $('#fk_appointment_id').val(data1.id);

    $('#view_patient_id').text(data1.patient_id);
    $('#view_first_name').text(data1.first_name);
    $('#view_last_name').text(data1.last_name);
    $('#view_blood_group').text(data1.blood_group);
    $('#view_email').text(data1.email);
    $('#view_contact_no').text(data1.contact_no);
    $('#view_appointment_date').text(data1.appointment_date);
    $('#view_appointment_time').text(data1.appointment_time);
    $('#view_description').text(data1.description);
    $('#view_diseases').text(data1.diseases_name);
    $('#view_payment_type').text(data1.payment_type);
    $('#view_cash_amount').text(data1.cash_amount);
    $('#view_online_amount').text(data1.online_amount);
    $('#view_mediclaim_amount').text(data1.mediclaim_amount);
    $('#view_discount').text(data1.discount);
    $('#view_total_amount').text(data1.total_amount);
    $('#view_pescription').html('<a target="blank_"href="'+frontend_path+data1.prescription+'" style="width: 50px;">Prescription</a>');
    // $('#view_pescription').html('<a target="blank_" href="'+frontend_path+data1.prescription+'" style="width: 50px;">'+frontend_path+data1.prescription+'</a>');
    var html ='';
    $.each(data1.documents[0], function (key, val) {
       
        html +='<a target="blank_" href="'+frontend_path+val['documents']+'" style="width: 50px;">'+frontend_path+val['documents']+'</a><br>';
        
    });
    $('#view_documents').html(html);
    

});
$(document).on("click","#appointment_table tbody tr, .update_appointment_details tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
    $('#update_id').val(data1.id);
    $('#fk_appointment_id').val(data1.id);

    $('#update_patient_id').text(data1.patient_id);
    $('#update_first_name').text(data1.first_name);
    $('#update_last_name').text(data1.last_name);
    $('#update_blood_group').text(data1.blood_group);
    $('#update_email').text(data1.email);
    $('#update_contact_no').text(data1.contact_no);
    $('#update_appointment_date').val(data1.appointment_date);
    $('#update_appointment_time').val(data1.appointment_time);
});
$("#appointment_date").datepicker({
format: 'dd-mm-yyyy',
autoclose: true, 
todayHighlight: true,
 startDate: "today",
});
$("#update_appointment_date").datepicker({
format: 'dd-mm-yyyy',
autoclose: true, 
todayHighlight: true,
 startDate: "today",
});



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
                $('#add_diseases_model').modal('hide');
                $('form#save_diseases_form').trigger('reset');
                $('#diseases_table').DataTable().ajax.reload(null, false);
                $('.drop_name1').load(frontend_path + 'receptionist/appointment .shipper_select', function() {
                    $(".chosen-select-deselect").chosen({
                        width: "95%"
                    });
                }).fadeIn('slow');
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


$('#addRows').click(function() {
    var latest_count = $('#count_details').val();
    var new_count = parseInt(latest_count) + 1;
    $.ajax({
        type: "POST",
        url: frontend_path + "receptionist/get_charges_details",
        dataType: "json",
        cache: false,
       
        success: function(result) {
                var charges_data = result.charges_data;
                var charges_option = "";
                charges_option = "<option></option>";
                $.each(charges_data, function(charges_data_index, charges_data_row) {
                    charges_option += "<option value=" + charges_data_row["id"] + ">" + charges_data_row["charges_name"] + "</option>";
                });
            var html2 = '';
            html2 += '<div class="row"><div class="col-md-4"> <div class="form-group"> <label class="form-label">Select Charges</label> <select type="text" class="form-control chosen-select-deselect " name="charges[]" id="charges_'+new_count+'" data-placeholder="Select Charges">'+charges_option+' </select> <span class="error_msg" id="fk_place_id_error"></span> </div></div><div class="col-md-4"> <div class="form-group"> <label class="form-label">Amount</label> <input type="text" class="form-control input-text amount_charges" name="amount[]" id="amount_'+new_count+'" placeholder="Amount"> <span class="error_msg" id="amount_error"></span> </div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 49px; width: 38px;">-</button></div>';

            $('#Charges_append').append(html2);
            $("#count_details").val(new_count);
            $(".chosen-select-deselect").chosen({
                width: "100%",
            });

        },
    });

});
$(document).on('click', '#removeRow', function() {
    var latest_count = $('#count').val();
    var new_count = parseInt(latest_count) - 1;
    $('#count').val(new_count);
    $(this).closest("div").remove();
});

$('#update_appointment_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_appointment_details_form")[0]);
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
            $('#add_appointment_button').button('loading');
        },
        success: function(response) {
            $('#add_appointment_button').button('reset');
            if (response.status == 'success') {
                $('form#update_appointment_details_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#view_appointment_model').modal('hide');
                $('#appointment_table').DataTable().ajax.reload(null, false);
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

$(document).on('input',function() {
      var total_sum = 0;
     var sum =0;
    var amount_charges = $('.amount_charges').map( function(){return $(this).val(); }).get();
    var discount = parseFloat($('#discount').val());
    if(!discount){
        discount = 0;
    }
      for(var i = 0; i < amount_charges.length; i++){
        var sum_1 = parseFloat(amount_charges[i]);
        total_sum += sum+sum_1;
      
      } 
    $('#total_amount').val((total_sum - discount ? total_sum - discount : 0));
});


$('#cash_amount, #online_amount, #mediclaim_amount').on('input',function() {
    var cash_amount = parseInt($('#cash_amount').val());
    var online_amount = parseFloat($('#online_amount').val());
    var mediclaim_amount = parseFloat($('#mediclaim_amount').val());
    if(!cash_amount){
        cash_amount = 0;
    }
    if(!online_amount){
        online_amount = 0;
    }
    if(!mediclaim_amount){
        mediclaim_amount = 0;
    }
    $('#total_paid_amount').val((cash_amount + online_amount + mediclaim_amount ? cash_amount + online_amount + mediclaim_amount : 0));

    var total_paid_amount = parseInt($('#total_paid_amount').val());
    var total_amount = parseFloat($('#total_amount').val());
    $('#remaining_amount').val((total_amount - total_paid_amount ? total_amount - total_paid_amount : 0));
});
$('#reschedule_appointment_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#reschedule_appointment_form")[0]);
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
            $('#add_appointment_button').button('loading');
        },
        success: function(response) {
            $('#add_appointment_button').button('reset');
            if (response.status == 'success') {
                $('form#reschedule_appointment_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#reschedule_appointment').modal('hide');
                $('#appointment_table').DataTable().ajax.reload(null, false);
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