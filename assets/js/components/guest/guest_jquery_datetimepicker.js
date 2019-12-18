// https://xdsoft.net/jqplugins/datetimepicker/
import "jquery-datetimepicker";

let today = new Date();
today.setDate(today.getDate() - 6570);

$('#guest_birthday').datetimepicker({
    format: 'Y-m-d',
    dateFormat: "dd.mm.yy",
    showAnim: 'blind',
    inline: false,
    timepicker: false,
    inline: false,
    startDate: today
});
$.datetimepicker.setLocale('de');