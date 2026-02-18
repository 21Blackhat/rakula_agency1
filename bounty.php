<?php 
include 'db_config.php'; 

// 1. FETCH HEADER CONTENT FROM DATABASE
$bounty_res = mysqli_query($conn, "SELECT content_value FROM site_content WHERE content_key = 'bounty_text'");
if ($bounty_res && mysqli_num_rows($bounty_res) > 0) {
    $bounty_row = mysqli_fetch_assoc($bounty_res);
    $bounty_text = $bounty_row['content_value'];
} else {
    $bounty_text = "Experience the revitalizing taste of Bounty Limited products, including the world-class Safari range.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bounty Limited | Rakula Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    
    <style>
        :root { 
            --primary-blue: #003399; 
            --rakula-gold: #ffcc00; 
            --bounty-green: #2e7d32; 
        }
        
        body { background-color: #fcfcfc; font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; }
        
        /* Hero Section Styling */
        .bounty-hero { 
            background: linear-gradient(rgba(0,0,0,0.65), rgba(0,0,0,0.65)), url('uploads/about_bounty_default.jpg');
            background-size: cover; 
            background-position: center; 
            color: white; 
            padding: 120px 0;
            margin-bottom: 40px;
        }

        /* Filter Buttons Styling */
        .filter-nav .btn {
            border: 1px solid var(--bounty-green);
            color: var(--bounty-green);
            transition: all 0.3s ease;
            font-weight: 500;
        }
        
        .filter-nav .btn:hover, .filter-nav .btn.active {
            background-color: var(--bounty-green);
            color: white;
            box-shadow: 0 4px 10px rgba(46, 125, 50, 0.2);
        }

        /* Product Card Styling */
        .product-card { 
            border: none; 
            transition: 0.3s; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
            border-radius: 15px;
            overflow: hidden;
        }
        
        .product-card:hover { transform: translateY(-8px); box-shadow: 0 12px 20px rgba(0,0,0,0.1); }
        
        .category-badge { 
            background-color: var(--bounty-green); 
            color: white; 
            padding: 4px 12px; 
            border-radius: 50px; 
            font-size: 0.75rem; 
            text-transform: uppercase;
        }

        /* Built-in Footer Styling */
        .custom-footer { background-color: #111; color: #aaa; padding: 60px 0 30px; margin-top: 80px; }
        .footer-brand { color: var(--rakula-gold); font-weight: 700; letter-spacing: 1px; }
    </style>
</head>
<body>

<?php if(file_exists('theme_handler.php')) { include 'theme_handler.php'; } ?>

<section class="bounty-hero text-center">
    <div class="container">
        <h1 class="display-3 fw-bold mb-3">BOUNTY LIMITED</h1>
        <p class="lead mx-auto" style="max-width: 800px;"><?php echo htmlspecialchars($bounty_text); ?></p>
    </div>
</section>

<div class="container">
    <div class="filter-nav d-flex flex-wrap justify-content-center gap-2 mb-5">
        <?php 
            $current_type = isset($_GET['type']) ? $_GET['type'] : 'all'; 
            $types = [
                'all' => 'All Products',
                'Safari Lemonade' => 'Safari Lemonade',
                'Safari Energy' => 'Energy Booster',
                'Safari King Water' => 'King Water',
                'Safari Orange' => 'Safari Orange'
            ];

            foreach($types as $key => $label) {
                $active = ($current_type == $key) ? 'active' : '';
                echo "<a href='?type=$key' class='btn rounded-pill px-4 $active'>$label</a>";
            }
        ?>
    </div>

    <div class="row g-4 mb-5">
        <?php
        $filter = mysqli_real_escape_string($conn, $current_type);
        $query = "SELECT * FROM product_variations WHERE brand_name = 'Bounty Limited'";
        
        if ($filter !== 'all') {
            $query .= " AND flavor_name LIKE '%$filter%'";
        }
        
        $query .= " ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if ($result && mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
        ?>
            <div class="col-6 col-md-4 col-lg-3">
                <div class="card h-100 product-card">
                    <div class="p-4 bg-white text-center">
                        <img src="uploads/products/<?php echo $row['image_path']; ?>" 
                             class="img-fluid" 
                             alt="Product" 
                             style="height: 200px; object-fit: contain;">
                    </div>
                    <div class="card-body text-center pt-0">
                        <span class="category-badge mb-2 d-inline-block">Bounty</span>
                        <h6 class="fw-bold mb-1"><?php echo htmlspecialchars($row['flavor_name']); ?></h6>
                        <p class="text-muted small mb-0"><?php echo htmlspecialchars($row['size_label']); ?></p>
                    </div>
                </div>
            </div>
        <?php 
            }
        } else {
            // "Coming Soon" placeholder if no products match
            echo '<div class="col-12 text-center py-5">
                    <div class="bg-white rounded-4 p-5 shadow-sm border">
                        <img src="assets/img/empty-drop.png" style="width: 60px; opacity: 0.2; filter: grayscale(1);">
                        <h4 class="text-muted mt-3">Refreshing content coming soon for '. ($filter == 'all' ? 'Bounty' : $filter) .'.</h4>
                        <a href="index.php" class="btn btn-sm btn-outline-secondary mt-3 rounded-pill">View All Brands</a>
                    </div>
                  </div>';
        }
        ?>
    </div>
</div>

<footer class="custom-footer">
    <div class="container">
        <div class="row">
            <div class="col-md-6 mb-4">
                <h5 class="footer-brand mb-3">RAKULA AGENCY</h5>
                <p class="small text-white-50">Leading distributors of premium beverages including Kevian and Bounty Limited products. Refreshing the coastal region one bottle at a time.</p>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="text-white mb-3">Quick Links</h6>
                <ul class="list-unstyled small">
                    <li class="mb-2"><a href="kevian.php" class="text-white-50 text-decoration-none">Kevian Products</a></li>
                    <li class="mb-2"><a href="bounty.php" class="text-white-50 text-decoration-none">Bounty Range</a></li>
                    <li class="mb-2"><a href="management_hub.php" class="text-white-50 text-decoration-none">Staff Portal</a></li>
                </ul>
            </div>
            <div class="col-md-3 mb-4">
                <h6 class="text-white mb-3">Contact Information</h6>
                <p class="small text-white-50 mb-1"><i class="bi bi-geo-alt-fill me-2"></i> Mombasa, Kenya</p>
                <p class="small text-white-50"><i class="bi bi-envelope-fill me-2"></i> info@rakulaagency.com</p>
            </div>
        </div>
        <hr class="border-secondary opacity-25 mt-4">
        <div class="text-center small text-white-50">
            &copy; <?php echo date('Y'); ?> Rakula Agency. All rights reserved.
        </div>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>