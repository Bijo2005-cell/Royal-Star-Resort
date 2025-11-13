<?php
// room.php
require_once '../Database/db_connect.php';

// Get room ID from URL, e.g., room.php?id=1
$roomId = 2; // Default to room 1 for this example
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $roomId = intval($_GET['id']);
}

// Fetch room data from the database
// ... on line 12
// Corrected query for room3.php:
$stmt = $conn->prepare("SELECT * FROM accommodations WHERE acc_id = ?");
    $stmt->bind_param("i", $roomId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $room = $result->fetch_assoc();
} else {
    die("Room not found.");
}
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Presidential Suite | Royal Star Resort</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Poppins:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="accommodation.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">Royal <span>Star</span> Resort</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto">
                        <li class="nav-item"><a class="nav-link" href="../home.php">Home</a></li>
                        <li class="nav-item"><a class="nav-link" href="../home.php#rooms">Rooms</a></li>
                        <li class="nav-item"><a class="nav-link" href="../home.php#services">Services</a></li>
                        <li class="nav-item"><a class="nav-link" href="../home.php#gallery">Gallery</a></li>
                        <li class="nav-item"><a class="nav-link" href="../home.php#contact">Contact</a></li>
                        <li class="nav-item ms-lg-3">
                            <a class="nav-link login-btn" href="../Guest&Public_Pages/reservation.php?roomId=<?php echo $roomId; ?>" role="button">Book Now</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>

    <section class="hero-section">
        <img src="../photos/rm7.jpeg" alt="Presidential Suite" class="hero-image">
        <div class="hero-overlay"></div>
        <div class="container hero-content">
            <div class="row">
                <div class="col-lg-6">
                    <h1 class="room-title">Presidential Suite</h1>
                    <p class="hero-subtitle">Experience the pinnacle of luxury in our Presidential Suite, the most prestigious and opulent accommodation offered at our resort.</p>
                    
                    <div class="price-tag">
                        <span class="price-amount">₹6900</span>
                        <span class="price-text">per night</span>
                    </div>
                    
                    <div class="d-flex align-items-center">
                        <div class="rating-badge">
                            <span class="rating-stars">
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                                <i class="fas fa-star"></i>
                            </span>
                            <span class="review-count">4.9/5</span>
                        </div>
                        <span class="review-count">(180 reviews)</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <main class="content-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <section class="mb-5">
                        <h2 class="section-title">Unmatched Luxury and Prestige</h2>
                        <p>The Presidential Suite is the most luxurious and prestigious accommodation offered in our hotel. Designed for guests who demand the utmost in comfort, space, and service, this suite provides an extraordinary experience from the moment you arrive.</p>
                        <p>Covering an expansive 720 square feet, the suite features a master bedroom with a king-sized bed, a separate grand living room, a dining area, and a lavish bathroom with premium fixtures. Every detail is crafted to perfection, ensuring an unforgettable stay.</p>
                        
                        <div class="row mt-4">
                            <div class="col-md-4 mb-3">
                                <div class="amenity-item">
                                    <div class="amenity-icon">
                                        <i class="fas fa-ruler-combined"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">720 sq.ft</h5>
                                        <small>Suite Size</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="amenity-item">
                                    <div class="amenity-icon">
                                        <i class="fas fa-bed"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">King Bed</h5>
                                        <small>Sleeping Arrangement</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3">
                                <div class="amenity-item">
                                    <div class="amenity-icon">
                                        <i class="fas fa-user-friends"></i>
                                    </div>
                                    <div>
                                        <h5 class="mb-0">2+2</h5>
                                        <small>Guests</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <section class="mb-5">
                        <h2 class="section-title">Exclusive Amenities</h2>
                        <div class="amenities-container">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="amenity-item">
                                        <div class="amenity-icon">
                                            <i class="fas fa-wifi"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Premium Wi-Fi</h5>
                                            <small>High-speed internet access</small>
                                        </div>
                                    </div>
                                    <div class="amenity-item">
                                        <div class="amenity-icon">
                                            <i class="fas fa-wind"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Climate Control</h5>
                                            <small>Individual temperature settings</small>
                                        </div>
                                    </div>
                                    <div class="amenity-item">
                                        <div class="amenity-icon">
                                            <i class="fas fa-tv"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Entertainment</h5>
                                            <small>75" 4K Smart TV</small>
                                        </div>
                                    </div>
                                    <div class="amenity-item">
                                        <div class="amenity-icon">
                                            <i class="fas fa-wine-glass-alt"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Mini Bar</h5>
                                            <small>Fully-stocked selection</small>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="amenity-item">
                                        <div class="amenity-icon">
                                            <i class="fas fa-mountain"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Panoramic View</h5>
                                            <small>Wraparound balcony</small>
                                        </div>
                                    </div>
                                    <div class="amenity-item">
                                        <div class="amenity-icon">
                                            <i class="fas fa-coffee"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Coffee Station</h5>
                                            <small>Nespresso machine</small>
                                        </div>
                                    </div>
                                    <div class="amenity-item">
                                        <div class="amenity-icon">
                                            <i class="fas fa-bath"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Spa Bathroom</h5>
                                            <small>Jacuzzi & rainfall shower</small>
                                        </div>
                                    </div>
                                    <div class="amenity-item">
                                        <div class="amenity-icon">
                                            <i class="fas fa-concierge-bell"></i>
                                        </div>
                                        <div>
                                            <h5 class="mb-0">Butler Service</h5>
                                            <small>Personalized 24/7 concierge</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </section>
                    
                    <section class="mb-5">
                        <h2 class="section-title">Gallery</h2>
                        <div class="gallery-container">
                            <div class="main-image">
                                <img src="../photos/rm7.jpeg" alt="Presidential Suite" class="gallery-img w-100 h-100">
                            </div>
                            <div class="thumbnail-container">
                                <div class="thumbnail active">
                                    <img src="../photos/hall.jpg" alt="Suite Hall">
                                </div>
                                <div class="thumbnail">
                                    <img src="../photos/gallery1.jpg" alt="Bathroom">
                                </div>
                                <div class="thumbnail">
                                    <img src="../photos/gallery2.jpg" alt="Balcony View">
                                </div>
                                <div class="thumbnail">
                                    <img src="../photos/gallery3.jpg" alt="Living Area">
                                </div>
                                <div class="thumbnail">
                                    <img src="../photos/gallery4.jpg" alt="Bedroom Detail">
                                </div>
                            </div>
                        </div>
                    </section>
                </div>
                
                <div class="col-lg-4">
                    <div class="card policy-card mb-4">
                        <div class="card-body">
                            <h4 class="section-title">Reserve Your Stay</h4>
                            <form id="bookingForm">
                                <div class="mb-3">
                                    <label for="checkIn" class="form-label">Check-In</label>
                                    <input type="date" class="form-control" id="checkIn" required>
                                </div>
                                <div class="mb-3">
                                    <label for="checkOut" class="form-label">Check-Out</label>
                                    <input type="date" class="form-control" id="checkOut" required>
                                </div>
                                <div class="mb-3">
                                    <label for="adults" class="form-label">Adults</label>
                                    <select class="form-select" id="adults" required>
                                        <option value="1">1 Adult</option>
                                        <option value="2" selected>2 Adults</option>
                                        <option value="3">3 Adults</option>
                                        <option value="4">4 Adults</option>
                                    </select>
                                </div>
                                <div class="mb-4">
                                    <label for="children" class="form-label">Children</label>
                                    <select class="form-select" id="children">
                                        <option value="0" selected>No Children</option>
                                        <option value="1">1 Child</option>
                                        <option value="2">2 Children</option>
                                    </select>
                                </div>
                                <button type="submit" class="btn btn-primary w-100" style="background-color: var(--secondary-color); border: none; padding: 0.75rem;">Check Availability</button>
                            </form>
                        </div>
                    </div>
                    
                    <div class="card policy-card">
                        <div class="card-body">
                            <h4 class="section-title">Suite Policies</h4>
                            <ul class="list-unstyled">
                                <li class="mb-3">
                                    <div class="d-flex">
                                        <i class="fas fa-clock me-3 mt-1" style="color: var(--secondary-color);"></i>
                                        <div>
                                            <h6 class="mb-0">Check-In/Out</h6>
                                            <small>3:00 PM / 11:00 AM</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-3">
                                    <div class="d-flex">
                                        <i class="fas fa-child me-3 mt-1" style="color: var(--secondary-color);"></i>
                                        <div>
                                            <h6 class="mb-0">Children Policy</h6>
                                            <small>Under 12 stay free with parents</small>
                                        </div>
                                    </div>
                                </li>
                                <li class="mb-3">
                                    <div class="d-flex">
                                        <i class="fas fa-paw me-3 mt-1" style="color: var(--secondary-color);"></i>
                                        <div>
                                            <h6 class="mb-0">Pet Policy</h6>
                                            <small>Pets allowed upon request</small>
                                        </div>
                                    </div>
                                </li>
                                <li>
                                    <div class="d-flex">
                                        <i class="fas fa-smoking-ban me-3 mt-1" style="color: var(--secondary-color);"></i>
                                        <div>
                                            <h6 class="mb-0">Smoking Policy</h6>
                                            <small>Allowed on balcony only</small>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                    
                    <div class="card policy-card mt-4">
                        <div class="card-body">
                            <h4 class="section-title">Special Offers</h4>
                            <div class="alert alert-warning">
                                <h5><i class="fas fa-gift me-2"></i> Extended Stay Discount</h5>
                                <p class="small">Book 5 nights or more and receive 15% off your entire stay!</p>
                            </div>
                            <div class="alert alert-info">
                                <h5><i class="fas fa-umbrella-beach me-2"></i> Honeymoon Package</h5>
                                <p class="small">Complimentary champagne and spa credit for honeymooners.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            
            <a href="../Guest&Public_Pages/reservation.php?roomId=<?php echo $roomId; ?>" class="btn room-btn">Book Now</a>
        </div>
    </main>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="accommodation_ajax.js"></script>
</body>
</html>