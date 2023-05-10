$(document).ready(function() {
    table = $('#report_table').DataTable({
        dom: 'Bfrtip',
        buttons: [
                    
                    'excel',
                    'csv',
                   
                ],
        "ajax": frontend_path + "superadmin/display_all_patient_report_details",
         
        "columns": [{
                "data": null
            },
            {
                "data": "appointment_date"
            },
            // {
            //     "data": null
            // },
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
            {
                "data": "gender"
            },
            { "data": "contact_no"},
            {
                "data": "doctor_first_name",
                  "render": function ( data, type, row, meta ) {
                  
                    var html="";
                     html= data+" "+row.doctor_last_name;
                     return html;
                  },
            },
            {
                "data": "cash_amount"
            },
            {
                "data": "online_amount"
            },
            {
                "data": "mediclaim_amount"
            },
            {
                "data": "discount_amount"
            },
            {
                "data": "total_amount"
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