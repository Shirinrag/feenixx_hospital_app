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
        {
            text: 'Excel',
            action: function ( e, dt, node, config ) {
                $.ajax({
                    url: frontend_path + "superadmin/get_all_patient_reports",
                    method: "POST",
                    data: {
                        id: data1.id,
                    },
                    dataType: "json",
                    success: function(data) {
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