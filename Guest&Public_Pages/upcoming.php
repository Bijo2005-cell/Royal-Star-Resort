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
    <title>Upcoming Projects - Royal Star Resort</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;600;700&family=Montserrat:wght@300;400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Styling&Scripts/style1.css">
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
            </div>
        </nav>
    </header>

    <main>
        <section class="hero-banner3">
            <div class="container">
                <h1 class="hero-title1">The Future of Luxury</h1>
                <p class="lead">We are constantly evolving to redefine your experience. Discover what's next at Royal Star Resort.</p>
            </div>
        </section>

        <section id="projects" class="py-5">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="section-title">Upcoming Projects</h2>
                    <p class="lead">A glimpse into the exciting new additions and enhancements coming soon.</p>
                </div>

                <div id="project-filters" class="text-center mb-5">
                    <button class="btn active" data-filter="all">All</button>
                    <button class="btn" data-filter="planning">Planning</button>
                    <button class="btn" data-filter="in-progress">In Progress</button>
                    <button class="btn" data-filter="opening-soon">Opening Soon</button>
                </div>

                <div class="row">
                    <?php
                    // Fetch projects, ordered by status (opening soon first)
                    $sql = "SELECT * FROM upcoming ORDER BY FIELD(status, 'opening-soon', 'in-progress', 'planning')";
                    $result = $conn->query($sql);

                    if ($result && $result->num_rows > 0) {
                        while($row = $result->fetch_assoc()) {
                            // Sanitize data
                            $status = htmlspecialchars($row['status']);
                            $image_path = htmlspecialchars($row['image_path']);
                            $image_alt = htmlspecialchars($row['image_alt']);
                            $title = htmlspecialchars($row['title']);
                            $description = htmlspecialchars($row['description']);
                            $est_completion = htmlspecialchars($row['est_completion']);
                            $modal_target = htmlspecialchars($row['modal_target']);

                            // Create dynamic class and text for the status badge
                            $status_class = $status . '1'; // e.g., 'opening-soon1', 'in-progress1'
                            $status_text = ucwords(str_replace('-', ' ', $status)); // e.g., 'Opening Soon', 'In Progress'

                            echo '
                            <div class="col-lg-4 col-md-6 mb-4 project-card" data-status="' . $status . '">
                                <div class="card h-100">
                                    <span class="status-badge ' . $status_class . '">' . $status_text . '</span>
                                    <div class="card-img-container"><img src="' . $image_path . '" class="card-img-top" alt="' . $image_alt . '"></div>
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title">' . $title . '</h5>
                                        <p class="card-text">' . $description . '</p>
                                        <p class="text-muted small mt-auto">Est. Completion: ' . $est_completion . '</p>
                                        <button class="btn btn-main" data-bs-toggle="modal" data-bs-target="' . $modal_target . '">View Details</button>
                                    </div>
                                </div>
                            </div>
                            ';
                        }
                    } else {
                        if (!$result) {
                            echo '<p class="text-center text-danger">Error fetching projects: ' . $conn->error . '</p>';
                        } else {
                            echo '<p class="text-center">No upcoming projects have been added yet.</p>';
                        }
                    }
                    $conn->close();
                    ?>
                    </div>
            </div>
        </section>
    </main>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for anchor links
        document.querySelectorAll('a.nav-link[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Project Filtering Logic
        document.addEventListener('DOMContentLoaded', function () {
            const filterButtons = document.querySelectorAll('#project-filters .btn');
            const projectCards = document.querySelectorAll('.project-card');

            filterButtons.forEach(button => {
                button.addEventListener('click', function () {
                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');

                    const filter = this.getAttribute('data-filter');

                    // Show/hide cards
                    projectCards.forEach(card => {
                        if (filter === 'all' || card.getAttribute('data-status') === filter) {
                            card.classList.remove('hide');
                        } else {
                            card.classList.add('hide');
                        }
                    });
                });
            });
        });
    </script>
</body>
</html>