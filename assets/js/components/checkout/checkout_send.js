import printJS from "print-js";

const axios = require('axios');
let sendPDFButton = document.getElementById('sendPDFs');

if (sendPDFButton) {

    let modalSendButton = document.getElementById('modalsend_button').addEventListener('click', function () {
        // getting formula data
        let elements = document.getElementById("modalsendformular").elements;
        let sendFormularData = {};
        for (let i = 0; i < elements.length; i++) {
            let item = elements.item(i);
            if (item.checked) {
                sendFormularData[item.name] = true;
            }
            if (item.name === 'bookingid') {
                sendFormularData[item.name] = item.value;
            }
            if (item.name === 'receiver') {
                sendFormularData['receiver'] = item.value;
            }
            if (item.name === 'subject') {
                sendFormularData['subject'] = item.value;
            }
            if (item.name === 'bodytext') {
                sendFormularData['bodytext'] = item.value;
            }
        }
        let bookingID = sendFormularData['bookingid'];
        // sends data
        axios({
            method: 'POST',
            url: '/booking/checkout/sendfiles',
            data: sendFormularData
        })
            .then(function (response) {
                console.log(response);
            });
    });
}
