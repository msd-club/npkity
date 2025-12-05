<?php
require_once 'api/connection.php';

// Redirect if already logged in
if (isLoggedIn()) {
    header("Location: dashboard.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NPK Sensor Web UI | Login</title>
    
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Custom CSS -->
    <link href="assets/css/custom.css" rel="stylesheet">
    
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body class="bg-light">
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-md-6 col-lg-5">
                <!-- Login Form -->
                <div class="card shadow-lg border-0" id="loginForm">
                    <div class="card-header bg-primary text-white text-center py-4">
                        <h3 class="mb-0">
                            <i class='bx bx-leaf'></i> NPK Sensor Web UI
                        </h3>
                        <p class="mb-0 opacity-75">Sign in to your account</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form id="loginFormElement">
                            <div class="mb-3">
                                <label for="loginUsername" class="form-label">
                                    <i class='bx bx-user'></i> Username or Email
                                </label>
                                <input type="text" class="form-control" id="loginUsername" name="username" 
                                       placeholder="Enter your username or email" required>
                            </div>
                            <div class="mb-3">
                                <label for="loginPassword" class="form-label">
                                    <i class='bx bx-lock-alt'></i> Password
                                </label>
                                <input type="password" class="form-control" id="loginPassword" name="password" 
                                       placeholder="Enter your password" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-primary btn-lg">
                                    <i class='bx bx-log-in'></i> Login
                                </button>
                                <button type="button" class="btn btn-outline-primary" id="showRegister">
                                    <i class='bx bx-user-plus'></i> Create New Account
                                </button>
                            </div>
                        </form>
                        
                        <div id="loginMessage" class="mt-3"></div>
                    </div>
                </div>
                
                <!-- Register Form -->
                <div class="card shadow-lg border-0 d-none" id="registerForm">
                    <div class="card-header bg-success text-white text-center py-4">
                        <h3 class="mb-0">
                            <i class='bx bx-leaf'></i> Create Account
                        </h3>
                        <p class="mb-0 opacity-75">Join NPK Sensor Monitoring</p>
                    </div>
                    <div class="card-body p-4 p-md-5">
                        <form id="registerFormElement">
                            <div class="mb-3">
                                <label for="registerEmail" class="form-label">
                                    <i class='bx bx-envelope'></i> Email Address
                                </label>
                                <input type="email" class="form-control" id="registerEmail" name="email" 
                                       placeholder="Enter your email" required>
                            </div>
                            <div class="mb-3">
                                <label for="registerUsername" class="form-label">
                                    <i class='bx bx-user'></i> Username
                                </label>
                                <input type="text" class="form-control" id="registerUsername" name="username" 
                                       placeholder="Choose a username" required>
                            </div>
                            <div class="mb-3">
                                <label for="registerPassword" class="form-label">
                                    <i class='bx bx-lock-alt'></i> Password
                                </label>
                                <input type="password" class="form-control" id="registerPassword" name="password" 
                                       placeholder="Create a password" required>
                                <small class="text-muted">Minimum 6 characters</small>
                            </div>
                            <div class="mb-3">
                                <label for="registerConfirmPassword" class="form-label">
                                    <i class='bx bx-lock'></i> Confirm Password
                                </label>
                                <input type="password" class="form-control" id="registerConfirmPassword" 
                                       name="confirm_password" placeholder="Confirm your password" required>
                            </div>
                            <div class="d-grid gap-2">
                                <button type="submit" class="btn btn-success btn-lg">
                                    <i class='bx bx-user-plus'></i> Register
                                </button>
                                <button type="button" class="btn btn-outline-secondary" id="showLogin">
                                    <i class='bx bx-log-in'></i> Already have an account?
                                </button>
                            </div>
                        </form>
                        
                        <div id="registerMessage" class="mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Custom JS -->
    <script>
    $(document).ready(function() {
        // Toggle between login and register forms
        $('#showRegister').click(function() {
            $('#loginForm').addClass('d-none');
            $('#registerForm').removeClass('d-none');
            clearMessages();
        });
        
        $('#showLogin').click(function() {
            $('#registerForm').addClass('d-none');
            $('#loginForm').removeClass('d-none');
            clearMessages();
        });
        
        // Handle login form submission
        $('#loginFormElement').submit(function(e) {
            e.preventDefault();
            
            const formData = $(this).serialize();
            const messageDiv = $('#loginMessage');
            
            // Clear previous messages
            messageDiv.removeClass('alert-success alert-danger').html('');
            
            // Show loading state
            const submitBtn = $('#loginFormElement button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<span class="spinner-border spinner-border-sm"></span> Logging in...').prop('disabled', true);
            
            $.ajax({
                url: 'api/user_login.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        messageDiv.addClass('alert alert-success').html(response.message);
                        setTimeout(function() {
                            window.location.href = response.redirect;
                        }, 1000);
                    } else {
                        messageDiv.addClass('alert alert-danger').html(response.message);
                        submitBtn.html(originalText).prop('disabled', false);
                    }
                },
                error: function() {
                    messageDiv.addClass('alert alert-danger').html('An error occurred. Please try again.');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });
        
        // Handle register form submission
        $('#registerFormElement').submit(function(e) {
            e.preventDefault();
            
            // Validate passwords match
            const password = $('#registerPassword').val();
            const confirmPassword = $('#registerConfirmPassword').val();
            
            if (password !== confirmPassword) {
                showRegisterMessage('Passwords do not match!', 'danger');
                return;
            }
            
            if (password.length < 6) {
                showRegisterMessage('Password must be at least 6 characters!', 'danger');
                return;
            }
            
            const formData = $(this).serialize();
            const messageDiv = $('#registerMessage');
            
            // Clear previous messages
            messageDiv.removeClass('alert-success alert-danger').html('');
            
            // Show loading state
            const submitBtn = $('#registerFormElement button[type="submit"]');
            const originalText = submitBtn.html();
            submitBtn.html('<span class="spinner-border spinner-border-sm"></span> Registering...').prop('disabled', true);
            
            $.ajax({
                url: 'api/user_register.php',
                type: 'POST',
                data: formData,
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        messageDiv.addClass('alert alert-success').html(response.message);
                        // Clear form
                        $('#registerFormElement')[0].reset();
                        // Switch to login form after 2 seconds
                        setTimeout(function() {
                            $('#registerForm').addClass('d-none');
                            $('#loginForm').removeClass('d-none');
                            clearMessages();
                        }, 2000);
                    } else {
                        messageDiv.addClass('alert alert-danger').html(response.message);
                    }
                    submitBtn.html(originalText).prop('disabled', false);
                },
                error: function() {
                    messageDiv.addClass('alert alert-danger').html('An error occurred. Please try again.');
                    submitBtn.html(originalText).prop('disabled', false);
                }
            });
        });
        
        // Helper functions
        function showRegisterMessage(message, type) {
            const messageDiv = $('#registerMessage');
            messageDiv.removeClass('alert-success alert-danger').addClass('alert alert-' + type).html(message);
        }
        
        function clearMessages() {
            $('#loginMessage, #registerMessage').removeClass('alert-success alert-danger').html('');
        }
    });
    </script>
</body>
</html>