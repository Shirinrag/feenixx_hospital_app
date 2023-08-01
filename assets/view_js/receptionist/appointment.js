$('#addRows_advance_payment').click(function() {
    var advance_latest_count = $('#advance_count_details').val();
    var advance_new_count = parseInt(advance_latest_count) + 1;
    $.ajax({
        type: "POST",
        url: frontend_path + "receptionist/get_payment_type_details",
        dataType: "json",
        cache: false,

        success: function(result) {
            var payment_type = result.payment_type;
            var advance_payment_type = "";
            advance_payment_type = "<option></option>";
            $.each(payment_type, function(payment_type_index, payment_type_row) {
                advance_payment_type += "<option value=" + payment_type_row["id"] + ">" + payment_type_row["payment_type"] + "</option>";
            });
            var html2 = '';
            html2 += '<div class="row"><div class="col-md-3"><div class="form-group"><label class="form-label">Advance Amount</label><input type="text" class="form-control input-text" name="advance_amount[]" id="advance_amount_' + advance_new_count + '" placeholder="Enter Advance Amount"></div></div><div class="col-md-3"> <div class="form-group"> <label class="form-label">Select Payment Type</label> <select type="text" class="form-control chosen-select-deselect " name="advance_payment_type[]" id="advance_payment_type_' + advance_new_count + '" data-placeholder="Select Charges">' + advance_payment_type + ' </select> <span class="error_msg" id="fk_place_id_error"></span> </div></div><div class=col-md-3><div class=form-group><label class="form-label required"for=date>Date</label> <input class="form-control input-text advance_payment_date" id=advance_payment_date_' + advance_new_count + '" name="advance_payment_date[]" placeholder="Enter Date"> <span class=error_msg id=advance_payment_date_error></span></div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 49px; width: 38px;">-</button></div>';

            $('#Advance_Charges_append').append(html2);
            $("#advance_count_details").val(advance_new_count);
            $(".chosen-select-deselect").chosen({
                width: "100%",
            });
            $(".advance_payment_date").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                // startDate: "today",
            });
        },
    });

});
$(document).on('click', '#removeRow', function() {
    var advance_latest_count = $('#advance_count').val();
    var advance_new_count = parseInt(advance_latest_count) - 1;
    $('#advance_count').val(advance_new_count);
    $(this).closest("div").remove();
});
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
$(document).on("change", "#admission_type", function() {
    var admission_type_id = $(this).val();
    if (admission_type_id == 2) {
        $("#hide_deposite_amount").hide();
    } else {
        $("#hide_deposite_amount").hide();
    }
});

$(document).on("change", "#patient_id", function() {
    var patient_id = $(this).val();
    $.ajax({
        type: "POST",
        url: frontend_path + "receptionist/get_patient_details_on_patient_id",
        data: {
            id: patient_id
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
                "render": function(data, type, row, meta) {

                    var html = "";
                    html = data + " " + row.doctor_last_name;
                    return html;
                },
            },
            {
                "data": "patient_id"
            },
            {
                "data": "first_name",
                "render": function(data, type, row, meta) {

                    var html = "";
                    html = data + " " + row.last_name;
                    return html;
                },
            },
            {
                "data": "email"
            },
            {
                "data": "contact_no"
            },
            {
                "data": "appointment_date"
            },
            {
                "data": "appointment_time"
            },
            {
                "data": null,
                "className": "update_appointment_details",
                "render": function(data, type, row, meta) {
                    var html = "";
                    if (row.diseases_name == null) {
                        html += '<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#reschedule_appointment">Reschedule Appointment</button>';
                    } else {
                        html += '';
                    }
                    return html;
                },

            },
            {
                "data": null,
                "className": "view_appointment_details",
                "render": function(data, type, row, meta) {
                    var html = "";
                    if (row.fk_payment_id == null) {
                        html += '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Edit Details" ><i class="bi bi-pencil-fill edit_doctor_data" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#view_appointment_model"></i></a></span>';

                    } else {
                        html += '<span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="Update Payment" ><i class="bi bi-pencil-fill" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#update_payment_model"></i></a></span>';
                    }
                    return html;
                },
            },
            {
                "data": null,
                "render": function(data, type, row, meta) {
                    var html = "";
                    if (row.invoice_pdf == null) {
                        html += '';

                    } else {
                        html += '<span><a href="' + row.invoice_pdf + '" data-toggle="tooltip" class="mr-1 ml-1" title="Download Invoice" target="_blank" ><i class="bi bi-download" style="font-size: 150%;"></i></a></span>';
                    }
                    return html;
                },
            },
            {
                "data": null,
                "render": function(data, type, row, meta) {
                    var html1 = "";
                    if (row.discharge_summary_pdf == null) {
                        html1 += '';

                    } else {
                        html1 += '<span><a href="' + row.discharge_summary_pdf + '" data-toggle="tooltip" class="mr-1 ml-1" title="Download Discharge Summary" target="_blank" ><i class="bi bi-download" style="font-size: 150%;"></i></a></span>';
                    }
                    return html1;
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
$(document).on("click", "#appointment_table tbody tr, .view_appointment_details tbody tr td", function() {
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();
    $('#edit_id').val(data1.id);
    $('#fk_patient_id').val(data1.fk_patient_id);
    $('#fk_appointment_id').val(data1.id);
    $('#update_appointment_id').val(data1.id);
    $('#final_fk_appointment_id').val(data1.id);
    $('#final_fk_patient_id').val(data1.fk_patient_id);
    $('#advance_fk_patient_id').val(data1.fk_patient_id);
    $('#advance_fk_appointment_id').val(data1.id);
    $('#edit_fk_appointment_id').val(data1.id);
    $('#edit_fk_appointment_id_1').val(data1.id);
    $('#surgery_fk_appointment_id').val(data1.id);

    if(data1.date_of_discharge != null){
       $('#date_of_discharge').val(data1.date_of_discharge); 
       // $('#hide_add_charges').hide();
    }
    if(data1.admission_type==1){

        $('#hide_date_of_discharge').hide();
        $('#hide_advance_charge_data').hide();
        $('#hide_add_charges').show();
        $('#hide_discharge_summary').hide();
        $('#hide_surgery_data').hide();
    }else if(data1.admission_type==2){
        $('#hide_date_of_discharge').show();
        $('#hide_add_charges').show();
         $('#hide_discharge_summary').show();
          $('#hide_surgery_data').show();
    }else{
        $('#hide_date_of_discharge').hide();
    }
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
    $('#view_doctor').text(data1.doctor_first_name + " " + data1.doctor_last_name);
    $('#view_reference_doctor_name').text(data1.reference_doctor_name);
    $('#view_type_of_addmission').text(data1.type);
    if (data1.sub_type != null) {
        $('#view_sub_type_of_addmission').text(data1.sub_type);
        $('#hide_sub_type_of_addmission').show();
    } else {
        $('#hide_sub_type_of_addmission').hide();
    }
    if (data1.diseases_name != null) {
        $('#hide_payment_div').show();
    } else {
        $('#hide_payment_div').hide();
    }
    $('#view_pescription').html('<a target="blank_"href="' + frontend_path + data1.prescription + '" style="width: 50px;">Prescription</a>');
    var html = '';
    $.each(data1.documents[0], function(key, val) {

        html += '<a target="blank_" href="' + frontend_path + val['documents'] + '" style="width: 50px;">' + frontend_path + val['documents'] + '</a><br>';

    });
    $('#view_documents').html(html);
});
$(document).on("click", "#appointment_table tbody tr, .update_appointment_details tbody tr td", function() {
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
$(document).on("click", "#appointment_table tbody tr, .view_appointment_details tbody tr td", function() {
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
            var info = data.payment_detail;
            var payment_details = info.payment_details;
            var payment_history = info.payment_history;
            var advance_payment = data.advance_payment;
            var final_payment_details = data.final_payment_details;            
            var charges_payment_details = data.charges_payment_details;
            var payment_info = data.payment_info;
            var surgery_details = data.surgery_details;
                CKEDITOR.instances['discharge_summary'].setData(info['discharge_summary']);
            if(info['date_of_discharge'] != null){
                    $('#date_of_discharge').val(info['date_of_discharge']);
                    // $('#hide_add_charges').hide();
            }            
            
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
            $('#u_doctor').text(data1.doctor_first_name + " " + data1.doctor_last_name);
            $('#u_reference_doctor_name').text(data1.reference_doctor_name);
            $('#u_type_of_addmission').text(data1.type);
            if (data1.sub_type != null) {
                $('#u_sub_type_of_addmission').text(data1.sub_type);
                $('#hide_sub_type_of_addmission').show();
            } else {
                $('#hide_sub_type_of_addmission').hide();
            }

            $('#u_pescription').html('<a target="blank_"href="' + frontend_path + info.prescription + '" style="width: 50px;">Prescription</a>');
            var html = '';
            $.each(data1.documents[0], function(key, val) {
                html += '<a target="blank_" href="' + frontend_path + val['documents'] + '" style="width: 50px;">' + frontend_path + val['documents'] + '</a><br>';
            });
            $('#u_documents').html(html);

            var advance_html = '';
            var advance_grand_total= 0;
            $.each(advance_payment, function(advance_payment_key, advance_payment_row) { advance_html += '<div class="row"><div class="col-md-3"><div class="form-group"><label class="form-label">Advance Amount</label><div><span class="message_data" id="u_charges_name">' + advance_payment_row['amount'] + '</span></div></div></div><div class="col-md-3"><div class="form-group"><label for="u_amount" class="form-label">Payment Type</label><div><span class="message_data" id="u_amount">' + advance_payment[advance_payment_key]['payment_type'] + '</span></div></div></div><div class="col-md-3"><div class="form-group"><label for="u_amount" class="form-label">Date</label><div><span class="message_data" id="u_amount">' + advance_payment[advance_payment_key]['date'] + '</span></div></div></div><div class="col-md-3"><div class="form-group"><label for="u_amount" class="form-label">Download Receipt</label><div><a href='+advance_payment[advance_payment_key]['invoice_pdf']+' target="_blank">Receipt</a></div></div></div></div>';
            });
            $('#show_advance_amount').html(advance_html);

            var charges_payment_html = "";
            var charges_payment_html_1 = "";
            $.each(charges_payment_details, function(charges_payment_details_key, charges_payment_details_row) {
                if(charges_payment_details_row['date'] == info['date_of_discharge']){
                    $('#hide_add_charges').hide();
                    $('#hide_advance_charge_data').hide();
                    $('#hide_payment_details_data').show();
                    $('#hide_discharge_summary').show();
                    $('#hide_surgery_data_details').hide();

                }else{
                    $('#hide_payment_details_data').show();
                    $('#hide_discharge_summary').hide();
                }
                if(charges_payment_details_row['dr_name'] != ""){
                        charges_payment_html_1 = '<div class="col-md-3"><div class="form-group"><label class="form-label">Dr. Name</label><div><span class="message_data" id="u_charges_name">' + charges_payment_details_row['dr_name'] + '</span></div></div></div>';
                }else{
                    charges_payment_html_1 = '';
                }
                charges_payment_html += '<div class="row"><div class="col-md-3"><div class="form-group"><label class="form-label">Charge Name</label><div><span class="message_data" id="u_charges_name">' + charges_payment_details_row['charges_name'] + '</span></div></div></div>'+charges_payment_html_1+'<div class="col-md-3"><div class="form-group"><label for="u_amount" class="form-label">Amount</label><div><span class="message_data" id="u_amount">' + charges_payment_details_row['amount'] + '</span></div></div></div><div class="col-md-3"><div class="form-group"><label for="u_amount" class="form-label">Units</label><div><span class="message_data" id="u_amount">' + charges_payment_details_row['no_of_count'] + '</span></div></div></div><div class="col-md-3"><div class="form-group"><label for="u_amount" class="form-label">Total Amount (Amount * Units)</label><div><span class="message_data" id="u_amount">' + charges_payment_details_row['total_amount'] + '</span></div></div></div><div class="col-md-3"><div class="form-group"><label for="u_amount" class="form-label">Date</label><div><span class="message_data" id="u_amount">' + charges_payment_details_row['date'] + '</span></div></div></div></div>';
            });

            $('#total_amount_payable').text(payment_info.total_charges);
            $('#show_charges_amount_1').html(charges_payment_html);
            $('#u_payment_type').text(info['payment_type']);
            $('#advance_grand_total').text(payment_info.total_paid_amount);
            $('#grand_total').text(payment_info.remaining_amount);
            $('#previous_remaining_amount').val(info['previous_remaining_amount']);
            if(payment_info.remaining_amount == 0){
                $('#hide_payment_details_data_1').hide();
                 // $('#hide_add_charges').hide();
            }
            if (payment_details) {
                var charges_html = '';
                $.each(payment_details.charges_name, function(payment_details_key, payment_details_row) {
                    charges_html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="u_charges_name" class="form-label">Charges Name</label><div><span class="message_data" id="u_charges_name">' + payment_details_row + '</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Amount</label><div><span class="message_data" id="u_amount">' + payment_details.amount[payment_details_key] + '</span></div></div></div></div>';
                });
                $('#show_charges_amount').html(charges_html);
            }
            var amount_paid_html = '';
            $.each(payment_history, function(payment_history_key, payment_history_row) {
                amount_paid_html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label"> Amount</label><div><span class="message_data" id="u_amount">' + payment_history_row['amount'] + '</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Mediclaim Amount</label><div><span class="message_data" id="u_amount">' + payment_history_row['mediclaim_amount'] + '</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Total Paid Amount</label><div><span class="message_data" id="u_amount">' + payment_history_row['total_paid_amount'] + '</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Remaining Amount</label><div><span class="message_data" id="u_amount">' + payment_history_row['remaining_amount'] + '</span></div></div></div><input type="hidden" name="last_remaining_amount" value="' + payment_history_row['total_paid_amount'] + '"id="last_remaining_amount" class="last_remaining_amount"></div>';
               
            });
            $('#amount_paid_details').html(amount_paid_html);

            var final_payment_details_html = '';
            $.each(final_payment_details, function(final_payment_details_key, final_payment_details_row) {                

                final_payment_details_html += '<div class="row"><div class="col-md-3"><div class="form-group"><label for="u_amount" class="form-label">Payment Type</label><div><span class="message_data" id="u_amount">' + final_payment_details[final_payment_details_key]['payment_type'] + '</span></div></div></div><div class="col-md-3"><div class="form-group"><label class="form-label"> Amount</label><div><span class="message_data" id="u_charges_name">' + final_payment_details_row['amount'] + '</span></div></div></div><div class="col-md-3"><div class="form-group"><label class="form-label">Mediclaim Amount</label><div><span class="message_data" id="u_charges_name">' + final_payment_details_row['mediclaim_amount'] + '</span></div></div></div><div class="col-md-3"><div class="form-group"><label class="form-label">Total Amount</label><div><span class="message_data" id="u_charges_name">' + final_payment_details_row['total_amount'] + '</span></div></div></div><div class="col-md-3"><div class="form-group"><label for="u_amount" class="form-label">Date</label><div><span class="message_data" id="u_amount">' + final_payment_details[final_payment_details_key]['date'] + '</span></div></div></div><div class="col-md-3"><div class="form-group"><label for="u_amount" class="form-label">Download Receipt</label><div><a href='+final_payment_details[final_payment_details_key]['invoice_pdf']+' target="_blank">Receipt</a></div></div></div></div>';
            });
            $('#show_final_payment_details').html(final_payment_details_html);

            var up_total_sum = 0;
            var up_sum = 0;
            var last_remaining_amount = $('.last_remaining_amount').map(function() {
                return $(this).val();
            }).get();
            for (var i = 0; i < last_remaining_amount.length; i++) {
                var sum_11 = parseFloat(last_remaining_amount[i]);
                up_total_sum += up_sum + sum_11;

            }
            $('#total_remaining_amount').val(up_total_sum);

            var show_surgery_details_html='';
            $.each(surgery_details, function(surgery_details_key, surgery_details_row) {
                show_surgery_details_html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="" class="form-label">Surgery Date</label><div><span class="message_data">' + surgery_details_row['surgery_date'] + '</span></div></div></div></div>';
            });
           $('#show_surgery_details').append(show_surgery_details_html);
        },


    });
});
$(".date_payment").datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    todayHighlight: true,
    // startDate: "today",
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


$("#date_of_discharge").datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    todayHighlight: true,
    startDate: "today",
});

$(".advance_payment_date").datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    todayHighlight: true,    
});

$(".surgery_date").datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    todayHighlight: true,    
});
$('#add_appointment_advance_payment_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_appointment_advance_payment_details_form")[0]);
    var AddAdvancePaymentForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: AddAdvancePaymentForm.attr('action'),
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        beforeSend: function() {
            $('#add_appointment_advance_payment_details_button').button('loading');
        },
        success: function(response) {
            $('#add_appointment_advance_payment_details_button').button('reset');
            if (response.status == 'success') {
                $('#view_appointment_model').modal('hide');

                $('form#add_appointment_advance_payment_details_form').trigger('reset');
                 $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#Advance_Charges_append').html("");
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
$('#add_appointment_charges_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_appointment_charges_details_form")[0]);
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
            $('#add_appointment_charges_payment_details_button').button('loading');
        },
        success: function(response) {
            $('#add_appointment_charges_payment_details_button').button('reset');
            if (response.status == 'success') {
                $('form#add_appointment_charges_details_form').trigger('reset');
                $(".chosen-select-deselect").val('');
                $('.chosen-select-deselect').trigger("chosen:updated");
                $('#view_appointment_model').modal('hide');
                $('#appointment_table').DataTable().ajax.reload(null, false);
                $('#Charges_append').html("");
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
            html2 += '<div class="row"><div class="col-md-3"> <div class="form-group"> <label class="form-label">Select Charges</label> <select type="text" class="form-control chosen-select-deselect " name="charges[]" id="charges_' + new_count + '" data-placeholder="Select Charges">' + charges_option + ' </select> <span class="error_msg" id="fk_place_id_error"></span> </div></div><div class="col-md-3"><div class="form-group"><label for="dr_name" class="form-label">Dr. Name</label><input type="text" name="dr_name[]" id="dr_name_' + new_count + '" class="form-control input-text dr_name" placeholder="Enter Dr. Name"><span class="error_msg" id="dr_name_error"></span></div></div><div class="col-md-3"> <div class="form-group"> <label class="form-label">Amount</label> <input type="text" class="form-control input-text amount_charges" name="amount[]" id="amount_' + new_count + '" placeholder="Amount"> <span class="error_msg" id="amount_error"></span> </div></div><div class="col-md-3"><div class="form-group"><label for="unit" class="form-label">Units</label><input type="text" name="unit[]" id="unit_' + new_count + '" class="form-control input-text unit_charges" placeholder="Enter Unit"><span class="error_msg" id="unit_error"></span></div></div><div class="col-md-3"><div class="form-group"><label for="unit" class="form-label">Total Amount</label><input type="text" name="total_amount[]" id="total_amount_' + new_count + '" class="form-control input-text total_amount_charges" placeholder="Enter Total Amount"><span class="error_msg" id="total_amount_error"></span></div></div><div class="col-md-3"><div class="form-group"><label for="date" class="form-label required">Date</label><input type="text" class="form-control input-text date_payment" id="date_' + new_count + '" name="date[]" placeholder="Enter Your Date"><span class="error_msg" id="date_error"></span></div></div><button id="removeRow" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 49px; width: 38px;">-</button></div>';

            $('#Charges_append').append(html2);
            $("#count_details").val(new_count);
            $(".chosen-select-deselect").chosen({
                width: "100%",
            });
            $(".date_payment").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                // startDate: "today",
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

$('#add_appointment_final_payment_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_appointment_final_payment_details_form")[0]);
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
                $('form#add_appointment_final_payment_details_form').trigger('reset');
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
$('#cash_amount, #online_amount, #mediclaim_amount').on('input', function() {
    var cash_amount = parseInt($('#cash_amount').val());
    var online_amount = parseFloat($('#online_amount').val());
    var mediclaim_amount = parseFloat($('#mediclaim_amount').val());
    if (!cash_amount) {
        cash_amount = 0;
    }
    if (!online_amount) {
        online_amount = 0;
    }
    if (!mediclaim_amount) {
        mediclaim_amount = 0;
    }
    $('#total_paid_amount').val((cash_amount + online_amount + mediclaim_amount ? cash_amount + online_amount + mediclaim_amount : 0));

    var total_paid_amount = parseInt($('#total_paid_amount').val());
    var total_amount = parseFloat($('#total_amount').val());
    $('#remaining_amount').val((total_amount - total_paid_amount ? total_amount - total_paid_amount : 0));
});

$(document).on('input', '.amount_charges, .unit_charges', function(event) {
    var changeCountNumber = $(this).attr('id');
    var changeCountNumberArray = changeCountNumber.split("_");
    var changeCountNumber_1 = changeCountNumberArray[1];
    var amount_charges = parseInt($('#amount_'+changeCountNumber_1).val());
    var unit_charges = parseFloat($('#unit_'+changeCountNumber_1).val());
    if (!amount_charges) {
        amount_charges = 0;
    } 
    if(!unit_charges){
        unit_charges = 0;
    }
    var totalAmElementId = 'total_amount_'+changeCountNumber_1;
    $('#'+totalAmElementId).val((amount_charges * unit_charges ? amount_charges * unit_charges : 0));
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

$(document).on('input', function() {
    var final_amount = parseInt($('#final_amount').val());
    var up_mediclaim_amount = parseFloat($('#mediclaim_amount').val());
    if (!final_amount) {
        final_amount = 0;
    }
    if (!up_mediclaim_amount) {
        up_mediclaim_amount = 0;
    }
    $('#total_paid_amount').val((final_amount + up_mediclaim_amount ? final_amount + up_mediclaim_amount : 0));
});
$('#update_discharge_summary_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#update_discharge_summary_form")[0]);
    var AddDischargeSummaryForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: AddDischargeSummaryForm.attr('action'),
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        beforeSend: function() {
            $('#update_discharge_summary_button').button('loading');
        },
        success: function(response) {
            $('#update_discharge_summary_button').button('reset');
            if (response.status == 'success') {
                $('form#update_discharge_summary_form').trigger('reset');
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

$(document).on("change", "#date_of_discharge", function() {
        var date_of_discharge = $(this).val();
        var id = $('#edit_fk_appointment_id').val();
        $.ajax({
            type: "POST",
            url: frontend_path + "receptionist/update_discharge_date",
            data: { date_of_discharge: date_of_discharge,id: id },
            dataType: "json",
            cache: false,
            success: function(response) {
                 swal({
                    title: "success",
                    text: response.msg,
                    icon: "success",
                    dangerMode: true,
                    timer: 1500
                });
            },


        });
    });

$('#addRows_surgery_details').click(function() {
    var surgey_latest_count = $('#surgey_count_details').val();
    
    var surgey_new_count = parseInt(surgey_latest_count) + 1;
    console.log(surgey_new_count);
    $.ajax({
        type: "POST",
        url: frontend_path + "receptionist/get_payment_type_details",
        dataType: "json",
        cache: false,

        success: function(result) {
            var surgery_html = '';
            surgery_html += '<div class="row"><div class=col-md-3><div class=form-group><label class="form-label required"for=date>Surgery Date</label> <input class="form-control input-text surgery_date" id=surgery_date_"'+surgey_new_count+'" name="surgery_date[]" placeholder="Enter Date"> <span class=error_msg id=surgery_date_error></span></div></div><button id="removeRow_surgery" type="button" class="btn btn-danger btn-sm removeRow" style="height: 29px; margin-top: 49px; width: 38px;">-</button></div>';

            $('#Surgery_details_append').append(surgery_html);
            $("#surgey_count_details").val(surgey_new_count);
            $(".chosen-select-deselect").chosen({
                width: "100%",
            });
            $(".surgery_date").datepicker({
                format: 'dd-mm-yyyy',
                autoclose: true,
                todayHighlight: true,
                // startDate: "today",
            });
        },
    });

});
$(document).on('click', '#removeRow_surgery', function() {
    var surgey_latest_count = $('#surgey_count_details').val();
    var surgey_new_count = parseInt(surgey_latest_count) - 1;
    $('#surgey_count_details').val(surgey_new_count);
    $(this).closest("div").remove();
});

 $('#add_surgery_details_form').submit(function(e) {
    e.preventDefault();
    var formData = new FormData($("#add_surgery_details_form")[0]);
    var AddAdvancePaymentForm = $(this);
    jQuery.ajax({
        dataType: 'json',
        type: 'POST',
        url: AddAdvancePaymentForm.attr('action'),
        data: formData,
        cache: false,
        processData: false,
        contentType: false,
        mimeType: "multipart/form-data",
        beforeSend: function() {
            $('#add_surgery_details_button').button('loading');
        },
        success: function(response) {
            $('#add_surgery_details_button').button('reset');
            if (response.status == 'success') {
                $('#view_appointment_model').modal('hide');
                $('form#add_surgery_details_form').trigger('reset');
                $('#Surgery_details_append').html("");
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
 CKEDITOR.replace('discharge_summary', {
  skin: 'moono',
  enterMode: CKEDITOR.ENTER_BR,
  shiftEnterMode:CKEDITOR.ENTER_P,
  toolbar: [{ name: 'basicstyles', groups: [ 'basicstyles' ], items: [ 'Bold', 'Italic', 'Underline', "-", 'TextColor', 'BGColor' ] },
             { name: 'styles', items: [ 'Format', 'Font', 'FontSize' ] },
             { name: 'scripts', items: [ 'Subscript', 'Superscript' ] },
             { name: 'justify', groups: [ 'blocks', 'align' ], items: [ 'JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
             { name: 'paragraph', groups: [ 'list', 'indent' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent'] },
             { name: 'links', items: [ 'Link', 'Unlink' ] },
             { name: 'insert', items: [ 'Image'] },
             { name: 'spell', items: [ 'jQuerySpellChecker' ] },
             { name: 'table', items: [ 'Table' ] }
             ],
});

