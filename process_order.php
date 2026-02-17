<?php
include 'db_config.php';

// Check if form was submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = $_SESSION['user_id'] ?? 0; // 0 for guest
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $location_fee = (int)$_POST['location'];
    $payment = mysqli_real_escape_string($conn, $_POST['payment']);

    // Calculate Grand Total from Session
    $cart_total = 0;
    foreach ($_SESSION['cart'] as $item) {
        $cart_total += ($item['price'] * $item['quantity']);
    }
    $final_total = $cart_total + $location_fee;

    // Insert Order into Database
    $query = "INSERT INTO orders (user_id, customer_name, phone, location, total_amount, payment_method) 
              VALUES ('$user_id', '$name', '$phone', 'Location Fee: $location_fee', '$final_total', '$payment')";
    
    $success = mysqli_query($conn, $query);

    if ($success) {
        // Clear the cart since order is placed
        unset($_SESSION['cart']);
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Processing Order | Rakula Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .success-checkmark { width: 80px; height: 80px; margin: 0 auto; display: none; }
        .spinner-border { width: 3rem; height: 3rem; }
        .order-box { border-radius: 20px; border: none; box-shadow: 0 10px 40px rgba(0,0,0,0.1); }
    </style>
</head>
<body class="bg-light d-flex align-items-center" style="min-height: 100vh;">

<div class="container text-center">
    <div class="row justify-content-center">
        <div class="col-md-6 card p-5 order-box">
            
            <div id="loading-state">
                <div class="spinner-border text-primary mb-4" role="status"></div>
                <h3 class="fw-bold">Securing your refreshments...</h3>
                <p class="text-muted">Please do not refresh the page.</p>
            </div>

            <div id="success-state" style="display: none;">
                <div class="mb-4">
                    <svg width="80" height="80" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="12" cy="12" r="12" fill="#28a745"/>
                        <path d="M7 12L10 15L17 8" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </div>
                <h2 class="fw-bold text-success">Order Placed!</h2>
                <p class="mb-4">Thank you, <strong><?php echo $name; ?></strong>. We've received your order and are preparing it for delivery.</p>
                
                <div class="bg-light p-3 rounded text-start mb-4">
                    <small class="text-muted d-block">Order Total:</small>
                    <span class="fw-bold fs-5 text-primary">KES <?php echo number_format($final_total, 2); ?></span>
                    <hr>
                    <small class="text-muted d-block">Payment Method:</small>
                    <span class="fw-bold"><?php echo strtoupper($payment); ?></span>
                </div>

                <a href="index.php" class="btn btn-primary w-100 py-3 rounded-pill fw-bold">Return to Home</a>
            </div>

        </div>
    </div>
</div>

<script>
    // Simulate a "Processing" delay for a catchy feel
    setTimeout(() => {
        document.getElementById('loading-state').style.display = 'none';
        document.getElementById('success-state').style.display = 'block';
    }, 2500); // 2.5 seconds delay
</script>

</body>
</html>