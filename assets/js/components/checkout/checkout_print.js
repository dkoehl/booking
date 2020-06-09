import print from 'print-js'
import printJS from "print-js";

const axios = require('axios');
let generatePDFButton = document.getElementById('printPDFs');

if (generatePDFButton) {
    let modalPrintButton = document.getElementById('modalprint_button').addEventListener('click', function () {
        // getting print- formula data
        let elements = document.getElementById("modalprintformular").elements;
        let printFormularData = {};
        for (let i = 0; i < elements.length; i++) {
            let item = elements.item(i);
            if (item.checked) {
                printFormularData[item.name] = true;
            }
            if (item.name === 'bookingid') {
                printFormularData[item.name] = item.value;
            }
        }
        let bookingID = printFormularData['bookingid'];

        axios({
            method: 'POST',
            url: '/booking/printpdfs',
            data: printFormularData
        })
            .then(function (response) {
                printJS({
                    printable: response.data[0],
                    type: "pdf",
                    showModal: true
                });
            });
    });
}
