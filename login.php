<?php
include 'db_config.php';

// 1. SMART SESSION START
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['login'])) {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']); 

    $result = mysqli_query($conn, "SELECT * FROM users WHERE email='$email' AND password='$password'");
    
    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
        
        // Setting session variables
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username']; 
        $_SESSION['role'] = $user['role'];
        
        // Redirect based on role
        if ($user['role'] == 'admin') {
            header("Location: admin.php"); 
        } else {
            header("Location: index.php");
        }
        exit(); 
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rakula Agency | Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7fe; height: 100vh; font-family: 'Segoe UI', sans-serif; }
        .login-card { border-radius: 15px; border: none; }
        .input-group-text { background: white; border-left: none; cursor: pointer; }
        .form-control { border-right: none; }
        .form-control:focus { border-color: #dee2e6; box-shadow: none; }
    </style>
</head>
<body class="d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-4 card p-4 shadow-sm login-card">
                <h3 class="text-center fw-bold text-primary mb-1">Rakula Agency</h3>
                <p class="text-center text-muted small mb-4">Sign in to manage your business or shop</p>
                
                <?php if(isset($error)) echo "<div class='alert alert-danger py-2 small text-center'>$error</div>"; ?>

                <form method="POST">
                    <div class="mb-3">
                        <label class="form-label small fw-bold">Email Address</label>
                        <input type="email" name="email" class="form-control rounded-3" placeholder="email" required>
                    </div>

                    <div class="mb-2">
                        <div class="d-flex justify-content-between">
                            <label class="form-label small fw-bold">Password</label>
                            <a href="forgot_password.php" class="text-decoration-none small fw-bold text-primary">Forgot?</a>
                        </div>
                        <div class="input-group">
                            <input type="password" name="password" id="password" class="form-control rounded-start-3" placeholder="••••••••" required>
                            <span class="input-group-text rounded-end-3" onclick="togglePassword()">
                                <i class="bi bi-eye" id="toggleIcon"></i>
                            </span>
                        </div>
                    </div>

                    <button type="submit" name="login" class="btn btn-primary w-100 mt-3 py-2 fw-bold rounded-pill shadow-sm">Login to Account</button>
                </form>
                
                <div class="text-center mt-4">
                    <a href="index.php" class="text-decoration-none text-secondary small d-block mb-2">Continue as Guest (View Only)</a>
                    
                    <hr class="text-muted opacity-25">
                    
                    <p class="small text-muted mb-0">Don't have an account? <a href="signup.php" class="fw-bold text-primary text-decoration-none">Register here</a></p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function togglePassword() {
            const passwordField = document.getElementById("password");
            const toggleIcon = document.getElementById("toggleIcon");
            if (passwordField.type === "password") {
                passwordField.type = "text";
                toggleIcon.classList.replace("bi-eye", "bi-eye-slash");
            } else {
                passwordField.type = "password";
                toggleIcon.classList.replace("bi-eye-slash", "bi-eye");
            }
        }
    </script>
</body>
</html>