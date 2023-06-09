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
$(document).on("click","#appointment_table tbody tr, .view_appointment_details tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
   
    $.ajax({
        url: frontend_path + "receptionist/get_payment_data_on_appointment_id",
        method: "POST",
        data: {
            id: data1.id,
        },
        dataType: "json",
        success: function(data) {
                var info = data.payment_details;
                var payment_details = info.payment_details;
                var payment_history = info.payment_history;

                $('#u_patient_id').text(info['patient_id']);
                $('#u_first_name').text(info['first_name']);
                $('#u_last_name').text(info['last_name']);
                $('#u_email').text(info['email']);
                $('#u_contact_no').text(info['contact_no']);
                $('#u_blood_group').text(info['blood_group']);
                $('#u_diseases').text(info['diseases_name']);
                $('#u_description').text(info['description']);               
                $('#u_fk_payment_id').val(info['payment_id']);   
                $('#u_fk_appointment_id').val(info['id']);        
                $('#u_fk_patient_id').val(info['fk_patient_id']);            
                $('#u_pescription').html('<a target="blank_"href="'+frontend_path+info.prescription+'" style="width: 50px;">Prescription</a>');
                var html ='';
                $.each(data1.documents[0], function (key, val) {
                    html +='<a target="blank_" href="'+frontend_path+val['documents']+'" style="width: 50px;">'+frontend_path+val['documents']+'</a><br>';        
                });
                $('#u_documents').html(html);
                $('#u_payment_type').text(info['payment_type']);
                $('#u_discount_amount').text(payment_details['discount']);
                $('#u_total_amount').text(payment_details['total_amount']);
                $('#up_total_amount').val(payment_details['total_amount']);
                var charges_html = '';
                 $.each(payment_details.charges_name, function (payment_details_key, payment_details_row) {
                    charges_html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="u_charges_name" class="form-label">Charges Name</label><div><span class="message_data" id="u_charges_name">'+payment_details_row+'</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Amount</label><div><span class="message_data" id="u_amount">'+payment_details.amount[payment_details_key]+'</span></div></div></div></div>';
                });
                 $('#show_charges_amount').html(charges_html);

                 var amount_paid_html = '';
                 $.each(payment_history, function (payment_history_key, payment_history_row) {
                    amount_paid_html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="u_charges_name" class="form-label">Online Payment</label><div><span class="message_data" id="u_charges_name">'+payment_history_row['online_amount']+'</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Cash Amount</label><div><span class="message_data" id="u_amount">'+payment_history_row['cash_amount']+'</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Mediclaim Amount</label><div><span class="message_data" id="u_amount">'+payment_history_row['mediclaim_amount']+'</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Total Paid Amount</label><div><span class="message_data" id="u_amount">'+payment_history_row['total_paid_amount']+'</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Remaining Amount</label><div><span class="message_data" id="u_amount">'+payment_history_row['remaining_amount']+'</span></div></div></div><input type="text" name="last_remaining_amount" value="'+payment_history_row['remaining_amount']+'"id="last_remaining_amount" class="last_remaining_amount"></div>';

                    if(payment_history_row['remaining_amount']==0){
                        $('#hide_charges').hide();
                    }
                });
                $('#amount_paid_details').html(amount_paid_html);
        },
    });
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

$(document).ready(function() {
    var up_total_sum = 0;
    var up_sum =0;
    var last_remaining_amount = $('.last_remaining_amount').map( function(){return $(this).val(); }).get();
    console.log(last_remaining_amount);
      for(var i = 0; i < last_remaining_amount.length; i++){
        var sum_11 = parseFloat(last_remaining_amount[i]);
        up_total_sum += up_sum+sum_11;
      
      } 
      console.log(up_total_sum);
    $('#total_remaining_amount').val(up_total_sum);
});
     

$(document).on('input',function() {
    var up_cash_amount = parseInt($('#up_cash_amount').val());
    var up_online_amount = parseFloat($('#up_online_amount').val());
    var up_mediclaim_amount = parseFloat($('#up_mediclaim_amount').val());
    if(!up_cash_amount){
        up_cash_amount = 0;
    }
    if(!up_online_amount){
        up_online_amount = 0;
    }
    if(!up_mediclaim_amount){
        up_mediclaim_amount = 0;
    }
    $('#up_total_paid_amount').val((up_cash_amount + up_online_amount + up_mediclaim_amount ? up_cash_amount + up_online_amount + up_mediclaim_amount : 0));

    var up_total_paid_amount = parseInt($('#up_total_paid_amount').val());
    var up_total_amount = parseFloat($('#up_total_amount').val());
    var total_last_remaining_amount = parseFloat($('#total_remaining_amount').val());
    $('#up_remaining_amount').val((total_last_remaining_amount - up_total_paid_amount ? total_last_remaining_amount - up_total_paid_amount : 0));
});



$('#update_payment_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_payment_details_form")[0]);
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
                $('form#update_payment_details_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#update_payment_model').modal('hide');
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