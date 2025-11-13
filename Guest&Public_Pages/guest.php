<?php
// session_start();

// // Security check: Redirect to login if not logged in as a guest
// if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'guest') {
//     header('Location: ../Guest&Public_Pages/login.php');
//     exit();
// }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Resort - Luxury Getaway</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <link rel="stylesheet" href="../Styling&Scripts/style.css">
    
    <style>
        .guest-section { padding: 50px 0; }
        .guest-section table { border-collapse: collapse; width: 100%; margin-top: 20px; }
        .guest-section th, .guest-section td { border: 1px solid #ddd; padding: 12px; text-align: left; }
        .guest-section th { background-color: #f8f9fa; }
        .guest-section button { padding: 10px 20px; font-size: 16px; cursor: pointer; }

        /* --- NEW LUXURY HEADER STYLES (with renamed classes) --- */
        /* Using .navbar-luxury to avoid conflict with default .navbar styles if needed */
        .navbar-luxury {
            padding-top: 1rem;
            padding-bottom: 1rem;
            background-color: rgba(255, 255, 255, 0.7); /* Optional: semi-transparent bg */
            backdrop-filter: blur(10px); /* Creates a frosted glass effect */
            border-bottom: 1px solid rgba(0, 0, 0, 0.05);
            transition: background-color 0.3s ease-in-out;
        }

        .navbar-luxury .navbar-brand {
            font-family: 'Playfair Display', serif;
            font-weight: 700;
            font-size: 1.8rem;
            letter-spacing: 1px;
        }

        .navbar-luxury .navbar-brand span {
            font-weight: 400;
        }

        /* Renamed to avoid conflicts */
        .luxury-book-btn-new {
            border: 2px solid #8B4513; /* SaddleBrown color */
            color: #8B4513;
            font-weight: 500;
            padding: 0.5rem 1.5rem;
            border-radius: 50px; /* Fully rounded */
            transition: all 0.3s ease;
            text-decoration: none;
        }

        .luxury-book-btn-new:hover {
            background-color: #8B4513;
            color: #fff;
        }

        .navbar-luxury .header-actions {
            display: flex;
            align-items: center;
            gap: 1.5rem; /* Increased spacing between icons */
        }

        .navbar-luxury .header-actions .nav-link {
            font-size: 1.2rem; /* Make icons slightly larger */
            position: relative;
            padding: 0;
            color: #333;
        }
        
        .navbar-luxury .header-actions .dropdown-toggle::after {
            display: none; /* Hide default dropdown arrow */
        }

    </style>
</head>
<body>
   
    <header>
     <nav class="navbar-luxury navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand" href="#">Royal <span>Star</span> Resort</a>
                
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav ms-auto align-items-center">
                        
                        <li class="nav-item me-3">
                            <a href="../Guest&Public_Pages/program.php" class="luxury-book-btn-new">
                                <i class="fas fa-calendar-alt me-2"></i>Book Now
                            </a>
                        </li>
                        
                        <li class="nav-item">
                            <div class="header-actions">
                               
                                <a class="nav-link" href="#" aria-label="Notifications">
                                    <i class="fas fa-bell"></i>
                                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">5</span>
                                </a>
                                
                                <div class="dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" role="button" id="profileDropdown" data-bs-toggle="dropdown" aria-expanded="false" aria-label="Profile menu">
                                        <i class="fas fa-user-circle"></i>
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end shadow" aria-labelledby="profileDropdown">
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> My Account</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-history me-2"></i> Booking History</a></li>
                                        <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Settings</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li><a class="dropdown-item text-danger" href="../Guest&Public_Pages/home.php"><i class="fas fa-sign-out-alt me-2"></i> Log Out</a></li>
                                    </ul>
                                </div>
                                 
                                <a class="nav-link" href="#" type="button" data-bs-toggle="offcanvas" data-bs-target="#offcanvasMenu" aria-controls="offcanvasMenu">
                                    <i class="fas fa-bars"></i>
                                </a>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
    </header>
    <section id="home" class="hero-section">
        <div id="heroCarousel" class="carousel slide" data-bs-ride="carousel">
            <div class="carousel-inner">
                <div class="carousel-item active">
                    <img src="../photos/bg7.jpg" class="d-block w-100" alt="Hero Image 1">
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
            <a href="../Guest&Public_Pages/room.php" class="btn hero-btn">Explore Rooms</a>
        </div>
    </section>

    <section class="py-5">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="booking-form-container">
                        <form class="booking-form">
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
    
    

    <section id="services" class="py-5">
        <div class="container">
            <div class="section-title">
                <h2>Our Amenities</h2>
                <p class="lead text-muted">Experience luxury at every turn</p>
            </div>
            <div class="row">
                <div class="col-md-4" data-aos="fade-up">
                     <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-ship"></i>
                        </div>
                        <h4>Private Speed Boat Safari</h4>
                        <p>Exclusive private speed boat safari offering unparalleled access to hidden coastal gems and luxurious onboard amenities.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                     <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-spa"></i>
                        </div>
                        <h4>Luxury Spa</h4>
                        <p>Rejuvenate with our award-winning spa treatments and therapies.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                     <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-wifi"></i>
                        </div>
                        <h4>High-Speed Wi-Fi</h4>
                        <p>Stay connected with our complimentary high-speed internet access throughout the resort.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-award"></i>
                        </div>
                        <h4>Award-Winning Service</h4>
                        <p>5-star restaurants featuring world-class chefs and international cuisine.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up">
                     <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-swimming-pool"></i>
                        </div>
                        <h4>Infinity Pools</h4>
                        <p>Multiple pools with stunning mountain views, including adults-only options.</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                     <div class="service-card">
                        <div class="service-icon">
                            <i class="fas fa-horse"></i>
                        </div>
                        <h4>Horse And Camel Riding</h4>
                        <p>Indulge in curated horse and camel rides tailored for intimate exploration and elevated comfort.</p>
                </div>
                
            </div>
        </div>
    </section>

    <section class="py-5 bg-light">
    <div class="container">
        <div class="section-title text-center mb-5">
            <h2 class="display-4">Guest Stories</h2>
            <p class="lead text-muted">Hear what our valued guests say about their Royal Star experience</p>
        </div>
            <div class="row">
                <div class="col-md-4" data-aos="fade-up">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="" class="testimonial-img me-3" alt="Guest testimonial">
                            <div>
                                <h5 class="mb-0">Adithya I S</h5>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p>"The Royal Star Resort exceeded all our expectations. The service was impeccable, the food divine, and our overwater villa was simply breathtaking. We can't wait to return!"</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="" class="testimonial-img me-3" alt="Guest testimonial">
                            <div>
                                <h5 class="mb-0">Noyal</h5>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p>"This was our third visit to Royal Star and it just keeps getting better. The staff remembers us and our preferences, making us feel like family. The new spa facilities are incredible."</p>
                    </div>
                </div>
                <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                    <div class="testimonial-card">
                        <div class="d-flex align-items-center mb-3">
                            <img src="" class="testimonial-img me-3" alt="Guest testimonial">
                            <div>
                                <h5 class="mb-0">Abidev Biju</h5>
                                <div class="text-warning">
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                    <i class="fas fa-star"></i>
                                </div>
                            </div>
                        </div>
                        <p>"We celebrated our anniversary here and the resort went above and beyond to make it special - rose petals on the bed, champagne at sunset, even a private beach dinner. Magical!"</p>
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


    <div class="offcanvas offcanvas-end" tabindex="-1" id="offcanvasMenu" aria-labelledby="offcanvasMenuLabel">
        <div class="offcanvas-header">
            <h5 class="offcanvas-title" id="offcanvasMenuLabel">Royal Star Resort</h5>
            <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas" aria-label="Close"></button>
        </div>
        <div class="offcanvas-body offcanvas-menu">
            <nav class="nav flex-column">
                <a class="nav-link active" href="../Guest&Public_Pages/guest.php"><i class="fas fa-home"></i> Home</a>
                <a class="nav-link" href="../Guest&Public_Pages/my_bookings.php"><i class="fas fa-door-open"></i> My Bookings</a>
                <a class="nav-link" href="../Guest&Public_Pages/room.php"><i class="fas fa-bed"></i> Room & Villas</a>
                <a class="nav-link" href="../Guest&Public_Pages/program.php"><i class="fas fa-calendar-check"></i> Program</a>
                <a class="nav-link" href="../Guest&Public_Pages/facilities.php"><i class="fas fa-swimming-pool"></i> Facilities</a>
                <a class="nav-link" href="../Guest&Public_Pages/gallery.php"><i class="fas fa-camera"></i> Gallery</a>
                <a class="nav-link" href="../Guest&Public_Pages/upcoming.php"><i class="fas fa-building"></i> Upcoming Projects</a>
                <a class="nav-link" href="../Guest&Public_Pages/award.php"><i class="fas fa-trophy"></i> Awards & Achievements</a>
                <a class="nav-link" href="../Guest&Public_Pages/blog.php"><i class="fas fa-book"></i> Blog & History</a>
                <a class="nav-link" href="../Guest&Public_Pages/rules.php"><i class="fas fa-clipboard-list"></i> Rules</a>
                <a class="nav-link" href="../Guest&Public_Pages/location.php"><i class="fas fa-map-marker-alt"></i> Location & Contact Us</a>
                <div class="mt-4 pt-3 border-top">
                    <a href="../Guest&Public_Pages/home.php" class="btn btn-outline-danger w-100"><i class="fas fa-sign-out-alt me-2"></i> Log Out</a>
                </div>
            </nav>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        // Initialize AOS animation
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true
        });

        // Initialize date pickers with min date as today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date().toISOString().split('T')[0];
            document.getElementById('checkIn').min = today;
            
            // Set check-out min date based on check-in date
            document.getElementById('checkIn').addEventListener('change', function() {
                const checkInDate = this.value;
                document.getElementById('checkOut').min = checkInDate;
                
                // If check-out is before new check-in, reset it
                if (document.getElementById('checkOut').value < checkInDate) {
                    document.getElementById('checkOut').value = '';
                }
            });
            
            // Form submission handler
            document.querySelector('.booking-form').addEventListener('submit', function(e) {
                e.preventDefault();
                // Here you would typically send the data to a server
                alert('Searching for available rooms...');
            });
        });

        // --- SCRIPT FOR GUEST LIST FETCHING ---
        const fetchButton = document.getElementById('fetch-btn');
        const guestListDiv = document.getElementById('guest-list');

        // Add a click event listener to the button
        fetchButton.addEventListener('click', () => {
            // Use the fetch API to call your PHP script
            fetch('fetch_guests.php')
                .then(response => {
                    // Check if the request was successful
                    if (!response.ok) {
                        throw new Error('Network response was not ok');
                    }
                    // Parse the JSON response
                    return response.json();
                })
                .then(data => {
                    // The 'data' variable now holds the array of guests from your PHP script
                    let tableHTML = '<table>';
                    tableHTML += '<tr><th>ID</th><th>Name</th><th>Email</th><th>Registered On</th></tr>';
                    
                    if (data.length > 0) {
                        // Loop through each guest and create a table row
                        data.forEach(guest => {
                            tableHTML += `<tr>
                                            <td>${guest.id}</td>
                                            <td>${guest.name}</td>
                                            <td>${guest.email}</td>
                                            <td>${guest.registration_date}</td>
                                          </tr>`;
                        });
                    } else {
                        tableHTML += '<tr><td colspan="4">No guests found.</td></tr>';
                    }
                    
                    tableHTML += '</table>';
                    
                    // Update the guest-list div with the new table
                    guestListDiv.innerHTML = tableHTML;
                })
                .catch(error => {
                    // Handle any errors that occurred during the fetch
                    console.error('Error fetching data:', error);
                    guestListDiv.innerHTML = '<p>Sorry, there was an error fetching the data.</p>';
                });
        });
    </script>
</body>
</html>