<?php
$bookingType = isset($_GET['packageId']) ? 'program' : 'accommodation';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Resort Reservation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700&family=Poppins:wght@400;500&display=swap" rel="stylesheet">
    <style>
        :root {
            --primary-color: #8B4513; --secondary-color: #D4AF37; --dark-color: #333333;
            --light-color: #f8f9fa; --accent-color: #A0522D;
        }
        body { background-color: var(--light-color); color: var(--dark-color); font-family: 'Poppins', sans-serif; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Playfair Display', serif; color: var(--primary-color); }
        .btn-primary { background-color: var(--primary-color); border-color: var(--primary-color); font-weight: 500; }
        .section-header { border-bottom: 2px solid var(--accent-color); padding-bottom: 0.5rem; margin-bottom: 1.5rem; }
        .card { border: 1px solid var(--accent-color); }
        .total { font-size: 1.5rem; font-weight: bold; color: var(--primary-color); }
        
        .horizontal-scroll-container { display: flex; overflow-x: auto; padding-bottom: 1rem; gap: 1.5rem; }
        .horizontal-scroll-container::-webkit-scrollbar { height: 8px; }
        .horizontal-scroll-container::-webkit-scrollbar-track { background: #f1f1f1; }
        .horizontal-scroll-container::-webkit-scrollbar-thumb { background: #ccc; border-radius: 4px; }

        .package-card, .room-selection-card {
            min-width: 280px;
            max-width: 280px;
            flex-shrink: 0;
            height: auto;
            display: flex;
            flex-direction: column;
        }
        .package-card .card-img-top, .room-selection-card .card-img-top {
            height: 160px;
            object-fit: cover;
        }
        .package-card .card-body, .room-selection-card .card-body {
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }
        .selection-card.selected { border: 2px solid var(--primary-color); }
        
        .remove-item-btn { 
            line-height: 1; padding: 0.2rem 0.5rem; font-weight: bold;
            background: none; border: none; color: red; cursor: pointer;
        }
    </style>
</head>
<body>

    <div class="container my-5">
        <div class="text-center mb-5">
            <h1>Confirm Your Reservation</h1>
            <p class="lead text-muted">Review your details and complete your booking.</p>
        </div>
 
        <div class="row g-5">
            <div class="col-lg-8">
                <div id="availability-alert-container"></div>
                
                <div class="card p-4 mb-4" id="booking-details-card">
                    <h3 class="section-header">Booking Details</h3>
                    <div class="row g-3 align-items-end">
                        <div class="col-md-4" id="checkin-container"><label for="checkin-date" class="form-label">Check-in</label><input type="text" class="form-control" id="checkin-date" placeholder="Select Date"></div>
                        <div class="col-md-4" id="checkout-container"><label for="checkout-date" class="form-label">Check-out</label><input type="text" class="form-control" id="checkout-date" placeholder="Select Date"></div>
                        <div class="col-md-2" id="program-days-container" style="display: none;"><label for="program-days" class="form-label">Days</label><input type="number" class="form-control" id="program-days" value="1" min="1"></div>
                        <div class="col-md-2" id="adults-container"><label for="adults" class="form-label">Adults</label><input type="number" class="form-control" id="adults" value="2" min="1"></div>
                        <div class="col-md-2" id="children-container"><label for="children" class="form-label">Children</label><input type="number" class="form-control" id="children" value="0" min="0"></div>
                    </div>
                </div>
                <div class="card p-4 mb-4" id="selection-details-card">
                    <h3 class="section-header">Your Selection</h3>
                    <div class="row g-4" id="selection-details"></div>
                </div>
                <div class="mb-4" id="enhancements-section">
                    <h3 class="section-header" id="enhance-stay-title">Enhance Your Stay</h3>
                    <div class="horizontal-scroll-container" id="enhancements-container"></div>
                </div>
                <div class="card p-4">
                    <h3 class="section-header">Guest Information</h3>
                    <form class="needs-validation" id="guest-form" novalidate>
                         <div class="row g-3">
                            <div class="col-sm-6"><label for="fullName" class="form-label">Full Name</label><input type="text" class="form-control" id="fullName" required></div>
                            <div class="col-sm-6"><label for="email" class="form-label">Email Address</label><input type="email" class="form-control" id="email" required></div>
                            <div class="col-sm-6"><label for="phone" class="form-label">Phone Number</label><input type="tel" class="form-control" id="phone" required></div>
                            
                            <div class="col-sm-6">
                                <label for="nationality" class="form-label">Nationality</label>
                                <select class="form-select" id="nationality" required>
                                    <option value="" selected disabled>Choose...</option>
                                    <option value="India">India</option>
                                    <option value="Other">Other</option>
                                </select>
                            </div>

                            <div class="col-12" id="aadhar-container" style="display: none;">
                                <label for="aadhar" class="form-label">Upload Aadhar Card</label>
                                <input type="file" class="form-control" id="aadhar" accept="image/*,.pdf">
                            </div>

                            <div class="col-12" id="passport-container" style="display: none;">
                                <label for="passport" class="form-label">Upload Passport</label>
                                <input type="file" class="form-control" id="passport" accept="image/*,.pdf">
                            </div>
                            <div class="col-12"><label for="requests" class="form-label">Special Requests</label><textarea class="form-control" id="requests" rows="3"></textarea></div>
                        </div>
                    </form>
                    <div class="d-grid mt-4 pt-3 border-top">
                         <button type="button" class="btn btn-primary btn-lg" id="complete-reservation-btn">Confirm Reservation</button>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="card p-4 position-sticky" style="top: 2rem;">
                    <h3 class="section-header">Booking Summary</h3>
                    <div id="price-details"></div>
                    <hr>
                    <div class="d-flex justify-content-between align-items-center"><h5>Total</h5><div class="total" id="total-price">₹0.00</div></div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const bookingType = '<?php echo $bookingType; ?>';

            let appData = { rooms: [], packages: [], bookings: [] };
            let bookingState = {
                roomId: null, programId: null,
                checkin: null, checkout: null, adults: 2, children: 0,
                programDays: 1, 
                selectedPackages: [], totalPrice: 0,
            };

            async function init() {
                try {
                    const response = await fetch('../Booking&Public_APIs/api_get_booking_data.php');
                    const data = await response.json();
                    if (data.status === 'error') throw new Error(data.message);
                    
                    appData = data;
                    parseUrlParams();
                    
                    // Set initial guest counts from state
                    document.getElementById('adults').value = bookingState.adults;
                    document.getElementById('children').value = bookingState.children;

                    if (bookingType === 'accommodation') {
                        document.getElementById('enhance-stay-title').textContent = 'Enhance Your Stay with Packages';
                        populateSelectedRoom();
                        populatePackages();
                    } else { // 'program'
                        document.getElementById('enhance-stay-title').textContent = 'Select Your Accommodation';
                        populateSelectedProgram();
                        populateRoomsForSelection();
                    }
                    
                    updateUIVisibility();
                    updatePriceSummary();
                    setupEventListeners();
                } catch (error) {
                    document.getElementById('availability-alert-container').innerHTML = `<div class="alert alert-danger">${error.message}</div>`;
                }
            }
            
            function parseUrlParams() {
                const urlParams = new URLSearchParams(window.location.search);
                const roomIdFromUrl = urlParams.get('roomId');
                const packageIdFromUrl = urlParams.get('packageId');

                if (roomIdFromUrl) bookingState.roomId = parseInt(roomIdFromUrl, 10);
                if (packageIdFromUrl) bookingState.programId = 'prog_' + packageIdFromUrl;

                if (bookingType === 'accommodation' && !bookingState.roomId && appData.rooms.length > 0) {
                    bookingState.roomId = appData.rooms[0].id;
                }
            }

            function updateBookingDetailsUI() {
                const checkinLabel = document.querySelector('label[for="checkin-date"]');
                const checkinContainer = document.getElementById('checkin-container');
                const checkoutContainer = document.getElementById('checkout-container');
                const programDaysContainer = document.getElementById('program-days-container');
                const adultsContainer = document.getElementById('adults-container');
                const childrenContainer = document.getElementById('children-container');
                const isProgramOnlyBooking = !!bookingState.programId && !bookingState.roomId;

                if (isProgramOnlyBooking) {
                    checkinLabel.textContent = 'Program Date';
                    checkoutContainer.style.display = 'none';
                    programDaysContainer.style.display = 'block';
                    checkinContainer.className = 'col-md-5';
                    programDaysContainer.className = 'col-md-2';
                    adultsContainer.className = 'col-md-3';
                    childrenContainer.className = 'col-md-2';
                } else {
                    checkinLabel.textContent = 'Check-in';
                    checkoutContainer.style.display = 'block';
                    programDaysContainer.style.display = 'none';
                    checkinContainer.className = 'col-md-4';
                    checkoutContainer.className = 'col-md-4';
                    adultsContainer.className = 'col-md-2';
                    childrenContainer.className = 'col-md-2';
                }
            }
            
            function updateUIVisibility() {
                const bookingDetailsCard = document.getElementById('booking-details-card');
                const selectionDetailsCard = document.getElementById('selection-details-card');
                const enhancementsSection = document.getElementById('enhancements-section');
                const hasPrimarySelection = !!bookingState.roomId || !!bookingState.programId;

                bookingDetailsCard.style.display = hasPrimarySelection ? 'block' : 'none';
                selectionDetailsCard.style.display = hasPrimarySelection ? 'block' : 'none';
                enhancementsSection.style.display = hasPrimarySelection ? 'block' : 'none';
                updateBookingDetailsUI();
            }
            
            function populateSelectedRoom() {
                const room = appData.rooms.find(r => r.id == bookingState.roomId);
                const container = document.getElementById('selection-details');
                if (!room) {
                    container.innerHTML = `<p class="text-muted">No room selected.</p>`;
                } else {
                    container.innerHTML = `<div class="col-md-5"><img src="${room.image}" class="img-fluid rounded" alt="${room.name}"></div><div class="col-md-7"><h4>${room.name}</h4><div class="h5 mb-3">₹${parseFloat(room.price).toFixed(2)} / night</div><p class="text-muted">${room.description}</p></div>`;
                }
                updateUIVisibility();
            }

            function populateSelectedProgram() {
                const program = appData.packages.find(p => p.id == bookingState.programId);
                const container = document.getElementById('selection-details');
                if (!program) {
                    container.innerHTML = `<p class="text-muted">No package selected.</p>`;
                    return;
                }
                const priceDisplay = program.type === 'offer' ? `<span>${program.price}</span>` : `₹${parseFloat(program.price).toFixed(2)}`;
                container.innerHTML = `<div class="col-md-5"><img src="${program.image}" class="img-fluid rounded" alt="${program.name}"></div><div class="col-md-7"><h4>${program.name}</h4><div class="h5 mb-3">${priceDisplay}</div><p class="text-muted">${program.description}</p></div>`;
            }
            
            function populatePackages() {
                document.getElementById('enhancements-container').innerHTML = appData.packages.map(pkg => {
                    const isAdded = bookingState.selectedPackages.some(p => p.id === pkg.id);
                    return `<div class="card package-card"><img src="${pkg.image}" class="card-img-top" alt="${pkg.name}"><div class="card-body"><div><h5 class="card-title">${pkg.name}</h5><p class="card-text small text-muted">${pkg.description}</p></div><div class="d-flex justify-content-between align-items-center mt-3"><span>${pkg.type === 'offer' ? pkg.price : '₹'+parseFloat(pkg.price).toFixed(2)}</span><button class="btn btn-sm btn-primary add-package-btn" data-package-id="${pkg.id}" ${isAdded ? 'disabled' : ''}>${isAdded ? 'Added' : 'Add'}</button></div></div></div>`;
                }).join('');
            }
            
            function populateRoomsForSelection() {
                document.getElementById('enhancements-container').innerHTML = appData.rooms.map(room => {
                    const isSelected = bookingState.roomId == room.id;
                    return `<div class="card room-selection-card selection-card ${isSelected ? 'selected' : ''}" data-room-id="${room.id}"><img src="${room.image}" class="card-img-top" alt="${room.name}"><div class="card-body"><div><h5 class="card-title">${room.name}</h5><p class="card-text small text-muted">${(room.description || '').substring(0, 80)}...</p></div><div class="d-flex justify-content-between align-items-center mt-3"><div class="fw-bold">₹${parseFloat(room.price).toFixed(2)} / night</div><button class="btn btn-sm btn-primary select-room-btn" data-room-id="${room.id}" ${isSelected ? 'disabled' : ''}>${isSelected ? 'Added' : 'Add'}</button></div></div></div>`;
                }).join('');
            }

            function updatePriceSummary() {
                let html = '';
                let roomSubtotal = 0;
                let packagesSubtotal = 0;
                
                if (bookingState.roomId) {
                    const room = appData.rooms.find(r => r.id == bookingState.roomId);
                    if (room) {
                        const removeBtn = `<button class="remove-item-btn" data-remove-room-id="${room.id}" title="Remove Room">&times;</button>`;
                        if (bookingState.checkin && bookingState.checkout) {
                            const nights = Math.round((new Date(bookingState.checkout) - new Date(bookingState.checkin)) / (1000 * 60 * 60 * 24));
                            if (nights > 0) {
                                roomSubtotal = parseFloat(room.price) * nights;
                                html += `<div class="d-flex justify-content-between align-items-center"><span>${room.name} (×${nights} nights)</span><span>₹${roomSubtotal.toFixed(2)} ${removeBtn}</span></div>`;
                            } else {
                                // Handle case where checkout is same as checkin (should not happen with flatpickr config)
                                html += `<div class="d-flex justify-content-between align-items-center"><span>${room.name}</span><span>₹${parseFloat(room.price).toFixed(2)} / night ${removeBtn}</span></div>`;
                            }
                        } else {
                            html += `<div class="d-flex justify-content-between align-items-center"><span>${room.name}</span><span>₹${parseFloat(room.price).toFixed(2)} / night ${removeBtn}</span></div>`;
                        }
                    }
                }

                let currentPackages = [];
                if (bookingState.programId) {
                    const mainProgram = appData.packages.find(p => p.id === bookingState.programId);
                    if (mainProgram) currentPackages.push(mainProgram);
                }
                currentPackages = currentPackages.concat(bookingState.selectedPackages);

                currentPackages.forEach(pkg => {
                    if (pkg && pkg.type !== 'offer') {
                        const pkgPrice = parseFloat(pkg.price) || 0;
                        packagesSubtotal += pkgPrice;
                        const removeBtn = `<button class="remove-item-btn" data-remove-package-id="${pkg.id}" title="Remove Package">&times;</button>`;
                        html += `<div class="d-flex justify-content-between align-items-center small pt-1"><span class="text-muted">+ ${pkg.name}</span><span><span class="text-muted">₹${pkgPrice.toFixed(2)}</span> ${removeBtn}</span></div>`;
                    }
                });

                const total = roomSubtotal + packagesSubtotal;
                bookingState.totalPrice = total; 
                document.getElementById('price-details').innerHTML = html || '<p class="text-muted small">Your summary is empty.</p>';
                document.getElementById('total-price').textContent = `₹${total.toFixed(2)}`;
                updateUIVisibility();
            }

            function calculateCheckoutForProgram() {
                if (bookingState.checkin && bookingState.programDays > 0) {
                    const checkinDate = new Date(bookingState.checkin);
                    checkinDate.setDate(checkinDate.getDate() + parseInt(bookingState.programDays, 10));
                    bookingState.checkout = checkinDate.toISOString().split('T')[0];
                } else {
                    bookingState.checkout = null;
                }
            }

            // =================================================================
            // START: NEW AVAILABILITY CHECK FUNCTION
            // =================================================================
            function checkRoomAvailability() {
                const { roomId, checkin, checkout } = bookingState;
                const alertContainer = document.getElementById('availability-alert-container');
                const confirmBtn = document.getElementById('complete-reservation-btn');
                
                // 1. Don't check if we don't have all the info
                if (!roomId || !checkin || !checkout) {
                    alertContainer.innerHTML = ''; // Clear any old alerts
                    confirmBtn.disabled = false;    // Ensure button is enabled
                    return;
                }

                // 2. Find the room
                const room = appData.rooms.find(r => r.id == roomId);
                if (!room) return; // Room not found

                // 3. Your DB schema has unique rooms, so Total Quantity is always 1
                const totalQuantity = 1; 

                // 4. Find all conflicting bookings from the data we loaded
                const conflictingBookings = appData.bookings.filter(booking => {
                    // Check for the same room ID (using 'roomId' as sent by your API)
                    // and an overlapping date range
                    // Your API sends: { "roomId": "8", "checkin": "2025-10-11", "checkout": "2025-10-12" }
                    return booking.roomId == roomId &&
                           (booking.checkin < checkout) && 
                           (booking.checkout > checkin);
                });
                
                const bookedCount = conflictingBookings.length;

                // 5. The Decision: Compare booked count to total quantity
                if (bookedCount >= totalQuantity) {
                    // NOT AVAILABLE
                    alertContainer.innerHTML = `<div class="alert alert-danger" role="alert">
                        <strong>Sold Out!</strong> ${room.name} is fully booked for the selected dates. Please choose different dates.
                    </div>`;
                    confirmBtn.disabled = true; // Disable the confirmation button
                } else {
                    // AVAILABLE
                    alertContainer.innerHTML = ''; // Clear any error messages
                    confirmBtn.disabled = false; // Enable the confirmation button
                }
            }
            // =================================================================
            // END: NEW AVAILABILITY CHECK FUNCTION
            // =================================================================
            
            function setupEventListeners() {
                const enhancementsContainer = document.getElementById('enhancements-container');

                enhancementsContainer.addEventListener('click', (e) => {
                    if (e.target.classList.contains('add-package-btn')) {
                        const btn = e.target;
                        const packageToAdd = appData.packages.find(p => p.id === btn.dataset.packageId);
                        if (packageToAdd && !bookingState.selectedPackages.some(p => p.id === packageToAdd.id)) {
                            bookingState.selectedPackages.push(packageToAdd);
                            btn.textContent = 'Added';
                            btn.disabled = true;
                            updatePriceSummary();
                        }
                    } 
                    else if (e.target.classList.contains('select-room-btn')) {
                        const btn = e.target;
                        bookingState.roomId = parseInt(btn.dataset.roomId, 10);
                        updatePriceSummary();
                        populateRoomsForSelection(); 
                        checkRoomAvailability(); // <-- ADDED
                    }
                });

                document.getElementById('price-details').addEventListener('click', (e) => {
                    if (e.target.dataset.removeRoomId) {
                        bookingState.roomId = null;
                        if (bookingType === 'accommodation') {
                            populateSelectedRoom(); 
                        }
                        populateRoomsForSelection();
                        updatePriceSummary();
                        checkRoomAvailability(); // <-- ADDED
                    }
                    if (e.target.dataset.removePackageId) {
                         const packageIdToRemove = e.target.dataset.removePackageId;
                        if ((bookingType === 'program' && packageIdToRemove === bookingState.programId) || (bookingState.selectedPackages.length === 0 && packageIdToRemove === bookingState.programId && !bookingState.roomId)) {
                           window.location.href = '../Guest&Public_Pages/reservation.php';
                            return;
                        }
                        bookingState.selectedPackages = bookingState.selectedPackages.filter(p => p.id !== packageIdToRemove);
                        populatePackages();
                        updatePriceSummary();
                    }
                });
                
                document.getElementById('nationality').addEventListener('change', (e) => {
                    const nationality = e.target.value;
                    const aadharContainer = document.getElementById('aadhar-container');
                    const passportContainer = document.getElementById('passport-container');
                    const aadharInput = document.getElementById('aadhar');
                    const passportInput = document.getElementById('passport');

                    if (nationality === 'India') {
                        aadharContainer.style.display = 'block';
                        passportContainer.style.display = 'none';
                        aadharInput.required = true;
                        passportInput.required = false;
                        passportInput.value = '';
                    } else if (nationality === 'Other') {
                        aadharContainer.style.display = 'none';
                        passportContainer.style.display = 'block';
                        aadharInput.required = false;
                        passportInput.required = true;
                        aadharInput.value = '';
                    } else {
                        aadharContainer.style.display = 'none';
                        passportContainer.style.display = 'none';
                        aadharInput.required = false;
                        passportInput.required = false;
                    }
                });

                document.getElementById('complete-reservation-btn').addEventListener('click', async () => {
                    const form = document.getElementById('guest-form');
                    if (!form.checkValidity()) {
                        form.classList.add('was-validated');
                        return;
                    }

                    const isItemSelected = !!bookingState.roomId || !!bookingState.programId || bookingState.selectedPackages.length > 0;
                    if (!isItemSelected) {
                        alert('Please select a room or a package to continue.'); return;
                    }
                    if (!bookingState.checkin || !bookingState.checkout) {
                        alert('Please select the dates for your booking.'); return;
                    }
                    
                    const btn = document.getElementById('complete-reservation-btn');
                    btn.disabled = true;
                    btn.innerHTML = `<span class="spinner-border spinner-border-sm"></span> Processing...`;
                    
                    const formData = new FormData();
                    for (const key in bookingState) {
                        if (key === 'selectedPackages') {
                            formData.append(key, JSON.stringify(bookingState[key]));
                        } else {
                            formData.append(key, bookingState[key]);
                        }
                    }
                    formData.append('fullName', document.getElementById('fullName').value);
                    formData.append('email', document.getElementById('email').value);
                    formData.append('phone', document.getElementById('phone').value);
                    formData.append('requests', document.getElementById('requests').value);
                    formData.append('nationality', document.getElementById('nationality').value);

                    const aadharFile = document.getElementById('aadhar').files[0];
                    const passportFile = document.getElementById('passport').files[0];
                    if (aadharFile) {
                        formData.append('identity_document', aadharFile);
                    } else if (passportFile) {
                        formData.append('identity_document', passportFile);
                    }

                    try {
                        const response = await fetch('../Booking&Public_APIs/api_process_booking.php', {
                            method: 'POST',
                            body: formData
                        });

                        const result = await response.json();
                        if (result.status === 'success') {
                            window.location.href = `../Guest&Public_Pages/payment.php?id=${result.booking_id}`;
                        } else { 
                            // This will now show the server error (e.g., "already booked")
                            alert('Error: ' + (result.message || 'Could not process booking.')); 
                        }
                    } catch (error) {
                        console.error('Booking Error:', error);
                        alert('A network or server error occurred. Please try again.');
                    } finally {
                        btn.disabled = false;
                        btn.innerHTML = 'Confirm Reservation';
                    }
                });
                 
                const commonConfig = { altInput: true, altFormat: "F j, Y", dateFormat: "Y-m-d", minDate: "today" };
                
                flatpickr(document.getElementById('checkin-date'), { ...commonConfig, 
                    onChange: (selectedDates, dateStr) => { 
                        bookingState.checkin = dateStr;
                        const isProgramOnly = !!bookingState.programId && !bookingState.roomId;
                        if (isProgramOnly) {
                            calculateCheckoutForProgram();
                        } else if (selectedDates.length > 0) {
                            document.getElementById('checkout-date')._flatpickr.set('minDate', new Date(selectedDates[0]).fp_incr(1));
                        }
                        updatePriceSummary();
                        checkRoomAvailability(); // <-- ADDED
                    } 
                });

                flatpickr(document.getElementById('checkout-date'), { ...commonConfig, 
                    onChange: (selectedDates, dateStr) => { 
                        bookingState.checkout = dateStr;
                        updatePriceSummary();
                        checkRoomAvailability(); // <-- ADDED
                    } 
                });
                
                document.getElementById('program-days').addEventListener('change', (e) => {
                    bookingState.programDays = parseInt(e.target.value, 10) || 1;
                    calculateCheckoutForProgram();
                });

                document.getElementById('adults').addEventListener('change', (e) => { bookingState.adults = parseInt(e.target.value, 10); });
                document.getElementById('children').addEventListener('change', (e) => { bookingState.children = parseInt(e.target.value, 10); });
            }

            init();
        });
    </script>
</body>
</html>