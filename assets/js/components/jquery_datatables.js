import "datatables.net-jqui";
import "datatables.net-buttons";
import "datatables.net-buttons-dt";
// Datatable Button for export
import "datatables.net-buttons/js/buttons.colVis.min";
import "datatables.net-buttons/js/buttons.flash.min";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.print.min";

const axios = require("axios");

let dataTableRooms = document.getElementById('dataTableRooms');
if (dataTableRooms) {
    axios.get('/room/overview')
        .then(
            function (response) {
                $('#dataTableRooms').DataTable(
                    {
                        responsive: true,
                        stateSave: true,
                        // oLanguage: {
                        //     sSearch: "Find the bond you need:",
                        //     language: {searchPlaceholder: "Search records"}
                        // },
                        data: response.data,
                        columns: [
                            {data: 'name'},
                            {data: 'house'},
                            {data: 'floor'},
                            {data: 'beds'},
                            {
                                "data": null,
                            }
                        ],
                        columnDefs: [
                            {
                                targets: 4,
                                render: function (data, type, row, meta) {
                                    if (type === 'display') {
                                        data = '<a href="/guest/' + data.id + '">Show</a>';
                                    }
                                    return data;
                                }
                            }
                        ],
                        // dom: '<flip>',
                        dom: "<'col s12'" +
                            "<'row'" +
                            "<'col s1'l>" +
                            "<'col s11'B>" +
                            "<'col s12'f>" +
                            ">" +
                            "<'row dt-table'" +
                            "<'sixteen wide column'tr>" +
                            ">" +
                            "<'row'" +
                            "<'seven wide column'i>" +
                            "<'right aligned nine wide column'p>" +
                            ">" +
                            ">",
                        buttons: [
                            {
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
                    }
                );
            }
        )
        .finally(function () {
            $('.spinner').fadeOut("fast", function () {
                $('#datatablewrapper').fadeIn();
            });

        });
}


let dataTableGuests = document.getElementById('dataTableGuests');
if (dataTableGuests) {
    axios.get('/guest/overview')
        .then(
            function (response) {
                $('#dataTableGuests').DataTable(
                    {
                        responsive: true,
                        stateSave: true,
                        // oLanguage: {
                        //     sSearch: "Find the bond you need:",
                        //     language: {searchPlaceholder: "Search records"}
                        // },
                        data: response.data,
                        columns: [
                            {data: 'id'},
                            {data: 'lastname'},
                            {data: 'firstname'},
                            {data: 'birthday'},
                            {
                                "data": null,
                            }
                        ],
                        columnDefs: [
                            {
                                targets: 4,
                                render: function (data, type, row, meta) {
                                    if (type === 'display') {
                                        data = '<a href="/guest/' + data.id + '">Show</a>';
                                    }
                                    return data;
                                }
                            }
                        ],
                        // dom: '<flip>',
                        dom: "<'col s12'" +
                            "<'row'" +
                            "<'col s1'l>" +
                            "<'col s11'B>" +
                            "<'col s12'f>" +
                            ">" +
                            "<'row dt-table'" +
                            "<'sixteen wide column'tr>" +
                            ">" +
                            "<'row'" +
                            "<'seven wide column'i>" +
                            "<'right aligned nine wide column'p>" +
                            ">" +
                            ">",
                        buttons: [
                            {
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
                    }
                );
            }
        )
        .finally(function () {
            $('.spinner').fadeOut("fast", function () {
                $('#datatablewrapper').fadeIn();
            });

        });
}



$('#dataTableRooms_filter > label > input[type=search]').attr("placeholder", "enter seach terms here");
