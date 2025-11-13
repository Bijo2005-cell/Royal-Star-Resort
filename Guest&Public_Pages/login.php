<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Royal Star Residency | Member Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Cormorant+Garamond:wght@400;500;700&family=Montserrat:wght@300;400;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="../Styling&Scripts/style1.css">
</head>
<body1>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-5">
                <div class="auth-container">
                    <div class="auth-header">
                        <div class="resort-logo">Royal Star Residency</div>
                        <h1 class="auth-title">Welcome Back</h1>
                    </div>
                    
                    <form action="login_process.php" method="POST" id="loginForm">
                        <div id="serverError" class="alert alert-danger d-none" role="alert"></div>

                        <div class="mb-3">
                            <label for="user" class="form-label">Username or Email</label>
                            <input type="text" class="form-control" name="user" id="user" placeholder="Enter your credentials" required>
                            <span id="usernameError" class="text-danger"></span>
                        </div>
                        
                        <div class="mb-3">
                            <label for="pass" class="form-label">Password</label>
                            <input type="password" class="form-control" name="pass" id="pass" placeholder="Enter your password" required>
                            <span id="passwordError" class="text-danger"></span>
                        </div>
                        
                        <div class="form-footer">
                            <div class="remember-me">
                                <input type="checkbox" id="remember" name="remember">
                                <label for="remember">Remember me</label>
                            </div>
                            <a href="#forgot-password">Forgot password?</a>
                        </div>
                        
                        <button type="submit" class="btn btn-auth">
                            <i class="fas fa-sign-in-alt me-2"></i> Sign In
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();
        
        // First, run client-side validation
        if (!validateClientSide()) {
            return; // Stop if validation fails
        }

        const form = event.target;
        const serverErrorDiv = document.getElementById('serverError');
        serverErrorDiv.textContent = '';
        serverErrorDiv.classList.add('d-none'); // Hide error div initially

        // Handle "Remember me" functionality
        const remember = document.getElementById('remember').checked;
        if (remember) {
            const username = document.getElementById('user').value;
            // Set cookie for 30 days
            document.cookie = `remember_username=${username}; path=/; max-age=2592000`; 
        } else {
            // If not checked, expire the cookie
            document.cookie = `remember_username=; path=/; max-age=0`;
        }

        const formData = new FormData(form);

        // Send data to the server
        fetch('../Authentication/login_process.php', {
            method: 'POST',
            body: formData,
            credentials: 'include' // Important for handling sessions
        })
        .then(response => {
            if (!response.ok) {
                throw new Error(`HTTP error! Status: ${response.status}`);
            }
            return response.json();
        })
        .then(data => {
            if (data.status === 'success') {
                // Redirect on successful login
                window.location.href = data.redirect;
            } else {
                // Show server error message
                serverErrorDiv.textContent = data.message || 'Login failed. Please check your credentials.';
                serverErrorDiv.classList.remove('d-none');
            }
        })
        .catch(error => {
            console.error('Fetch Error:', error);
            serverErrorDiv.textContent = 'An unexpected error occurred. Please try again later.';
            serverErrorDiv.classList.remove('d-none');
        });
    });

    function validateClientSide() {
        const username = document.getElementById('user').value.trim();
        const password = document.getElementById('pass').value.trim();
        let isValid = true;
        
        // Clear previous errors
        document.getElementById('usernameError').textContent = '';
        document.getElementById('passwordError').textContent = '';
        
        if (username === '') {
            document.getElementById('usernameError').textContent = 'Please enter your username or email.';
            isValid = false;
        }
        
        if (password === '') {
            document.getElementById('passwordError').textContent = 'Please enter your password.';
            isValid = false;
        } else if (password.length < 6) {
            document.getElementById('passwordError').textContent = 'Password must be at least 6 characters.';
            isValid = false;
        }
        
        return isValid;
    }

    // On page load, check for the "remember me" cookie
    window.addEventListener('load', function() {
        const cookies = document.cookie.split(';');
        for (let cookie of cookies) {
            const [name, value] = cookie.trim().split('=');
            if (name === 'remember_username' && value) {
                document.getElementById('user').value = value;
                document.getElementById('remember').checked = true;
                break;
            }
        }
    });
    </script>
</body>
</html>