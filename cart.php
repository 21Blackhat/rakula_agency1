<?php
include 'db_config.php';

// Start session if not started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Logic to Remove Items
if (isset($_GET['remove'])) {
    $id = $_GET['remove'];
    if (isset($_SESSION['cart'][$id])) {
        unset($_SESSION['cart'][$id]);
    }
    header("Location: cart.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Basket | Rakula Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        :root { --primary-blue: #003399; }
        .cart-img { width: 80px; height: 80px; object-fit: contain; border-radius: 8px; background: #fff; }
        .btn-qty { width: 32px; height: 32px; display: flex; align-items: center; justify-content: center; border-radius: 50% !important; text-decoration: none; }
        .table thead { background-color: #f8f9fa; }
        .summary-card { border: none; border-radius: 15px; }
    </style>
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold m-0">Shopping Cart</h2>
        <a href="index.php" class="btn btn-outline-primary btn-sm">Keep Shopping</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <?php if (!empty($_SESSION['cart'])): ?>
                <div class="card border-0 shadow-sm p-3 mb-4">
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Product</th>
                                    <th>Price</th>
                                    <th class="text-center">Quantity</th>
                                    <th>Total</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php 
                                $grand_total = 0;
                                foreach ($_SESSION['cart'] as $id => $item): 
                                    // Calculate subtotal
                                    $subtotal = $item['price'] * $item['quantity'];
                                    $grand_total += $subtotal;
                                    
                                    // Ensure we have the right image path
                                    $img_src = "uploads/products/" . $item['image'];
                                ?>
                                <tr>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <img src="<?php echo $img_src; ?>" class="cart-img me-3 border" onerror="this.src='uploads/default.png'">
                                            <div>
                                                <span class="fw-bold d-block"><?php echo htmlspecialchars($item['name']); ?></span>
                                                <small class="text-muted"><?php echo htmlspecialchars($item['brand'] ?? 'Premium Refreshment'); ?></small>
                                            </div>
                                        </div>
                                    </td>
                                    <td>KES <?php echo number_format($item['price'], 2); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center justify-content-center gap-2">
                                            <a href="cart_logic.php?action=minus&id=<?php echo $id; ?>" class="btn btn-sm btn-outline-secondary btn-qty">-</a>
                                            <span class="fw-bold px-2"><?php echo $item['quantity']; ?></span>
                                            <a href="cart_logic.php?action=plus&id=<?php echo $id; ?>" class="btn btn-sm btn-outline-secondary btn-qty">+</a>
                                        </div>
                                    </td>
                                    <td class="fw-bold">KES <?php echo number_format($subtotal, 2); ?></td>
                                    <td class="text-end">
                                        <a href="cart.php?remove=<?php echo $id; ?>" class="text-danger" title="Remove Item">
                                            <i class="bi bi-trash3 fs-5"></i>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="currentColor" viewBox="0 0 16 16">
                                                <path d="M6.5 1h3a.5.5 0 0 1 .5.5v1H6v-1a.5.5 0 0 1 .5-.5M11 2.5v-1A1.5 1.5 0 0 0 9.5 0h-3A1.5 1.5 0 0 0 5 1.5v1H1.5a.5.5 0 0 0 0 1h.538l.853 10.66A2 2 0 0 0 4.885 16h6.23a2 2 0 0 0 1.994-1.84l.853-10.66h.538a.5.5 0 0 0 0-1zm1.958 1-.846 10.58a1 1 0 0 1-.997.92h-6.23a1 1 0 0 1-.997-.92L3.042 3.5zm-7.487 1a.5.5 0 0 1 .528.47l.5 8.5a.5.5 0 0 1-.998.06L5 5.03a.5.5 0 0 1 .47-.53Zm5.058 0a.5.5 0 0 1 .47.53l-.5 8.5a.5.5 0 1 1-.998-.06l.5-8.5a.5.5 0 0 1 .528-.47M8 4.5a.5.5 0 0 1 .5.5v8.5a.5.5 0 0 1-1 0V5a.5.5 0 0 1 .5-.5"/>
                                            </svg>
                                        </a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php else: ?>
                <div class="text-center py-5 card border-0 shadow-sm">
                    <img src="https://cdn-icons-png.flaticon.com/512/11329/11329060.png" width="100" class="mb-3 opacity-50 mx-auto">
                    <h3>Your cart is empty</h3>
                    <p class="text-muted px-4">Refresh your day with our premium selection!</p>
                    <div class="d-grid col-md-4 mx-auto">
                        <a href="index.php" class="btn btn-primary px-4">Start Shopping</a>
                    </div>
                </div>
            <?php endif; ?>
        </div>

        <?php if (!empty($_SESSION['cart'])): ?>
        <div class="col-lg-4">
            <div class="card summary-card shadow-sm p-4 sticky-top" style="top: 100px;">
                <h5 class="fw-bold mb-3">Order Summary</h5>
                <div class="d-flex justify-content-between mb-2">
                    <span class="text-muted">Subtotal</span>
                    <span>KES <?php echo number_format($grand_total, 2); ?></span>
                </div>
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Delivery</span>
                    <span class="text-success fw-bold">FREE</span>
                </div>
                <hr>
                <div class="d-flex justify-content-between fw-bold fs-4 mb-4">
                    <span>Total</span>
                    <span class="text-primary">KES <?php echo number_format($grand_total, 2); ?></span>
                </div>
                <a href="checkout.php" class="btn btn-success btn-lg w-100 shadow-sm fw-bold py-3">Proceed to Checkout</a>
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>