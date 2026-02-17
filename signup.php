<?php
include 'db_config.php';

if (isset($_POST['register'])) {
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password']; // In production, use password_hash($password, PASSWORD_DEFAULT)

    // Check if email already exists
    $check_email = mysqli_query($conn, "SELECT id FROM users WHERE email = '$email'");
    if (mysqli_num_rows($check_email) > 0) {
        $error = "Email already registered!";
    } else {
        $sql = "INSERT INTO users (username, email, password, role) VALUES ('$username', '$email', '$password', 'user')";
        if (mysqli_query($conn, $sql)) {
            header("Location: login.php?msg=Registration Successful! Please login.");
        } else {
            $error = "Registration failed. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join Rakula Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-5">
            <div class="card shadow-lg border-0 p-4">
                <div class="text-center mb-4">
                    <h2 class="fw-bold text-primary">Create Account</h2>
                    <p class="text-muted">Start ordering your drinks today</p>
                </div>

                <?php if(isset($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>

                <form method="POST" id="signupForm">
                    <div class="mb-3">
                        <label class="form-label">Full Name</label>
                        <input type="text" name="username" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Email Address</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Password</label>
                        <input type="password" name="password" id="pass" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" id="confirm_pass" class="form-control" required>
                        <div id="matchError" class="text-danger small mt-1 d-none">Passwords do not match!</div>
                    </div>
                    
                    <button type="submit" name="register" id="submitBtn" class="btn btn-primary w-100 py-2">Sign Up</button>
                </form>

                <div class="text-center mt-4">
                    <p>Already have an account? <a href="login.php" class="text-decoration-none">Login</a></p>
                    <a href="index.php" class="text-muted small">Back to Home</a>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Password Match Validation
const pass = document.getElementById('pass');
const confirmPass = document.getElementById('confirm_pass');
const submitBtn = document.getElementById('submitBtn');
const matchError = document.getElementById('matchError');

function validatePasswords() {
    if (confirmPass.value === "") {
        matchError.classList.add('d-none');
        return;
    }
    if (pass.value !== confirmPass.value) {
        matchError.classList.remove('d-none');
        submitBtn.disabled = true;
    } else {
        matchError.classList.add('d-none');
        submitBtn.disabled = false;
    }
}

pass.addEventListener('input', validatePasswords);
confirmPass.addEventListener('input', validatePasswords);
</script>

</body>
</html>