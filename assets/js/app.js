/*
 * Welcome to your app's main JavaScript file!
 *
 * We recommend including the built version of this JavaScript file
 * (and its CSS file) in your base layout (base.html.twig).
 */

// any CSS you require will output into a single css file (app.css in this case)
import '../css/app.css';

// Need jQuery? Install it with "yarn add jquery", then uncomment to require it.

var $ = require('jquery');
import "jquery-ui";


import 'materialize';
import 'materialize-css';
import 'material-icons';



//https://datatables.net/extensions/buttons/config

//https://xdsoft.net/jqplugins/datetimepicker/
import "jquery-datetimepicker";
import "select2";


const Highcharts = require ("./components/highcharts");
const Collapsed = require ("./components/collapsed");
const DropDownButtons = require("./components/dropdownbuttons");
const Actionbuttons = require("./components/actionbuttons");


document.addEventListener('DOMContentLoaded', function () {
    Highcharts;
    Collapsed;
    DropDownButtons;
    Actionbuttons;
});



if (typeof window !== 'undefined') {
    window.$ = $;
    window.jQuery = $;
    require('materialize-css');
}
const DataTables = require ("./components/datatables");
// Or with jQuery
$(document).ready(
    function () {
        DataTables;
    }
);


