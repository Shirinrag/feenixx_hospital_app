$(document).ready(function() {
    table = $('#superadin_appointment_table').DataTable({
        "ajax": frontend_path + "superadmin/display_all_appointment_details",
        
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
            {
                "data": null,
                "render": function ( data, type, row, meta ) {
                     var html="";
                     if(row.invoice_pdf == null){
                        html += '';                       
                     }else{
                         html += '<span><a href="'+row.invoice_pdf+'" data-toggle="tooltip" class="mr-1 ml-1" title="Download Invoice" target="_blank" ><i class="bi bi-download" style="font-size: 150%;"></i></a></span>';
                     }
                     return html;
                  },
              },
            {
                "data": null,
                "render": function(data, type, row, meta) {
                    var html2 = "";
                    if (row.discharge_summary_pdf == null) {
                        html2 += '';

                    } else {
                        html2 += '<span><a href="' + row.discharge_summary_pdf + '" data-toggle="tooltip" class="mr-1 ml-1" title="Download Discharge Summary" target="_blank" ><i class="bi bi-download" style="font-size: 150%;"></i></a></span>';
                    }
                    return html2;
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
$(document).on("click","#superadin_appointment_table tbody tr, .view_appointment_details tbody tr td",function(){
    var tr = $(this).closest('tr');
    var row = table.row(tr);
    var data1 = row.data();

    $.ajax({
        url: frontend_path + "superadmin/get_payment_data_on_appointment_id",
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
            $('#discharge_summary').html( info['discharge_summary']);
            $('#view_patient_id').text(info['patient_id']);
            $('#view_first_name').text(info['first_name']);
            $('#view_last_name').text(info['last_name']);
            $('#view_email').text(info['email']);
            $('#view_contact_no').text(info['contact_no']);
            $('#view_blood_group').text(info['blood_group']);
            $('#view_diseases').text(info['diseases_name']);
            $('#view_description').text(info['description']);
            $('#view_date_of_discharge').text(info['date_of_discharge'])
            $('#view_doctor').text(data1.doctor_first_name + " " + data1.doctor_last_name);
            $('#view_reference_doctor_name').text(data1.reference_doctor_name);
            $('#view_type_of_addmission').text(data1.type);
            if (data1.sub_type != null) {
                $('#u_sub_type_of_addmission').text(data1.sub_type);
                $('#hide_sub_type_of_addmission').show();
            } else {
                $('#hide_sub_type_of_addmission').hide();
            }

            if(info['admission_type'] ==1){
                $('#hide_surgery_data').hide();
                $('#hide_advance_charge_data').hide();
                $('#hide_discharge_summary').hide();
            }else if(info['admission_type'] ==2){
                $('#hide_surgery_data').show();
                $('#hide_advance_charge_data').show();
                $('#hide_discharge_summary').show();

            }

            $('#view_pescription').html('<a target="blank_"href="' + frontend_path + info.prescription + '" style="width: 50px;">Prescription</a>');
            var html = '';
            $.each(data1.documents[0], function(key, val) {
                html += '<a target="blank_" href="' + frontend_path + val['documents'] + '" style="width: 50px;">' + frontend_path + val['documents'] + '</a><br>';
            });
            $('#view_documents').html(html);

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

