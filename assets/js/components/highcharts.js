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
        .then(
            function (response) {
                const Rooms = response.data;
                Highcharts.chart(
                    'roomsChartContainer', {
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



let demoContainer = document.getElementById('demoContainer');
if (demoContainer) {
    Highcharts.chart('demoContainer', {

        title: {
            text: 'Bookings over the years'
        },

        subtitle: {
            text: 'Source: thesolarfoundation.com'
        },

        yAxis: {
            title: {
                text: 'Number of Employees'
            }
        },
        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        plotOptions: {
            series: {
                label: {
                    connectorAllowed: false
                },
                pointStart: 2010
            }
        },

        series: [{
            name: 'Installation',
            data: [43934, 52503, 57177, 69658, 97031, 119931, 137133, 154175]
        }, {
            name: 'Manufacturing',
            data: [24916, 24064, 29742, 29851, 32490, 30282, 38121, 40434]
        }, {
            name: 'Sales & Distribution',
            data: [11744, 17722, 16005, 19771, 20185, 24377, 32147, 39387]
        }, {
            name: 'Project Development',
            data: [null, null, 7988, 12169, 15112, 22452, 34400, 34227]
        }, {
            name: 'Other',
            data: [12908, 5948, 8105, 11248, 8989, 11816, 18274, 18111]
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
        }
    });

}


let seconddemoContainer = document.getElementById('seconddemoContainer');
if (seconddemoContainer) {
    Highcharts.chart('seconddemoContainer', {
        chart: {
            zoomType: 'xy'
        },
        title: {
            text: 'Average Monthly'
        },
        subtitle: {
            text: 'Source: WorldClimate.com'
        },
        xAxis: [{
            categories: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun',
                'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            crosshair: true
        }],
        yAxis: [{ // Primary yAxis
            labels: {
                format: '{value}°C',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            },
            title: {
                text: 'Temperature',
                style: {
                    color: Highcharts.getOptions().colors[1]
                }
            }
        }, { // Secondary yAxis
            title: {
                text: 'Rainfall',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            labels: {
                format: '{value} mm',
                style: {
                    color: Highcharts.getOptions().colors[0]
                }
            },
            opposite: true
        }],
        tooltip: {
            shared: true
        },
        legend: {
            layout: 'vertical',
            align: 'left',
            x: 120,
            verticalAlign: 'top',
            y: 100,
            floating: true,
            backgroundColor: (Highcharts.theme && Highcharts.theme.legendBackgroundColor) || 'rgba(255,255,255,0.25)'
        },
        series: [{
            name: 'Rainfall',
            type: 'column',
            yAxis: 1,
            data: [49.9, 71.5, 106.4, 129.2, 144.0, 176.0, 135.6, 148.5, 216.4, 194.1, 95.6, 54.4],
            tooltip: {
                valueSuffix: ' mm'
            }

        }, {
            name: 'Temperature',
            type: 'spline',
            data: [7.0, 6.9, 9.5, 14.5, 18.2, 21.5, 25.2, 26.5, 23.3, 18.3, 13.9, 9.6],
            tooltip: {
                valueSuffix: '°C'
            }
        }]
    });
}