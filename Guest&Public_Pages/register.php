<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Residency | Membership</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;500;700&family=Poppins:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Styling&Scripts/style1.css"> </head>
<body>
    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-lg-6">
                <div class="text-center mb-5">
                    <h1>Royal Star Resort</h1>
                </div>
                
                <div class="form-container">
                    <div id="server-message" class="mb-3"></div>

                    <form id="membershipForm">
                        <div class="mb-4">
                            <label for="name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name">
                            <span id="Name" class="text-danger"></span>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" id="emails" name="email" placeholder="your.email@example.com">
                            <span id="emailids" class="text-danger"></span>
                        </div>
                        
                        <div class="mb-4">
                            <label for="user" class="form-label">Username</label>
                            <input type="text" class="form-control" id="user" name="username" placeholder="Choose a username">
                            <span id="username" class="text-danger"></span>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Password</label>
                            <input type="password" class="form-control" id="pass" name="password" placeholder="Minimum 8 characters">
                            <span id="passwords" class="text-danger"></span>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="conpass" name="conpass" placeholder="Re-enter your password">
                            <span id="confrmpass" class="text-danger"></span>
                        </div>
                        
                        <div class="mb-4">
                            <label class="form-label">Mobile Number</label>
                            <input type="tel" class="form-control" id="mobileNumber" name="mobileNumber" placeholder="">
                            <span id="mobileno" class="text-danger"></span>
                        </div>
                        
                        <div class="d-grid gap-3 d-md-flex justify-content-md-end mt-5">
                            <button type="reset" class="btn btn-secondary px-4">Reset</button>
                            <button type="submit" class="btn btn-primary px-4" id="submitBtn">Create Account</button>
                        </div>
                        
                        <div class="text-center mt-3">
                            <a href="login.php" class="d-flex align-items-center justify-content-center">
                                <i class="fas fa-arrow-right me-2"></i> Access your account
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.getElementById('membershipForm').addEventListener('submit', function(event) {
            // Prevent the default form submission to handle it with AJAX
            event.preventDefault();

            // Run client-side validation first
            if (validation()) {
                // If validation is successful, send the data to the server
                sendData();
            }
        });

        function sendData() {
            const form = document.getElementById('membershipForm');
            const formData = new FormData(form);
            const submitBtn = document.getElementById('submitBtn');
            const serverMessageDiv = document.getElementById('server-message');

            // Disable the button and show a loading state
            submitBtn.disabled = true;
            submitBtn.innerHTML = `<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Creating...`;

            // Use the modern fetch API to send form data
            fetch('../Authentication/api_register.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json()) // The server will respond with JSON
            .then(data => {
                // Display the server's message
                const messageClass = data.status === 'success' ? 'alert-success' : 'alert-danger';
                serverMessageDiv.innerHTML = `<div class="alert ${messageClass}" role="alert">${data.message}</div>`;

                if (data.status === 'success') {
                    form.reset(); // Clear the form fields
                    // Redirect to the login page after a short delay
                    setTimeout(() => {
                         window.location.href = '../Guest&Public_Pages/guest.php';
                    }, 2000);
                }
            })
            .catch(error => {
                // Handle network errors
                console.error('Error:', error);
                serverMessageDiv.innerHTML = `<div class="alert alert-danger" role="alert">An unexpected network error occurred. Please try again later.</div>`;
            })
            .finally(() => {
                // Re-enable the button after the request is complete
                submitBtn.disabled = false;
                submitBtn.innerHTML = 'Create Account';
            });
        }

        // Your existing validation function remains the same
        function validation() {
            const name = document.getElementById('name').value.trim();
            const email = document.getElementById('emails').value.trim();
            const username = document.getElementById('user').value.trim();
            const password = document.getElementById('pass').value.trim();
            const confirmPassword = document.getElementById('conpass').value.trim();
            const mobileNumber = document.getElementById('mobileNumber').value.trim();
            
            let isValid = true;
            
            // Reset all previous error messages
            document.getElementById('Name').textContent = '';
            document.getElementById('emailids').textContent = '';
            document.getElementById('username').textContent = '';
            document.getElementById('passwords').textContent = '';
            document.getElementById('confrmpass').textContent = '';
            document.getElementById('mobileno').textContent = '';
            
            // --- [All your existing validation checks go here] ---
            if (name === '') {
                document.getElementById('Name').textContent = 'Please enter your full name';
                isValid = false;
            }
            if (email === '') {
                document.getElementById('emailids').textContent = 'Please enter your email';
                isValid = false;
            } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
                document.getElementById('emailids').textContent = 'Please enter a valid email address';
                isValid = false;
            }
            if (username === '') {
                document.getElementById('username').textContent = 'Please choose a username';
                isValid = false;
            }
            if (password === '') {
                document.getElementById('passwords').textContent = 'Please enter a password';
                isValid = false;
            } else if (password.length < 8) {
                document.getElementById('passwords').textContent = 'Password must be at least 8 characters';
                isValid = false;
            }
            if (confirmPassword === '') {
                document.getElementById('confrmpass').textContent = 'Please confirm your password';
                isValid = false;
            } else if (password !== confirmPassword) {
                document.getElementById('confrmpass').textContent = 'Passwords do not match';
                isValid = false;
            }
            if (mobileNumber === '') {
                document.getElementById('mobileno').textContent = 'Please enter your mobile number';
                isValid = false;
            } else if (!/^\d{10}$/.test(mobileNumber)) { // Simplified for 10-digit numbers
                document.getElementById('mobileno').textContent = 'Please enter a valid 10-digit mobile number';
                isValid = false;
            }
            
            return isValid;
        }
    </script>
</body>
</html>