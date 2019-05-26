// https://xdsoft.net/jqplugins/datetimepicker/
import "jquery-datetimepicker";

$('.js-datepicker').datetimepicker(
    {
        format: 'Y-m-d H:i:s',
        dateFormat: "dd.mm.yy",
        showAnim: 'blind',
        inline: true,
    },
);
$.datetimepicker.setLocale('de');


