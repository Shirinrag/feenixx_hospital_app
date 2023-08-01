 function format(d) {
        var html = '';
        var amount = d.amount;
        if (amount) {
            if (amount.indexOf(',') > -1) {
                var amount_1 = amount.split(",");
            } else {
                var amount_1 = [amount];
            }
        } else {
            var amount_1 = ['NA'];
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
        html +=
            '<table cellpadding="0" cellspacing="0" border="0" class="table table-bordered table-striped table-hover">' +
            '<tr>' + '<th>Amount</th>' + '<th>Mediclaim Amount</th>' + '<th>Total Amount</th>' + '<th>Date</th>' + '</tr>';
        $.each(total_amount_1, function(total_amount_1_key, total_amount_1_val) {
            html += '<tr>' +
                '<td>' + amount_1[total_amount_1_key] + '</td>' +
                '<td>' + mediclaim_amount_1[total_amount_1_key] + '</td>' +
                '<td>' + total_amount_1_val + '</td>' +
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
                    // 'excel'

                    {
                        extend: "excel",
                        action: function ( e, dt, node, config ) {
                            // console.log("in");
                             $.ajax({
                                    type: "POST",
                                    url: frontend_path + "superadmin/display_all_patient_report",
                                    data: {
                                        state: 1
                                    },
                                    dataType: "json",
                                    success: function(result) {
                                        if(result.status == 'success'){
                                            window.open(result.url);
                                        } else {
                                            
                                        }
                                        
                                    },
                                });


                        }
                    }
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
            { "data": "total_charges"},
            { "data": "total_paid_amount"},
            { "data": "remaining_amount"},

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