




let bookingId = document.location.pathname.split('/');
if (bookingId){
    let guestSaveButton = document.getElementById('guest_bookings');
    let priceSaveButton = document.getElementById('price_booking');
    let paymentSaveButton = document.getElementById('payment_booking');
    let parkingSaveButton = document.getElementById('parking_booking');
    let inventorySaveButton = document.getElementById('inventory_booking');
    let damageSaveButton = document.getElementById('damage_booking');

    if (guestSaveButton){
        guestSaveButton.value = bookingId[2];
    }

    if (priceSaveButton){
        priceSaveButton.value = bookingId[2];
    }
    if (paymentSaveButton){
        paymentSaveButton.value = bookingId[2];
    }
    if (parkingSaveButton) {
        parkingSaveButton.value = bookingId[2];
    }
    if (inventorySaveButton) {
        inventorySaveButton.value = bookingId[2];
    }
    if (damageSaveButton) {
        damageSaveButton.value = bookingId[2];
    }
}
