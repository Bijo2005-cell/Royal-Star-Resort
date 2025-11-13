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
    <title>Royal Star Resort - Blog</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
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
                </nav>
  </header>
<section class="hero-section2">
    <div class="hero-overlay"></div>
    <div class="hero-content">
        <h1 class="hero-title animate__animated animate__fadeInDown">Explore Our Latest Blogs</h1>
        <p class="lead animate__animated animate__fadeInUp animate__delay-1s">Discover the Best of Royal Star Resort</p>
    </div>
</section>
    
    <section class="blog-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="section-title animate__animated animate__fadeIn">Latest Posts</h2>
                    
                    <div class="row">

                        <?php
                        // Fetch blog posts from the database, ordered by post date
                        $sql = "SELECT * FROM blogs ORDER BY post_date DESC";
                        $result = $conn->query($sql);

                        if ($result && $result->num_rows > 0) {
                            $delay = 0; // To control animation delay
                            while($row = $result->fetch_assoc()) {
                                // Get data and sanitize
                                $image_path = htmlspecialchars($row['image_path']);
                                $image_alt = htmlspecialchars($row['image_alt']);
                                // Format the date
                                $post_date = date("F j, Y", strtotime($row['post_date']));
                                $title = htmlspecialchars($row['title']);
                                $summary = htmlspecialchars($row['summary']);
                                $read_more_link = htmlspecialchars($row['read_more_link']);

                                // Set animation delay
                                $delay_class = ($delay > 0) ? 'animate__delay-' . $delay . 's' : '';
                                if ($delay > 1) $delay_class = 'animate__delay-1s'; // Cap delay for faster loading

                                echo '
                                <div class="col-md-4 animate__animated animate__fadeInUp ' . $delay_class . '">
                                    <div class="blog-card">
                                        <div class="blog-img">
                                            <img src="' . $image_path . '" alt="' . $image_alt . '">
                                        </div>
                                        <div class="blog-body">
                                            <p class="blog-date">' . $post_date . '</p>
                                            <h4 class="blog-title">' . $title . '</h4>
                                            <p>' . $summary . '</p>
                                            <a href="' . $read_more_link . '" class="blog-btn">Read More <i class="fas fa-arrow-right"></i></a>
                                        </div>
                                    </div>
                                </div>
                                ';
                                $delay++;
                            }
                        } else {
                            if (!$result) {
                                echo '<p class="text-center text-danger">Error fetching blog posts: ' . $conn->error . '</p>';
                            } else {
                                echo '<p class="text-center">No blog posts have been added yet.</p>';
                            }
                        }
                        $conn->close();
                        ?>
                        </div>
                </div>
            </div>
        </div>
    </section>

 <script src="../Styling&Scripts/script.js"></script>
</body>
</html>