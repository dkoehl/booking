const axios = require('axios');
let generatePDFButton = document.getElementById('sendPDFs');

if (generatePDFButton) {

    let modalPrintButton = document.getElementById('modalsend_button').addEventListener('click', function () {
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
        // send formular data to booking- controller for generating pdf files
        axios.post('/booking/checkout/sendfiles', {
            data: sendFormularData
        })
            .catch(function (error) {
                console.log(error);
            });

    });
}

// if (generatePDFButton) {
//     let modalPrintButton = document.getElementById('generatePDFs').addEventListener('click', function () {
//         // getting print- formula data
//         let data = document.querySelector('#generatePDFs');
//         // send formular data to booking- controller for generating pdf files
//         axios.post('/booking/checkout/sendCheckoutFiles', {
//             bookingid: data.dataset.bookingid
//         })
//             .catch(function (error) {
//                 console.log(error);
//             });
//     });
// }
// if (modalPrint) {
//     let modalPrintButton = document.getElementById('modalprilnt_button').addEventListener('click', function () {
//         // getting print- formula data
//         let elements = document.getElementById("modalprintformular").elements;
//         let printFormularData = {};
//         for (let i = 0; i < elements.length; i++) {
//             let item = elements.item(i);
//             if (item.checked) {
//                 printFormularData[item.name] = true;
//             }
//             if (item.name === 'bookingid') {
//                 printFormularData[item.name] = item.value;
//             }
//         }
//         // send formular data to booking- controller for generating pdf files
//         axios.post('/booking/checkout/print/', printFormularData)
//             .catch(function (error) {
//                 console.log(error);
//             });
//     });
// }