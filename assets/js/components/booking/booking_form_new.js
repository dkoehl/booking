const axios = require("axios");

let bookingVacancies = document.getElementById('bookingVacancies');
if (bookingVacancies) {

    let selectedRoomType = '';
    let bookingFrom = '';
    let bookingTill = '';

    let EZ = document.getElementById('ez').addEventListener('click', function() {
        selectedRoomType = this.value;
        bookingFrom = document.getElementById('booking_bookingfrom').value;
        bookingTill = document.getElementById('booking_bookingtill').value;
        getvacanciesbydate(bookingFrom, bookingTill, 1)
    });
    let DZ = document.getElementById('dz').addEventListener('click', function() {
        selectedRoomType = this.value;
        bookingFrom = document.getElementById('booking_bookingfrom').value;
        bookingTill = document.getElementById('booking_bookingtill').value;
        getvacanciesbydate(bookingFrom, bookingTill, 2)
    });


    /**
     * Saves ROOMID to booking formular
     * 
     * Beim Absenden wird die ausgewählte 
     * ROOM-ID in ein verstecktes Formular- 
     * Feld eingefügt.
     * 
     */
    let bookingSubmitAction = document.getElementById('booking_submit').addEventListener('click', function(e) {
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
     * 
     * Ruft BookingController auf und fragt dort
     * freie Zimmer für einen eingegebenen Zeitraum ab.
     * 
     * Bei Erfolg wird eine Liste mit Ergebnissen angezeigt
     * 
     */
    function getvacanciesbydate(bookingFrom, bookingTill, roomType = '') {
        let url = "/booking/getvacanciesbydate/" + bookingFrom + '/' + bookingTill + '/' + roomType;
        axios.get(url)
            .then(
                function(response) {
                    // console.log(response.data);
                    let returnHtml = '';
                    document.getElementById('bookingVacancies').innerHTML = '';
                    let containerDiv = document.getElementById('bookingVacancies');
                    for (let i = 0; i < response.data.length; i++) {
                        let newElement = document.createElement('li');
                        newElement.setAttribute('class', 'hoverable collapsible-header blue-grey-text');
                        newElement.setAttribute('data-room', response.data[i]['id']);
                        returnHtml = '<div class="col s4">' +
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
                        lis[i].addEventListener('click', function() {
                            let defaultClasses = this.getAttribute('class');
                            if (defaultClasses.includes('active')) {
                                // removes active state
                                this.setAttribute('class', 'hoverable collapsible-header blue-grey-text');
                            } else {
                                // sets active state
                                this.setAttribute('class', defaultClasses + ' active light-blue white-text');
                            }

                        }, false);
                    }
                }
            )
    }
}