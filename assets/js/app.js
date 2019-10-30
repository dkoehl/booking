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
import * as mdc from 'material-components-web';
mdc.autoInit();

const Highcharts = require ("./components/highcharts");
const Collapsed = require ("./components/collapsed");
const DropDownButtons = require("./components/dropdownbuttons");
const Actionbuttons = require("./components/actionbuttons");
const BookingVacancies = require ("./components/bookingform");
const BookingUserSearch = require ("./components/bookingform_searchguest");
const BookingFormAddForms = require("./components/booking_add_formulars");
const BokkingFormSaveForms = require('./components/booking_save_formulars');
/**
 * Nativ JS stuff
 */
document.addEventListener('DOMContentLoaded', function () {

    Highcharts;
    Collapsed;
    DropDownButtons;
    Actionbuttons;
    BookingVacancies;
    BookingUserSearch;
    BookingFormAddForms;

});
/**
 *
 *
 *
 *
 * jquery stuff
 *
 *
 *
 *
 *
 */
if (typeof window !== 'undefined') {
    window.$ = $;
    window.jQuery = $;
    require('materialize-css');
}
const DataTables = require ("./components/jquery_datatables");
const DateTimePicker = require ("./components/jquery_datetimepicker");
const MultipleSelect = require ("./components/jquery_multipleselect");
// Or with jQuery
$(document).ready(
    function () {
        DataTables;
        DateTimePicker;
        MultipleSelect;

    }
);


