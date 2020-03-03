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
// global stuff
const Dashboard_Highcharts = require("./components/index/highcharts");
const Collapsed = require("./components/helper/collapsed");
const DropDownButtons = require("./components/helper/dropdownbuttons");
const Global_Actionbuttons = require("./components/helper/actionbuttons");
// Booking JS
const Booking_AddEntitiesToForm = require("./components/booking/booking_add_formulars");
const Booking_CreateBookingForm = require("./components/booking/booking_form_new");
const Booking_SaveForm = require("./components/booking/booking_form_save");
// Guest
const Guest_CaptureWebcamImage = require("./components/guest/capture_webcam");
const Guest_SearchGuest = require("./components/guest/guest_form_searchguest");
/**
 * Nativ JS stuff
 */
document.addEventListener('DOMContentLoaded', function() {
    var elems = document.querySelectorAll('.datepicker');
    var instances = M.Datepicker.init(elems, {
        format: 'YYYY-mm-dd',
        minDate: new Date(1999, 10 - 1, 25)
    });
    Dashboard_Highcharts;
    Global_Actionbuttons;

    Booking_AddEntitiesToForm;
    Booking_CreateBookingForm;
    Booking_SaveForm;
    Collapsed;
    DropDownButtons;

    Guest_CaptureWebcamImage;
    Guest_SearchGuest;

});
/**
 *
 *
 *
 *
 * jQuery stuff
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
const Guest_Datatable = require("./components/guest/guest_jquery_datatable");
const Room_Datatable = require("./components/room/room_jquery_datatable");
const Booking_Datepicker = require("./components/booking/booking_jquery_datetimepicker");
const Guest_Datepicker = require("./components/guest/guest_jquery_datetimepicker");
const Global_DateTimePicker = require("./components/helper/jquery_datetimepicker");
// const GlobalMultipleSelect = require("./components/helper/jquery_multipleselect");
// Or with jQuery
$(document).ready(
    function() {
        Guest_Datatable;
        Guest_Datepicker;

        Room_Datatable;

        Booking_Datepicker;

        Global_DateTimePicker;
    }
);