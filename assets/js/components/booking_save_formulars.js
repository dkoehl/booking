




let bookingId = document.location.pathname.split('/');
if (bookingId){
    let guestSaveButton = document.getElementById('guest_bookings');
    let priceSaveButton = document.getElementById('price_booking');
    let paymentSaveButton = document.getElementById('payment_booking');

    if (guestSaveButton){
        guestSaveButton.value = bookingId[2];
    }

    if (priceSaveButton){
        priceSaveButton.value = bookingId[2];
    }
    if (paymentSaveButton){
        paymentSaveButton.value = bookingId[2];
    }
}
