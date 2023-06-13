 function format(d) {
        var html = '';
        var cash_amount = d.cash_amount;
        if (cash_amount) {
            if (cash_amount.indexOf(',') > -1) {
                var cash_amount_1 = cash_amount.split(",");
            } else {
                var cash_amount_1 = [cash_amount];
            }

        } else {
            var cash_amount_1 = ['NA'];
        }

        var online_amount = d.online_amount;
        if (online_amount) {
            if (online_amount.indexOf(',') > -1) {
                var online_amount_1 = online_amount.split(",");
            } else {
                var online_amount_1 = [online_amount];
            }
        } else {
            var online_amount_1 = ['NA'];
        }


        var mediclaim_amount = d.mediclaim_amount;
        if (mediclaim_amount) {
            if (mediclaim_amount.indexOf(',') > -1) {
                var mediclaim_amount_1 = mediclaim_amount.split(",");
            } else {
                var mediclaim_amount_1 = [mediclaim_amount];
            }
        } else {
            var mediclaim_amount_1 = ['NA'];
        }
        var total_amount = d.total_amount;
        if (total_amount) {
            if (total_amount.indexOf(',') > -1) {
                var total_amount_1 = total_amount.split(",");
            } else {
                var total_amount_1 = [total_amount];
            }
        } else {
            var total_amount_1 = [0];
        }

        var date = d.date;
        if (date) {
            if (date.indexOf(',') > -1) {
                var date_1 = date.split(",");
            } else {
                var date_1 = [date];
            }
        } else {
            var date_1 = ['NA'];
        }

        var total_paid_amount = d.total_paid_amount;
        if (total_paid_amount) {
            if (total_paid_amount.indexOf(',') > -1) {
                var total_paid_amount_1 = total_paid_amount.split(",");
            } else {
                var total_paid_amount_1 = [total_paid_amount];
            }
        } else {
            var total_paid_amount_1 = ['NA'];
        }

        var remaining_amount = d.remaining_amount;
        if (remaining_amount) {
            if (remaining_amount.indexOf(',') > -1) {
                var remaining_amount_1 = remaining_amount.split(",");
            } else {
                var remaining_amount_1 = [remaining_amount];
            }
        } else {
            var remaining_amount_1 = ['NA'];
        }


        html +=
            '<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-hover">' +
            '<tr>' + '<th>Cash Amount</th>' + '<th>Online Amount</th>' + '<th>Mediclaim Amount</th>' + '<th>Total Amount</th>' + '<th>Paid Total Amount</th>' + '<th>Remaining Amount</th>'
            + '<th>Date</th>' + '</tr>';
        $.each(total_amount_1, function(total_amount_1_key, total_amount_1_val) {
            html += '<tr>' +
                '<td>' + cash_amount_1[total_amount_1_key] + '</td>' +
                '<td>' + online_amount_1[total_amount_1_key] + '</td>' +
                '<td>' + mediclaim_amount_1[total_amount_1_key] + '</td>' +
                '<td>' + total_amount_1_val + '</td>' +
                '<td>' + total_paid_amount_1[total_amount_1_key] + '</td>' +
                '<td>' + remaining_amount_1[total_amount_1_key] + '</td>' +
                '<td>' + date_1[total_amount_1_key] + '</td>' +
                '</tr>';
        });
        html += '</table>';
        return html;

    }

    $(document).ready(function() {
        var table = $('#report_table').DataTable({
            dom: 'Bfrtip',
        buttons: [
                    
                    'excel',
                    'csv',
                   
                ],
            "ajax": frontend_path + "superadmin/display_all_patient_report_details",
            "columns": [{
                    "className": 'details-control',
                    "orderable": false,
                    "data": null,
                    "defaultContent": ''
                },
                {
                    "data": "appointment_date"
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

            ],
            "order": [
                [1, 'asc']
            ]
        });

        // Add event listener for opening and closing details
        $('#report_table tbody').on('click', 'td.details-control', function() {
            var tr = $(this).closest('tr');
            var row = table.row(tr);

            if (row.child.isShown()) {
                // This row is already open - close it
                row.child.hide();
                tr.removeClass('shown');
            } else {
                // Open this row
                row.child(format(row.data())).show();
                tr.addClass('shown');
            }
        });
    });

// $(document).ready(function() {
//     table = $('#report_table').DataTable({
//         dom: 'Bfrtip',
//         buttons: [
                    
//                     'excel',
//                     'csv',
                   
//                 ],
//         "ajax": frontend_path + "superadmin/display_all_patient_report_details",
         
//         "columns": [{
//                 "data": null
//             },
//             {
//                 "data": "appointment_date"
//             },
//             // {
//             //     "data": null
//             // },
//             {
//                 "data": "patient_id"
//             },
//             {
//                 "data": "first_name",
//                 "render": function ( data, type, row, meta ) {
                  
//                     var html="";
//                      html= data+" "+row.last_name;
//                      return html;
//                   },
//             },
//             {
//                 "data": "gender"
//             },
//             { "data": "contact_no"},
//             {
//                 "data": "doctor_first_name",
//                   "render": function ( data, type, row, meta ) {
                  
//                     var html="";
//                      html= data+" "+row.doctor_last_name;
//                      return html;
//                   },
//             },
//             {
//                 "data": "cash_amount"
//             },
//             {
//                 "data": "online_amount"
//             },
//             {
//                 "data": "mediclaim_amount"
//             },
//             {
//                 "data": "discount_amount"
//             },
//             {
//                 "data": "total_amount"
//             },
//         ],
//         "order": [
//             [0, 'desc']
//         ]
//     });
//     table.on('order.dt search.dt', function() {
//         table.column(0, {
//             search: 'applied',
//             order: 'applied'
//         }).nodes().each(function(cell, i) {
//             cell.innerHTML = i + 1;
//         });

//     }).draw();
// });
// $(document).on("click","#appointment_table tbody tr, .view_appointment_details tbody tr td",function(){
//     var tr = $(this).closest('tr');
//     var row = table.row(tr);
//     var data1 = row.data();
    
//     $('#view_patient_id').text(data1.patient_id);
//     $('#view_first_name').text(data1.first_name);
//     $('#view_last_name').text(data1.last_name);
//     $('#view_blood_group').text(data1.blood_group);
//     $('#view_email').text(data1.email);
//     $('#view_contact_no').text(data1.contact_no);
//     $('#view_appointment_date').text(data1.appointment_date);
//     $('#view_appointment_time').text(data1.appointment_time);
//     $('#view_description').text(data1.description);
//     $('#view_diseases').text(data1.diseases_name);
//     $('#view_payment_type').text(data1.payment_type);
//     $('#view_cash_amount').text(data1.cash_amount);
//     $('#view_online_amount').text(data1.online_amount);
//     $('#view_mediclaim_amount').text(data1.mediclaim_amount);
//     $('#view_discount').text(data1.discount);
//     $('#view_total_amount').text(data1.total_amount);
//     $('#view_pescription').html('<a target="blank_"href="'+frontend_path+data1.prescription+'" style="width: 50px;">Prescription</a>');
//     // $('#view_pescription').html('<a target="blank_" href="'+frontend_path+data1.prescription+'" style="width: 50px;">'+frontend_path+data1.prescription+'</a>');
//     var html ='';
//     $.each(data1.documents[0], function (key, val) {
       
//         html +='<a target="blank_" href="'+frontend_path+val['documents']+'" style="width: 50px;">'+frontend_path+val['documents']+'</a><br>';
        
//     });
//     $('#view_documents').html(html);
    

// });