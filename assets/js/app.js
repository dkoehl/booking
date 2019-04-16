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
import '@material-ui/core/Button';
import "@material-ui/core/Icon";
import 'materialize-css';

import "jquery-datetimepicker";
import "datatables.net-jqui";
import "datatables.net-buttons";
import "datatables.net-buttons-dt";
import "jquery-ui";
import "datatables.net-buttons/js/buttons.colVis.min";
import "datatables.net-buttons/js/buttons.flash.min";
import "datatables.net-buttons/js/buttons.html5";
import "datatables.net-buttons/js/buttons.print.min";
import "jquery-datetimepicker";


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
    var elems = document.querySelectorAll('.collapsible');
    var instances = M.Collapsible.init(elems, {
        accordion: 'true',
        onOpenStart: true,
        onOpenEnd: true,
        onCloseStart: false,
        onCloseEnd: false
    });
});

// Initialize collapsible (uncomment the lines below if you use the dropdown variation)
// var collapsibleElem = document.querySelector('.collapsible');
// var collapsibleInstance = M.Collapsible.init(collapsibleElem, options);

// Or with jQuery

// $(document).ready(function(){
//     // $('.sidenav').sidenav();
// });
// // topbar
// import {MDCTopAppBar} from '@material/top-app-bar/index';
//
// // Instantiation
// const topAppBarElement = document.querySelector('.mdc-top-app-bar');
// const topAppBar = new MDCTopAppBar(topAppBarElement);

$(document).ready(
    function () {
        $('#dataTable').DataTable(
            {
                // "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "All"]],
                stateSave: true,
                columnDefs: [
                    {
                        targets: [ 0, 1, 2 ],
                        className: 'mdl-data-table__cell--non-numeric',
                    }
                ],
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'csv', 'excel', 'pdf', 'print'
                ]
            }
        );
        $('.js-datepicker').datetimepicker(
            {
                format:'Y-m-d H:i:s',
                dateFormat: "dd.mm.yy",
                firstDay: 1,
                minDate: 0,
                showButtonPanel: true,
                closeText: 'Kalender schließen',
                currentText: 'Heute',
                dayNames: ['Sonntag', 'Montag', 'Dienstag', 'Mittwoch', 'Donnerstag', 'Freitag', 'Samstag'],
                dayNamesMin: ['SO', 'MO', 'DI', 'MI', 'DO', 'FR', 'SA'],
                monthNames: ['Januar', 'Februar', 'März', 'April', 'Mai',
                    'Juni', 'Juli', 'August', 'September', 'Oktober', 'November', 'Dezember'],
                showAnim: 'blind'
            }
        );


    }
);


