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
        let printPDFFileArray = [];
        let bookingID = printFormularData['bookingid'];
        let documentfolder = '/../../../../documents/';
        let today = new Date();
        let date = today.getFullYear() + '-' + '0' + (today.getMonth() + 1) + '-' + today.getDate();

        if (printFormularData['agbs']) {
            let agbsPDF = documentfolder + '_Datenschutzerklaerung.pdf'
            printPDFFileArray.push(agbsPDF);
            // printJS({
            //     printable: agbsPDF,
            //     type: "pdf",
            //     showModal: true
            // });
        }
        if (printFormularData['houserules']) {
            let houserulesPDF = documentfolder + '_Hausordnung.pdf'
            printPDFFileArray.push(houserulesPDF);
            // printJS({
            //     printable: houserulesPDF,
            //     type: "pdf",
            //     showModal: true
            // });
        }
        if (printFormularData['pricelist']) {
            let pricelistPDF = documentfolder + '_Preisliste.pdf'
            printPDFFileArray.push(pricelistPDF);
            // printJS({
            //     printable: pricelistPDF,
            //     type: "pdf",
            //     showModal: true
            // });
        }
        if (printFormularData['contract']) {
            let contractPDF = documentfolder + bookingID + '/' + date + '-HSN_Aufnahmevertrag_Muster_06.2019-' + bookingID + '.pdf'
            printPDFFileArray.push(contractPDF);

        }
        if (printFormularData['meldeschein']) {
            let meldescheinPDF = documentfolder + bookingID + '/' + date + '-meldeschein-' + bookingID + '.pdf'
            printPDFFileArray.push(meldescheinPDF);

        }

        console.log(printPDFFileArray);

        // for (let i = 0; i < printPDFFileArray.length; i++) {
        //     var oWindow = window.open(printPDFFileArray[i], "print");
        //     oWindow.print();
        //     oWindow.close();
        // }

    });
}
