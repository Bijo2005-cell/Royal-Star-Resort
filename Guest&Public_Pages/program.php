<?php
// /Guest&Public_Pages/program.php

// --- FIXED PATH ---
include $_SERVER['DOCUMENT_ROOT'] . '/miniproject/Database/db_connect.php';

$programs_for_js = [];

// --- Check for connection error ---
if (isset($conn) && !$conn->connect_error) {
    // Connection was successful, proceed to get data
    $sql = "SELECT * FROM programs";
    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            
            // --- Synthesize the 'dates' field ---
            $dates_map = [
                1 => '3 Nights', 2 => '4 Nights', 3 => '5 Nights',
                4 => 'Per Person', 5 => 'Per Person', 6 => 'Starting Price',
                7 => 'Starting Price', 8 => 'On all suites', 9 => 'On deluxe rooms',
                10 => 'For stays of 5+ nights'
            ];
            $dates = $dates_map[$row['program_id']] ?? 'Details';

            // --- Synthesize the 'link' field ---
            $link_map = [
                1 => '/miniproject/program/honeymoon_package.php',
                2 => '/miniproject/program/family_package.php',
                3 => '/miniproject/program/wellness_retreat.php',
                4 => '/miniproject/program/foodfestival_event.php',
                5 => '/miniproject/program/cultural_event.php',
                6 => '/miniproject/program/wedding_function.php',
                7 => '/miniproject/program/birthday_parties.php',
                8 => '/miniproject/program/summer_offer.php',
                9 => '/miniproject/program/weekend_offer.php',
                10 => '/miniproject/program/extended_offer.php'
            ];
            $link = $link_map[$row['program_id']] ?? '#';

            // Build the array
            $programs_for_js[] = [
                'id' => (int)$row['program_id'],
                'type' => $row['type'],
                'title' => $row['title'],
                'description' => $row['description'],
                'price' => $row['price'],
                'dates' => $dates,
                'image' => $row['image'],
                'link' => $link
            ];
        }
    }
    $conn->close();
}
// If $conn was NOT set or had an error, $programs_for_js will be an empty array.
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Offerings</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="../Styling&Scripts/style1.css" >  
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">Royal <span>Star</span> Resort</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                 <div class="d-flex align-items-center ms-auto">
                     <i class="fas fa-heart icon-btn" title="Wishlist"></i>
                     <i class="fas fa-shopping-cart icon-btn" title="Cart"></i>
                     <i class="fas fa-user icon-btn" title="Profile"></i>
                 </div>
            </div>
        </div>
    </nav>

    <section class="hero-section">
        <div class="container hero-content">
            <h1 class="display-4 fw-bold animate__animated animate__fadeInDown">Our Exclusive Offerings</h1>
            <p class="lead fs-4 animate__animated animate__fadeInUp animate__delay-1s">Curated experiences for every occasion</p>
            <div class="animate__animated animate__fadeInUp animate__delay-2s">
                <a href="#offerings" class="btn btn-lg px-4 py-2" style="background-color: var(--secondary-color); border: none; color: var(--dark-color); font-weight: 600;">Explore All</a>
            </div>
        </div>
    </section>

    <section id="offerings" class="py-5">
        <div class="container">
            <h2 class="section-title">Find Your Perfect Experience</h2>
            <p class="text-center text-muted mb-4">Select a category to find exactly what you're looking for.</p>
            
            <div class="availability-check-section bg-light p-4 rounded mb-5 shadow-sm">
                <h3 class="text-center mb-3 fw-bold">Check Program Availability</h3>
                <form class="row g-3 justify-content-center align-items-end" onsubmit="return false;">
                    <div class="col-md-3 col-sm-6">
                        <label for="checkin-date" class="form-label">Check-In</label>
                        <input type="date" class="form-control" id="checkin-date">
                    </div>
                    <div class="col-md-3 col-sm-6">
                        <label for="checkout-date" class="form-label">Check-Out</label>
                        <input type="date" class="form-control" id="checkout-date">
                    </div>
                    <div class="col-md-3 col-12 d-flex align-items-end">
                        <button type="button" id="check-availability-btn" class="btn w-100" style="background-color: var(--primary-color); border: none; color: white; padding: 0.55rem 0.75rem;">Check Availability</button>
                    </div>
                </form>
            </div>

            <div id="filter-buttons" class="text-center mb-5">
                <button class="btn active" data-filter="all">All</button>
                <button class="btn" data-filter="package">Packages</button>
                <button class="btn" data-filter="event">Events</button>
                <button class="btn" data-filter="function">Functions</button>
                <button class="btn" data-filter="offer">Offers</button>
            </div>
            
            <div class="row" id="offerings-grid"></div>
        </div>
    </section>
    
    <footer>
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-5 mb-lg-0">
                    <a href="#" class="footer-logo">Royal <span>Star</span> Residency</a>
                    <div class="footer-about">
                        <p>Experience unparalleled luxury and exceptional service at our award-winning resort. We're dedicated to creating unforgettable experiences for our guests.</p>
                        <div class="social-icons">
                            <a href="#"><i class="fab fa-facebook-f"></i></a>
                            <a href="#"><i class="fab fa-twitter"></i></a>
                            <a href="#"><i class="fab fa-instagram"></i></a>
                            <a href="#"><i class="fab fa-linkedin-in"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <div class="footer-links">
                        <h4>Quick Links</h4>
                        <ul>
                            <li><a href="#home">Home</a></li>
                            <li><a href="#rooms">Rooms</a></li>
                            <li><a href="#services">Services</a></li>
                            <li><a href="#about">About Us</a></li>
                            <li><a href="#contact">Contact</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-2 col-md-4 mb-5 mb-md-0">
                    <div class="footer-links">
                        <h4>Services</h4>
                        <ul>
                            <li><a href="#">Spa & Wellness</a></li>
                            <li><a href="#">Dining</a></li>
                            <li><a href="#">Events</a></li>
                            <li><a href="#">Activities</a></li>
                            <li><a href="#">Concierge</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-lg-4 col-md-4">
                    <div class="footer-newsletter">
                        <h4>Newsletter</h4>
                        <p>Subscribe to our newsletter for special offers and updates.</p>
                        <form class="newsletter-form">
                            <input type="email" class="newsletter-input" placeholder="Your Email">
                            <button type="submit" class="newsletter-btn"><i class="fas fa-paper-plane"></i></button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p>© 2023 Royal Star Residency. All Rights Reserved. | <a href="#">Privacy Policy</a> | <a href="#">Terms & Conditions</a></p>
            </div>
        </div>
    </footer>

    <a href="#" class="btn back-to-top" style="position: fixed; bottom: 20px; right: 20px; width: 50px; height: 50px; border-radius: 50%; background-color: var(--secondary-color); color: var(--dark-color); border: none; font-size: 20px; display: none; align-items: center; justify-content: center; box-shadow: 0 4px 10px rgba(0,0,0,0.2);">
        <i class="fas fa-arrow-up"></i>
    </a>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // --- DATA SOURCE (FROM DATABASE) ---
        const items = <?php echo json_encode($programs_for_js, JSON_PRETTY_PRINT); ?>;

        // --- GENERAL UI SCRIPTS ---
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled', 'navbar-light');
                navbar.classList.remove('navbar-dark');
            } else {
                navbar.classList.remove('scrolled', 'navbar-light');
                navbar.classList.add('navbar-dark');
            }
        });
        const backToTopButton = document.querySelector('.back-to-top');
        window.addEventListener('scroll', function() {
            if (window.scrollY > 300) {
                backToTopButton.style.display = 'flex';
            } else {
                backToTopButton.style.display = 'none';
            }
        });
        backToTopButton.addEventListener('click', function(e) {
            e.preventDefault();
            window.scrollTo({ top: 0, behavior: 'smooth' });
        });


        // --- DYNAMIC CONTENT RENDERING & FILTERING ---
        document.addEventListener('DOMContentLoaded', function () {
            const offeringsGrid = document.getElementById('offerings-grid');
            const filterButtons = document.querySelectorAll('#filter-buttons .btn');

            // Function to format price
            function formatPrice(price, dates) {
                if (!isNaN(price) && !isNaN(parseFloat(price))) {
                     return `₹${Number(price).toLocaleString('en-IN')} <small class="text-muted">/ ${dates}</small>`;
                }
                return `${price} <small class="text-muted">/ ${dates}</small>`;
            }
            
            // Function to determine button text
            function getButtonText(type) {
                switch(type) {
                    case 'function': return 'Enquire Now';
                    case 'event': return 'Get Tickets';
                    default: return 'Book Now';
                }
            }

            // Function to render items to the grid
            function renderOfferings(itemsToRender) {
                offeringsGrid.innerHTML = ''; // Clear existing items
                
                // Check if items came from DB first
                if (items.length === 0 && itemsToRender.length === 0) {
                    // This means the initial page load from PHP failed
                    offeringsGrid.innerHTML = '<p class="text-center text-danger">Could not load offerings. Database connection may have failed.</p>';
                    return;
                }
                
                if (!itemsToRender || itemsToRender.length === 0) {
                    // This means the API check found no items
                    offeringsGrid.innerHTML = '<p class="text-center">No offerings found for the selected dates.</p>';
                    return;
                }

                itemsToRender.forEach(item => {
                    const cardHTML = `
                        <div class="col-lg-4 col-md-6 mb-4 filter-item ${item.type}">
                            <div class="card offering-card animate__animated animate__fadeInUp">
                                <img src="${item.image}" class="card-img-top" alt="${item.title}">
                                <div class="card-body d-flex flex-column">
                                    <h5 class="card-title">${item.title}</h5>
                                    <p class="card-text flex-grow-1">${item.description}</p>
                                    <div class="price">${formatPrice(item.price, item.dates)}</div>
                                    <a href="${item.link}" class="btn btn-book">${getButtonText(item.type)}</a>
                                 </div>
                            </div>
                        </div>
                    `;
                    offeringsGrid.insertAdjacentHTML('beforeend', cardHTML);
                });
            }

            // Filtering Logic Setup
            function setupFiltering() {
                filterButtons.forEach(button => {
                    button.addEventListener('click', function () {
                        filterButtons.forEach(btn => btn.classList.remove('active'));
                        this.classList.add('active');

                        const filterValue = this.getAttribute('data-filter');
                        const filterItems = document.querySelectorAll('.filter-item'); 

                        filterItems.forEach(item => {
                            item.classList.remove('animate__animated', 'animate__zoomIn', 'animate__zoomOut');
                            
                            if (filterValue === 'all' || item.classList.contains(filterValue)) {
                                item.classList.remove('hide');
                                item.classList.add('animate__animated', 'animate__zoomIn');
                            } else {
                                item.classList.add('animate__animated', 'animate__zoomOut');
                                setTimeout(() => {
                                    item.classList.add('hide');
                                }, 500); // match animation duration
                            }
                        });
                    });
                });
            }

            // --- RENDER INITIAL DATA ---
            renderOfferings(items);
            setupFiltering();


            // ===================================================
            // === AVAILABILITY CHECK LOGIC ===
            // ===================================================
            const checkBtn = document.getElementById('check-availability-btn');
            const checkInInput = document.getElementById('checkin-date');
            const checkOutInput = document.getElementById('checkout-date');

            checkBtn.addEventListener('click', function() {
                const checkIn = checkInInput.value;
                const checkOut = checkOutInput.value;

                if (!checkIn || !checkOut) {
                    alert('Please select both a Check-In and Check-Out date.');
                    return;
                }
                if (new Date(checkOut) < new Date(checkIn)) {
                    alert('Check-Out date must be after the Check-In date.');
                    return;
                }

                checkBtn.disabled = true;
                checkBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Checking...';

                // Use the absolute path
                const apiUrl = `/miniproject/Booking&Public_APIs/api_program.php?check_in=${checkIn}&check_out=${checkOut}`;
                
                fetch(apiUrl)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok: ' + response.statusText);
                        }
                        return response.json(); 
                    })
                    .then(data => {
                        if (data.status === 'success') {
                            
                            // Filter the master 'items' list
                            const availableItems = items.filter(item => {
                                return data.available_ids.includes(item.id);
                            });
                            
                            renderOfferings(availableItems); // Re-render with only available items

                            // Reset category filters to 'All'
                            filterButtons.forEach(btn => btn.classList.remove('active'));
                            document.querySelector('#filter-buttons .btn[data-filter="all"]').classList.add('active');

                        } else {
                            alert('Error: ' + data.message);
                        }
                        
                        checkBtn.disabled = false;
                        checkBtn.innerHTML = 'Check Availability';
                    })
                    .catch(error => {
                        console.error('Fetch Error:', error);
                        alert('An error occurred while checking availability. The API path may be wrong or the server is down.');
                        checkBtn.disabled = false;
                        checkBtn.innerHTML = 'Check Availability';
                    });
            });

        });
    </script>
</body>
</html>