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

                $('#view_doctor').text(data1.doctor_first_name+ " "+data1.doctor_last_name);
                $('#view_reference_doctor_name').text(data1.reference_doctor_name);
                $('#view_type_of_addmission').text(data1.type);
                if(data1.sub_type!= null){
                     $('#view_sub_type_of_addmission').text(data1.sub_type);
                     $('#hide_sub_type_of_addmission').show();
                }else{
                    $('#hide_sub_type_of_addmission').hide();
                }
                $('#view_pescription').html('<a target="blank_"href="'+frontend_path+data1.prescription+'" style="width: 50px;">Prescription</a>');
                var html ='';
                    $.each(data1.documents[0], function (key, val) {
                        html +='<a target="blank_" href="'+frontend_path+val['documents']+'" style="width: 50px;">'+frontend_path+val['documents']+'</a><br>';
                    });
                $('#view_documents').html(html);
                $('#view_payment_type').text(info['payment_type']);
                $('#u_discount_amount').text(payment_details['discount']);
                $('#u_total_amount').text(payment_details['total_amount']);

                var charges_html = '';
                 $.each(payment_details.charges_name, function (payment_details_key, payment_details_row) {
                    charges_html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="u_charges_name" class="form-label">Charges Name</label><div><span class="message_data" id="u_charges_name">'+payment_details_row+'</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Amount</label><div><span class="message_data" id="u_amount">'+payment_details.amount[payment_details_key]+'</span></div></div></div></div>';
                });
                 $('#show_charges_amount').html(charges_html);

                 var amount_paid_html = '';
                 $.each(payment_history, function (payment_history_key, payment_history_row) {
                    amount_paid_html += '<div class="row"><div class="col-md-4"><div class="form-group"><label for="u_charges_name" class="form-label">Online Payment</label><div><span class="message_data" id="u_charges_name">'+payment_history_row['online_amount']+'</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Cash Amount</label><div><span class="message_data" id="u_amount">'+payment_history_row['cash_amount']+'</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Mediclaim Amount</label><div><span class="message_data" id="u_amount">'+payment_history_row['mediclaim_amount']+'</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Total Paid Amount</label><div><span class="message_data" id="u_amount">'+payment_history_row['total_paid_amount']+'</span></div></div></div><div class="col-md-4"><div class="form-group"><label for="u_amount" class="form-label">Remaining Amount</label><div><span class="message_data" id="u_amount">'+payment_history_row['remaining_amount']+'</span></div></div></div></div>';
                    if(payment_history_row['remaining_amount']==0){
                        $('#hide_charges').hide();
                    }
                });
                $('#amount_paid_details').html(amount_paid_html);
            },
            });

});

