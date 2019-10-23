// https://github.com/axios/axios

const axios = require("axios");

let guestAjaxSearch = document.getElementById('guestajaxsearch');
if (guestAjaxSearch) {
    let guestSearch = document.getElementById('guestajaxsearch').addEventListener('input', function () {
        let input = document.getElementById('guestajaxsearch').value;
        let url = "/guest/getguestbyajaxsearch/" + input;

        if (input.length >= 3) {
            axios.get(url)
                .then(
                    function (response) {
                        let guests = response.data;
                        if (guests) {
                            let listContainer = document.getElementById('guestajaxsearchresult');
                            listContainer.innerHTML = '';
                            for (let i = 0; i < guests.length; i++) {
                                let newListElement = document.createElement('a');
                                newListElement.setAttribute('data-guestid', guests[i]['id']);
                                newListElement.setAttribute('class', 'collection-item');
                                newListElement.setAttribute('href', '#');
                                newListElement.innerHTML = guests[i]['lastname'] + ', ' + guests[i]['firstname'];
                                // newListElement.appendChild(document.createTextNode(guests[i]['lastname'] + ', ' + guests[i]['firstname']));
                                listContainer.appendChild(newListElement);
                            }
                        }else{
                            console.log('Not found: ' + input);
                        }
                    });
        }

    });
}


