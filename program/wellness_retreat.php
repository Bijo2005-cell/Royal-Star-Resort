<?php
// wellness_retreat.php
require_once '../Database/db_connect.php';

// Fetch the specific 'Wellness Retreat' package
$today = date("Y-m-d");
$stmt = $conn->prepare("SELECT * FROM programs WHERE title = 'Wellness Retreat' AND (valid_to >= ? OR valid_to IS NULL)");
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
    <title>Royal Star Resort - Rejuvenating Wellness Retreats</title>
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

    <header id="home" class="hero10">
        <div class="container text-center">
             <div class="d-flex justify-content-center align-items-center mb-3">
                 <h1 class="mx-4">A Journey to Wellness</h1>
             </div>
            <p class="lead">Reconnect with yourself at our exclusive wellness sanctuary.</p>
            <a href="#booking" class="btn btn-gold mt-3">Begin Your Journey</a>
        </div>
    </header>

    <main>
        <section id="package" class="py-5">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title">Our "Sanctuary" Wellness Retreats</h2>
                    <p class="section-subtitle">A holistic experience for mind, body, and soul.</p>
                </div>
                <div class="row g-4 justify-content-center">

                    <?php if (!empty($programs)): ?>
                        <?php foreach ($programs as $program): ?>
                        <div class="col-lg-4 col-md-6 d-flex align-items-stretch">
                            <div class="package-card text-center">
                                <div class="card-body">
                                    <div class="icon"><i class="fas fa-spa"></i></div>
                                    <h3 class="card-title"><?php echo htmlspecialchars($program['title']); ?></h3>
                                    <p><?php echo htmlspecialchars($program['description']); ?></p>
                                    <h4 class="price-tag">
                                        <?php 
                                            if (is_numeric($program['price'])) {
                                                echo 'From ₹' . htmlspecialchars(number_format($program['price'])) . ' / person';
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
                            <p class="lead">No wellness retreats are currently scheduled. Please inquire for future dates.</p>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </section>

        <section class="py-5 bg-sienna">
            <div class="container text-center">
                <h2 class="mb-3">Invest in Your Well-being</h2>
                <p class="lead mb-4">Let us create your personalized wellness plan.</p>
                <a href="#booking" class="btn btn-gold">Customize Your Retreat</a>
            </div>
        </section>

        <section id="gallery" class="py-5">
            <div class="container">
                <div class="text-center">
                    <h2 class="section-title">Moments of Tranquility</h2>
                    <p class="section-subtitle">Visualize your rejuvenating escape at Royal Star Resort.</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4"><img src="../photos/packagewellness.jpg" class="img-fluid gallery-img" alt="Gallery Image 1"></div>
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
                    <h2 class="section-title">Book Your Wellness Retreat</h2>
                    <p class="section-subtitle">Fill out the form below and our wellness concierge will contact you shortly.</p>
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
                                         <label for="checkin" class="form-label text-muted ms-3">Preferred Arrival Date</label>
                                         <input type="date" id="checkin" class="form-control" required>
                                     </div>
                                    <div class="col-12">
                                        <textarea class="form-control" rows="4" style="border-radius: 20px;" placeholder="What are your wellness goals for this retreat?"></textarea>
                                    </div>
                                    <div class="col-12 text-center">
                                        <button type="submit" class="btn btn-gold">Send Inquiry</button>
                                        
                                        <script>
                                            document.querySelector('.booking-form form').addEventListener('submit', function(e) {
                                                // 1. Prevent the default form action
                                                e.preventDefault();

                                                // 2. Define IDs for the package and a suitable suite
                                                const wellnessRetreatId = 3; // program_id for 'Wellness Retreat'
                                                const roomId = 3;            // acc_id for 'Jacuzzi 180-Degree Suite'

                                                // 3. Build the URL and redirect
                                                const url = `/miniproject/Guest&Public_Pages/reservation.php?roomId=${roomId}&packageId=${wellnessRetreatId}`;
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