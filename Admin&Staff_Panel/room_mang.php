<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
   <link rel="stylesheet" href="../Styling&Scripts/style.css"> </head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light ">
            <div class="container">
                <a class="navbar-brand" >Royal <span>Star</span> Resort</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
        </div>
    </nav>
    </header>

    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <h1 class="page-title">Room & Villa Management</h1>
            <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addAccommodationModal">
                <i class="bi bi-plus-lg me-2"></i>Add New Accommodation
            </button>
        </div>

        <div class="filter-section mb-4">
            <div class="row">
                <div class="col-md-6 mb-3 mb-md-0">
                    <div class="search-box1">
                        <div class="input-group">
                            <span class="input-group-text bg-transparent border-0">
                                <i class="bi bi-search"></i>
                            </span>
                            <input type="text" class="form-control border-0" id="searchInput" placeholder="Search accommodations...">
                            <button class="btn btn-outline-secondary" type="button" id="searchButton">Search</button>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="row">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <select class="form-select" id="typeFilter">
                                <option value="">All Types</option>
                                <option value="room">Room</option>
                                <option value="villa">Villa</option>
                            </select>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <select class="form-select" id="statusFilter">
                                <option value="">All Statuses</option>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="maintenance">Under Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <select class="form-select" id="priceFilter">
                                <option value="">All Prices</option>
                                <option value="0-5000">₹0 - ₹5000</option>
                                <option value="5001-8000">₹5001 - ₹8000</option>
                                <option value="8001-15000">₹8001 - ₹15000</option>
                                <option value="15000+">₹15000+</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="row" id="accommodationsGrid">
            </div>
    </div>

    <div class="modal fade" id="addAccommodationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add New Accommodation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="addAccommodationForm">
                        <div class="mb-3">
                            <label for="accommodationType" class="form-label">Type</label>
                            <select class="form-select" id="accommodationType" required>
                                <option value="">Select Type</option>
                                <option value="room">Room</option>
                                <option value="villa">Villa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="accommodationNumber" class="form-label">Number/Name</label>
                            <input type="text" class="form-control" id="accommodationNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="accommodationPrice" class="form-label">Price per Night (₹)</label>
                            <input type="number" class="form-control" id="accommodationPrice" min="0" step="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="accommodationStatus" class="form-label">Status</label>
                            <select class="form-select" id="accommodationStatus" required>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="maintenance">Under Maintenance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="accommodationImage" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="accommodationImage" placeholder="photos/example.jpg">
                        </div>
                        <div class="mb-3">
                            <label for="accommodationDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="accommodationDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="saveAccommodationBtn">Save Accommodation</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="editAccommodationModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Accommodation</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="editAccommodationForm">
                        <input type="hidden" id="editAccommodationId">
                        <div class="mb-3">
                            <label for="editAccommodationType" class="form-label">Type</label>
                            <select class="form-select" id="editAccommodationType" required>
                                <option value="room">Room</option>
                                <option value="villa">Villa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editAccommodationNumber" class="form-label">Number/Name</label>
                            <input type="text" class="form-control" id="editAccommodationNumber" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAccommodationPrice" class="form-label">Price per Night (₹)</label>
                            <input type="number" class="form-control" id="editAccommodationPrice" min="0" step="1" required>
                        </div>
                        <div class="mb-3">
                            <label for="editAccommodationStatus" class="form-label">Status</label>
                            <select class="form-select" id="editAccommodationStatus" required>
                                <option value="available">Available</option>
                                <option value="occupied">Occupied</option>
                                <option value="maintenance">Under Maintenance</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="editAccommodationImage" class="form-label">Image URL</label>
                            <input type="text" class="form-control" id="editAccommodationImage" placeholder="photos/example.jpg">
                        </div>
                        <div class="mb-3">
                            <label for="editAccommodationDescription" class="form-label">Description</label>
                            <textarea class="form-control" id="editAccommodationDescription" rows="3"></textarea>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-primary" id="updateAccommodationBtn">Update Accommodation</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // DOM elements
        const accommodationsGrid = document.getElementById('accommodationsGrid');
        const searchInput = document.getElementById('searchInput');
        const typeFilter = document.getElementById('typeFilter');
        const statusFilter = document.getElementById('statusFilter');
        const priceFilter = document.getElementById('priceFilter');
        const searchButton = document.getElementById('searchButton');
        const saveAccommodationBtn = document.getElementById('saveAccommodationBtn');
        const updateAccommodationBtn = document.getElementById('updateAccommodationBtn');

        // Modals
        const addModal = new bootstrap.Modal(document.getElementById('addAccommodationModal'));
        const editModal = new bootstrap.Modal(document.getElementById('editAccommodationModal'));
        
        // --- API Path ---
        const API_URL = '../Admin&Staff_APIs/api_rooms.php';

        // Initialize the page
        document.addEventListener('DOMContentLoaded', function() {
            fetchAccommodations();
            
            // Event listeners for filters
            [searchInput, typeFilter, statusFilter, priceFilter, searchButton].forEach(el => {
                const event = el.tagName === 'INPUT' ? 'input' : 'change';
                if (el.tagName === 'BUTTON') {
                    el.addEventListener('click', fetchAccommodations);
                } else {
                    el.addEventListener(event, fetchAccommodations);
                }
            });
            
            // Event listeners for modals
            saveAccommodationBtn.addEventListener('click', saveAccommodation);
            updateAccommodationBtn.addEventListener('click', updateAccommodation);
        });

        // Fetch accommodations from the server using AJAX
        function fetchAccommodations() {
            const params = new URLSearchParams({
                action: 'fetch',
                search: searchInput.value,
                type: typeFilter.value,
                status: statusFilter.value,
                price: priceFilter.value
            });
            
            // --- FIX: Corrected API path ---
            fetch(`${API_URL}?${params}`)
                .then(response => {
                    if (!response.ok) throw new Error(`Network response was not ok (${response.status})`);
                    return response.json();
                })
                .then(data => {
                    if (data.status && data.status === 'error') throw new Error(`API Error: ${data.message}`);
                    renderAccommodations(data);
                })
                .catch(error => {
                    console.error('Error fetching data:', error);
                    accommodationsGrid.innerHTML = `<div class="col-12 text-center text-danger py-5"><h4>Error Loading Data</h4><p>${error.message}</p></div>`;
                });
        }

        // Render accommodations
        function renderAccommodations(data) {
            accommodationsGrid.innerHTML = '';
            
            if (data.length === 0) {
                accommodationsGrid.innerHTML = '<div class="col-12 text-center py-5"><h4>No accommodations found</h4><p>Try adjusting your search filters.</p></div>';
                return;
            }
            
            data.forEach(acc => {
                const statusClass = `status-${acc.status}`;
                const statusText = acc.status.charAt(0).toUpperCase() + acc.status.slice(1).replace('maintenance', 'Under Maintenance');
                
                const card = document.createElement('div');
                card.className = 'col-md-6 col-lg-4 col-xl-3 mb-4';
                card.innerHTML = `
                    <div class="card h-100">
                        <img src="${acc.image || 'photos/default.jpg'}" class="card-img-top" alt="${acc.number}">
                        <div class="card-body">
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <h5 class="card-title mb-0">${acc.number}</h5>
                                <span class="price">₹${parseFloat(acc.price).toLocaleString('en-IN')}</span>
                            </div>
                            <span class="status-badge ${statusClass}">${statusText}</span>
                            <p class="card-text mt-2 text-muted small">${acc.description || 'No description available.'}</p>
                        </div>
                        <div class="card-footer bg-white border-0 d-flex justify-content-between">
                            <i class="bi bi-pencil-square action-btn1 edit-btn" title="Edit"></i>
                            <i class="bi bi-trash action-btn1 delete-btn" title="Delete"></i>
                            <i class="bi bi-arrow-repeat action-btn1 status-btn" title="Change Status"></i>
                        </div>
                    </div>
                `;

                // Add event listeners to action buttons with the full 'acc' object
                card.querySelector('.edit-btn').addEventListener('click', () => openEditModal(acc));
                card.querySelector('.delete-btn').addEventListener('click', () => deleteAccommodation(acc.id));
                card.querySelector('.status-btn').addEventListener('click', () => changeStatus(acc.id));
                
                accommodationsGrid.appendChild(card);
            });
        }

        // Save new accommodation
        function saveAccommodation() {
            const form = document.getElementById('addAccommodationForm');
            const formData = new FormData(); // Don't pass 'form' here, we append manually
            formData.append('action', 'add');
            
            // Manual mapping for form element IDs to FormData keys
            formData.append('type', document.getElementById('accommodationType').value);
            formData.append('number', document.getElementById('accommodationNumber').value);
            formData.append('price', document.getElementById('accommodationPrice').value);
            formData.append('status', document.getElementById('accommodationStatus').value);
            formData.append('image', document.getElementById('accommodationImage').value);
            formData.append('description', document.getElementById('accommodationDescription').value);
            
            // --- FIX: Corrected API path ---
            fetch(API_URL, { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        addModal.hide();
                        form.reset();
                        fetchAccommodations();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => alert('Fetch Error: ' + error.message));
        }

        // Open edit modal
        function openEditModal(acc) {
            document.getElementById('editAccommodationId').value = acc.id;
            document.getElementById('editAccommodationType').value = acc.type;
            document.getElementById('editAccommodationNumber').value = acc.number;
            document.getElementById('editAccommodationPrice').value = acc.price;
            document.getElementById('editAccommodationStatus').value = acc.status;
            document.getElementById('editAccommodationImage').value = acc.image || '';
            document.getElementById('editAccommodationDescription').value = acc.description || '';
            editModal.show();
        }

        // Update accommodation
        function updateAccommodation() {
            const form = document.getElementById('editAccommodationForm');
            const formData = new FormData(); // Don't pass 'form' here
            formData.append('action', 'update');
            
            // Manual mapping for form element IDs to FormData keys
            formData.append('id', document.getElementById('editAccommodationId').value);
            formData.append('type', document.getElementById('editAccommodationType').value);
            formData.append('number', document.getElementById('editAccommodationNumber').value);
            formData.append('price', document.getElementById('editAccommodationPrice').value);
            formData.append('status', document.getElementById('editAccommodationStatus').value);
            formData.append('image', document.getElementById('editAccommodationImage').value);
            formData.append('description', document.getElementById('editAccommodationDescription').value);

            // --- FIX: Corrected API path ---
            fetch(API_URL, { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        editModal.hide();
                        fetchAccommodations();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => alert('Fetch Error: ' + error.message));
        }

        // Delete accommodation
        function deleteAccommodation(id) {
            if (confirm('Are you sure you want to delete this accommodation?')) {
                const formData = new FormData();
                formData.append('action', 'delete');
                formData.append('id', id);
                
                // --- FIX: Corrected API path ---
                fetch(API_URL, { method: 'POST', body: formData })
                    .then(res => res.json())
                    .then(data => {
                        if(data.status === 'success') {
                            fetchAccommodations();
                        } else {
                            alert('Error: ' + data.message);
                        }
                    })
                    .catch(error => alert('Fetch Error: ' + error.message));
            }
        }

        // Change status
        function changeStatus(id) {
            const formData = new FormData();
            formData.append('action', 'change_status');
            formData.append('id', id);

            // --- FIX: Corrected API path ---
            fetch(API_URL, { method: 'POST', body: formData })
                .then(res => res.json())
                .then(data => {
                    if(data.status === 'success') {
                        fetchAccommodations();
                    } else {
                        alert('Error: ' + data.message);
                    }
                })
                .catch(error => alert('Fetch Error: ' + error.message));
        }
    </script>
</body>
</html>