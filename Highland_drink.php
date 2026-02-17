<?php 
include 'db_config.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get category from URL, default to 'Club Soda'
$category = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : 'Club Soda';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Highland Drinks | <?php echo htmlspecialchars($category); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --primary: #003399; --gold: #ffcc00; --dark-blue: #001a4d; }
        body { font-family: 'Segoe UI', sans-serif; background-color: #f4f6f9; }
        
        /* Original Theme Header */
        .category-header { background: var(--primary); color: white; padding: 60px 0; border-bottom: 4px solid var(--gold); text-transform: uppercase; letter-spacing: 2px; }
        
        /* The requested 2-image flavor card */
        .flavor-card { border: none; transition: 0.3s; background: #fff; border-radius: 20px; overflow: hidden; margin-bottom: 30px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .flavor-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        
        .img-container { background: #f8f9fa; padding: 25px; text-align: center; display: flex; align-items: center; justify-content: center; height: 300px; }
        .product-img { max-height: 100%; width: auto; object-fit: contain; }
        
        .desc-text { color: #666; font-size: 0.95rem; line-height: 1.6; }
        .badge-size { background: var(--gold); color: #000; font-weight: 700; padding: 5px 15px; border-radius: 50px; }
        
        .nav-link.active { border-bottom: 3px solid var(--gold); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: var(--primary);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">RAKULA AGENCY</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="highland_drinks.php">Products</a></li>
                <li class="nav-item"><a class="nav-link" href="gallery.php">Gallery</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="category-header text-center">
    <div class="container">
        <h1 class="fw-bold display-4"><?php echo htmlspecialchars($category); ?></h1>
        <p class="lead opacity-75">Premium Refreshment Distributed by Rakula Agency</p>
    </div>
</header>

<div class="container my-5">
    <div class="text-center mb-5">
        <a href="?cat=Club Soda" class="btn <?php echo $category == 'Club Soda' ? 'btn-primary' : 'btn-outline-primary'; ?> rounded-pill px-4 m-1">Club Soda</a>
        <a href="?cat=Cordials" class="btn <?php echo $category == 'Cordials' ? 'btn-primary' : 'btn-outline-primary'; ?> rounded-pill px-4 m-1">Cordials</a>
        <a href="?cat=Water" class="btn <?php echo $category == 'Water' ? 'btn-primary' : 'btn-outline-primary'; ?> rounded-pill px-4 m-1">Pure Water</a>
        <a href="?cat=Bazu" class="btn <?php echo $category == 'Bazu' ? 'btn-primary' : 'btn-outline-primary'; ?> rounded-pill px-4 m-1">Bazu</a>
    </div>

    <div class="row">
        <?php
        // Fetching variations based on the selected category
        $query = "SELECT * FROM product_variations WHERE brand_name = '$category' ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-6">
                    <div class="flavor-card">
                        <div class="row g-0">
                            <div class="col-6 img-container border-end">
                                <img src="uploads/products/<?php echo $row['image_path']; ?>" class="product-img img-fluid" alt="Front View">
                            </div>
                            <div class="col-6 img-container">
                                <img src="uploads/products/<?php echo $row['image_path_2']; ?>" class="product-img img-fluid" alt="Detail View">
                            </div>
                        </div>
                        <div class="p-4">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <h3 class="fw-bold mb-0 text-primary"><?php echo htmlspecialchars($row['flavor_name']); ?></h3>
                                    <small class="text-muted text-uppercase fw-bold"><?php echo htmlspecialchars($row['brand_name']); ?></small>
                                </div>
                                <span class="badge-size"><?php echo htmlspecialchars($row['size_label']); ?></span>
                            </div>
                            <p class="desc-text mb-0"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="col-12 text-center py-5">
                <i class="bi bi-box-seam display-1 text-muted opacity-25"></i>
                <h3 class="mt-3 text-muted">No variants added for <?php echo htmlspecialchars($category); ?> yet.</h3>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<footer class="py-4 text-center border-top bg-white">
    <p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> Rakula Agency Ltd. All Rights Reserved.</p>
</footer>

</body>
</html>