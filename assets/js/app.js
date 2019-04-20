/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.

// loads the jquery package from node_modules
// const $ = require('jquery');
// import bootstrap from "bootstrap";


// import M from "materialize";


// import $ from "jquery";
var $ = require('jquery');

import 'material-icons';
//https://datatables.net/extensions/buttons/config
import '@material-ui/core/Button';
import "@material-ui/core/Icon";
import 'materialize-css';
import '@material/textfield';
//https://xdsoft.net/jqplugins/datetimepicker/
import "jquery-datetimepicker";
import "datatables.net-jqui";
import "datatables.net-buttons";
import "datatables.net-buttons-dt";
import "jquery-ui";
import "datatables.net-buttons/js/buttons.colVis.min";
import "datatables.net-buttons/js/buttons.flash.min";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.print.min";
import "select2";
import Highcharts from "highcharts";


if (typeof window !== 'undefined') {
    window.$ = $;
    window.jQuery = $;
    require('materialize-css');
}


// document.addEventListener('DOMContentLoaded', function () {
//     var elems = document.querySelectorAll('.sidenav');
//     var instances = M.Sidenav.init(elems, {
//         edge: 'left',
//         draggable: true,
//         inDuration: 250,
//         outDuration: 200,
//         onOpenStart: true,
//         onOpenEnd: true,
//         onCloseStart: false,
//         onCloseEnd: false,
//         preventScrolling: true
//     });
// });

document.addEventListener('DOMContentLoaded', function () {

});

document.addEventListener('DOMContentLoaded', function () {
    var Collapseelems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(Collapseelems, {
        accordion: 'true',
        onOpenStart: true,
        onOpenEnd: true,
        onCloseStart: false,
        onCloseEnd: false
    });


    var fixedelems = document.querySelectorAll('.fixed-action-btn');
    var instances = M.FloatingActionButton.init(fixedelems, {
        direction: 'top',
    });


    /**
     * Hicharts
     */
    var request = new XMLHttpRequest();
    request.open("GET", "/showAllBookingsChart", false);
    request.send(null);
    var bookingperday = JSON.parse(request.responseText);
    Highcharts.chart('bookingMonthContainer', {
        chart: {
            type: 'areaspline'
        },
        title: {
            text: 'Bookings this month'
        },

        // subtitle: {
        //     text: 'Source: thesolarfoundation.com'
        // },
        xAxis: {
            categories: bookingperday.dates
            // plotBands: [{ // visualize the weekend
            //     from: 4.5,
            //     to: 6.5,
            //     color: 'rgba(68, 170, 213, .2)'
            // }]
        },
        yAxis: {
            title: {
                text: 'Bookings '
            }
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            verticalAlign: 'top',
            x: 150,
            y: 100,
            floating: true,
            borderWidth: 1,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || '#FFFFFF'
        },

        // plotOptions: {
        //     series: {
        //         label: {
        //             connectorAllowed: true
        //         },
        //         pointStart: 2019,
        //         pointInterval: 24 * 3600 * 1000 // one day
        //     }
        // },

        series: [{
            name : 'booking/day',
            data : bookingperday.bookings
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        },

    });


    var request = new XMLHttpRequest();
    request.open("GET", "/showBookedRooms", false);
    request.send(null);
    var Rooms = JSON.parse(request.responseText);
    Highcharts.chart('roomsChartContainer', {
        chart: {
            plotBackgroundColor: null,
            plotBorderWidth: null,
            plotShadow: false,
            type: 'pie'
        },
        title: {
            text: 'Rooms'
        },
        tooltip: {
            pointFormat: '{series.name}: <b>{point.percentage:.1f}%</b>'
        },
        plotOptions: {
            pie: {
                allowPointSelect: true,
                cursor: 'pointer',
                dataLabels: {
                    enabled: true,
                    format: '<b>{point.name}</b>: {point.percentage:.1f} %',
                    style: {
                        color: (Highcharts.theme && Highcharts.theme.contrastTextColor) || 'blue'
                    }
                }
            }
        },
        series: [{
            name: 'Rooms',
            colorByPoint: true,
            data: [{
                name: 'Rooms free',
                y: Rooms.rooms,
                // sliced: true,
                // selected: true
            }, {
                name: 'Booked rooms',
                y: Rooms.bookings
            }]
        }]
    });


});


// Or with jQuery
$(document).ready(
    function () {
        $('#dataTable').DataTable(
            {
                // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                stateSave: true,
                columnDefs: [
                    {
                        targets: [0, 1, 2],
                        className: 'mdl-data-table__cell--non-numeric',
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            }
        );
        // https://xdsoft.net/jqplugins/datetimepicker/
        $('.js-datepicker').datetimepicker(
            {
                format: 'Y-m-d H:i:s',
                dateFormat: "dd.mm.yy",

                // dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
                // dayNamesMin: ['SO', 'MO', 'DI', 'MI', 'DO', 'FR', 'SA'],
                // monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai',
                //     'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                showAnim: 'blind',
                inline: true,
                // allowTimes:[
                //     '12:00', '13:00', '14:00', '15:00','16:00', '17:00', '18:05', '17:20', '19:00', '20:00'
                // ]
            },
        );
        $.datetimepicker.setLocale('de');

        // $('.fixed-action-btn').floatingActionButton();
        // https://select2.org/getting-started/basic-usage
        $('.js-example-basic-multiple').select2();

    }
);


