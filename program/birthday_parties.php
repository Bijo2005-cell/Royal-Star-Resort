<?php
// event_page.php
require_once '../Database/db_connect.php';

// Fetch the specific 'Birthday Parties' function
$today = date("Y-m-d");
$stmt = $conn->prepare("SELECT * FROM programs WHERE title = 'Birthday Parties' AND (valid_to >= ? OR valid_to IS NULL)");
$stmt->bind_param("s", $today);
$stmt->execute();
$programs = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt->close();
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Birthday Parties</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css"/>
    <link rel="stylesheet" href="style.css">
</head>
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

    <header id="home" class="hero1" >
        <div class="container text-center">
             <div class="d-flex justify-content-center align-items-center mb-3">
                 <h1 class="mx-4">Epic Birthday Celebrations</h1>
             </div>
            <p class="lead">Host a birthday party that everyone will remember.</p>
            <a href="#booking" class="btn btn-gold mt-3">Plan Your Party</a>
        </div>
    </header>

    <main>
        <section id="package" class="py-5">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title">Our All-Inclusive Party Packages</h2>
                    <p class="section-subtitle">Fun-filled, hassle-free birthday parties for all ages.</p>
                </div>
                <div class="row g-4 justify-content-center">

                    <?php if (!empty($programs)): ?>
                        <?php foreach ($programs as $program): ?>
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                            <div class="package-card text-center">
                                <div class="card-body">
                                    <div class="icon"><i class="fas fa-birthday-cake"></i></div>
                                    <h3 class="card-title"><?php echo htmlspecialchars($program['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($program['description']); ?></p>
                                    <h4 class="price-tag">
                                        <?php 
                                            if (is_numeric($program['price'])) {
                                                echo '₹' . htmlspecialchars(number_format($program['price']));
                                            } else {
                                                echo htmlspecialchars($program['price']);
                                            }
                                        ?>
                                    </h4>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <div class="col-12 text-center">
                            <p class="lead">No party packages are available at this time. Please check back later!</p>
                        </div>
                    <?php endif; ?>
                    
                </div>
            </div>
        </section>

        <section class="py-5 bg-sienna">
            <div class="container text-center">
                <h2 class="mb-3">Let's Get The Party Started!</h2>
                <p class="lead mb-4">Contact us to book a date and start planning the best birthday party ever.</p>
                <a href="../Guest&Public_Pages/reservation.php" class="btn btn-gold">Book Your Party</a>
            </div>
        </section>

        <section id="gallery" class="py-5">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title">Party Photo Album</h2>
                    <p class="section-subtitle">See the fun and excitement from past birthday parties.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4"><img src="../photos/function.jpg" class="img-fluid gallery-img" alt="Gallery Image 1"></div>
                    <div class="col-md-4"><img src="../photos/limited2.jpg" class="img-fluid gallery-img" alt="Gallery Image 2"></div>
                    <div class="col-md-4"><img src="../photos/hall.jpg" class="img-fluid gallery-img" alt="Gallery Image 3"></div>
                    <div class="col-md-6"><img src="../photos/limited3.jpg" class="img-fluid gallery-img" alt="Gallery Image 4"></div>
                    <div class="col-md-6"><img src="../photos/limited4.jpg" class="img-fluid gallery-img" alt="Gallery Image 5"></div>
                </div>
            </div>
        </section>
        
        <section id="booking" class="py-5 bg-light">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title">Plan Your Birthday Party</h2>
                    <p class="section-subtitle">Fill out the form below and our party planner will get in touch!</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="booking-form">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Parent's Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" placeholder="Email Address" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="tel" class="form-control" placeholder="Phone Number">
                                    </div>
                                    <div class="col-md-6">
                                         <input type="number" class="form-control" placeholder="Number of Guests" min="1" required>
                                    </div>
                                     <div class="col-12">
                                         <label for="partyDate" class="form-label text-muted ms-3">Preferred Party Date</label>
                                         <input type="date" id="partyDate" class="form-control" required>
                                     </div>
                                    <div class="col-12">
                                        <textarea class="form-control" rows="4" style="border-radius: 20px;" placeholder="Tell us about the birthday person and any themes you have in mind!"></textarea>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-gold">Send Inquiry</button>
                                        
                                        <script>
                                            document.querySelector('.booking-form form').addEventListener('submit', function(e) {
                                                // 1. Prevent the form from submitting normally
                                                e.preventDefault();

                                                // 2. Define the program_id for 'Birthday Parties' (from your SQL file)
                                                const birthdayPackageId = 7;

                                                // 3. Build the URL for the reservation page and redirect the user
                                                // Make sure '/miniproject2/' is your correct project path
                                                const url = `/miniproject/Guest&Public_Pages/reservation.php?packageId=${birthdayPackageId}`;
                                                window.location.href = url;
                                            });
                                        </script>

                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

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


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>