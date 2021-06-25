import "datatables.net-jqui";
import "datatables.net-buttons";
import "datatables.net-buttons-dt";
// Datatable Button for export
import "datatables.net-buttons/js/buttons.colVis.min";
import "datatables.net-buttons/js/buttons.flash.min";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.print.min";
//https://datatables.net/extensions/buttons/config
const axios = require("axios");
/**
 * Displays datatable 
 */
let dataTableGuests = document.getElementById('dataTableGuests');
if (dataTableGuests) {
    axios.get('/guest/overview')
        .then(
            function(response) {
                $('#dataTableGuests').DataTable({
                    responsive: true,
                    stateSave: true,
                    oLanguage: {
                        sSearch: " ",
                        language: { searchPlaceholder: "Search records" }
                    },
                    data: response.data,
                    language: {
                        searchPlaceholder: "Search"
                    },
                    columns: [
                        { data: 'id' },
                        { data: 'lastname' },
                        { data: 'firstname' },
                        { data: 'birthday', type: 'date-dd-mmm-yyyy', targets: 0 },
                        {
                            "data": null,
                        }
                    ],
                    columnDefs: [{
                            targets: 3,
                            render: function(data, type, row, meta) {
                                let birthDate = new Date(data);
                                return birthDate.toLocaleDateString();
                            }
                        },
                        {
                            targets: 4,
                            render: function(data, type, row, meta) {
                                if (type === 'display') {
                                    data = '<a class="blue-grey-text" href="/guest/' + data.id + '"><i class="material-icons">more_horiz</i></a>';
                                }
                                return data;
                            }
                        }
                    ],
                    // dom: '<flip>',
                    dom: "<'col s12'" +
                        "<'row'" +
                        "<'col s6'l>" +
                        "<'col s6'B>" +
                        "<'col s12'f>" +
                        ">" +
                        "<'row dt-table'" +
                        "<'sixteen wide column'tr>" +
                        ">" +
                        "<'row'" +
                        "<'footerline wide column'i>" +
                        "<'right aligned nine wide column'p>" +
                        ">" +
                        ">",
                    buttons: [{
                            extend: 'copy',
                            text: '<i class="material-icons blue-grey-text">file_copy</i> Copy',
                            titleAttr: 'Copy'
                        },
                        {
                            extend: 'csv',
                            text: '<i class="material-icons blue-grey-text">grid_on</i> CSV',
                            titleAttr: 'csv'
                        },
                        {
                            extend: 'excel',
                            text: '<i class="material-icons blue-grey-text">person</i> excel',
                            titleAttr: 'excel'
                        },
                        {
                            extend: 'pdf',
                            text: '<i class="material-icons blue-grey-text">person</i> pdf',
                            titleAttr: 'pdf'
                        },
                        {
                            extend: 'print',
                            text: '<i class="material-icons blue-grey-text">print</i> Print',
                            titleAttr: 'print'
                        }
                    ],
                });
            }
        )
        .finally(function() {
            $('.spinner').fadeOut("fast", function() {
                $('#datatablewrapper').fadeIn();
            });

        });
}
