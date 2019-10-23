// https://xdsoft.net/jqplugins/datetimepicker/
import "jquery-datetimepicker";

$('.js-datepicker').datetimepicker(
    {
        format: 'Y-m-d',
        dateFormat: "dd.mm.yy",
        showAnim: 'blind',
        inline: false,
        timepicker : false,
    },
);
$.datetimepicker.setLocale('de');


