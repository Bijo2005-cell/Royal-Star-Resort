// --- Corrected accommodation_ajax.js ---

document.addEventListener('DOMContentLoaded', function() {

    // This function gets the room ID from the page's URL (e.g., from .../room2.php?id=2)
    function getRoomIdFromUrl() {
        const params = new URLSearchParams(window.location.search);
        return params.get('id');
    }

    // --- PART 1: FIX THE "CHECK AVAILABILITY" FORM ---
    const bookingForm = document.getElementById('bookingForm');
    if (bookingForm) {
        // Set min/max dates
        const checkInInput = document.getElementById('checkIn');
        const checkOutInput = document.getElementById('checkOut');
        const today = new Date().toISOString().split('T')[0];
        checkInInput.setAttribute('min', today);
        checkInInput.addEventListener('change', function() {
            let nextDay = new Date(checkInInput.value);
            nextDay.setDate(nextDay.getDate() + 1);
            checkOutInput.setAttribute('min', nextDay.toISOString().split('T')[0]);
        });

        // Handle form submission
        bookingForm.addEventListener('submit', function(event) {
            event.preventDefault();

            const roomId = getRoomIdFromUrl();
            const checkIn = checkInInput.value;
            const checkOut = checkOutInput.value;

            if (!roomId) {
                alert('ERROR: The room ID is missing from the URL.');
                return;
            }
            if (!checkIn || !checkOut) {
                alert('Please select both check-in and check-out dates.');
                return;
            }

            // Navigate to the reservation page with all the details
            const url = `../Guest&Public_Pages/reservation.php?room_id=${roomId}&checkin=${checkIn}&checkout=${checkOut}`;
            window.location.href = url;
        });
    }

    // --- PART 2: FIX THE NAVBAR "BOOK NOW" BUTTON ---
    const navbarBookButton = document.querySelector('a.login-btn#navbarDropdown');
    if (navbarBookButton) {
        // This button was wrongly configured as a dropdown; these lines fix it.
        navbarBookButton.removeAttribute('data-bs-toggle');
        navbarBookButton.removeAttribute('role');
    }

    // --- PART 3: FIX THE MAIN "BOOK NOW" BUTTON ---
    const mainBookButton = document.querySelector('a.btn.room-btn');
    if (mainBookButton) {
        const roomId = getRoomIdFromUrl();
        if (roomId) {
            // Add the room ID to the button's link
            mainBookButton.href = `../Guest&Public_Pages/reservation.php?room_id=${roomId}`;
        }
    }
});