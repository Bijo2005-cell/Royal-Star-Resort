<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Rooms & Villas</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Styling&Scripts/style.css">
    </head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark" style="background-color: var(--primary-color);">
        <div class="container">
            <a class="navbar-brand" href="#">Royal <span>Star</span> Resort</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse justify-content-end" id="navbarNav">
                <div class="d-flex align-items-center">
                    <i class="fas fa-heart icon-btn" title="Like"></i>
                    <i class="fas fa-shopping-cart icon-btn" title="Cart"></i>
                    <i class="fas fa-user icon-btn" title="Profile"></i>
                </div>
            </div>
        </div>
    </nav>

    <div class="container my-5">
        <div class="filter-section fade-in">
            <h2 class="section-title">Find Your Perfect Stay</h2>
            <ul class="nav nav-tabs mb-4" id="accommodationTabs" role="tablist">
                <li class="nav-item" role="presentation">
                    <button class="nav-link active" id="rooms-tab" data-bs-toggle="tab" data-bs-target="#rooms" type="button" role="tab">Rooms</button>
                </li>
                <li class="nav-item" role="presentation">
                    <button class="nav-link" id="villas-tab" data-bs-toggle="tab" data-bs-target="#villas" type="button" role="tab">Villas</button>
                </li>
            </ul>
            
            <div class="row">
                <div class="col-md-3 mb-3">
                    <label for="roomType" class="form-label">Room Type</label>
                    <select class="form-select" id="roomType">
                        <option selected>All Types</option>
                        <option>Deluxe</option>
                        <option>Executive</option>
                        <option>Suite</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="priceRange" class="form-label">Price Range</label>
                    <select class="form-select" id="priceRange">
                        <option selected>All Prices</option>
                        <option>₹1000 - ₹5000</option>
                        <option>₹5000 - ₹15000</option>
                        <option>₹15000</option>
                    </select>
                </div>
                <div class="col-md-3 mb-3">
                    <label for="bedType" class="form-label">Bed Type</label>
                    <select class="form-select" id="bedType">
                        <option selected>Any</option>
                        <option>King</option>
                        <option>Queen</option>
                        <option>Twin</option>
                    </select>
                </div>
            </div>
            <div class="row">
                 <div class="col-md-3 mb-3">
                    <label for="checkInDate" class="form-label">Check-In</label>
                    <input type="date" class="form-control" id="checkInDate">
                </div>
                <div class="col-md-3 mb-3">
                    <label for="checkOutDate" class="form-label">Check-Out</label>
                    <input type="date" class="form-control" id="checkOutDate">
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end">
                    <button id="filterBtn" class="btn btn-primary w-100" style="background-color: var(--primary-color); border: none;">
                        Filter / Check Availability
                    </button>
                </div>
                <div class="col-md-3 mb-3 d-flex align-items-end" id="filter-status" style="display: none;">
                    <span class="text-muted">Checking...</span>
                </div>
            </div>
        </div>

        <div class="tab-content" id="accommodationTabsContent">
            <div class="tab-pane fade show active" id="rooms" role="tabpanel">
                <h2 class="section-title mb-4 fade-in">Luxury Rooms</h2>
                <p><h5>Royal Star Beach Resort offers comfortable mid-to-large-sized rooms, equipped with modern conveniences and pleasant views. The Family Rooms and Suites are ideal for groups, while the Standard and Triple Rooms offer excellent value. </h5></p>
                <div class="row">
                    <div class="col-lg-3 col-md-4 fade-in accommodation-item">
                        <div class="card room-card" data-price="7200" data-type="Suite" data-bed="King" data-acc-id="1">
                            <span class="badge badge-luxury px-3 py-2">BESTSELLER</span>
                            <img src="../photos/rm5.jpeg" class="card-img-top" alt="Premium Club Suite">
                            <div class="card-body">
                                <h5 class="card-title">Premium Club Suite</h5>
                                <p class="card-text">spacious club suite with stunning valley views. modern decor,and a balcony for a luxurious stay</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-ruler-combined me-2"></i>750 sq.ft</span>
                                    <span class="price">₹7200<small>/night</small></span>
                                </div>
                                <div class="d-flex">
                                    <a href="../accommodations/room2.php"><button class="btn btn-book w-100">View More</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-4 fade-in accommodation-item">
                        <div class="card room-card" data-price="6900" data-type="Suite" data-bed="King" data-acc-id="2">
                            <img src="../photos/rm7.jpeg" class="card-img-top" alt="Executive Room">
                            <div class="card-body">
                                <h5 class="card-title">Presidental Suite</h5>
                                <p class="card-text">A Presidential Suite is the most luxurious and prestigious accommodation offered in a hotel. </p><br>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-ruler-combined me-2"></i>720 sq.ft</span>
                                    <span class="price">₹6900<small>/night</small></span>
                                </div>
                                <div class="d-flex">
                                    <a href="../accommodations/room3.php"><button class="btn btn-book w-100">View More</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-4 fade-in accommodation-item">
                        <div class="card room-card" data-price="8700" data-type="Suite" data-bed="King" data-acc-id="3">
                            <span class="badge badge-luxury px-3 py-2">NEW</span>
                            <img src="../photos/rm8.jpeg" class="card-img-top" alt="Jacuzzi 180-Degree Suite">
                            <div class="card-body">
                                <h5 class="card-title">Jacuzzi 180-Degree Suite</h5>
                                <p class="card-text">The Jacuzzi 180-Degree Suite is a high-end hotel suite designed for guests seeking luxury, privacy, and breathtaking views.</p><br>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-ruler-combined me-2"></i>750 sq.ft</span>
                                    <span class="price">₹8700<small>/night</small></span>
                                </div>
                                <div class="d-flex">
                                    <a href="../accommodations/room4.php"><button class="btn btn-book w-100">View More</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                     <div class="col-lg-3 col-md-4 fade-in accommodation-item">
                        <div class="card room-card" data-price="4999" data-type="Deluxe" data-bed="Queen" data-acc-id="4">
                            <span class="badge badge-luxury px-3 py-2">BESTSELLER</span>
                            <img src="../photos/rm3.jpg" class="card-img-top" alt="Deluxe Room">
                            <div class="card-body">
                                <h5 class="card-title">Deluxe Room</h5>
                                <p class="card-text">Experience comfort in our spacious deluxe rooms with stunning views.</p><br>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-ruler-combined me-2"></i>450 sq.ft</span>
                                    <span class="price">₹4999<small>/night</small></span>
                                </div>
                                <div class="d-flex">
                                    <a href="../accommodations/room1.php"><button class="btn btn-book w-100">View More</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-4 fade-in accommodation-item">
                        <div class="card room-card" data-price="6700" data-type="Suite" data-bed="King" data-acc-id="5">
                            <img src="../photos/rm6.jpeg" class="card-img-top" alt="Honeymoon Suite">
                            <div class="card-body">
                                <h5 class="card-title">Honeymoon Suite</h5>
                                <p class="card-text">Escape into a world of romance and luxury in our Honeymoon Suite, thoughtfully designed for newlyweds and couples celebrating love.</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-ruler-combined me-2"></i>720 sq.ft</span>
                                    <span class="price">₹6700<small>/night</small></span>
                                </div>
                                <div class="d-flex">
                                    <a href="../accommodations/room5.php"><button class="btn btn-book w-100">View More</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-4 fade-in accommodation-item">
                        <div class="card room-card" data-price="6000" data-type="Executive" data-bed="King" data-acc-id="6">
                            <span class="badge badge-luxury px-3 py-2">NEW</span>
                            <img src="../photos/rm1.jpg" class="card-img-top" alt="Premium Room">
                            <div class="card-body">
                                <h5 class="card-title">Premium Room</h5>
                                <p class="card-text">Relax in a plush king or twin bed with premium linens, enjoy a well-lit workspace for productivity, and take in scenic views from large windows. </p><br>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-ruler-combined me-2"></i>750 sq.ft</span>
                                    <span class="price">₹6000<small>/night</small></span>
                                </div>
                                <div class="d-flex">
                                    <a href="../accommodations/room6.php"><button class="btn btn-book w-100">View More</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                   <div class="col-lg-3 col-md-4 fade-in accommodation-item">
                        <div class="card room-card" data-price="3500" data-type="Deluxe" data-bed="Twin" data-acc-id="7">
                            <img src="../photos/rm2.jpg" class="card-img-top" alt="Superior Room">
                            <div class="card-body">
                                <h5 class="card-title">Superior Room</h5>
                                <p class="card-text">Elevate your stay in our stylish Superior Room, thoughtfully designed for comfort and convenience.</p><br>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-ruler-combined me-2"></i>450 sq.ft</span>
                                    <span class="price">₹3500<small>/night</small></span>
                                </div>
                                <div class="d-flex">
                                    <a href="../accommodations/room7.php"><button class="btn btn-book w-100">View More</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-3 col-md-4 fade-in accommodation-item">
                        <div class="card room-card" data-price="7200" data-type="Suite" data-bed="Twin" data-acc-id="8">
                            <img src="../photos/rm4.jpg" class="card-img-top" alt="Family Innerconnected Club Suite">
                            <div class="card-body">
                                <h5 class="card-title">Family Innerconnected Club Suite</h5>
                                <p class="card-text">Premium accommodations with extra space and exclusive amenities.</p><br>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-ruler-combined me-2"></i>750 sq.ft</span>
                                    <span class="price">₹7200<small>/night</small></span>
                                </div>
                                <div class="d-flex">
                                    <a href="../accommodations/room8.php"><button class="btn btn-book w-100">View More</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="tab-pane fade" id="villas" role="tabpanel">
                <h2 class="section-title mb-4 fade-in">Luxurious Villas</h2>
                <p><h5>A villa is a luxurious, often standalone residence, typically located in scenic or vacation areas. Villas are known for offering privacy, space, and upscale amenities.</h5></p>
                <div class="row">
                    <div class="col-lg-4 col-md-6 fade-in accommodation-item">
                        <div class="card villa-card" data-price="17200" data-acc-id="9">
                            <span class="badge badge-luxury px-3 py-2">POPULAR</span>
                            <img src="../photos/villa1.jpeg" class="card-img-top" alt="Garden Villa">
                            <div class="card-body">
                                <h5 class="card-title">Garden Villa</h5>
                                <p class="card-text">Private villa surrounded by lush tropical gardens with a plunge pool.</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-ruler-combined me-2"></i>1200 sq.ft</span>
                                    <span class="price">₹17200<small>/night</small></span>
                                </div>
                                <div class="d-flex">
                                    <a href="../accommodations/villa1.php"><button class="btn btn-book w-100">View More</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 fade-in accommodation-item">
                        <div class="card villa-card" data-price="14000" data-acc-id="10">
                            <img src="../photos/villa2.jpeg" class="card-img-top" alt="Beachfront Villa">
                            <div class="card-body">
                                <h5 class="card-title">Dam front Villa</h5>
                                <p class="card-text">Direct dam access with stunning ocean views from every room.</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-ruler-combined me-2"></i>1500 sq.ft</span>
                                    <span class="price">₹14000<small>/night</small></span>
                                </div>
                                <div class="d-flex">
                                    <a href="../accommodations/villa2.php"><button class="btn btn-book w-100">View More</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-4 col-md-6 fade-in accommodation-item">
                        <div class="card villa-card" data-price="21000" data-acc-id="11">
                            <span class="badge badge-luxury px-3 py-2">PREMIUM</span>
                            <img src="../photos/villa3.jpeg" class="card-img-top" alt="Royal Suite Villa">
                            <div class="card-body">
                                <h5 class="card-title">Royal Suite Villa</h5>
                                <p class="card-text">Our most luxurious accommodation with private butler service and infinity pool.</p>
                                <div class="d-flex justify-content-between align-items-center mb-3">
                                    <span><i class="fas fa-ruler-combined me-2"></i>2500 sq.ft</span>
                                    <span class_price">₹21000<small>/night</small></span>
                                </div>
                                <div class="d-flex">
                                    <a href="../accommodations/villa3.php"><button class="btn btn-book w-100">View More</button></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Icon event handlers
        document.querySelector('.fa-heart').addEventListener('click', function() {
            alert('Liked items page');
        });

        document.querySelector('.fa-shopping-cart').addEventListener('click', function() {
            alert('Cart page');
        });

        document.querySelector('.fa-user').addEventListener('click', function() {
            alert('Profile page');
        });

        // Animation trigger
        document.addEventListener('DOMContentLoaded', function() {
            const fadeElements = document.querySelectorAll('.fade-in');
            const fadeInObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.opacity = 1;
                    }
                });
            }, { threshold: 0.1 });
            
            fadeElements.forEach(element => {
                element.style.opacity = 0;
                element.style.transition = 'opacity 0.6s ease-out';
                fadeInObserver.observe(element);
            });
        });

        // --- UPDATED Filter & Availability Logic ---
        document.getElementById('filterBtn').addEventListener('click', async () => {
            const selectedType = document.getElementById('roomType').value;
            const selectedPriceRange = document.getElementById('priceRange').value;
            const selectedBedType = document.getElementById('bedType').value;
            const checkIn = document.getElementById('checkInDate').value;
            const checkOut = document.getElementById('checkOutDate').value;
            const filterStatus = document.getElementById('filter-status');

            let unavailableIds = [];

            // 1. Check Availability (if dates are entered)
            if (checkIn && checkOut) {
                // This validation check is still important
                if (checkOut <= checkIn) {
                    alert('Check-out date must be after check-in date.');
                    return;
                }
                
                filterStatus.style.display = 'block';
                filterStatus.innerHTML = `<span class="text-primary">Checking availability...</span>`;
                
                try {
                    const response = await fetch(`../Booking&Public_APIs/check_availability.php?check_in=${checkIn}&check_out=${checkOut}`);
                    const data = await response.json();
                    
                    if (data.error) {
                        alert('Error checking availability: ' + data.error);
                        filterStatus.innerHTML = `<span class="text-danger">Error.</span>`;
                        return;
                    } else {
                        unavailableIds = data.unavailable_ids;
                        filterStatus.innerHTML = `<span class="text-success">Done.</span>`;
                    }
                } catch (error) {
                    console.error('Fetch error:', error);
                    filterStatus.innerHTML = `<span class="text-danger">Failed to check.</span>`;
                }
            } else {
                 filterStatus.style.display = 'none';
            }

            // 2. Apply All Filters (Client-side)
            const activeTabPane = document.querySelector('.tab-pane.active');
            const accommodationItems = activeTabPane.querySelectorAll('.accommodation-item');

            const parsePrice = (rangeStr) => {
                if (rangeStr === 'All Prices') return { min: 0, max: Infinity };
                if (rangeStr === '₹15000') return { min: 15000, max: Infinity };
                const parts = rangeStr.replace(/₹/g, '').split(' - ');
                return { min: parseInt(parts[0], 10), max: parseInt(parts[1], 10) };
            };
            const priceFilter = parsePrice(selectedPriceRange);

            let resultsFound = 0;
            accommodationItems.forEach(item => {
                const card = item.querySelector('.card');
                if (!card) return;

                // Get data from the card's data-* attributes
                const itemType = card.dataset.type;
                const itemPrice = parseInt(card.dataset.price, 10);
                const itemBed = card.dataset.bed;
                const itemAccId = parseInt(card.dataset.accId, 10);

                // Check filter criteria
                let typeMatch = (selectedType === 'All Types') || (itemType === selectedType);
                let bedMatch = (selectedBedType === 'Any') || (itemBed === selectedType);
                let priceMatch = (itemPrice >= priceFilter.min && itemPrice <= priceFilter.max);
                
                // NEW: Check availability
                // If dates were entered, check if the ID is in the unavailable list
                let availabilityMatch = true; // Default to available
                if (checkIn && checkOut) {
                    availabilityMatch = !unavailableIds.includes(itemAccId);
                }

                // For villas, the 'Room Type' and 'Bed Type' filters are not applicable
                if (activeTabPane.id === 'villas') {
                    typeMatch = true;
                    bedMatch = true;
                }

                // Show or hide the item
                if (typeMatch && bedMatch && priceMatch && availabilityMatch) {
                    item.style.display = 'block';
                    resultsFound++;
                } else {
                    item.style.display = 'none';
                }
            });
            
             if (resultsFound === 0) {
                // You can add a "No results" message here if you want
            }
        });

        // --- FIX FOR DATE PICKERS ---
        // Set min date for date pickers to today and link them
        document.addEventListener('DOMContentLoaded', () => {
            const checkInInput = document.getElementById('checkInDate');
            const checkOutInput = document.getElementById('checkOutDate');
            
            const today = new Date().toISOString().split('T')[0];
            checkInInput.setAttribute('min', today);
            checkOutInput.setAttribute('min', today);

            // This is the new logic to link the dates
            checkInInput.addEventListener('change', () => {
                const checkInDate = checkInInput.value;
                if (checkInDate) {
                    // Create a Date object from the check-in value
                    const minCheckoutDate = new Date(checkInDate);
                    // Add one day
                    minCheckoutDate.setDate(minCheckoutDate.getDate() + 1);
                    
                    // Format to YYYY-MM-DD string
                    const minDateString = minCheckoutDate.toISOString().split('T')[0];
                    
                    // Set the min attribute for the check-out input
                    checkOutInput.setAttribute('min', minDateString);

                    // Optional: Clear checkout if it's no longer valid
                    if (checkOutInput.value && checkOutInput.value < minDateString) {
                        checkOutInput.value = '';
                    }
                } else {
                    // If check-in is cleared, reset check-out min to today
                    checkOutInput.setAttribute('min', today);
                }
            });
        });
    
    </script>
</body>
</html>