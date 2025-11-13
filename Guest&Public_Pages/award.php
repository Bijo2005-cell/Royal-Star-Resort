<?php
// Include the database connection file
// This path is based on your file structure from gallery.php
include '../Database/db_connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Awards & Achievements</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="../Styling&Scripts/style.css">
    </head>
<body>
   <header>
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">Royal <span>Star</span> Resort</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
            </div>
        </nav>
    </header>
<section class="hero-section1">
    <div class="hero-overlay"></div>

    <div class="hero-content">
        <h1 class="hero-title animate__animated animate__fadeInDown">Our Awards & Achievements</h1>
        <p class="lead animate__animated animate__fadeInUp animate__delay-1s">Recognized excellence in hospitality and service</p>
    </div>
</section>

    <section class="py-5">
        <div class="container">
            <h2 class="section-title animate__animated animate__fadeIn">Prestigious Awards</h2>
            <div class="row">

                <?php
                // Fetch awards from the database, ordered by year
                $sql = "SELECT * FROM awards ORDER BY year_received DESC";
                $result = $conn->query($sql);

                if ($result && $result->num_rows > 0) {
                    $delay = 0; // To control animation delay
                    while($row = $result->fetch_assoc()) {
                        // Use htmlspecialchars for security
                        $image_path = htmlspecialchars($row['image_path']);
                        $title = htmlspecialchars($row['title']);
                        $year = htmlspecialchars($row['year_received']);
                        $description = htmlspecialchars($row['description']);

                        // Add animation delay class
                        $delay_class = ($delay == 0) ? '' : 'animate__delay-1s';
                        
                        echo '
                        <div class="col-md-3 animate__animated animate__fadeInUp ' . $delay_class . '">
                            <div class="award-card">
                                <img src="' . $image_path . '" class="card-img-top award-img" alt="' . $title . '">
                                <div class="award-body">
                                    <h5 class="award-title">' . $title . '</h5>
                                    <p class="award-year">' . $year . '</p>
                                    <p class="card-text">' . $description . '</p>
                                </div>
                            </div>
                        </div>
                        ';
                        $delay++;
                    }
                } else {
                    if (!$result) {
                         echo '<p class="text-center text-danger">Error fetching awards: ' . $conn->error . '</p>';
                    } else {
                        echo '<p class="text-center">No awards have been added yet.</p>';
                    }
                }
                $conn->close();
                ?>
                </div>
        </div>
    </section>

    <section class="py-5 bg-light">
        <div class="container">
            <h2 class="section-title animate__animated animate__fadeIn">Our Journey</h2>
            <div class="achievement-timeline">
                <div class="timeline-item left animate__animated animate__fadeInLeft">
                    <div class="timeline-content">
                        <h5 class="timeline-year">2023</h5>
                        <p>Opened our new infinity pool complex and spa center, voted "Best Resort Spa" by Luxury Travel Magazine.</p>
                    </div>
                </div>
                <div class="timeline-item right animate__animated animate__fadeInRight">
                    <div class="timeline-content">
                        <h5 class="timeline-year">2022</h5>
                        <p>Received the prestigious "Award of Excellence" from the Indian Academy of Hospitality Sciences.</p>
                    </div>
                </div>
                <div class="timeline-item left animate__animated animate__fadeInLeft">
                    <div class="timeline-content">
                        <h5 class="timeline-year">2021</h5>
                        <p>Launched our sustainability initiative, reducing our carbon footprint by 40% in the first year.</p>
                    </div>
                </div>
                <div class="timeline-item right animate__animated animate__fadeInRight">
                    <div class="timeline-content">
                        <h5 class="timeline-year">2020</h5>
                        <p>Recognized as "Best Family Resort" by International Travel Awards for our exceptional children's programs.</p>
                    </div>
                </div>
                <div class="timeline-item left animate__animated animate__fadeInLeft">
                    <div class="timeline-content">
                        <h5 class="timeline-year">2019</h5>
                        <p>Completed major renovation of all guest rooms and suites, introducing our signature Royal Star bedding.</p>
                    </div>
                </div>
                <div class="timeline-item right animate__animated animate__fadeInRight">
                    <div class="timeline-content">
                        <h5 class="timeline-year">2018</h5>
                        <p>Celebrated our 10th anniversary and received the "Best Employer in Hospitality" award.</p>
                    </div>
                </div>
            </div>
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
 <script src="../Styling&Scripts/script.js"></script>
</body>
</html>