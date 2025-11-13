<?php
// Include the database connection file
// Make sure this path is correct relative to your gallery.php location
// If 'admin' folder is at the same level as 'gallery.php', this path is wrong.
// Assuming 'gallery.php' is in the root, and 'admin' is also in the root.
// Adjust '../admin/db_connect.php' or 'admin/db_connect.php' as needed.

// Per your file structure (e.g., '../Styling&Scripts/style.css'), 
// it seems gallery.php might be in a subfolder. 
// Let's assume db_connect.php is in an 'admin' folder at the SAME level
// as your 'Styling&Scripts' folder.
// If gallery.php is at the root, db_connect.php would be 'admin/db_connect.php'
// If gallery.php is in a folder like 'user/', it might be '../admin/db_connect.php'

// PLEASE VERIFY THIS PATH
include '../Database/db_connect.php'; 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/lightgallery-js/1.4.0/css/lightgallery.min.css">
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


    <section class="gallery-container">
        <div class="container">
            <h2 class="section-title animate__animated animate__fadeIn">Photo Gallery</h2>
            
            <div class="gallery-filter animate__animated animate__fadeIn animate__delay-1s">
                <button class="filter-btn active" data-filter="all">All</button>
                <button class="filter-btn" data-filter="rooms">Rooms & Suites</button>
                <button class="filter-btn" data-filter="dining">Dining</button>
                <button class="filter-btn" data-filter="spa">Spa & Wellness</button>
                <button class="filter-btn" data-filter="pool"> Kids Park</button>
                <button class="filter-btn" data-filter="events">Events</button>
            </div>
            
            <div class="row gallery-grid">
                
                <?php
                // Fetch all gallery images from the database
                // Note: Make sure your image paths in the DB are correct (e.g., '../photos/gallery/my-image.jpg')
                
                // --- FIX 1: Changed 'uploaded_at' to 'image_id' which exists in your table ---
                $sql = "SELECT * FROM gallery ORDER BY category, image_id DESC";
                $result = $conn->query($sql);
                
                if ($result && $result->num_rows > 0) {
                    // Loop through each row (image)
                    while($row = $result->fetch_assoc()) {
                        // Use htmlspecialchars to prevent XSS issues
                        $image_path = htmlspecialchars($row['image_path']);
                        
                        // --- FIX 2: Changed 'alt_text' to 'image_alt' which exists in your table ---
                        $alt_text = htmlspecialchars($row['image_alt']);
                        $category = htmlspecialchars($row['category']);
                        
                        echo '
                        <div class="col-md-4 col-sm-6 gallery-item" data-category="' . $category . '">
                            <img src="' . $image_path . '" alt="' . $alt_text . '">
                            <div class="item-overlay">
                                <i class="fas fa-search-plus"></i>
                            </div>
                        </div>
                        ';
                    }
                } else {
                    if (!$result) {
                        // Query failed
                        echo '<p class="text-center text-danger">Error fetching gallery: ' . $conn->error . '</p>';
                    } else {
                        // No images found
                        echo '<p class="text-center">No images have been added to the gallery yet.</p>';
                    }
                }
                $conn->close();
                ?>
                </div>
        </div>
    </section>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<div class="modal fade" id="imageModal" tabindex="-1" aria-labelledby="imageModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-dialog-centered modal-lg">
    <div class="modal-content">
      <div class="modal-body p-0">
        <img src="" id="modalImage" class="img-fluid" alt="">
      </div>
    </div>
  </div>
</div>

<script >
    // Simulate loading animation
        document.addEventListener('DOMContentLoaded', function() {
            // Add animation classes after a short delay
            setTimeout(function() {
                const cards = document.querySelectorAll('.card');
                cards.forEach((card, index) => {
                    card.classList.add('animate__fadeInUp');
                    card.style.animationDelay = `${index * 0.1}s`;
                });
            }, 300);
        });

         document.addEventListener('DOMContentLoaded', function() {
            // Filter gallery items
            const filterButtons = document.querySelectorAll('.filter-btn');
            const galleryItems = document.querySelectorAll('.gallery-item');
            
            filterButtons.forEach(button => {
                button.addEventListener('click', function() {
                    // Update active button
                    filterButtons.forEach(btn => btn.classList.remove('active'));
                    this.classList.add('active');
                    
                    const filterValue = this.getAttribute('data-filter');
                    
                    // Filter items
                    galleryItems.forEach(item => {
                        // Re-add animation class for re-filtering
                        item.classList.add('animate__animated', 'animate__fadeInUp');
                        if (filterValue === 'all' || item.getAttribute('data-category') === filterValue) {
                            item.style.display = 'block';
                        } else {
                            item.style.display = 'none';
                        }
                    });
                });
            });
            
            // Image lightbox
            const galleryImages = document.querySelectorAll('.gallery-item img');
            const modalImage = document.getElementById('modalImage');
            const imageModal = new bootstrap.Modal(document.getElementById('imageModal'));
            
            galleryImages.forEach(image => {
                image.addEventListener('click', function() {
                    modalImage.src = this.src;
                    modalImage.alt = this.alt;
                    imageModal.show();
                });
            });
            
            // Animation on scroll
            const animateElements = document.querySelectorAll('.animate__animated');
            
            const animateOnScroll = function() {
                animateElements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;
                    
                    if (elementPosition < windowHeight - 100) {
                        // This logic might be flawed. Let's fix it.
                        // We need to add the animation class, not re-add its existing class.
                        // Let's assume the animation class is 'animate__fadeIn' or 'animate__fadeInUp' etc.
                        // The code will add *all* 'animate__animated' classes on scroll,
                        // which is what your original code implies.
                        
                        // Let's find the *specific* animation (e.g., animate__fadeIn)
                        let animationClass = '';
                        element.classList.forEach(cls => {
                            if (cls.startsWith('animate__') && cls !== 'animate__animated') {
                                animationClass = cls;
                            }
                        });

                        if (animationClass) {
                             element.classList.add(animationClass);
                        }
                    }
                });
            };
            
            // Initial check
            animateOnScroll();
            
            // Check on scroll
            window.addEventListener('scroll', animateOnScroll);
            
            // Smooth scrolling for anchor links
            document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                anchor.addEventListener('click', function(e) {
                    e.preventDefault();
                    
                    const targetElement = document.querySelector(this.getAttribute('href'));
                    if (targetElement) {
                        targetElement.scrollIntoView({
                            behavior: 'smooth'
                        });
                    }
                });
            });
        });

</script>
</body>
</html>