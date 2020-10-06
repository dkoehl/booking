/**
 * Adds forms to the booking form
 */
let bookingId = document.location.pathname.split('/');
if (bookingId) {
    let guestSaveButton = document.getElementById('guest_bookings');
    let occupancySaveButton = document.getElementById('occupancy_booking');
    let priceSaveButton = document.getElementById('price_booking');
    let paymentSaveButton = document.getElementById('payment_booking');
    let parkingSaveButton = document.getElementById('parking_booking');
    let inventorySaveButton = document.getElementById('inventory_booking');
    let damageSaveButton = document.getElementById('damage_booking');
    let depositeSaveButton = document.getElementById('deposite_booking');

    if (occupancySaveButton) {
        occupancySaveButton.value = bookingId[2];
    }
    if (guestSaveButton) {
        guestSaveButton.value = bookingId[2];
    }

    if (priceSaveButton) {
        priceSaveButton.value = bookingId[2];
    }
    if (paymentSaveButton) {
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
    if (depositeSaveButton) {
        depositeSaveButton.value = bookingId[2];
    }
}