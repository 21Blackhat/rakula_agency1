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
        
        .category-header { background: var(--primary); color: white; padding: 60px 0; border-bottom: 4px solid var(--gold); text-transform: uppercase; letter-spacing: 2px; }
        
        /* Premium Card Styling */
        .flavor-card { border: none; transition: 0.3s; background: #fff; border-radius: 20px; overflow: hidden; margin-bottom: 40px; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
        .flavor-card:hover { transform: translateY(-5px); box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
        
        /* Main Top Image (Cover) - Set to SHOW ENTIRE IMAGE */
        .cover-container { background: #ffffff; height: 450px; width: 100%; display: flex; align-items: center; justify-content: center; padding: 20px; border-bottom: 1px solid #f0f0f0; }
        .cover-img { max-width: 100%; max-height: 100%; object-fit: contain; transition: 0.5s ease; }
        
        /* Bottom Small Images - Set to SHOW ENTIRE IMAGE */
        .sub-img-container { background: #ffffff; height: 250px; display: flex; align-items: center; justify-content: center; padding: 15px; }
        .sub-img { max-width: 100%; max-height: 100%; object-fit: contain; transition: 0.5s ease; }
        
        /* Hover Zoom Effect */
        .flavor-card:hover .cover-img, 
        .flavor-card:hover .sub-img { transform: scale(1.03); }
        
        /* Text Content Styling (Centered) */
        .desc-text { color: #666; font-size: 1rem; line-height: 1.6; max-width: 85%; margin: 0 auto; }
        .badge-size { background: var(--gold); color: #000; font-weight: 700; padding: 8px 25px; border-radius: 50px; display: inline-block; margin-top: 15px; font-size: 0.95rem; }
        
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
                <li class="nav-item"><a class="nav-link active" href="highland_drink.php">Products</a></li>
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

    <div class="row justify-content-center">
        <?php
        $query = "SELECT * FROM product_variations WHERE brand_name = '$category' ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-8 mb-5">
                    <div class="flavor-card">
                        
                        <div class="cover-container">
                            <?php if (!empty($row['image_path_cover'])): ?>
                                <img src="uploads/products/<?php echo $row['image_path_cover']; ?>" class="cover-img" alt="Product Cover">
                            <?php else: ?>
                                <div class="text-muted opacity-50"><i class="bi bi-image h1"></i><br>Main Image Pending</div>
                            <?php endif; ?>
                        </div>

                        <div class="row g-0 border-bottom">
                            <div class="col-6 sub-img-container border-end">
                                <img src="uploads/products/<?php echo $row['image_path']; ?>" class="sub-img" alt="Solo Shot">
                            </div>
                            <div class="col-6 sub-img-container">
                                <img src="uploads/products/<?php echo $row['image_path_2']; ?>" class="sub-img" alt="Group Detail">
                            </div>
                        </div>

                        <div class="p-5 text-center">
                            <small class="text-muted text-uppercase fw-bold d-block mb-2" style="letter-spacing: 1px;"><?php echo htmlspecialchars($row['brand_name']); ?></small>
                            <h2 class="fw-bold text-primary mb-3"><?php echo htmlspecialchars($row['flavor_name']); ?></h2>
                            
                            <p class="desc-text"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                            
                            <div class="mt-4">
                                <span class="badge-size"><?php echo htmlspecialchars($row['size_label']); ?></span>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
            }
        } else {
            echo '<div class="col-12 text-center py-5"><h3 class="text-muted">No products found for this category.</h3></div>';
        }
        ?>
    </div>
</div>

<footer class="py-4 text-center border-top bg-white">
    <p class="mb-0 text-muted small">&copy; <?php echo date('Y'); ?> Rakula Agency Ltd. | Quality You Can Taste</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>