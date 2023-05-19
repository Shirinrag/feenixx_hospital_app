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

