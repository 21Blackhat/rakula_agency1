<?php
include 'db_config.php';

// Redirect if cart is empty
if (empty($_SESSION['cart'])) {
    header("Location: index.php");
    exit();
}

$grand_total = 0;
foreach ($_SESSION['cart'] as $item) {
    $grand_total += ($item['price'] * $item['quantity']);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Checkout | Rakula Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --rakula-blue: #003399; }
        .step-circle { width: 40px; height: 40px; border-radius: 50%; background: #eee; display: flex; align-items: center; justify-content: center; font-weight: bold; margin-bottom: 10px; }
        .step-active .step-circle { background: var(--rakula-blue); color: white; }
        .checkout-card { border: none; border-radius: 15px; box-shadow: 0 10px 30px rgba(0,0,0,0.05); }
        .form-section { display: none; }
        .form-section.active { display: block; animation: fadeIn 0.5s; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8 mb-5 d-flex justify-content-around text-center">
            <div class="step-item step-active" id="step-head-1">
                <div class="step-circle mx-auto">1</div>
                <small>Delivery</small>
            </div>
            <div class="step-item" id="step-head-2">
                <div class="step-circle mx-auto">2</div>
                <small>Payment</small>
            </div>
            <div class="step-item" id="step-head-3">
                <div class="step-circle mx-auto">3</div>
                <small>Review</small>
            </div>
        </div>

        <div class="col-lg-8">
            <form action="process_order.php" method="POST" id="checkoutForm">
                <div class="card checkout-card p-4">
                    
                    <div class="form-section active" id="step-1">
                        <h4 class="fw-bold mb-4">Where should we deliver?</h4>
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Full Name</label>
                                <input type="text" name="name" class="form-control" placeholder="John Doe" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Phone Number</label>
                                <input type="tel" name="phone" class="form-control" placeholder="0712345678" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Delivery Estate / Area</label>
                                <select name="location" class="form-select" id="locationSelect" onchange="updateDelivery()">
                                    <option value="0" selected disabled>Select Neighborhood...</option>
                                    <option value="100">Bamburi (KES 100)</option>
                                    <option value="150">Nyali (KES 150)</option>
                                    <option value="200">Mtwapa (KES 200)</option>
                                    <option value="0">Store Pickup (FREE)</option>
                                </select>
                            </div>
                            <div class="col-12 text-end mt-4">
                                <button type="button" class="btn btn-primary px-5 py-2 fw-bold" onclick="nextStep(2)">Continue to Payment</button>
                            </div>
                        </div>
                    </div>

                    <div class="form-section" id="step-2">
                        <h4 class="fw-bold mb-4">Payment Method</h4>
                        <div class="card p-3 border-primary mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="mpesa" value="mpesa" checked>
                                <label class="form-check-label fw-bold" for="mpesa">
                                    M-PESA (Lipa na M-PESA)
                                </label>
                            </div>
                        </div>
                        <div class="card p-3 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="payment" id="cod" value="cod">
                                <label class="form-check-label fw-bold" for="cod">
                                    Cash on Delivery
                                </label>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-4">
                            <button type="button" class="btn btn-outline-secondary" onclick="nextStep(1)">Back</button>
                            <button type="button" class="btn btn-primary px-5" onclick="nextStep(3)">Final Review</button>
                        </div>
                    </div>

                    <div class="form-section" id="step-3">
                        <h4 class="fw-bold mb-4">Confirm Your Order</h4>
                        <div class="alert alert-info">
                            Please ensure your phone number is active for the M-Pesa prompt.
                        </div>
                        <div class="bg-light p-3 rounded mb-4">
                            <h6>Order Summary:</h6>
                            <p class="mb-1">Items: <strong>KES <?php echo number_format($grand_total, 2); ?></strong></p>
                            <p class="mb-1">Delivery: <strong id="review-delivery">KES 0.00</strong></p>
                            <hr>
                            <h5>Total: <span class="text-primary" id="review-total">KES <?php echo number_format($grand_total, 2); ?></span></h5>
                        </div>
                        <div class="d-flex justify-content-between">
                            <button type="button" class="btn btn-outline-secondary" onclick="nextStep(2)">Back</button>
                            <button type="submit" class="btn btn-success btn-lg px-5 fw-bold">PLACE ORDER NOW</button>
                        </div>
                    </div>

                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let subtotal = <?php echo $grand_total; ?>;

    function nextStep(step) {
        document.querySelectorAll('.form-section').forEach(s => s.classList.remove('active'));
        document.querySelectorAll('.step-item').forEach(s => s.classList.remove('step-active'));
        
        document.getElementById('step-' + step).classList.add('active');
        document.getElementById('step-head-' + step).classList.add('step-active');
    }

    function updateDelivery() {
        let fee = parseInt(document.getElementById('locationSelect').value);
        let total = subtotal + fee;
        
        document.getElementById('review-delivery').innerText = "KES " + fee.toFixed(2);
        document.getElementById('review-total').innerText = "KES " + total.toLocaleString();
    }
</script>

</body>
</html>