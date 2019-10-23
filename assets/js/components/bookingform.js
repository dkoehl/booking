const axios = require("axios");

let bookingVacancies = document.getElementById('bookingVacancies');
if (bookingVacancies) {

    let selectedRoomType = '';
    let bookingFrom = '';
    let bookingTill = '';

    let EZ = document.getElementById('ez').addEventListener('click', function () {
        selectedRoomType = this.value;
        bookingFrom = document.getElementById('booking_bookingfrom').value;
        bookingTill = document.getElementById('booking_bookingtill').value;
        getvacanciesbydate(bookingFrom, bookingTill)
    });
    let DZ = document.getElementById('dz').addEventListener('click', function () {
        selectedRoomType = this.value;
        bookingFrom = document.getElementById('booking_bookingfrom').value;
        bookingTill = document.getElementById('booking_bookingtill').value;
        getvacanciesbydate(bookingFrom, bookingTill)
    });


    /**
     * Saves values to booking formular
     */
    let bookingSubmitAction = document.getElementById('booking_submit').addEventListener('click', function (e) {
        let lis = document.getElementById("bookingVacancies").getElementsByTagName('li');
        for (var i = 0; i < lis.length; i++) {
            let elementClasses = lis[i].getAttribute('class');
            if (elementClasses.includes('active')) {
                let roomId = lis[i].getAttribute('data-room');
                document.getElementById('booking_room').getElementsByTagName('option')[roomId - 1].selected = 'selected';
                document.getElementById('booking_room').getElementsByTagName('option')[roomId - 1].getAttribute('value');
            }
        }
        document.getElementById('booking_guest').setAttribute('value', 1);
        // e.preventDefault();

    }, false);


    /**
     * Gets free rooms for list view
     */
    function getvacanciesbydate(bookingFrom, bookingTill) {
        let url = "/booking/getvacanciesbydate/" + bookingFrom + '/' + bookingTill;
        axios.get(url)
            .then(
                function (response) {
                    // console.log(response.data);
                    let returnHtml = '';
                    let containerDiv = document.getElementById('bookingVacancies');

                    for (let i = 0; i < response.data.length; i++) {
                        let newElement = document.createElement('li');
                        newElement.setAttribute('class', 'hoverable collapsible-header blue-grey-text');
                        newElement.setAttribute('data-room', response.data[i]['id']);
                        returnHtml = '<div class="col s1">' +
                            '<input type="checkbox" id="room_' + response.data[i]['id'] + '" name="booking[room]" style="opacity:1;">' +
                            '</div>' +
                            '<div class="col s3">' +
                            response.data[i]['name'] +
                            '</div>' +
                            '<div class="col s3">' +
                            response.data[i]['floor'] +
                            '</div>' +
                            '<div class="col s2">' +
                            response.data[i]['beds'] +
                            '</div>' +
                            '<div class="col s3">' +
                            response.data[i]['house'] +
                            '</div>';
                        newElement.innerHTML = returnHtml;
                        containerDiv.appendChild(newElement);
                        delete newElement;
                    }

                    /**
                     * Click event on <li> of rooms
                     */
                    var lis = document.getElementById("bookingVacancies").getElementsByTagName('li');
                    for (var i = 0; i < lis.length; i++) {
                        lis[i].addEventListener('click', function () {
                            // let selectedRooms = this.getAttribute('data-room');
                            let defaultClasses = this.getAttribute('class');
                            // let hiddenInputValues = document.getElementById('booking_room').getAttribute('value');

                            if (defaultClasses.includes('active')) {
                                // removes active state
                                this.setAttribute('class', 'hoverable collapsible-header blue-grey-text');
                                // if (hiddenInputValues) {
                                //     if (hiddenInputValues.includes(selectedRooms)) {
                                //         let newHiddenValues = hiddenInputValues.replace(selectedRooms + ',', '');
                                //         document.getElementById('booking_room').setAttribute('value', newHiddenValues);
                                //     }
                                // }
                            } else {
                                // sets active state
                                this.setAttribute('class', defaultClasses + ' active light-blue white-text');
                                // if (hiddenInputValues) {
                                //     if (!hiddenInputValues.includes(selectedRooms)) {
                                //         document.getElementById('booking_room').setAttribute('value', hiddenInputValues + selectedRooms + ',');
                                //     }
                                // } else {
                                //     document.getElementById('booking_room').setAttribute('value', selectedRooms + ',');
                                // }
                            }

                        }, false);
                    }
                    // console.log(returnHtml);
                    // bookingVacancies
                }
            )
    }


}