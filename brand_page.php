<?php
include 'db_config.php';

// 1. Capture the brand name from the URL
$brand_name = isset($_GET['brand']) ? mysqli_real_escape_string($conn, $_GET['brand']) : '';

if (empty($brand_name)) {
    header("Location: index.php"); // Redirect if no brand is selected
    exit();
}

// 2. Fetch all flavors/products for this specific brand
// Using the "Category (Brand)" field from your 'Add Brand' form
$query = "SELECT * FROM brand_products WHERE category_brand = '$brand_name' AND status = 'active'";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo htmlspecialchars($brand_name); ?> | Rakula Agency</title>
    </head>
<body style="background: #0a0a0a; color: white;">

<div class="container py-5">
    <a href="index.php" class="btn btn-outline-warning mb-4">← Back to Brands</a>
    
    <h1 class="mb-5">Discover <?php echo htmlspecialchars($brand_name); ?></h1>

    <div class="row g-4">
        <?php if(mysqli_num_rows($result) > 0): ?>
            <?php while($product = mysqli_fetch_assoc($result)): ?>
                <div class="col-md-4">
                    <div class="product-card p-3 border border-secondary rounded">
                        <img src="uploads/<?php echo $product['primary_image']; ?>" class="img-fluid mb-3" alt="Product">
                        
                        <h4><?php echo htmlspecialchars($product['flavor_name']); ?></h4>
                        <p class="text-warning"><?php echo htmlspecialchars($product['size_label']); ?></p>
                        <p class="small opacity-75"><?php echo htmlspecialchars($product['flavor_description']); ?></p>
                    </div>
                </div>
            <?php endwhile; ?>
        <?php else: ?>
            <div class="col-12">
                <p>No products available for this brand yet.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

</body>
</html>