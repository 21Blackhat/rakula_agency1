<?php
include 'db_config.php';

// Ensure session is started for all operations
if (session_status() === PHP_SESSION_NONE) { 
    session_start(); 
}

// 1. ADDING TO CART (Works for Index and Brand Pages)
if (isset($_POST['add_to_cart'])) {
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    $qty = (int)$_POST['quantity'];

    // We check 'product_variations' as it contains the detailed flavor/size info
    $res = mysqli_query($conn, "SELECT * FROM product_variations WHERE id = '$product_id'");
    $p = mysqli_fetch_assoc($res);

    if ($p) {
        // Check if stock exists (if your table has this column)
        if (isset($p['stock_status']) && $p['stock_status'] == 'Out of Stock') {
            header("Location: " . $_SERVER['HTTP_REFERER'] . "?error=OutOfStock");
            exit();
        }

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }

        // Use the Database ID as the key to prevent overwriting different products
        if (isset($_SESSION['cart'][$product_id])) {
            $_SESSION['cart'][$product_id]['quantity'] += $qty;
        } else {
            // Store specific details so cart.php doesn't have to query the DB again
            $_SESSION['cart'][$product_id] = [
                "name"     => $p['flavor_name'] . " (" . $p['size_label'] . ")", 
                "price"    => $p['price'], 
                "image"    => $p['image_path'], // Using image_path from variations
                "brand"    => $p['brand_name'],
                "quantity" => $qty
            ];
        }
    }

    // Redirect back to wherever the user came from (Silent Update)
    header("Location: " . $_SERVER['HTTP_REFERER']); 
    exit();
}

// 2. PLUS / MINUS / AJAX UPDATES
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = $_GET['id'];
    
    if (isset($_SESSION['cart'][$id])) {
        if ($_GET['action'] == 'plus') {
            $_SESSION['cart'][$id]['quantity']++;
        } elseif ($_GET['action'] == 'minus') {
            $_SESSION['cart'][$id]['quantity']--;
            // If quantity drops below 1, remove the item entirely
            if ($_SESSION['cart'][$id]['quantity'] < 1) {
                unset($_SESSION['cart'][$id]);
            }
        }
    }

    // Handle AJAX requests (if you use JavaScript to update totals without refreshing)
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $qty = $_SESSION['cart'][$id]['quantity'] ?? 0;
        $price = $_SESSION['cart'][$id]['price'] ?? 0;
        $newSubtotal = $qty * $price;
        
        $grand = 0;
        if(isset($_SESSION['cart'])) {
            foreach($_SESSION['cart'] as $item) { $grand += ($item['price'] * $item['quantity']); }
        }

        echo json_encode([
            'newQty' => $qty,
            'newSubtotal' => number_format($newSubtotal, 2),
            'cartTotal' => number_format($grand, 2)
        ]);
        exit();
    }

    // Standard redirect for non-AJAX clicks
    header("Location: cart.php");
    exit();
}
?>