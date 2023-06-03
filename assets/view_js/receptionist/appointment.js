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
$('#cash_amount, #online_amount, #mediclaim_amount, #discount').on('input',function() {
    var cash_amount = parseInt($('#cash_amount').val());
    var online_amount = parseFloat($('#online_amount').val());
    var mediclaim_amount = parseFloat($('#mediclaim_amount').val());
    var discount = parseFloat($('#discount').val());
    $('#total_amount').val((cash_amount + online_amount + mediclaim_amount - discount ? cash_amount + online_amount + mediclaim_amount - discount : 0));
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
                "className": "view_appointment_details",
                "defaultContent": '<span><span><a href="javascript:void(0);" data-toggle="tooltip" class="mr-1 ml-1" title="View Details" ><i class="bi bi-eye edit_doctor_data" aria-hidden="true" data-bs-toggle="modal" data-bs-target="#view_appointment_model"></i></a></span>'
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
$("#appointment_date").datepicker({
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