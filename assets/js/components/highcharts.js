import Highcharts from "highcharts";


// https://github.com/axios/axios
const axios = require("axios");

/**
 * Hicharts
 */
let bookingMonthContainer = document.getElementById('bookingMonthContainer');
if (bookingMonthContainer) {
    axios.get("/showAllBookingsChart")
        .then(
            function (response) {
                const bookingperday = response.data;
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
                        name: 'booking/day',
                        data: bookingperday.bookings
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
            });
}

let roomsChartContainer = document.getElementById('roomsChartContainer');
if (roomsChartContainer) {
    axios.get("/showBookedRoomsbymonth")
        .then(function (response) {
            const Rooms = response.data;
            Highcharts.chart('roomsChartContainer', {
                chart: {
                    plotBackgroundColor: null,
                    plotBorderWidth: null,
                    plotShadow: false,
                    type: 'pie'
                },
                title: {
                    text: 'Room utilization'
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
                        name: 'Rooms vacant',
                        y: Rooms.rooms,
                        // sliced: true,
                        // selected: true
                    }, {
                        name: 'Booked room',
                        y: Rooms.bookings
                    }]
                }]
            });
        });
}
