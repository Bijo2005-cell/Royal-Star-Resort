<?php
session_start();

// Security check: In your final project, you would uncomment this.
/*
if (!isset($_SESSION['user_id']) || !in_array($_SESSION['role'], ['staff', 'admin'])) {
    header('Location: login.php');
    exit();
}
*/
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Guest Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Styling&Scripts/style1.css"> </head>
<body>
    <div class="container-fluid p-4">
        <div class="header mb-4">
            <div class="d-flex justify-content-between align-items-center">
                <h1 class="page-title luxury-font mb-0"><i class="bi bi-people-fill me-2"></i>Guest Management</h1>
                <button class="btn btn-luxury" data-bs-toggle="modal" data-bs-target="#addGuestModal">
                    <i class="bi bi-plus-circle me-2"></i> Add Guest
                </button>
            </div>
        </div>

        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-0 luxury-font"><i class="bi bi-list-check me-2"></i>Guest Directory</h5>
                <span class="luxury-badge" id="guestCount">0 guests</span>
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                    <table class="table table-hover mb-0">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Guest</th>
                                <th>Check-in</th>
                                <th>Check-out</th>
                                <th>Room</th>
                                <th>Contact</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody id="guestTableBody">
                            </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addGuestModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title luxury-font"><i class="bi bi-person-plus me-2"></i>Add New Guest</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addGuestForm" novalidate>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="firstName" class="form-label">First Name</label><input type="text" class="form-control" id="firstName" required></div>
                            <div class="col-md-6 mb-3"><label for="lastName" class="form-label">Last Name</label><input type="text" class="form-control" id="lastName" required></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="email" class="form-label">Email</label><input type="email" class="form-control" id="email" required></div>
                            <div class="col-md-6 mb-3"><label for="phone" class="form-label">Phone Number</label><input type="tel" class="form-control" id="phone" required></div>
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="checkInDate" class="form-label">Check-in Date</label><input type="date" class="form-control" id="checkInDate" required></div>
                            <div class="col-md-6 mb-3"><label for="checkOutDate" class="form-label">Check-out Date</label><input type="date" class="form-control" id="checkOutDate" required></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3"><label for="roomId" class="form-label">Room</label><select class="form-select" id="roomId" required><option value="">Select a Room...</option></select></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-luxury" id="saveGuestBtn"><i class="bi bi-save me-2"></i>Save Guest</button>
                </div>
            </div>
        </div>
    </div>
    
    <div class="modal fade" id="editGuestModal" tabindex="-1" aria-hidden="true">
         <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title luxury-font"><i class="bi bi-pencil-square me-2"></i>Edit Guest Booking</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editGuestForm" novalidate>
                        <input type="hidden" id="editBookingDetailId">
                        <div class="mb-3"><p><strong>Guest:</strong> <span id="editGuestName"></span></p></div>
                        <div class="row">
                            <div class="col-md-6 mb-3"><label for="editCheckInDate" class="form-label">Check-in Date</label><input type="date" class="form-control" id="editCheckInDate" required></div>
                            <div class="col-md-6 mb-3"><label for="editCheckOutDate" class="form-label">Check-out Date</label><input type="date" class="form-control" id="editCheckOutDate" required></div>
                        </div>
                        <div class="row">
                            <div class="col-md-12 mb-3"><label for="editRoomId" class="form-label">Room</label><select class="form-select" id="editRoomId" required><option value="">Select a Room...</option></select></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-luxury" id="updateGuestBtn"><i class="bi bi-save me-2"></i>Update Booking</button>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
    document.addEventListener('DOMContentLoaded', function() {
        // --- DOM Element References ---
        const guestTableBody = document.getElementById('guestTableBody');
        const guestCount = document.getElementById('guestCount');
        const saveGuestBtn = document.getElementById('saveGuestBtn');
        const updateGuestBtn = document.getElementById('updateGuestBtn');
        const addGuestForm = document.getElementById('addGuestForm');
        const editGuestForm = document.getElementById('editGuestForm');
        const addGuestModal = new bootstrap.Modal(document.getElementById('addGuestModal'));
        const editGuestModal = new bootstrap.Modal(document.getElementById('editGuestModal'));

        let allGuests = [];
        let allRooms = [];

        // --- DATA FETCHING ---
        function fetchInitialData() {
            guestTableBody.innerHTML = `<tr><td colspan="8" class="text-center p-4">Loading...</td></tr>`;
            Promise.all([
                fetch('../Admin&Staff_APIs/api_guests.php?action=fetch_guests'),
                fetch('../Admin&Staff_APIs/api_guests.php?action=fetch_rooms') 
            ])
            .then(responses => Promise.all(responses.map(res => res.json())))
            .then(([guests, rooms]) => {
                allGuests = guests;
                allRooms = rooms;
                renderGuestTable(allGuests);
                populateRoomSelects(allRooms);
            })
            .catch(error => {
                guestTableBody.innerHTML = `<tr><td colspan="8" class="text-center p-4 text-danger">Could not load page data.</td></tr>`;
            });
        }
        
        // --- RENDERING ---
        function renderGuestTable(guests) {
            guestTableBody.innerHTML = '';
            guestCount.textContent = `${guests.length} guest${guests.length !== 1 ? 's' : ''}`;
            if (guests.length === 0) {
                guestTableBody.innerHTML = `<tr><td colspan="8" class="text-center p-4">No guests found.</td></tr>`;
                return;
            }
            guests.forEach((guest, index) => {
                const status = getGuestStatus(guest.check_in, guest.check_out);
                const statusClass = getStatusClass(status);
                const initials = (guest.guest_name || 'N A').split(' ').map(n => n[0]).join('').toUpperCase();
                const row = document.createElement('tr');
                row.innerHTML = `
                    <td>${index + 1}</td>
                    <td><div class="d-flex align-items-center"><div class="guest-avatar me-3">${initials}</div><div><div class="fw-semibold">${guest.guest_name}</div></div></div></td>
                    <td>${formatDisplayDate(guest.check_in)}</td>
                    <td>${formatDisplayDate(guest.check_out)}</td>
                    <td><span class="fw-semibold">${guest.room_name}</span></td>
                    <td><div>${guest.guest_email || 'N/A'}</div><small class="text-muted">${guest.guest_phone || 'N/A'}</small></td>
                    <td><span class="badge-status ${statusClass}">${status}</span></td>
                    <td>
                        <button class="btn btn-sm action-btn edit-btn" title="Edit Booking"><i class="bi bi-pencil"></i></button>
                        <button class="btn btn-sm action-btn delete-btn" title="Delete Booking"><i class="bi bi-trash"></i></button>
                    </td>`;
                
                row.querySelector('.edit-btn').addEventListener('click', () => openEditModal(guest));
                row.querySelector('.delete-btn').addEventListener('click', () => deleteBooking(guest.id, guest.guest_name));
                guestTableBody.appendChild(row);
            });
        }
        
        function populateRoomSelects(rooms) {
            const addRoomSelect = document.getElementById('roomId');
            const editRoomSelect = document.getElementById('editRoomId');
            addRoomSelect.innerHTML = '<option value="">Select a Room...</option>';
            editRoomSelect.innerHTML = '<option value="">Select a Room...</option>';
            rooms.forEach(room => {
                const option = `<option value="${room.acc_id}">${room.number} - (₹${room.price}/night)</option>`;
                addRoomSelect.innerHTML += option;
                editRoomSelect.innerHTML += option;
            });
        }
        
        // --- CRUD OPERATIONS ---
        function addGuest() {
            if (!addGuestForm.checkValidity()) {
                addGuestForm.classList.add('was-validated');
                return;
            }
            const formData = new FormData();
            formData.append('action', 'add_guest');
            formData.append('first_name', document.getElementById('firstName').value);
            formData.append('last_name', document.getElementById('lastName').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('phone', document.getElementById('phone').value);
            formData.append('check_in', document.getElementById('checkInDate').value);
            formData.append('check_out', document.getElementById('checkOutDate').value);
            formData.append('acc_id', document.getElementById('roomId').value);

            submitFormData('../Admin&Staff_APIs/api_guests.php', formData, 'Guest added successfully!');
        }
        
        function openEditModal(guest) {
            document.getElementById('editBookingDetailId').value = guest.id;
            document.getElementById('editGuestName').textContent = guest.guest_name;
            document.getElementById('editCheckInDate').value = guest.check_in;
            document.getElementById('editCheckOutDate').value = guest.check_out;
            document.getElementById('editRoomId').value = guest.room_id;
            editGuestModal.show();
        }
        
        function updateBooking() {
             if (!editGuestForm.checkValidity()) {
                editGuestForm.classList.add('was-validated');
                return;
            }
            const formData = new FormData();
            formData.append('action', 'update_booking');
            formData.append('bd_id', document.getElementById('editBookingDetailId').value);
            formData.append('check_in', document.getElementById('editCheckInDate').value);
            formData.append('check_out', document.getElementById('editCheckOutDate').value);
            formData.append('acc_id', document.getElementById('editRoomId').value);

            submitFormData('../Admin&Staff_APIs/api_guests.php', formData, 'Booking updated successfully!');
        }

        function deleteBooking(bookingDetailId, guestName) {
            if (confirm(`Are you sure you want to delete the booking for ${guestName}?`)) {
                const formData = new FormData();
                formData.append('action', 'delete_booking');
                formData.append('bd_id', bookingDetailId);
                submitFormData('../Admin&Staff_APIs/api_guests.php', formData, 'Booking deleted successfully!');
            }
        }
        
        function submitFormData(url, formData, successMessage) {
            fetch(url, { method: 'POST', body: formData })
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        addGuestModal.hide();
                        editGuestModal.hide();
                        addGuestForm.reset();
                        editGuestForm.reset();
                        addGuestForm.classList.remove('was-validated');
                        editGuestForm.classList.remove('was-validated');
                        alert(successMessage);
                        fetchInitialData(); // Refresh all data
                    } else {
                        alert(`Error: ${data.message}`);
                    }
                })
                .catch(error => console.error('Submission Error:', error));
        }

        // --- HELPER FUNCTIONS ---
        function getGuestStatus(checkInDate, checkOutDate) {
            const today = new Date();
            today.setHours(0, 0, 0, 0);
            const checkIn = new Date(checkInDate);
            const checkOut = new Date(checkOutDate);
            if (isNaN(checkIn) || isNaN(checkOut)) return 'Invalid Date';
            if (today >= checkIn && today < checkOut) return "Active";
            if (today < checkIn) return "Upcoming";
            return "Checked Out";
        }
        
        function getStatusClass(status) {
            if (status === "Active") return 'status-active';
            if (status === "Upcoming") return 'status-upcoming';
            return 'status-checkout';
        }
        
        function formatDisplayDate(dateString) {
            if (!dateString) return 'N/A';
            const date = new Date(dateString);
            if (isNaN(date)) return 'Invalid Date';
            const userTimezoneOffset = date.getTimezoneOffset() * 60000;
            const adjustedDate = new Date(date.getTime() + userTimezoneOffset);
            return adjustedDate.toLocaleDateString('en-GB', { day: '2-digit', month: 'short', year: 'numeric' });
        }

        // --- EVENT LISTENERS ---
        saveGuestBtn.addEventListener('click', addGuest);
        updateGuestBtn.addEventListener('click', updateBooking);

        // --- INITIAL LOAD ---
        fetchInitialData();
    });
    </script>
</body>
</html>