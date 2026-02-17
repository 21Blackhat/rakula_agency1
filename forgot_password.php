<?php
include 'db_config.php';

if (isset($_POST['send_code'])) {
    $identifier = mysqli_real_escape_string($conn, $_POST['identifier']);
    $method = $_POST['reset_method']; // 'email' or 'sms'

    // Logic to check if user exists and send code would go here
    // For now, we redirect to a verification entry page
    $msg = "A reset code has been sent to your " . ($method == 'email' ? "email address" : "phone number") . ".";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password | Rakula Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        body { background-color: #f4f7fe; height: 100vh; font-family: 'Segoe UI', sans-serif; }
        .reset-card { border-radius: 15px; border: none; max-width: 450px; }
        .method-option {
            border: 2px solid #eee;
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: 0.3s;
        }
        .method-option:hover { border-color: #003399; background: #f8f9ff; }
        .form-check-input:checked + .method-option {
            border-color: #003399;
            background: #f0f4ff;
        }
    </style>
</head>
<body class="d-flex align-items-center">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-5 card p-4 shadow-sm reset-card">
                <div class="text-center mb-4">
                    <div class="bg-primary text-white d-inline-block p-3 rounded-circle mb-3">
                        <i class="bi bi-shield-lock fs-3"></i>
                    </div>
                    <h3 class="fw-bold text-primary">Two-Step Verification</h3>
                    <p class="text-muted small">Choose how you want to receive your reset code</p>
                </div>

                <?php if(isset($msg)) echo "<div class='alert alert-info py-2 small'>$msg</div>"; ?>

                <form method="POST">
                    <div class="mb-4">
                        <label class="form-label small fw-bold">Enter Registered Email or Phone</label>
                        <input type="text" name="identifier" class="form-control form-control-lg rounded-3" placeholder="e.g. user@mail.com or 07123..." required>
                    </div>

                    <div class="row g-3 mb-4">
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="reset_method" id="method_email" value="email" checked autocomplete="off">
                            <label class="method-option d-block text-center w-100" for="method_email">
                                <i class="bi bi-envelope-at fs-3 d-block mb-2 text-primary"></i>
                                <span class="small fw-bold">Via Email</span>
                            </label>
                        </div>
                        
                        <div class="col-6">
                            <input type="radio" class="btn-check" name="reset_method" id="method_sms" value="sms" autocomplete="off">
                            <label class="method-option d-block text-center w-100" for="method_sms">
                                <i class="bi bi-chat-left-text fs-3 d-block mb-2 text-success"></i>
                                <span class="small fw-bold">Via SMS</span>
                            </label>
                        </div>
                    </div>

                    <button type="submit" name="send_code" class="btn btn-primary w-100 py-3 fw-bold rounded-pill shadow-sm">
                        Send Reset Code
                    </button>
                </form>

                <div class="text-center mt-4">
                    <a href="login.php" class="text-decoration-none text-secondary small">
                        <i class="bi bi-arrow-left me-1"></i> Back to Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>