<?php 
include 'db_config.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get category from URL, default to 'Afia' based on your handwritten list
$category = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : 'Afya';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kevian Kenya | <?php echo htmlspecialchars($category); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --kevian-green: #2e7d32; /* Natural juice green */
            --kevian-orange: #ff9800; /* Citrus orange */
            --soft-bg: #f9fbf9;
            --white: #ffffff;
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--soft-bg); 
            color: #333;
        }
        
        /* Modernized Header */
        .category-header { 
            background: linear-gradient(135deg, var(--kevian-green) 0%, #1b5e20 100%); 
            color: white; 
            padding: 80px 0; 
            border-bottom: 5px solid var(--kevian-orange);
            position: relative;
            overflow: hidden;
        }
        
        .category-header::after {
            content: "";
            position: absolute;
            bottom: -50px;
            right: -50px;
            width: 200px;
            height: 200px;
            background: rgba(255,255,255,0.05);
            border-radius: 50%;
        }

        /* Upgraded Category Pills */
        .nav-scroller {
            overflow-x: auto;
            white-space: nowrap;
            padding: 10px 0;
        }
        
        .btn-cat {
            border-radius: 50px;
            padding: 10px 25px;
            font-weight: 600;
            transition: 0.3s;
            border: 2px solid var(--kevian-green);
            color: var(--kevian-green);
            background: transparent;
            margin: 5px;
        }

        .btn-cat:hover, .btn-cat.active {
            background: var(--kevian-green);
            color: white;
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
        }

        /* 2-Image Flavor Card Upgrade */
        .flavor-card { 
            border: none; 
            transition: 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275); 
            background: var(--white); 
            border-radius: 25px; 
            overflow: hidden; 
            margin-bottom: 40px; 
            box-shadow: 0 10px 20px rgba(0,0,0,0.03); 
        }
        
        .flavor-card:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(0,0,0,0.1); 
        }
        
        .img-container { 
            background: #fff; 
            padding: 30px; 
            text-align: center; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 320px;
            position: relative;
        }

        .product-img { 
            max-height: 100%; 
            width: auto; 
            object-fit: contain; 
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
        }
        
        .card-details { padding: 30px; }
        .brand-label { color: var(--kevian-orange); font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }
        .flavor-title { color: var(--kevian-green); font-weight: 700; }
        .badge-size { 
            background: #e8f5e9; 
            color: var(--kevian-green); 
            font-weight: 700; 
            padding: 8px 20px; 
            border-radius: 12px;
            border: 1px solid rgba(46, 125, 50, 0.1);
        }

        .desc-text { color: #666; font-size: 0.95rem; line-height: 1.7; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: var(--kevian-green); border-bottom: 2px solid rgba(255,255,255,0.1);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">RAKULA AGENCY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="kevian.php">Kevian Brands</a></li>
                <li class="nav-item"><a class="nav-link" href="highland_drinks.php">Highland Brands</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="category-header text-center">
    <div class="container">
        <span class="badge bg-light text-success px-3 py-2 mb-3 rounded-pill fw-bold">DISTRIBUTION PARTNER</span>
        <h1 class="fw-bold display-3"><?php echo htmlspecialchars($category); ?></h1>
        <p class="lead opacity-75">Nature's Freshness by Kevian Kenya & Rakula Agency</p>
    </div>
</header>

<div class="container my-5">
    <div class="nav-scroller mb-5 text-center">
        <?php 
        $kev_cats = ['Afya', 'Pick n Peel', 'Tetra', 'Energy Strawberry', 'Energy Classic', 'Energy Exotic', 'Energy Apple', 'Fantasy', 'Apple Ginger', 'Cola'];
        foreach($kev_cats as $cat_item):
            $active = ($category == $cat_item) ? 'active' : '';
            echo "<a href='?cat=$cat_item' class='btn btn-cat $active'>$cat_item</a>";
        endforeach;
        ?>
    </div>

    <div class="row">
        <?php
        // Fetching variations based on the selected Kevian category
        $query = "SELECT * FROM product_variations WHERE brand_name = '$category' ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-6">
                    <div class="flavor-card">
                        <div class="row g-0">
                            <div class="col-6 img-container border-end">
                                <img src="uploads/products/<?php echo $row['image_path']; ?>" class="product-img" alt="Product Front">
                            </div>
                            <div class="col-6 img-container">
                                <img src="uploads/products/<?php echo $row['image_path_2']; ?>" class="product-img" alt="Product Details">
                            </div>
                        </div>
                        <div class="card-details">
                            <div class="d-flex justify-content-between align-items-start mb-3">
                                <div>
                                    <small class="brand-label"><?php echo htmlspecialchars($row['brand_name']); ?></small>
                                    <h3 class="flavor-title mb-0"><?php echo htmlspecialchars($row['flavor_name']); ?></h3>
                                </div>
                                <span class="badge-size"><?php echo htmlspecialchars($row['size_label']); ?></span>
                            </div>
                            <p class="desc-text mb-0">
                                <i class="bi bi-quote text-success opacity-50"></i>
                                <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                            </p>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-4 shadow-sm d-inline-block">
                    <i class="bi bi-droplet-half display-1 text-success opacity-25"></i>
                    <h3 class="mt-3 text-muted">Refreshing content coming soon for <?php echo htmlspecialchars($category); ?>.</h3>
                    <a href="kevian.php" class="btn btn-success rounded-pill mt-3">View All Brands</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<footer class="py-5 text-center bg-white border-top">
    <div class="container">
        <img src="uploads/logo.png" alt="Rakula" style="height: 40px; margin-bottom: 20px; opacity: 0.6;">
        <p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> Rakula Agency Ltd. Authorized Kevian Distributor.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>