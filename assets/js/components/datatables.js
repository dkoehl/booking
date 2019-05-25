import "datatables.net-jqui";
import "datatables.net-buttons";
import "datatables.net-buttons-dt";
// Datatable Button for export
import "datatables.net-buttons/js/buttons.colVis.min";
import "datatables.net-buttons/js/buttons.flash.min";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.print.min";

const axios = require("axios");

let dataTable = document.getElementById('dataTable');
if (dataTable) {
    axios.get('/room/overview')
        .then(
            function (response) {
                $('#dataTable').DataTable(
                    {
                        stateSave: true,
                        data: response.data,
                        columns: [
                            {data: 'name'},
                            {data: 'house'},
                            {data: 'floor'},
                            {data: 'beds'}
                        ],
                        dom: 'Bfrtip',
                        buttons: [
                            {
                                extend: 'copy',
                                text: '<i class="material-icons">person</i> Copy',
                                titleAttr: 'Copy'
                            },
                            {
                                extend: 'csv',
                                text: '<i class="material-icons">person</i> csv',
                                titleAttr: 'csv'
                            },
                            {
                                extend: 'excel',
                                text: '<i class="material-icons">person</i> excel',
                                titleAttr: 'excel'
                            },
                            {
                                extend: 'pdf',
                                text: '<i class="material-icons">person</i> pdf',
                                titleAttr: 'pdf'
                            },
                            {
                                extend: 'print',
                                text: '<i class="material-icons">person</i> print',
                                titleAttr: 'print'
                            }
                        ],
                    }
                );
            }
        )
}


// https://xdsoft.net/jqplugins/datetimepicker/
$('.js-datepicker').datetimepicker(
    {
        format: 'Y-m-d H:i:s',
        dateFormat: "dd.mm.yy",
        showAnim: 'blind',
        inline: true,
    },
);
$.datetimepicker.setLocale('de');

// $('.fixed-action-btn').floatingActionButton();
// https://select2.org/getting-started/basic-usage
$('.js-example-basic-multiple').select2();