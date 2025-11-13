<?php
// family_packages.php
require_once '../Database/db_connect.php';

// Fetch the specific 'Family Package'
$today = date("Y-m-d");
$stmt = $conn->prepare("SELECT * FROM programs WHERE title = 'Family Package' AND (valid_to >= ? OR valid_to IS NULL)");
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
    <title>Royal Star Resort - Unforgettable Family Packages</title>
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

    <header id="home" class="hero4">
        <div class="container text-center">
             <div class="d-flex justify-content-center align-items-center mb-3">
                 <h1 class="mx-4">Unforgettable Family Adventures</h1>
             </div>
            <p class="lead">Create lasting memories with our exclusive family getaway.</p>
            <a href="#booking" class="btn btn-gold mt-3">Inquire Now</a>
        </div>
    </header>

    <main>
        <section id="package" class="py-5">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title">Our Family Adventure Packages</h2>
                    <p class="section-subtitle">Everything you need for a journey of fun and bonding.</p>
                </div>
                <div class="row g-4 justify-content-center">

                    <?php if (!empty($programs)): ?>
                        <?php foreach ($programs as $program): ?>
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                            <div class="package-card text-center">
                                <div class="card-body">
                                    <div class="icon"><i class="fas fa-users"></i></div>
                                    <h3 class="card-title"><?php echo htmlspecialchars($program['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($program['description']); ?></p>
                                    <h4 class="price-tag">
                                        <?php
                                            if (is_numeric($program['price'])) {
                                                echo '₹' . htmlspecialchars(number_format($program['price'])) . ' / family';
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
                            <p class="lead">No family packages are currently available. Please check back later or contact us for custom arrangements.</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </section>

        <section class="py-5 bg-sienna">
            <div class="container text-center">
                <h2 class="mb-3">Your Family Adventure Awaits</h2>
                <p class="lead mb-4">Let us tailor your perfect family vacation.</p>
                <a href="../Guest&Public_Pages/reservation.php" class="btn btn-gold">Customize Your Package</a>
            </div>
        </section>

        <section id="gallery" class="py-5">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title">Family Fun in Photos</h2>
                    <p class="section-subtitle">Visualize your dream family vacation at Royal Star Resort.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4"><img src="../photos/packagefamily.jpg" class="img-fluid gallery-img" alt="Gallery Image 1"></div>
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
                    <h2 class="section-title">Book Your Family Getaway</h2>
                    <p class="section-subtitle">Fill out the form below and our family vacation planner will contact you shortly.</p>
                </div>
                <div class="row justify-content-center">
                    <div class="col-lg-8">
                        <div class="booking-form">
                            <form>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <input type="text" class="form-control" placeholder="Your Name" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="email" class="form-control" placeholder="Email Address" required>
                                    </div>
                                    <div class="col-md-6">
                                        <input type="tel" class="form-control" placeholder="Phone Number">
                                    </div>
                                    <div class="col-md-6">
                                         <input type="number" class="form-control" placeholder="Number of Adults" min="1" required>
                                     </div>
                                     <div class="col-md-6">
                                         <input type="number" class="form-control" placeholder="Number of Children" min="0" required>
                                     </div>
                                    <div class="col-md-6">
                                         <label for="checkin" class="form-label text-muted ms-3">Preferred Check-in Date</label>
                                         <input type="date" id="checkin" class="form-control" required>
                                     </div>
                                    <div class="col-12">
                                        <textarea class="form-control" rows="4" style="border-radius: 20px;" placeholder="Any special requests or questions?"></textarea>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-gold">Send Inquiry</button>
                                        
                                        <script>
                                            document.querySelector('.booking-form form').addEventListener('submit', function(e) {
                                                // 1. Prevent the form from submitting normally
                                                e.preventDefault();

                                                // 2. Define IDs for the package and a suitable room from your database
                                                const familyPackageId = 2; // program_id for 'Family Package'
                                                const familyRoomId = 8;    // acc_id for 'Family Innerconnected Club Suite'

                                                // 3. Build the URL and redirect
                                                const url = `/miniproject/Guest&Public_Pages/reservation.php?roomId=${familyRoomId}&packageId=${familyPackageId}`;
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="script.js"></script>
</body>
</html>