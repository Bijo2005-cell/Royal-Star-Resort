// Bootstrap JS
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scroll for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                
                const targetId = this.getAttribute('href');
                const targetElement = document.querySelector(targetId);
                
                if (targetElement) {
                    window.scrollTo({
                        top: targetElement.offsetTop - 70,
                        behavior: 'smooth'
                    });
                }
            });
        });

          // Initialize carousel
    document.addEventListener('DOMContentLoaded', function() {
        var offersCarousel = new bootstrap.Carousel(document.getElementById('offersCarousel'), {
            interval: 5000, // Change slide every 5 seconds
            ride: 'carousel'
        });
        
        // You can add countdown timer functionality here if needed
    });
    
//    Update your JavaScript initialization
         document.addEventListener('DOMContentLoaded', function() {
    initializeCountdown(1, 7);  // 7 days for offer 1
    initializeCountdown(2, 3);  // 3 days for offer 2
    initializeCountdown(3, 14); // 14 days for offer 3
    // Remove the initializeCountdown(4, 1) line as you don't have offer 4
});

// Modify your countdown function
function initializeCountdown(offerId, days) {
    const targetDate = new Date();
    targetDate.setDate(targetDate.getDate() + days);
    
    function updateCountdown() {
        // Only update if the carousel item is active
        const carouselItem = document.querySelector(`.carousel-item:nth-child(${offerId})`);
        if (!carouselItem || !carouselItem.classList.contains('active')) return;
        
        const now = new Date();
        const distance = targetDate - now;
        
        // Rest of your countdown logic...
    }
    
    updateCountdown();
    setInterval(updateCountdown, 1000);
}

// Alternative Solution
// Initialize all countdowns when DOM is ready
document.addEventListener('DOMContentLoaded', function() {
    const countdowns = {
        1: 7,   // offer 1: 7 days
        2: 3,   // offer 2: 3 days
        3: 14   // offer 3: 14 days
    };
    
    // Initialize when carousel slides
    const carousel = document.getElementById('offersCarousel');
    carousel.addEventListener('slid.bs.carousel', function() {
        const activeIndex = Array.from(document.querySelectorAll('.carousel-item')).findIndex(item => 
            item.classList.contains('active')
        ) + 1;
        
        if (countdowns[activeIndex]) {
            initializeCountdown(activeIndex, countdowns[activeIndex]);
        }
    });
    
    // Initialize first active slide
    initializeCountdown(1, 7);
});

        // Animate elements on scroll
        function animateOnScroll() {
            const elements = document.querySelectorAll('.package-card, .feature-box, .rules-list li, .contact-form');
            
            elements.forEach(element => {
                const elementPosition = element.getBoundingClientRect().top;
                const screenPosition = window.innerHeight / 1.2;
                
                if (elementPosition < screenPosition) {
                    element.classList.add('animated');
                }
            });
        }
        
        window.addEventListener('scroll', animateOnScroll);
        window.addEventListener('load', animateOnScroll);

        // Chatbot functionality
        const chatbotBtn = document.getElementById('chatbotBtn');
        const chatbotContainer = document.getElementById('chatbotContainer');
        const chatbotClose = document.getElementById('chatbotClose');
        const chatbotSend = document.getElementById('chatbotSend');
        const chatbotInput = document.getElementById('chatbotInput');
        const chatbotBody = document.getElementById('chatbotBody');
        
        chatbotBtn.addEventListener('click', function() {
            chatbotContainer.classList.toggle('active');
        });
        
        chatbotClose.addEventListener('click', function() {
            chatbotContainer.classList.remove('active');
        });
        
        function addBotMessage(message) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'chatbot-message bot-message';
            messageDiv.innerHTML = `<div class="message-content">${message}</div>`;
            chatbotBody.appendChild(messageDiv);
            chatbotBody.scrollTop = chatbotBody.scrollHeight;
        }
        
        function addUserMessage(message) {
            const messageDiv = document.createElement('div');
            messageDiv.className = 'chatbot-message user-message';
            messageDiv.innerHTML = `<div class="message-content">${message}</div>`;
            chatbotBody.appendChild(messageDiv);
            chatbotBody.scrollTop = chatbotBody.scrollHeight;
        }
        
        chatbotSend.addEventListener('click', function() {
            const message = chatbotInput.value.trim();
            if (message) {
                addUserMessage(message);
                chatbotInput.value = '';
                
                // Simple bot responses
                setTimeout(() => {
                    if (message.toLowerCase().includes('hello') || message.toLowerCase().includes('hi')) {
                        addBotMessage('Hello there! How can I assist you today?');
                    } else if (message.toLowerCase().includes('room') || message.toLowerCase().includes('book')) {
                        addBotMessage('You can book a room through our website or by calling our reservations team at +1 (555) 123-4567. Would you like me to direct you to our booking page?');
                    } else if (message.toLowerCase().includes('price') || message.toLowerCase().includes('cost')) {
                        addBotMessage('Room prices vary depending on the season and room type. Our standard rooms start at $199 per night. You can check current rates on our booking page.');
                    } else if (message.toLowerCase().includes('amenities') || message.toLowerCase().includes('facilities')) {
                        addBotMessage('We offer a wide range of amenities including a spa, fitness center, swimming pools, multiple dining options, and more. Is there any specific amenity you\'d like information about?');
                    } else if (message.toLowerCase().includes('thank')) {
                        addBotMessage('You\'re welcome! Is there anything else I can help you with?');
                    } else {
                        addBotMessage('I\'m sorry, I didn\'t understand that. Could you please rephrase your question or contact our front desk for assistance?');
                    }
                }, 1000);
            }
        });
        
        chatbotInput.addEventListener('keypress', function(e) {
            if (e.key === 'Enter') {
                chatbotSend.click();
            }
        });

        // Initialize contact form animation
        document.addEventListener('DOMContentLoaded', function() {
            const contactForm = document.querySelector('.contact-form');
            if (contactForm) {
                setTimeout(() => {
                    contactForm.classList.add('animated');
                }, 500);
            }
        });
    
        // Toggle sidebar on mobile
        document.getElementById('sidebarToggle').addEventListener('click', () => {
            document.getElementById('sidebar').classList.toggle('show');
        });

        // Initialize charts
        document.addEventListener('DOMContentLoaded', () => {
            // Occupancy Chart
            const occupancyCtx = document.getElementById('occupancyChart').getContext('2d');
            new Chart(occupancyCtx, {
                type: 'line',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
                    datasets: [{
                        label: 'Occupancy Rate',
                        data: [65, 59, 80, 81, 76, 85, 92, 78, 88, 75, 82, 90],
                        backgroundColor: 'rgba(139, 69, 19, 0.1)',
                        borderColor: '#8B4513',
                        borderWidth: 2,
                        tension: 0.4,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    plugins: { legend: { display: false } },
                    scales: {
                        y: {
                            beginAtZero: true,
                            max: 100,
                            ticks: { callback: value => value + '%' }
                        }
                    }
                }
            });

            // Room Type Chart
            const roomTypeCtx = document.getElementById('roomTypeChart').getContext('2d');
            new Chart(roomTypeCtx, {
                type: 'doughnut',
                data: {
                    labels: ['Deluxe', 'Executive', 'Standard', 'Suite', 'Presidential'],
                    datasets: [{
                        data: [35, 25, 20, 15, 5],
                        backgroundColor: ['#8B4513', '#A0522D', '#D4AF37', '#CD853F', '#D2B48C']
                    }]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'right' }
                    }
                }
            });
        });
    

         document.addEventListener('DOMContentLoaded', function() {
            // Animation on scroll
            const animateElements = document.querySelectorAll('.animate__animated');
            
            const animateOnScroll = function() {
                animateElements.forEach(element => {
                    const elementPosition = element.getBoundingClientRect().top;
                    const windowHeight = window.innerHeight;
                    
                    if (elementPosition < windowHeight - 100) {
                        const animationClass = element.classList.item(1);
                        element.classList.add(animationClass);
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
                    
                    document.querySelector(this.getAttribute('href')).scrollIntoView({
                        behavior: 'smooth'
                    });
                });
            });
        });


         // Toggle sidebar
        document.getElementById('sidebarToggle').addEventListener('click', function() {
            const sidebar = document.getElementById('sidebar');
            const mainContent = document.getElementById('mainContent');
            
            sidebar.classList.toggle('sidebar-collapsed');
            mainContent.classList.toggle('main-content-expanded');
            
            // Change icon
            const icon = this.querySelector('i');
            if (sidebar.classList.contains('sidebar-collapsed')) {
                icon.classList.remove('fa-bars');
                icon.classList.add('fa-indent');
            } else {
                icon.classList.remove('fa-indent');
                icon.classList.add('fa-bars');
            }
        });
        
// facilities
 <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>


        // JavaScript for Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // JavaScript for smooth scrolling
        document.querySelectorAll('a.nav-link[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function(e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });
