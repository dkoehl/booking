const axios = require('axios');

let generatePDFButton = document.getElementById('generatePDFs');
let modalPrint = document.getElementById('modalprint');


if (generatePDFButton) {
    let modalPrintButton = document.getElementById('generatePDFs').addEventListener('click', function () {
        // getting print- formula data
        let data = document.querySelector('#generatePDFs');
        // send formular data to booking- controller for generating pdf files
        axios.post('/booking/checkout/generatepdfs', {
            bookingid: data.dataset.bookingid
        })
            .catch(function (error) {
                console.log(error);
            });
    });
}
if (modalPrint) {
    // let modalPrintButton = document.getElementById('modalprint_button').addEventListener('click', function () {
    //     // getting print- formula data
    //     let elements = document.getElementById("modalprintformular").elements;
    //     let printFormularData = {};
    //     for (let i = 0; i < elements.length; i++) {
    //         let item = elements.item(i);
    //         if (item.checked) {
    //             printFormularData[item.name] = true;
    //         }
    //         if (item.name === 'bookingid') {
    //             printFormularData[item.name] = item.value;
    //         }
    //     }
    //     // send formular data to booking- controller for generating pdf files
    //     axios.post('/booking/checkout/print/', printFormularData)
    //         .catch(function (error) {
    //             console.log(error);
    //         });
    // });
}