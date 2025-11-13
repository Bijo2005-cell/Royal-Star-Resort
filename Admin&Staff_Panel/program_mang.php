<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <link rel="stylesheet" href="../Styling&Scripts/style1.css">
</head>
<body>
     <header>
        <nav class="navbar navbar-expand-lg navbar-light ">
            <div class="container">
                <a class="navbar-brand">Royal <span>Star</span> Resort</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        
                        
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <div class="container">
        <div class="row search-bar">
            <div class="col-md-8">
                <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search packages, events or functions..." id="searchInput">
                    <button class="btn btn-gold" type="button">
                        <i class="bi bi-search"></i> Search
                    </button>
                </div>
            </div>
            <div class="col-md-4 text-md-end">
                <button class="btn btn-gold" data-bs-toggle="modal" data-bs-target="#addItemModal">
                    <i class="bi bi-plus-circle"></i> Add New
                </button>
            </div>
        </div>

        <ul class="nav nav-tabs mb-4" id="filterTabs">
            <li class="nav-item">
                <a class="nav-link active" href="#" data-type="all">All Items</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-type="package">Packages</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-type="event">Events</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-type="function">Functions</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#" data-type="offer">Offers</a>
            </li>
        </ul>

        <div class="row" id="itemsGrid">
        </div>

        <div class="row d-none" id="noItemsMessage">
            <div class="col-12">
                <div class="no-items">
                    <i class="bi bi-info-circle" style="font-size: 3rem; color: var(--secondary-color);"></i>
                    <h3>No items found</h3>
                    <p>Try adding a new item or adjusting your search filters.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="addItemModal" tabindex="-1" aria-labelledby="addItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addItemModalLabel">Add New Item</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="itemForm">
                        <input type="hidden" id="itemId">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="itemType" class="form-label">Type</label>
                                    <select class="form-select" id="itemType" required>
                                        <option value="">Select type</option>
                                        <option value="package">Package</option>
                                        <option value="event">Event</option>
                                        <option value="function">Function</option>
                                        <option value="offer">Offer</option>
                                    </select>
                                </div>
                                <div class="mb-3">
                                    <label for="itemTitle" class="form-label">Title</label>
                                    <input type="text" class="form-control" id="itemTitle" required>
                                </div>
                                <div class="mb-3">
                                    <label for="itemDescription" class="form-label">Description</label>
                                    <textarea class="form-control" id="itemDescription" rows="3" required></textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="mb-3">
                                    <label for="itemPrice" class="form-label">Price (₹)</label>
                                    <input type="text" class="form-control" id="itemPrice" placeholder="e.g. 16000 or 30% OFF">
                                </div>
                                <div class="mb-3">
                                    <label for="itemDates" class="form-label">Dates/Availability</label>
                                    <input type="text" class="form-control" id="itemDates" placeholder="e.g. June 1-15, 2023 or Daily">
                                </div>
                                <div class="mb-3">
                                    <label for="itemImage" class="form-label">Image</label>
                                    <input type="file" class="form-control" id="itemImage" accept="image/*">
                                    <div class="mt-2 text-center">
                                        <img src="" alt="Preview" class="img-preview d-none" id="imagePreview">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-gold" id="saveItemBtn">Save Item</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal fade" id="deleteConfirmModal" tabindex="-1" aria-labelledby="deleteConfirmModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header bg-danger text-white">
                    <h5 class="modal-title" id="deleteConfirmModalLabel">Confirm Deletion</h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    Are you sure you want to delete this item? This action cannot be undone.
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="button" class="btn btn-danger" id="confirmDeleteBtn">Delete</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
        // No more hardcoded sample data!
        // let items = [...]; <-- REMOVE THIS

        // DOM elements
        const itemsGrid = document.getElementById('itemsGrid');
        const noItemsMessage = document.getElementById('noItemsMessage');
        const searchInput = document.getElementById('searchInput');
        const filterTabs = document.querySelectorAll('#filterTabs .nav-link');
        const itemForm = document.getElementById('itemForm');
        const addItemModal = new bootstrap.Modal(document.getElementById('addItemModal'));
        const deleteConfirmModal = new bootstrap.Modal(document.getElementById('deleteConfirmModal'));
        const saveItemBtn = document.getElementById('saveItemBtn');
        const confirmDeleteBtn = document.getElementById('confirmDeleteBtn');
        const imagePreview = document.getElementById('imagePreview');
        const itemImageInput = document.getElementById('itemImage');

        let currentItemId = null;
        let currentFilter = 'all';

        // Fetch and render items when the page loads
        document.addEventListener('DOMContentLoaded', function() {
            fetchItems();
            
            searchInput.addEventListener('input', () => fetchItems());
            filterTabs.forEach(tab => tab.addEventListener('click', handleFilterChange));
            saveItemBtn.addEventListener('click', saveItem);
            confirmDeleteBtn.addEventListener('click', confirmDelete);
            itemImageInput.addEventListener('change', handleImageUpload);
            
            // Reset form when "Add New" is clicked
            document.querySelector('[data-bs-target="#addItemModal"]').addEventListener('click', () => {
                itemForm.reset();
                currentItemId = null;
                document.getElementById('itemId').value = '';
                imagePreview.classList.add('d-none');
                imagePreview.src = '';
                document.getElementById('addItemModalLabel').textContent = 'Add New Item';
            });
        });

        // NEW: Fetch items from the server using AJAX
        function fetchItems() {
            const searchTerm = searchInput.value;
            const url = `../Admin&Staff_APIs/api.php?action=fetch&filter=${currentFilter}&search=${searchTerm}`;
            
            fetch(url)
                .then(response => response.json())
                .then(items => {
                    renderItems(items);
                })
                .catch(error => console.error('Error fetching items:', error));
        }

        function renderItems(items) {
            itemsGrid.innerHTML = '';
            noItemsMessage.classList.toggle('d-none', items.length > 0);
            
            items.forEach(item => {
                const card = createItemCard(item);
                itemsGrid.appendChild(card);
            });
        }

        function createItemCard(item) {
            const col = document.createElement('div');
            col.className = 'col-lg-4 col-md-6 mb-4';
            
            const card = document.createElement('div');
            card.className = 'card h-100';
            
            const typeBadge = document.createElement('span');
            typeBadge.className = `position-absolute top-0 end-0 mt-2 me-2 badge ${getBadgeClass(item.type)}`;
            typeBadge.textContent = item.type.charAt(0).toUpperCase() + item.type.slice(1);
            
            const img = document.createElement('img');
            img.className = 'card-img-top';
            img.src = item.image || '../photos/default.jpg'; // Use default if no image
            img.alt = item.title;
            
            const cardBody = document.createElement('div');
            cardBody.className = 'card-body d-flex flex-column';
            
            const title = document.createElement('h5');
            title.className = 'card-title';
            title.textContent = item.title;
            
            const description = document.createElement('p');
            description.className = 'card-text flex-grow-1';
            description.textContent = item.description;
            
            const dates = document.createElement('p');
            dates.className = 'card-text text-muted small';
            dates.innerHTML = `<i class="bi bi-calendar-event"></i> ${item.dates}`;
            
            const cardFooter = document.createElement('div');
            cardFooter.className = 'card-footer bg-transparent border-top-0';
            
            const price = document.createElement('div');
            price.className = 'price mb-2';

            // Check if price is numeric before formatting
            const numericPrice = parseFloat(item.price);
            if (!isNaN(numericPrice) && item.price.indexOf('%') === -1) {
                price.textContent = `₹${numericPrice.toLocaleString('en-IN')}`;
            } else {
                price.textContent = item.price || 'Price on request';
            }

            const btnGroup = document.createElement('div');
            btnGroup.className = 'd-grid gap-2 d-sm-flex justify-content-sm-between';
            
            const editBtn = document.createElement('button');
            editBtn.className = 'btn btn-sm btn-gold';
            editBtn.innerHTML = '<i class="bi bi-pencil"></i> Edit';
            editBtn.addEventListener('click', () => editItem(item));
            
            const deleteBtn = document.createElement('button');
            deleteBtn.className = 'btn btn-sm btn-outline-danger';
            deleteBtn.innerHTML = '<i class="bi bi-trash"></i> Delete';
            deleteBtn.addEventListener('click', () => showDeleteConfirm(item.id));
            
            btnGroup.appendChild(editBtn);
            btnGroup.appendChild(deleteBtn);
            
            cardFooter.appendChild(price);
            cardFooter.appendChild(btnGroup);
            
            cardBody.appendChild(title);
            cardBody.appendChild(description);
            cardBody.appendChild(dates);
            
            card.appendChild(typeBadge);
            card.appendChild(img);
            card.appendChild(cardBody);
            card.appendChild(cardFooter);
            
            col.appendChild(card);
            return col;
        }


        function getBadgeClass(type) {
            switch(type) {
                case 'package': return 'bg-primary';
                case 'event': return 'bg-success';
                case 'function': return 'bg-info';
                case 'offer': return 'bg-danger';
                default: return 'bg-secondary';
            }
        }

        function handleFilterChange(e) {
            e.preventDefault();
            currentFilter = this.dataset.type;
            filterTabs.forEach(tab => tab.classList.remove('active'));
            this.classList.add('active');
            fetchItems();
        }

        function editItem(item) {
            if (!item) return;
            
            currentItemId = item.id;
            
            document.getElementById('itemId').value = item.id;
            document.getElementById('itemType').value = item.type;
            document.getElementById('itemTitle').value = item.title;
            document.getElementById('itemDescription').value = item.description;
            document.getElementById('itemPrice').value = item.price || '';
            document.getElementById('itemDates').value = item.dates || '';
            
            imagePreview.src = item.image;
            imagePreview.classList.remove('d-none');
            itemImageInput.value = '';
            
            document.getElementById('addItemModalLabel').textContent = 'Edit Item';
            addItemModal.show();
        }

        function showDeleteConfirm(id) {
            currentItemId = id;
            deleteConfirmModal.show();
        }

        // MODIFIED: Send delete request to server
        function confirmDelete() {
            const formData = new FormData();
            formData.append('action', 'delete');
            formData.append('id', currentItemId);

            fetch('api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    deleteConfirmModal.hide();
                    fetchItems(); // Refresh the list
                } else {
                    alert('Error deleting item: ' + data.message);
                }
            });
        }

        // MODIFIED: Send form data to server
        function saveItem() {
            if (!itemForm.checkValidity()) {
                itemForm.classList.add('was-validated');
                return;
            }
            
            // Use FormData to easily handle file uploads
            const formData = new FormData(itemForm);
            formData.append('action', 'save');
            formData.append('id', document.getElementById('itemId').value);

            // Add the image file to FormData
            const imageFile = itemImageInput.files[0];
            if (imageFile) {
                formData.append('image', imageFile);
            }

            fetch('../Admin&Staff_APIs/api.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    addItemModal.hide();
                    fetchItems(); // Refresh the list from the server
                } else {
                    alert('Error saving item: ' + data.message);
                }
            })
            .catch(error => console.error('Error:', error));
        }

        function handleImageUpload(e) {
            const file = e.target.files[0];
            if (!file) return;
            
            const reader = new FileReader();
            reader.onload = function(event) {
                imagePreview.src = event.target.result;
                imagePreview.classList.remove('d-none');
            };
            reader.readAsDataURL(file);
        }
    </script>
</body>
</html>