<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Staff Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;600&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
   <link rel="stylesheet" href="../Styling&Scripts/style1.css">
</head>
<body>
<div class="container-fluid">
    <div class="row">
        <main class="col-12 content">
            <div class="header mb-4">
                 <div class="row align-items-center">
                    <div class="col-md-6">
                        <h1 class="page-title luxury-font">
                            <i class="bi bi-stars me-2"></i>Staff Management
                        </h1>
                    </div>
                    <div class="col-md-6 text-md-end">
                        <button class="btn btn-luxury" data-bs-toggle="modal" data-bs-target="#addStaffModal">
                            <i class="bi bi-plus-circle me-2"></i> Add Staff
                        </button>
                    </div>
                </div>
            </div>

            <div class="container-fluid">
                <div class="row mb-4">
                    <div class="col-lg-6">
                        <div class="search-box">
                            <i class="bi bi-search"></i>
                            <input type="text" id="searchInput" class="form-control" placeholder="Search staff by name, position...">
                        </div>
                    </div>
                    <div class="col-lg-6 text-lg-end mt-3 mt-lg-0">
                        <div class="filter-dropdown d-inline-block me-3">
                            <div class="dropdown">
                                <button class="btn dropdown-toggle" type="button" id="filterDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class="bi bi-funnel-fill me-2"></i> Filter by Position
                                </button>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="filterDropdown">
                                    <li><a class="dropdown-item filter-option active" href="#" data-filter="all">All Staff</a></li>
                                    <li><hr class="dropdown-divider"></li>
                                    <li><a class="dropdown-item filter-option" href="#" data-filter="Manager">Managers</a></li>
                                    <li><a class="dropdown-item filter-option" href="#" data-filter="Receptionist">Receptionists</a></li>
                                    <li><a class="dropdown-item filter-option" href="#" data-filter="Housekeeping">Housekeeping</a></li>
                                    <li><a class="dropdown-item filter-option" href="#" data-filter="Chef">Chefs</a></li>
                                    <li><a class="dropdown-item filter-option" href="#" data-filter="Waiter">Wait Staff</a></li>
                                    <li><a class="dropdown-item filter-option" href="#" data-filter="Maintenance">Maintenance</a></li>
                                </ul>
                            </div>
                        </div>
                        <button class="btn btn-gold" id="resetFilters">
                            <i class="bi bi-arrow-counterclockwise me-2"></i> Reset
                        </button>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0 luxury-font"><i class="bi bi-list-check me-2"></i>Staff Directory</h5>
                        <span class="luxury-badge" id="staffCount">...</span>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover mb-0" id="staffTable">
                                <thead>
                                    <tr>
                                        <th width="60px">#</th>
                                        <th>Staff Member</th>
                                        <th>Position</th>
                                        <th>Contact</th>
                                        <th>Status</th>
                                        <th width="150px">Actions</th>
                                    </tr>
                                </thead>
                                <tbody id="staffTableBody">
                                    </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </div>
</div>

<div class="modal fade" id="addStaffModal" tabindex="-1" aria-labelledby="addStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title luxury-font" id="addStaffModalLabel">
                    <i class="bi bi-person-plus me-2"></i>Add New Staff
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="addStaffForm">
                    <div class="mb-4">
                        <label for="fullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="fullName" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="position" class="form-label">Position</label>
                            <select class="form-select" id="position" required>
                                <option value="">Select Position</option>
                                <option value="Manager">Manager</option>
                                <option value="Receptionist">Receptionist</option>
                                <option value="Housekeeping">Housekeeping</option>
                                <option value="Chef">Chef</option>
                                <option value="Waiter">Wait Staff</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="hireDate" class="form-label">Hire Date</label>
                            <input type="date" class="form-control" id="hireDate" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="phone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="phone" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="status" class="form-label">Status</label>
                        <select class="form-select" id="status" required>
                            <option value="Active">Active</option>
                            <option value="On Leave">On Leave</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-luxury" id="saveStaffBtn">
                    <i class="bi bi-save me-2"></i>Save Staff
                </button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="editStaffModal" tabindex="-1" aria-labelledby="editStaffModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title luxury-font" id="editStaffModalLabel">
                    <i class="bi bi-person-lines-fill me-2"></i>Edit Staff Member
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editStaffForm">
                    <input type="hidden" id="editStaffId">
                    <div class="mb-4">
                        <label for="editFullName" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="editFullName" required>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="editPosition" class="form-label">Position</label>
                            <select class="form-select" id="editPosition" required>
                                <option value="">Select Position</option>
                                <option value="Manager">Manager</option>
                                <option value="Receptionist">Receptionist</option>
                                <option value="Housekeeping">Housekeeping</option>
                                <option value="Chef">Chef</option>
                                <option value="Waiter">Wait Staff</option>
                                <option value="Maintenance">Maintenance</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="editHireDate" class="form-label">Hire Date</label>
                            <input type="date" class="form-control" id="editHireDate" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-6 mb-4">
                            <label for="editEmail" class="form-label">Email</label>
                            <input type="email" class="form-control" id="editEmail" required>
                        </div>
                        <div class="col-md-6 mb-4">
                            <label for="editPhone" class="form-label">Phone Number</label>
                            <input type="tel" class="form-control" id="editPhone" required>
                        </div>
                    </div>
                    <div class="mb-4">
                        <label for="editStatus" class="form-label">Status</label>
                        <select class="form-select" id="editStatus" required>
                            <option value="Active">Active</option>
                            <option value="On Leave">On Leave</option>
                            <option value="Inactive">Inactive</option>
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-secondary" data-bs-dismiss="modal">Cancel</button>
                <button type="button" class="btn btn-luxury" id="updateStaffBtn">
                    <i class="bi bi-save me-2"></i>Update Staff
                </button>
            </div>
        </div>
    </div>
</div>

<div class="position-fixed bottom-0 end-0 p-3" style="z-index: 11">
    <div id="successToast" class="toast align-items-center text-white bg-success border-0" role="alert" aria-live="assertive" aria-atomic="true">
        <div class="d-flex">
            <div class="toast-body">
                <i class="bi bi-check-circle-fill me-2"></i>
                <span id="toastMessage">Operation completed successfully!</span>
            </div>
            <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast" aria-label="Close"></button>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // DOM elements
    const staffTableBody = document.getElementById('staffTableBody');
    const searchInput = document.getElementById('searchInput');
    const filterOptions = document.querySelectorAll('.filter-option');
    const resetFiltersBtn = document.getElementById('resetFilters');
    const staffCount = document.getElementById('staffCount');
    const saveStaffBtn = document.getElementById('saveStaffBtn');
    const updateStaffBtn = document.getElementById('updateStaffBtn');
    const addStaffForm = document.getElementById('addStaffForm');
    const editStaffForm = document.getElementById('editStaffForm');
    const successToast = new bootstrap.Toast(document.getElementById('successToast'));
    const toastMessage = document.getElementById('toastMessage');

    // Modals
    const addModal = new bootstrap.Modal(document.getElementById('addStaffModal'));
    const editModal = new bootstrap.Modal(document.getElementById('editStaffModal'));
    
    // Current filter state
    let currentFilter = 'all';
    let currentSearch = '';

    document.addEventListener('DOMContentLoaded', function() {
        fetchStaff();
        
        searchInput.addEventListener('input', () => {
            currentSearch = searchInput.value;
            fetchStaff();
        });

        filterOptions.forEach(option => {
            option.addEventListener('click', function(e) {
                e.preventDefault();
                currentFilter = this.dataset.filter;
                document.querySelector('#filterDropdown').innerHTML = `<i class="bi bi-funnel-fill me-2"></i> ${this.textContent}`;
                filterOptions.forEach(opt => opt.classList.remove('active'));
                this.classList.add('active');
                fetchStaff();
            });
        });

        resetFiltersBtn.addEventListener('click', () => {
            currentFilter = 'all';
            currentSearch = '';
            searchInput.value = '';
            document.querySelector('#filterDropdown').innerHTML = `<i class="bi bi-funnel-fill me-2"></i> Filter by Position`;
            filterOptions.forEach(opt => opt.classList.remove('active'));
            document.querySelector('.filter-option[data-filter="all"]').classList.add('active');
            fetchStaff();
        });

        saveStaffBtn.addEventListener('click', addStaff);
        updateStaffBtn.addEventListener('click', updateStaff);
    });
    
    // --- FIX: Corrected file path ---
    function fetchStaff() {
        const params = new URLSearchParams({
            action: 'fetch',
            search: currentSearch,
            filter: currentFilter
        });

        fetch(`../Admin&Staff_APIs/api_staff.php?${params}`) // Was 'api_staff.php?${params}'
            .then(response => {
                if (!response.ok) {
                    throw new Error(`Network response was not ok (${response.status})`);
                }
                return response.json();
            })
            .then(data => {
                if (data.status && data.status === 'error') {
                    throw new Error(`API Error: ${data.message}`);
                }
                renderStaffTable(data);
            })
            .catch(error => {
                console.error('Error fetching staff:', error);
                staffTableBody.innerHTML = `<tr><td colspan="6" class="text-center text-danger p-4">Error loading staff data. ${error.message}</td></tr>`;
            });
    }

    // Render staff table with data from the server
    function renderStaffTable(staffData) {
        staffCount.textContent = `${staffData.length} staff member${staffData.length !== 1 ? 's' : ''}`;
        staffTableBody.innerHTML = '';
        
        if (staffData.length === 0) {
            staffTableBody.innerHTML = `<tr><td colspan="6" class="text-center p-4">No staff members found.</td></tr>`;
            return;
        }

        staffData.forEach((staff, index) => {
            const row = document.createElement('tr');
            // Handle potential null names
            const name = staff.name || 'N/A';
            const initials = name.split(' ').map(n => n[0]).join('').toUpperCase();
            const statusClass = `status-${(staff.status || 'inactive').toLowerCase().replace(' ', '-')}`;
            
            row.innerHTML = `
                <td>${index + 1}</td>
                <td>
                    <div class="d-flex align-items-center">
                        <div class="staff-avatar me-3">${initials}</div>
                        <div>
                            <div class="fw-semibold">${name}</div>
                            <small class="text-muted">${staff.department || 'N/A'}</small>
                        </div>
                    </div>
                </td>
                <td>${staff.position || 'N/A'}</td>
                <td>
                    <div>${staff.email || 'N/A'}</div>
                    <small class="text-muted">${staff.phone || 'N/A'}</small>
                </td>
                <td><span class="badge-status ${statusClass}">${staff.status || 'N/A'}</span></td>
                <td>
                    <button class="btn btn-sm action-btn edit-btn" title="Edit"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-sm action-btn delete-btn" title="Delete"><i class="bi bi-trash"></i></button>
                </td>
            `;
            
            row.querySelector('.edit-btn').addEventListener('click', () => editStaff(staff));
            row.querySelector('.delete-btn').addEventListener('click', () => deleteStaff(staff.id));
            staffTableBody.appendChild(row);
        });
    }
    
    // --- FIX: Corrected file path ---
    function addStaff() {
        if (!addStaffForm.checkValidity()) {
            addStaffForm.reportValidity();
            return;
        }

        const formData = new FormData();
        formData.append('action', 'add');
        formData.append('name', document.getElementById('fullName').value);
        formData.append('position', document.getElementById('position').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('phone', document.getElementById('phone').value);
        formData.append('hire_date', document.getElementById('hireDate').value);
        formData.append('status', document.getElementById('status').value); // This is sent, but not used by the corrected API

        fetch('../Admin&Staff_APIs/api_staff.php', { method: 'POST', body: formData }) // Was 'api_staff.php'
            .then(res => res.json()).then(data => {
                if (data.status === 'success') {
                    addModal.hide();
                    addStaffForm.reset();
                    fetchStaff();
                    showToast('Staff member added successfully!');
                } else { 
                    alert('Error: ' + data.message); 
                }
            })
            .catch(error => {
                console.error('Error adding staff:', error);
                alert('An unexpected error occurred. Please check the console.');
            });
    }

    function editStaff(staff) {
        document.getElementById('editStaffId').value = staff.id;
        document.getElementById('editFullName').value = staff.name;
        document.getElementById('editPosition').value = staff.position;
        document.getElementById('editEmail').value = staff.email;
        document.getElementById('editPhone').value = staff.phone;
        document.getElementById('editHireDate').value = staff.hire_date; // Use hire_date from DB
        document.getElementById('editStatus').value = staff.status;
        editModal.show();
    }

    // MODIFIED: Send updated staff data to the server
    function updateStaff() {
        if (!editStaffForm.checkValidity()) {
            editStaffForm.reportValidity();
            return;
        }

        const formData = new FormData();
        formData.append('action', 'update');
        formData.append('id', document.getElementById('editStaffId').value);
        formData.append('name', document.getElementById('editFullName').value);
        formData.append('position', document.getElementById('editPosition').value);
        formData.append('email', document.getElementById('editEmail').value);
        formData.append('phone', document.getElementById('editPhone').value);
        formData.append('hire_date', document.getElementById('editHireDate').value);
        formData.append('status', document.getElementById('editStatus').value); // This is sent, but not used by the corrected API

        fetch('../Admin&Staff_APIs/api_staff.php', { method: 'POST', body: formData })
            .then(res => res.json()).then(data => {
                if (data.status === 'success') {
                    editModal.hide();
                    fetchStaff();
                    showToast('Staff member updated successfully!');
                } else { 
                    alert('Error: ' + data.message); 
                }
            })
            .catch(error => {
                console.error('Error updating staff:', error);
                alert('An unexpected error occurred. Please check the console.');
            });
    }
    
    // MODIFIED: Send delete request to the server
    function deleteStaff(staffId) {
        if (confirm('Are you sure you want to delete this staff member?')) {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', staffId);

            fetch('../Admin&Staff_APIs/api_staff.php', { method: 'POST', body: formData })
                .then(res => res.json()).then(data => {
                    if (data.status === 'success') {
                        fetchStaff();
                        showToast('Staff member deleted successfully!');
                    } else { 
                        alert('Error: ' + data.message); 
                    }
                })
                .catch(error => {
                    console.error('Error deleting staff:', error);
                    alert('An unexpected error occurred. Please check the console.');
                });
        }
    }

    // Helper to show the success toast
    function showToast(message) {
        toastMessage.textContent = message;
        successToast.show();
    }
</script>
</body>
</html>