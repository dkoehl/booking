// https://xdsoft.net/jqplugins/datetimepicker/
import "jquery-datetimepicker";

$('#booking_bookingfrom').datetimepicker({
    format: 'Y-m-d',
    dateFormat: "dd.mm.yy",
    showAnim: 'blind',
    inline: false,
    timepicker: false,
    startDate: new Date(),
    weeks: true,
    onShow: function(ct) {
        this.setOptions({
            maxDate: $('#booking_bookingtill').val() ? $('#booking_bookingtill').val() : false
        })
    },
});

$('#booking_bookingtill').datetimepicker({
    format: 'Y-m-d',
    dateFormat: "dd.mm.yy",
    showAnim: 'blind',
    inline: false,
    timepicker: false,
    startDate: new Date(),
    weeks: true,
    onShow: function(ct) {
        this.setOptions({
            minDate: jQuery('#booking_bookingfrom').val() ? jQuery('#booking_bookingfrom').val() : false
        })
    },
});

$.datetimepicker.setLocale('de');