<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Residency - Luxury Resort</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <!-- Custom CSS (ensure style.css exists and doesn't hide sections) -->
    <link rel="stylesheet" href="../Styling&Scripts/style.css">
</head>
<body>
    <!-- Header Section -->
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" >Royal <span>Star</span> Resort</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item">
                            <a class="nav-link" href="#home">Home</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#rooms">Rooms</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#services">Services</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Contact</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">About</a>
                        </li>
                       <a class="nav-link login-btn" href="../Guest&Public_Pages/register.php">Login</a>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <!-- Home Section --> 
    <section id="home" class="hero-section">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../photos/bg1.jpg" class="d-block w-100" alt="Hero Image 1">
                </div>
                <div class="carousel-item">
                    <img src="../photos/bg2.jpg" class="d-block w-100" alt="Hero Image 2">
                </div>
                <div class="carousel-item">
                    <img src="../photos/bg3.jpg" class="d-block w-100" alt="Hero Image 3">
                </div>
                <div class="carousel-item">
                    <img src="../photos/bg4.jpg" class="d-block w-100" alt="Hero Image 4">
                </div>
                <div class="carousel-item">
                    <img src="../photos/bg5.jpg" class="d-block w-100" alt="Hero Image 5">
                </div>
                <div class="carousel-item">
                    <img src="../photos/bg6.jpg" class="d-block w-100" alt="Hero Image 6">
                </div>
                <div class="carousel-item">
                    <img src="../photos/bg7.jpg" class="d-block w-100" alt="Hero Image 7">
                </div>
                <div class="carousel-item">
                    <img src="../photos/bg8.jpg" class="d-block w-100" alt="Hero Image 8">
                </div>
                <div class="carousel-item">
                    <img src="../photos/bg9.jpg" class="d-block w-100" alt="Hero Image 9">
                </div>
            </div>
            <button class="carousel-control-prev" type="button" data-bs-target="#heroCarousel" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
        </div>
        
        <div class="hero-content">
            <h1>Welcome to Royal Star Resort</h1>
            <p>Experience luxury and comfort in our world-class resort</p>
            <a href="../Guest&Public_Pages/rooms.html" id="exploreBtn" class="btn hero-btn">Explore Rooms</a>
        </div>
    </section>

    <!-- Booking Form -->
    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="booking-form-container">
                        <form>
                            <div class="row">
                                <div class="col-md-3 mb-3">
                                    <label for="checkIn" class="form-label">Check In</label>
                                    <input type="date" class="form-control" id="checkIn">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="checkOut" class="form-label">Check Out</label>
                                    <input type="date" class="form-control" id="checkOut">
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="adults" class="form-label">Adults</label>
                                    <select class="form-select" id="adults">
                                        <option value="1">1 Adult</option>
                                        <option value="2">2 Adults</option>
                                        <option value="3">3 Adults</option>
                                        <option value="4">4 Adults</option>
                                    </select>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <label for="children" class="form-label">Children</label>
                                    <select class="form-select" id="children">
                                        <option value="0">0 Children</option>
                                        <option value="1">1 Child</option>
                                        <option value="2">2 Children</option>
                                        <option value="3">3 Children</option>
                                    </select>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-12">
                                    <button type="submit" class="btn check-availability-btn">Check Availability</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Best-Selling Rooms -->
    <section id="rooms" class="py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>Best-Selling Rooms</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="../photos/rm3.jpg" class="img-fluid" alt="Deluxe Room">
                        </div>
                        <div class="room-body">
                            <h3 class="room-title">Deluxe Room</h3>
                            <p class="room-price">₹5000<span>/ night</span></p>
                            <p>Spacious room with king-size bed, modern amenities and stunning views.</p>
                            <a href="../accommodations/room1.php" class="btn room-btn">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="../photos/rm1.jpg" class="img-fluid" alt="Premium Room">
                        </div>
                        <div class="room-body">
                            <h3 class="room-title">Premium Room</h3>
                            <p class="room-price">₹6000<span>/ night</span></p>
                            <p>Luxurious suite with separate living area, premium amenities and ocean view.</p>
                            <a href="../accommodations/room6.php" class="btn room-btn">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="../photos/rm2.jpg" class="img-fluid" alt="Superior Room">
                        </div>
                        <div class="room-body">
                            <h3 class="room-title">Superior Room</h3>
                            <p class="room-price">₹3500<span>/ night</span></p>
                            <p>Ultimate luxury with expansive space, premium services and panoramic views.</p>
                            <a href="../accommodations/room7.php" class="btn room-btn">View Details</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="room-card">
                        <div class="room-img">
                            <img src="../photos/villa1.jpeg" class="img-fluid" alt="Classic Room">
                        </div>
                        <div class="room-body">
                            <h3 class="room-title">Garden Villa</h3>
                            <p class="room-price">₹17200<span>/ night</span></p>
                            <p>A classic room exudes timeless elegance with rich wood furnishings, neutral tones, and refined details.</p>
                            <a href="../accommodations/Villa1.php" class="btn room-btn">View Details</a>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-next" type="button" data-bs-target="#heroCarousel" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
            </button>
            </div>
        </div>
    </section>

    <!-- Limited Time Offer -->
    <section id="rooms" class="py-5">
        <div class="container">
            <div class="section-title text-center mb-5">
                <h2>Exclusive Resort Offers</h2>
                <p class="lead">Discover our limited-time packages designed for your perfect stay.</p>
            </div>
    
            <div class="row g-4">
                <div class="col-md-6 col-lg-4">
                    <div class="offer-card-v2">
                        <div class="offer-image-wrapper">
                            <img src="../photos/limited1.jpg" class="offer-img" alt="Luxury suite with a view">
                            <div class="discount-ribbon"><span>30% OFF</span></div>
                        </div>
                        <div class="card-content">
                            <span class="badge-offer">Limited Time</span>
                            <h3 class="offer-title">Summer Escape Special</h3>
                            <div class="offer-details">
                                <p class="offer-description">Enjoy incredible savings on all rooms plus complimentary breakfast for your dream vacation!</p>
                                <div class="countdown-container">
                                    <p class="countdown-title">Offer ends in:</p>
                                    <div class="countdown-timer">
                                        <div class="countdown-item"><span id="days-1">07</span><small>Days</small></div>
                                        <div class="countdown-item"><span id="hours-1">12</span><small>Hours</small></div>
                                        <div class="countdown-item"><span id="minutes-1">45</span><small>Mins</small></div>
                                        <div class="countdown-item"><span id="seconds-1">30</span><small>Secs</small></div>
                                    </div>
                                </div>
                                <a href="../program/summer_offer.php" class="btn btn-details">View Details <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
    
                <div class="col-md-6 col-lg-4">
                    <div class="offer-card-v2">
                        <div class="offer-image-wrapper">
                            <img src="../photos/limited2.jpg" class="offer-img" alt="Cozy room for a weekend getaway">
                            <div class="discount-ribbon"><span>25% OFF</span></div>
                        </div>
                        <div class="card-content">
                            <span class="badge-offer">Weekend Only</span>
                            <h3 class="offer-title">Weekend Getaway</h3>
                            <div class="offer-details">
                                <p class="offer-description">A perfect escape with amazing amenities and unbeatable comfort for your weekend retreat.</p>
                                <div class="countdown-container">
                                    <p class="countdown-title">Offer ends in:</p>
                                    <div class="countdown-timer">
                                        <div class="countdown-item"><span id="days-2">02</span><small>Days</small></div>
                                        <div class="countdown-item"><span id="hours-2">08</span><small>Hours</small></div>
                                        <div class="countdown-item"><span id="minutes-2">22</span><small>Mins</small></div>
                                        <div class="countdown-item"><span id="seconds-2">15</span><small>Secs</small></div>
                                    </div>
                                </div>
                                <a href="../program/weekend_offer.php" class="btn btn-details">View Details <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-md-6 col-lg-4">
                    <div class="offer-card-v2">
                        <div class="offer-image-wrapper">
                            <img src="../photos/limited3.jpg" class="offer-img" alt="Spacious room for an extended stay">
                            <div class="discount-ribbon"><span>40% OFF</span></div>
                        </div>
                        <div class="card-content">
                            <span class="badge-offer">Long Stay</span>
                            <h3 class="offer-title">Extended Stay Deal</h3>
                            <div class="offer-details">
                                <p class="offer-description">Stay 5+ nights and save big with our exclusive long-term package for extended comfort.</p>
                                <div class="countdown-container">
                                    <p class="countdown-title">Offer ends in:</p>
                                    <div class="countdown-timer">
                                        <div class="countdown-item"><span id="days-3">14</span><small>Days</small></div>
                                        <div class="countdown-item"><span id="hours-3">06</span><small>Hours</small></div>
                                        <div class="countdown-item"><span id="minutes-3">18</span><small>Mins</small></div>
                                        <div class="countdown-item"><span id="seconds-3">45</span><small>Secs</small></div>
                                    </div>
                                </div>
                                <a href="../program/extended_offer.php" class="btn btn-details">View Details <i class="fas fa-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
    
            </div>
        </div>
    </section>
    <!-- Packages -->
   
    <section id="packages" class="py-5 bg-light" style="display: block; visibility: visible; opacity: 1; min-height: 200px;">
        <div class="container">
            <div class="section-title">
                <h2>Our Packages</h2>
            </div>
            <div class="row" style="display: flex; flex-wrap: wrap;">
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="package-card" style="display: block; visibility: visible; opacity: 1;">
                        <div class="package-img">
                            <img src="../photos/packagehoney.jpg" class="img-fluid" alt="Honeymoon Package" onerror="this.src='https://via.placeholder.com/300x200?text=Honeymoon+Package';">
                        </div>
                        <div class="package-body">
                            <h3 class="package-title">Honeymoon Package</h3>
                            <p class="package-price"> ₹16000 <span>/3 nights</span></p>
                            <ul class="package-features">
                                <li><i class="fas fa-check-circle me-2"></i> Luxury Suite</li>
                                <li><i class="fas fa-check-circle me-2"></i> Champagne & Chocolate</li>
                                <li><i class="fas fa-check-circle me-2"></i> Couples Spa Treatment</li>
                                <li><i class="fas fa-check-circle me-2"></i> Romantic Dinner</li>
                                <li><i class="fas fa-check-circle me-2"></i> Late Checkout</li>
                            </ul>
                            <a href="../program/honeymoon_package.php" class="btn package-btn">View Details </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="package-card" style="display: block; visibility: visible; opacity: 1;">
                        <div class="package-img">
                            <img src="../photos/packagefamily.jpg" class="img-fluid" alt="Family Package" onerror="this.src='https://via.placeholder.com/300x200?text=Family+Package';">
                        </div>
                        <div class="package-body">
                            <h3 class="package-title">Family Package</h3>
                            <p class="package-price"> ₹19000 <span>/4 nights</span></p>
                            <ul class="package-features">
                                <li><i class="fas fa-check-circle me-2"></i> Connecting Rooms</li>
                                <li><i class="fas fa-check-circle me-2"></i> Kids Club Access</li>
                                <li><i class="fas fa-check-circle me-2"></i> Family Activities</li>
                                <li><i class="fas fa-check-circle me-2"></i> Breakfast Included</li>
                                <li><i class="fas fa-check-circle me-2"></i> Poolside Cabana</li>
                            </ul>
                            <a href="../program/family_package.php" class="btn package-btn">View Details </a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4">
                    <div class="package-card" style="display: block; visibility: visible; opacity: 1;">
                        <div class="package-img">
                            <img src="../photos/packagewellness.jpg" class="img-fluid" alt="Wellness Retreat" onerror="this.src='https://via.placeholder.com/300x200?text=Wellness+Retreat';">
                        </div>
                        <div class="package-body">
                            <h3 class="package-title">Wellness Retreat</h3>
                            <p class="package-price">₹22000 <span>/5 nights</span></p>
                            <ul class="package-features">
                                <li><i class="fas fa-check-circle me-2"></i> Daily Yoga Sessions</li>
                                <li><i class="fas fa-check-circle me-2"></i> Spa Treatments</li>
                                <li><i class="fas fa-check-circle me-2"></i> Healthy Gourmet Meals</li>
                                <li><i class="fas fa-check-circle me-2"></i> Personal Trainer</li>
                                <li><i class="fas fa-check-circle me-2"></i> Meditation Classes</li>
                            </ul>
                            <a href="../program/wellness_retreat.php" class="btn package-btn">View Details </a>
                        </div>
                    </div>
                </div>
            </div> 
        </div> 
    </section>
        
    <!-- Events & Functions -->
    <section class="py-5">
        <div class="container">
            <div class="section-title">
                <h2>Events & Functions</h2>
            </div>
            <div id="eventsCarousel" class="carousel slide events-carousel" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <img src="../photos/wedding.png" class="d-block w-100" alt="Weddings">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Weddings</h5>
                            <p>Make your special day unforgettable with our stunning wedding venues.</p>
                                                            <div class="text-center mt-4">
                                    <a href="../program/wedding_function.php" class="btn btn-primary-offer btn-lg px-5 py-3">View Details </a>
                                </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="../photos/Conference.jpg" class="d-block w-100" alt="Conferences">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Conferences</h5>
                            <p>State-of-the-art facilities for your business meetings and conferences.</p>
                                                            <div class="text-center mt-4">
                                    <a href="../program/cultural_event.php" class="btn btn-primary-offer btn-lg px-5 py-3">View Details </a>
                                </div>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <img src="../photos/banquent.jpg" class="d-block w-100" alt="Banquets">
                        <div class="carousel-caption d-none d-md-block">
                            <h5>Banquets</h5>
                            <p>Elegant spaces for your celebrations and special occasions.</p>
                                                            <div class="text-center mt-4">
                                    <a href="../program/birthday_function.php" class="btn btn-primary-offer btn-lg px-5 py-3">View Details </a>
                                </div>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#eventsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#eventsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
    </section>

    <!-- FAQs -->
    <section id="faq" class="py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>Frequently Asked Questions</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-8">
                    <div class="accordion" id="faqAccordion">
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingOne">
                                <button class="accordion-button" type="button" data-bs-toggle="collapse" data-bs-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                    What are the check-in and check-out times?
                                </button>
                            </h2>
                            <div id="collapseOne" class="accordion-collapse collapse show" aria-labelledby="headingOne" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Our standard check-in time is 3:00 PM and check-out is at 11:00 AM. Early check-in and late check-out may be available upon request and subject to availability.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingTwo">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                    Is parking available at the resort?
                                </button>
                            </h2>
                            <div id="collapseTwo" class="accordion-collapse collapse" aria-labelledby="headingTwo" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, we offer complimentary valet parking for all our guests. Self-parking options are also available in our secure underground parking facility.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingThree">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                    Do you have pet-friendly rooms?
                                </button>
                            </h2>
                            <div id="collapseThree" class="accordion-collapse collapse" aria-labelledby="headingThree" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Yes, we have designated pet-friendly rooms available upon request. Additional charges and pet policies apply. Please inform us in advance if you plan to bring a pet.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFour">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFour" aria-expanded="false" aria-controls="collapseFour">
                                    What dining options are available?
                                </button>
                            </h2>
                            <div id="collapseFour" class="accordion-collapse collapse" aria-labelledby="headingFour" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    We have restaurant offering a variety of cuisines, including our signature fine dining restaurant, a casual poolside grill, and an all-day dining café. Room service is also available 24/7.
                                </div>
                            </div>
                        </div>
                        <div class="accordion-item">
                            <h2 class="accordion-header" id="headingFive">
                                <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#collapseFive" aria-expanded="false" aria-controls="collapseFive">
                                    Is there a cancellation policy?
                                </button>
                            </h2>
                            <div id="collapseFive" class="accordion-collapse collapse" aria-labelledby="headingFive" data-bs-parent="#faqAccordion">
                                <div class="accordion-body">
                                    Cancellations made 24 hours or more prior to arrival will not incur any charges. For cancellations within 24 hours of arrival, one night's room rate will be charged. Special packages may have different cancellation policies.
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services -->
    <section id="services" class="py-5">
        <div class="container">
            <div class="section-title">
                <h2>Our Amenities</h2>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-spa"></i>
                        </div>
                        <h4 class="service-title">Spa & Wellness</h4>
                        <p>Indulge in our world-class spa treatments and wellness programs designed to rejuvenate your mind and body.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-swimming-pool"></i>
                        </div>
                        <h4 class="service-title">Infinity Pool</h4>
                        <p>Relax by our stunning infinity pool with panoramic views and premium poolside service.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-utensils"></i>
                        </div>
                        <h4 class="service-title">Fine Dining</h4>
                        <p>Experience exquisite culinary creations from our award-winning chefs at our multiple dining venues.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-concierge-bell"></i>
                        </div>
                        <h4 class="service-title">24/7 Concierge</h4>
                        <p>Our dedicated concierge team is available around the clock to assist with all your needs.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h4 class="service-title">High-Speed Wi-Fi</h4>
                        <p>Stay connected with our complimentary high-speed internet access throughout the resort.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-dumbbell"></i>
                        </div>
                        <h4 class="service-title">Fitness Center</h4>
                        <p>State-of-the-art fitness facilities with personal training services available upon request.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-child"></i>
                        </div>
                        <h4 class="service-title">Kids Club</h4>
                        <p>Fun and engaging activities for children supervised by our professional childcare staff.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-shuttle-van"></i>
                        </div>
                        <h4 class="service-title">Shuttle Service</h4>
                        <p>Complimentary shuttle service to nearby attractions and shopping areas.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Customer Experiences -->
<section class="py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="display-4">Guest Stories</h2>
            <p class="lead text-muted">Hear what our valued guests say about their Royal Star experience</p>
        </div>
        
        <div id="testimonialsCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner px-4">
                <!-- Testimonial 1 -->
                <div class="carousel-item active">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="testimonial-card p-4 p-lg-12 shadow-sm rounded-4">
                                <div class="stars mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <div class="quote-icon mb-4">
                                    <i class="fas fa-quote-left fa-2x text-primary opacity-25"></i>
                                </div>
                                <p class="testimonial-text fs-5 mb-4">"Our stay at Royal Star Residency was absolutely perfect. The staff went above and beyond to make our anniversary special. The room was luxurious, the food was exquisite, and the spa treatments were rejuvenating. We can't wait to return!"</p>
                                <div class="testimonial-author d-flex align-items-center">
                                    <div class="author-avatar me-4">
                                        <img src="" alt="Noyal Jaison" class="rounded-circle shadow" width="100" height="80">
                                    </div>
                                    <div>
                                        <h5 class="author-name mb-1">Noyal Jaison</h5>
                                        <p class="author-location text-muted mb-0">Kerala, India</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 2 -->
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="testimonial-card p-4 p-lg-7 shadow-sm rounded-5">
                                <div class="stars mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <div class="quote-icon mb-4">
                                    <i class="fas fa-quote-left fa-2x text-primary opacity-25"></i>
                                </div>
                                <p class="testimonial-text fs-5 mb-4">"The attention to detail at this resort is remarkable. From the moment we arrived, everything was flawless. The concierge helped us plan amazing excursions, and our suite had the most breathtaking ocean view. Truly a five-star experience."</p>
                                <div class="testimonial-author d-flex align-items-center">
                                    <div class="author-avatar me-4">
                                        <img src="" alt="Avani" class="rounded-circle shadow" width="80" height="80">
                                    </div>
                                    <div>
                                        <h5 class="author-name mb-1">Avani </h5>
                                        <p class="author-location text-muted mb-0">Kerala, India</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Testimonial 3 -->
                <div class="carousel-item">
                    <div class="row justify-content-center">
                        <div class="col-lg-12">
                            <div class="testimonial-card p-4 p-lg-5 shadow-sm rounded-4">
                                <div class="stars mb-3">
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                    <i class="fas fa-star text-warning"></i>
                                </div>
                                <div class="quote-icon mb-4">
                                    <i class="fas fa-quote-left fa-2x text-primary opacity-25"></i>
                                </div>
                                <p class="testimonial-text fs-5 mb-4">"We hosted our wedding at Royal Star Residency and it exceeded all our expectations. The event team was incredibly professional and made sure every detail was perfect. Our guests are still talking about how amazing everything was!"</p>
                                <div class="testimonial-author d-flex align-items-center">
                                    <div class="author-avatar me-4">
                                        <img src="" alt="Ananadu" class="rounded-circle shadow" width="80" height="80">
                                    </div>
                                    <div>
                                        <h5 class="author-name mb-1">Anandu</h5>
                                        <p class="author-location text-muted mb-0">Idukki</p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
           
           
        </div>
    </div>
</section>
    <!-- Why Choose Us -->
    <section id="why-choose-us" class="py-5" style="display: block; visibility: visible; opacity: 1; min-height: 200px;">
        <div class="container" style="display: block;">
            <div class="section-title">
                <h2>Why Choose Us</h2>
            </div>
            <div class="row" style="display: flex; flex-wrap: wrap; margin: 0;">
                <div class="col-lg-3 col-md-6 mb-4" style="padding: 0 15px;">
                    <div class="feature-box" style="display: block; visibility: visible; opacity: 1;">
                        <div class="feature-icon">
                            <i class="fas fa-ship"></i>
                        </div>
                        <h4 class="feature-title">Private Speed Boat Safari</h4>
                        <p>Exclusive private speed boat safari offering unparalleled access to hidden coastal gems and luxurious onboard amenities.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" style="padding: 0 15px;">
                    <div class="feature-box" style="display: block; visibility: visible; opacity: 1;">
                        <div class="feature-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4 class="feature-title">Award-Winning Service</h4>
                        <p>Consistently recognized for our exceptional hospitality and service.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" style="padding: 0 15px;">
                    <div class="feature-box" style="display: block; visibility: visible; opacity: 1;">
                        <div class="feature-icon">
                            <i class="fas fa-leaf"></i>
                        </div>
                        <h4 class="feature-title">Sustainable Luxury</h4>
                        <p>Committed to eco-friendly practices without compromising on luxury.</p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4" style="padding: 0 15px;">
                    <div class="feature-box" style="display: block; visibility: visible; opacity: 1;">
                        <div class="feature-icon">
                            <i class="fas fa-horse"></i>
                            <i class="fas fa-camel ms-2"></i>
                        </div>
                        <h4 class="feature-title">Horse And Camel Riding</h4>
                        <p>Indulge in curated horse and camel rides tailored for intimate exploration and elevated comfort.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Blog & History -->
    <section id="about" class="py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>Blog & History</h2>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="../photos/bg1.jpg" class="img-fluid" alt="History">
                        </div>
                        <div class="blog-body">
                            <p class="blog-date">June 15, 2023</p>
                            <h4 class="blog-title">The History of Royal Star Residency</h4>
                            <p>Nestled in the misty hills of Idukki, Royal Star Residency stands as a proud testimony to history, nature, and heritage. Once a quaint British-era bungalow that served as a haven for engineers and officials during the construction of the iconic Ponmudi Dam, this vintage structure has now been thoughtfully restored into a premium hilltop retreat—Royal Star Residency.</p>
                            <a href="#" class="blog-btn">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="../photos/blog1.png" class="img-fluid" alt="Family Stay">
                        </div>
                        <div class="blog-body">
                            <p class="blog-date">May 28, 2023</p>
                            <h4 class="blog-title">Make Every Stay Special at Royal Star Residency, the Perfect Destination for Family Comfort and Luxury.</h4>
                            <p>Nestled in a serene and accessible location, Royal Star Residency offers the perfect blend of warmth, elegance, and modern comfort. Designed with families in mind, our hotel features spacious rooms, thoughtful amenities, and a welcoming atmosphere that makes every guest feel at home.</p>
                            <a href="#" class="blog-btn">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="blog-card">
                        <div class="blog-img">
                            <img src="../photos/blog2.png" class="img-fluid" alt="Top Ten Resorts">
                        </div>
                        <div class="blog-body">
                            <p class="blog-date">April 10, 2023</p>
                            <h4 class="blog-title">Royal Star Residency: Your Perfect Escape among the Top Ten Resorts in Munnar</h4>
                            <p>Tucked away in the lush hills of Munnar, Royal Star Residency invites you to experience the ultimate blend of nature, comfort, and hospitality. Recognized among the top ten resorts in the region, our property offers an ideal retreat for couples, families, and travelers seeking peace, beauty, and premium service.</p>
                            <a href="#" class="blog-btn">Read More <i class="fas fa-arrow-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Maps & Nearest Viewpoints -->
    <section class="py-5">
        <div class="container">
            <div class="section-title">
                <h2>Location & Nearby Attractions</h2>
            </div>
            <div class="row mb-5">
                <div class="col-12">
                    <div class="map-container">
                        <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3932.071119426347!2d77.0539427!3d9.9603547!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b07a3889a82d0af%3A0x176a0866792fa0c3!2sDAM%20%26%20DALE%20TOURISM%20PROJECT%2CRAJAKKAD%20PONMUDI!5e0!3m2!1sen!2sin!4v1716123456789!5m2!1sen!2sin" 
                                allowfullscreen="" 
                                loading="lazy" 
                                referrerpolicy="no-referrer-when-downgrade">
                        </iframe>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6">
                    <div class="attraction-card">
                        <div class="attraction-img">
                            <img src="../photos/veiwpoint4.jpg" class="img-fluid" alt="Ponmudi Dam">
                        </div>
                        <div class="attraction-body">
                            <h5 class="attraction-title">Ponmudi Dam</h5>
                            <p>50 meter away</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="attraction-card">
                        <div class="attraction-img">
                            <img src="../photos/veiwpont3.jpg" class="img-fluid" alt="Ripple Waterfall">
                        </div>
                        <div class="attraction-body">
                            <h5 class="attraction-title">Ripple Waterfall</h5>
                            <p>2.5 kilometer away</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="attraction-card">
                        <div class="attraction-img">
                            <img src="../photos/veiwpoint2.jpg" class="img-fluid" alt="Kallimali Veiwpoint">
                        </div>
                        <div class="attraction-body">
                            <h5 class="attraction-title">Kallimali Veiwpoint</h5>
                            <p>2.4 kilometer away</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="attraction-card">
                        <div class="attraction-img">
                            <img src="../photos/veiwpoint1.jpg" class="img-fluid" alt="Ponmudi Hanging Bridge">
                        </div>
                        <div class="attraction-body">
                            <h5 class="attraction-title">Ponmudi Hanging Bridge</h5>
                            <p>400 meter away</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="attraction-card">
                        <div class="attraction-img">
                            <img src="../photos/veiwpoint5.jpg" class="img-fluid" alt="Anayirangal Dam">
                        </div>
                        <div class="attraction-body">
                            <h5 class="attraction-title">Anayirangal Dam</h5>
                            <p>35 kilometer away</p>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6">
                    <div class="attraction-card">
                        <div class="attraction-img">
                            <img src="../photos/veiwpoint6.jpg" class="img-fluid" alt="Chathurangapara Veiwpoint">
                        </div>
                        <div class="attraction-body">
                            <h5 class="attraction-title">Chathurangapara Veiwpoint</h5>
                            <p>54 kilometer away</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Rules of the Resort -->
    <section id="resort-rules" class="py-5 bg-light force-display" style="display: block !important; visibility: visible !important; opacity: 1 !important; min-height: 300px; position: relative; z-index: 1;">
        <div class="container" style="display: block !important; padding: 0;">
            <div class="section-title">
                <h2>Resort Rules</h2>
            </div>
            <div class="row justify-content-center" style="margin: 0 !important;">
                <div class="col-lg-8" style="padding: 0 !important;">
                    <ul class="rules-list" style="display: block !important; visibility: visible !important; opacity: 1 !important; padding: 0 !important; margin: 0 !important; list-style: none;">
                        <li style="display: flex !important; align-items: flex-start; margin-bottom: 1.5rem !important;">
                            <i class="fas fa-smoking-ban rule-icon" style="margin-right: 1rem !important; font-size: 1.5rem;"></i>
                            <div style="margin: 0 !important; padding: 0 !important;">
                                <h5>No Smoking</h5>
                                <p>Smoking is prohibited in all indoor areas. Designated smoking areas are available outside.</p>
                            </div>
                        </li>
                        <li style="display: flex !important; align-items: flex-start; margin-bottom: 1.5rem !important;">
                            <i class="fas fa-clock rule-icon" style="margin-right: 1rem !important; font-size: 1.5rem;"></i>
                            <div style="margin: 0 !important; padding: 0 !important;">
                                <h5>Quiet Hours</h5>
                                <p>Please observe quiet hours between 10:00 PM and 7:00 AM for the comfort of all guests.</p>
                            </div>
                        </li>
                        <li style="display: flex !important; align-items: flex-start; margin-bottom: 1.5rem !important;">
                            <i class="fas fa-swimming-pool rule-icon" style="margin-right: 1rem !important; font-size: 1.5rem;"></i>
                            <div style="margin: 0 !important; padding: 0 !important;">
                                <h5>Pool Rules</h5>
                                <p>Children under 12 must be supervised at all times. No glass containers in pool area.</p>
                            </div>
                        </li>
                        <li style="display: flex !important; align-items: flex-start; margin-bottom: 1.5rem !important;">
                            <i class="fas fa-utensils rule-icon" style="margin-right: 1rem !important; font-size: 1.5rem;"></i>
                            <div style="margin: 0 !important; padding: 0 !important;">
                                <h5>Dining Attire</h5>
                                <p>Proper attire is required in our restaurants. Swimwear is not permitted in dining areas.</p>
                            </div>
                        </li>
                        <li style="display: flex !important; align-items: flex-start; margin-bottom: 1.5rem !important;">
                            <i class="fas fa-paw rule-icon" style="margin-right: 1rem !important; font-size: 1.5rem;"></i>
                            <div style="margin: 0 !important; padding: 0 !important;">
                                <h5>Pet Policy</h5>
                                <p>Pets are only allowed in designated pet-friendly rooms with prior arrangement.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>
    <!-- Terms & Conditions -->
    <section class="py-5">
        <div class="container">
            <div class="section-title">
                <h2>Terms & Conditions</h2>
            </div>
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="terms-container">
                        <h4>Reservation Policy</h4>
                        <p>All reservations require a valid credit card to guarantee the booking. A deposit equivalent to one night's stay may be required for certain room types or during peak seasons. Reservations must be made by individuals 18 years or older.</p>
                        
                        <h4>Cancellation Policy</h4>
                        <p>Standard reservations may be cancelled without penalty up to 24 hours prior to arrival. Cancellations within 48 hours will incur a charge of one night's room rate plus tax. Special packages and group reservations may have different cancellation policies which will be specified at the time of booking.</p>
                        
                        <h4>Check-In/Check-Out</h4>
                        <p>Check-in time is 3:00 PM and check-out is at 11:00 AM. Early check-in and late check-out are subject to availability and may incur additional charges. Guests must present a valid government-issued photo ID and the credit card used for booking at check-in.</p>
                        
                        <h4>Payment Methods</h4>
                        <p>We accept all major credit cards including Visa, MasterCard, American Express, and Discover. Cash payments may be subject to additional verification and deposit requirements. All room charges must be settled at check-out.</p>
                        
                        <h4>Damage Policy</h4>
                        <p>Guests are responsible for any damage to the room or resort property caused by themselves or their visitors. A minimum cleaning fee of $250 will be charged for smoking in non-smoking rooms. Additional charges may apply for excessive cleaning or damage repair.</p>
                        
                        <h4>Privacy Policy</h4>
                        <p>Royal Star Residency respects your privacy. Personal information collected during the reservation process will be used solely for the purpose of your stay and will not be shared with third parties without your consent, except as required by law.</p>
                        
                        <h4>Liability</h4>
                        <p>The resort is not responsible for lost, stolen, or damaged personal items. Safe deposit boxes are available in each room for valuables. Guests use resort facilities at their own risk.</p>
                        
                        <h4>Guest Conduct</h4>
                        <p>We reserve the right to refuse service or evict guests for unacceptable behavior, including but not limited to: disorderly conduct, violation of resort policies, illegal activities, or failure to pay for services rendered.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Us -->
    <section id="contact" class="py-5 bg-light">
        <div class="container">
            <div class="section-title">
                <h2>Contact Us</h2>
            </div>
            <div class="row">
                <div class="col-lg-5 mb-4 mb-lg-0">
                    <div class="contact-info">
                        <h3 class="mb-4">Get in Touch</h3>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-map-marker-alt"></i>
                            </div>
                            <div>
                                <h5>Address</h5>
                                <p>Near Ponmudi Dam, Rajakkad, Munnar</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-phone-alt"></i>
                            </div>
                            <div>
                                <h5>Phone</h5>
                                <p>+91 9400258163</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-envelope"></i>
                            </div>
                            <div>
                                <h5>Email</h5>
                                <p>royalstarresidency2329@gmail.com</p>
                            </div>
                        </div>
                        <div class="contact-item">
                            <div class="contact-icon">
                                <i class="fas fa-clock"></i>
                            </div>
                            <div>
                                <h5>Front Desk Hours</h5>
                                <p>24 hours / 7 days a week</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-7">
                    <div class="contact-form">
                        <h3 class="mb-4">Send Us a Message</h3>
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">Name</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">Subject</label>
                                <input type="text" class="form-control" id="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">Message</label>
                                <textarea class="form-control" id="message" rows="5" required></textarea>
                            </div>
                            <button type="submit" class="btn submit-btn">Send Message</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
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

    <!-- Chatbot -->
    <div class="chatbot-btn" id="chatbotBtn">
        <i class="fas fa-comment-dots"></i>
    </div>
    <div class="chatbot-container" id="chatbotContainer">
        <div class="chatbot-header">
            <div class="chatbot-title">Royal Star Assistant</div>
            <button class="chatbot-close" id="chatbotClose">×</button>
        </div>
        <div class="chatbot-body" id="chatbotBody">
            <div class="chatbot-message bot-message">
                <div class="message-content">Hello! How can I assist you today?</div>
            </div>
        </div>
        <div class="chatbot-input">
            <input type="text" id="chatbotInput" placeholder="Type your message...">
            <button class="chatbot-send" id="chatbotSend"><i class="fas fa-paper-plane"></i></button>
        </div>
    </div>
    <script>
    // These IDs MUST match your HTML ids exactly.
    const chatBody = document.getElementById('chatbotBody');
    const chatbotInput = document.getElementById('chatbotInput');
    const chatbotSendBtn = document.getElementById('chatbotSend');

    // This function adds the message to the screen.
    // It uses the CSS classes you provided (.user-message, .bot-message).
    function appendMessage(message, senderClass) {
        const messageContainer = document.createElement('div');
        messageContainer.classList.add('chatbot-message', senderClass); // e.g., 'user-message'

        const messageContent = document.createElement('div');
        messageContent.classList.add('message-content');
        messageContent.textContent = message;

        messageContainer.appendChild(messageContent);
        chatBody.appendChild(messageContainer);
        chatBody.scrollTop = chatBody.scrollHeight; // Auto-scroll to bottom
        return messageContainer;
    }

    // This function runs when the send button is clicked.
    function sendMessage() {
        const userMessage = chatbotInput.value.trim();
        if (userMessage === '') return;

        // Add the user's message to the screen immediately.
        appendMessage(userMessage, 'user-message');
        chatbotInput.value = '';

        // Add a temporary "Typing..." message.
        const typingIndicator = appendMessage('...', 'bot-message');

        // Send the message to your PHP backend.
        fetch('../Booking&Public_APIs/chatbot.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ message: userMessage })
        })
        .then(response => response.json())
        .then(data => {
            // Remove the "Typing..." message.
            chatBody.removeChild(typingIndicator);
            // Add the bot's actual reply.
            appendMessage(data.reply, 'bot-message');
        })
        .catch(error => {
            console.error('Error:', error);
            chatBody.removeChild(typingIndicator);
            appendMessage('Sorry, something went wrong. Please try again.', 'bot-message');
        });
    }

    // Attach the sendMessage function to the button click and Enter key.
    chatbotSendBtn.addEventListener('click', sendMessage);
    chatbotInput.addEventListener('keypress', function(e) {
        if (e.key === 'Enter') {
            sendMessage();
        }
    });
</script>
</script>


<script>
document.addEventListener('DOMContentLoaded', () => {
    const chatbotBtn = document.getElementById('chatbotBtn');
    const chatbotContainer = document.getElementById('chatbotContainer');
    const chatbotCloseBtn = document.getElementById('chatbotClose');

    // Show or hide the chatbot when the button is clicked
    chatbotBtn.addEventListener('click', () => {
        chatbotContainer.classList.toggle('active');
    });

    // Close the chatbot when the 'x' is clicked
    chatbotCloseBtn.addEventListener('click', () => {
        chatbotContainer.classList.remove('active');
    });
});
</script>




    <!-- Bootstrap JS and Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.6/dist/umd/popper.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
    <!-- Custom JS (ensure script.js exists and handles bookNow() and chatbot functionality) -->
    <script src="script.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Reusable function to start a countdown timer
            function startCountdown(id, days, hours, minutes, seconds) {
                // Calculate the target date and time from the provided duration
                const now = new Date();
                const targetTime = new Date(now.getTime() + (days * 24 * 60 * 60 * 1000) + (hours * 60 * 60 * 1000) + (minutes * 60 * 1000) + (seconds * 1000));

                const daysEl = document.getElementById(`days-${id}`);
                const hoursEl = document.getElementById(`hours-${id}`);
                const minutesEl = document.getElementById(`minutes-${id}`);
                const secondsEl = document.getElementById(`seconds-${id}`);

                if (!daysEl || !hoursEl || !minutesEl || !secondsEl) {
                    // console.error(`Countdown elements for ID ${id} not found.`);
                    return;
                }

                const countdownInterval = setInterval(() => {
                    const currentTime = new Date().getTime();
                    const distance = targetTime - currentTime;

                    if (distance < 0) {
                        clearInterval(countdownInterval);
                        // Update the UI to show the offer has expired
                        const timerContainer = daysEl.closest('.countdown-timer');
                        if (timerContainer) {
                           timerContainer.innerHTML = "<p style='color: var(--secondary-color); font-weight: 500;'>Offer Expired!</p>";
                        }
                        return;
                    }

                    // Time calculations
                    const d = Math.floor(distance / (1000 * 60 * 60 * 24));
                    const h = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                    const m = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    const s = Math.floor((distance % (1000 * 60)) / 1000);

                    // Update the HTML elements, adding a leading zero if the number is less than 10
                    daysEl.innerHTML = d < 10 ? '0' + d : d;
                    hoursEl.innerHTML = h < 10 ? '0' + h : h;
                    minutesEl.innerHTML = m < 10 ? '0' + m : m;
                    secondsEl.innerHTML = s < 10 ? '0' + s : s;

                }, 1000);
            }

            // Initialize all countdowns based on the initial values in the HTML
            startCountdown('1', 7, 12, 45, 30);
            startCountdown('2', 2, 8, 22, 15);
            startCountdown('3', 14, 6, 18, 45);
        });
    </script>
    <script>
    // Find the button using the ID we added
    const exploreButton = document.getElementById('exploreBtn');

    // Add an event listener that runs when the button is clicked
    exploreButton.addEventListener('click', function(event) {
        
        // Always prevent the link from navigating immediately.
        // This gives our script control.
        event.preventDefault();

        // Check if a value 'isLoggedIn' is set to 'true' in the browser's storage
        if (localStorage.getItem('isLoggedIn') === 'true') {
            // If logged in, proceed to the rooms page
            window.location.href = 'rooms.html';
        } else {
            // If not logged in, show the alert message
            alert(" Please log in or create an account to explore our rooms."); // Displays an empty alert box as requested
        }
    });

    // --- Main AJAX Logic to Load Dynamic Content ---
        
        // Fetch Rooms
        fetch('../Booking&Public_APIs/fetch_data.php?type=rooms')
            .then(response => response.ok ? response.json() : Promise.reject('Failed to load rooms'))
            .then(data => {
                const container = document.getElementById('rooms-container');
                if (!container) return;
                if (!data || data.length === 0) {
                    container.innerHTML = '<p class="text-center">No rooms available at the moment.</p>';
                    return;
                }
                let htmlContent = '';
                data.forEach(room => {
                    htmlContent += `
                        <div class="col-lg-3 col-md-6 mb-4">
                            <div class="room-card h-100">
                                <div class="room-img"><img src="${room.image_path}" class="img-fluid" alt="${room.name}"></div>
                                <div class="room-body">
                                    <h3 class="room-title">${room.name}</h3>
                                    <p class="room-price">₹${parseFloat(room.price).toLocaleString('en-IN')}<span>/ night</span></p>
                                    <p>${room.description}</p>
                                    <a href="room-details.php?id=${room.id}" class="btn room-btn">View Details</a>
                                </div>
                            </div>
                        </div>`;
                });
                container.innerHTML = htmlContent;
            })
            .catch(error => console.error('Error fetching rooms:', error));

        // Fetch Offers
        fetch('../Booking&Public_APIs/fetch_data.php?type=offers')
            .then(response => response.ok ? response.json() : Promise.reject('Failed to load offers'))
            .then(data => {
                const container = document.getElementById('offers-container');
                if (!container) return;
                if (!data || data.length === 0) {
                    container.innerHTML = '<p class="text-center">No special offers available right now.</p>';
                    return;
                }
                let htmlContent = '';
                data.forEach((offer, index) => {
                    const countdownId = index + 1;
                    htmlContent += `
                        <div class="col-md-6 col-lg-4">
                            <div class="offer-card-v2 h-100">
                                <div class="offer-image-wrapper">
                                    <img src="${offer.image_path}" class="offer-img" alt="${offer.name}">
                                    <div class="discount-ribbon"><span>${offer.discount_percentage}% OFF</span></div>
                                </div>
                                <div class="card-content">
                                    <h3 class="offer-title">${offer.name}</h3>
                                    <p class="offer-description">${offer.description}</p>
                                    <div class="countdown-container">
                                        <p class="countdown-title">Offer ends in:</p>
                                        <div class="countdown-timer">
                                            <div class="countdown-item"><span id="days-${countdownId}">00</span><small>Days</small></div>
                                            <div class="countdown-item"><span id="hours-${countdownId}">00</span><small>Hours</small></div>
                                            <div class="countdown-item"><span id="minutes-${countdownId}">00</span><small>Mins</small></div>
                                            <div class="countdown-item"><span id="seconds-${countdownId}">00</span><small>Secs</small></div>
                                        </div>
                                    </div>
                                    <button class="btn btn-details">View Details <i class="fas fa-arrow-right"></i></button>
                                </div>
                            </div>
                        </div>`;
                    // Start the countdown for this specific offer
                    setTimeout(() => startCountdown(countdownId, offer.validity_to), 100);
                });
                container.innerHTML = htmlContent;
            })
            .catch(error => console.error('Error fetching offers:', error));

        // Fetch Packages
        fetch('../Booking&Public_APIs/fetch_data.php?type=packages')
            .then(response => response.ok ? response.json() : Promise.reject('Failed to load packages'))
            .then(data => {
                const container = document.getElementById('packages-container');
                if (!container) return;
                if (!data || data.length === 0) {
                    container.innerHTML = '<p class="text-center">No packages are currently available.</p>';
                    return;
                }
                let htmlContent = '';
                data.forEach(pkg => {
                    let featuresList = (pkg.features || '').split('|').map(feature => 
                        `<li><i class="fas fa-check-circle me-2"></i> ${feature.trim()}</li>`
                    ).join('');
                    
                    htmlContent += `
                        <div class="col-lg-4 col-md-6 mb-4">
                            <div class="package-card h-100">
                                <div class="package-img"><img src="${pkg.image_path}" class="img-fluid" alt="${pkg.name}"></div>
                                <div class="package-body">
                                    <h3 class="package-title">${pkg.name}</h3>
                                    <p class="package-price">₹${parseFloat(pkg.price).toLocaleString('en-IN')} <span>/${pkg.duration_nights} nights</span></p>
                                    <ul class="package-features">${featuresList}</ul>
                                    <button class="btn package-btn">View Details</button>
                                </div>
                            </div>
                        </div>`;
                });
                container.innerHTML = htmlContent;
            })
            .catch(error => console.error('Error fetching packages:', error));
</script>
</body>
</html>