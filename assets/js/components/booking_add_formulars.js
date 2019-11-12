let button_booking_guest = document.getElementById('button_booking_guest');
let button_booking_damage = document.getElementById('button_booking_damage');
let button_booking_inventory = document.getElementById('button_booking_inventory');
let button_booking_parking = document.getElementById('button_booking_parking');
let button_booking_payment = document.getElementById('button_booking_payment');
let button_booking_price = document.getElementById('button_booking_price');

if (button_booking_guest) {
    let form_booking_guest = document.getElementById('button_booking_guest').addEventListener('click', function () {
        let formularElementbutton_booking_guest = document.getElementById('form_booking_guest');
        formularElementbutton_booking_guest.classList.remove('hide');
        // console.log(formularElement);
    });


}
if (button_booking_price) {
    let form_booking_payment = document.getElementById('button_booking_price').addEventListener('click', function () {
        let formularElementbutton_booking_price = document.getElementById('form_booking_price');
        formularElementbutton_booking_price.classList.remove('hide');
    });
}


if (button_booking_payment) {
    let form_booking_payment = document.getElementById('button_booking_payment').addEventListener('click', function () {
        let formularElementbutton_booking_payment = document.getElementById('form_booking_payment');
        formularElementbutton_booking_payment.classList.remove('hide');
    });
}

if (button_booking_parking) {
    let form_booking_parking = document.getElementById('button_booking_parking').addEventListener('click', function () {
        let formularElementbutton_booking_parking = document.getElementById('form_booking_parking');
        formularElementbutton_booking_parking.classList.remove('hide');
    });
}
if (button_booking_inventory) {
    let form_booking_inventory = document.getElementById('button_booking_inventory').addEventListener('click', function () {
        let formularElementbutton_booking_inventory = document.getElementById('form_booking_inventory');
        formularElementbutton_booking_inventory.classList.remove('hide');
    });
}

if (button_booking_damage) {
    let form_booking_damage = document.getElementById('button_booking_damage').addEventListener('click', function () {
        let formularElementbutton_booking_damage = document.getElementById('form_booking_damage');
        formularElementbutton_booking_damage.classList.remove('hide');
    });
}
let formSwitch = document.getElementById('guest_type');
if (formSwitch) {
    document.getElementById('guest_type').value = 1;
    let formTypePrivate = document.getElementById('guest_type_private').addEventListener('click', function () {
        let resetCompanyForms = document.getElementById('guest_company');
        resetCompanyForms.classList.add('hide');
        document.getElementById('guest_type').value = 1;
    });
    let formTypeCompany = document.getElementById('guest_type_company').addEventListener('click', function () {
        let selectedFormField = document.getElementById('guest_company');
        selectedFormField.classList.remove('hide');
        document.getElementById('guest_type').value = 2;
    });
}






