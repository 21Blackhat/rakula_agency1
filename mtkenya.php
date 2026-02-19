<?php 
include 'db_config.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get category from URL, default to 'Mt Kenya Water'
$category = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : 'Mt Kenya Water';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mt Kenya | <?php echo htmlspecialchars($category); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --mt-blue: #0077be; 
            --mt-light-blue: #e0f2f1;
            --snow-white: #ffffff;
            --ice-gray: #f0f4f8;
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--ice-gray); 
            color: #334455;
        }
        
        .category-header { 
            background: linear-gradient(rgba(0, 119, 190, 0.8), rgba(0, 119, 190, 0.9)), url('https://images.unsplash.com/photo-1589182373726-e4f658ab50f0?q=80&w=2000&auto=format&fit=crop'); 
            background-size: cover;
            background-position: center;
            color: white; 
            padding: 90px 0; 
            border-bottom: 5px solid var(--mt-light-blue);
            text-shadow: 0 2px 4px rgba(0,0,0,0.2);
        }
        
        .nav-scroller {
            overflow-x: auto;
            white-space: nowrap;
            padding: 20px 0;
            scrollbar-width: none;
        }
        .nav-scroller::-webkit-scrollbar { display: none; }
        
        .btn-cat {
            border-radius: 15px;
            padding: 12px 28px;
            font-weight: 600;
            transition: 0.3s all ease;
            border: 2px solid var(--mt-blue);
            color: var(--mt-blue);
            background: white;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cat:hover, .btn-cat.active {
            background: var(--mt-blue);
            color: white;
            box-shadow: 0 8px 20px rgba(0, 119, 190, 0.2);
            transform: translateY(-2px);
        }

        /* PREMIUM 3-IMAGE CARD (Kevian Style) */
        .flavor-card { 
            border: none; 
            transition: 0.4s ease; 
            background: var(--snow-white); 
            border-radius: 30px; 
            overflow: hidden; 
            margin-bottom: 50px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.05); 
        }
        
        .flavor-card:hover { transform: translateY(-10px); box-shadow: 0 25px 50px rgba(0,0,0,0.1); }

        /* Main Top Image */
        .cover-container { 
            background: #ffffff; 
            height: 450px; 
            width: 100%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 20px; 
            border-bottom: 1px solid #f0f0f0; 
        }
        .cover-img { max-width: 100%; max-height: 100%; object-fit: contain; }
        
        /* Two Bottom Side-by-Side Images */
        .sub-img-container { 
            background: #ffffff; 
            height: 280px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 20px; 
        }
        .sub-img { max-width: 100%; max-height: 100%; object-fit: contain; }
        
        .card-details { padding: 40px; text-align: center; }
        .brand-label { color: var(--mt-blue); font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 2px; display: block; margin-bottom: 10px; }
        .flavor-title { color: #1a2a3a; font-weight: 700; font-size: 2.2rem; }
        .badge-size { 
            background: var(--mt-blue); color: #fff; font-weight: 700; 
            padding: 10px 30px; border-radius: 50px; display: inline-block; margin-top: 20px;
        }
        .desc-text { color: #5a6c7d; font-size: 1.05rem; line-height: 1.8; max-width: 85%; margin: 20px auto 0; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: var(--mt-blue);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">RAKULA AGENCY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="mtkenya.php">Mt Kenya</a></li>
                <li class="nav-item"><a class="nav-link" href="lato.php">Lato Milk</a></li>
                <li class="nav-item"><a class="nav-link" href="kevian.php">Kevian Brands</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="category-header text-center">
    <div class="container">
        <h1 class="fw-bold display-3 mb-2"><?php echo htmlspecialchars($category); ?></h1>
        <p class="lead opacity-90 fw-light">Pure Mountain Refreshment Delivered to Your Doorstep</p>
    </div>
</header>

<div class="container my-5">
    <div class="nav-scroller mb-5 text-center">
        <?php 
        $mt_cats = ['Mt Kenya Water', 'Mt Kenya 500ml', 'Dairy Joy', 'Mt Kenya Fino'];
        foreach($mt_cats as $cat_item):
            $active = (strcasecmp($category, $cat_item) == 0) ? 'active' : '';
            echo "<a href='?cat=" . urlencode($cat_item) . "' class='btn btn-cat $active'>$cat_item</a>";
        endforeach;
        ?>
    </div>

    <div class="row justify-content-center">
        <?php
        // LOGIC: Search for brand 'Mt Kenya' and match the sub-category in the flavor_name
        $query = "SELECT * FROM product_variations 
                  WHERE brand_name = 'Mt Kenya' 
                  AND (flavor_name LIKE '%$category%' OR description LIKE '%$category%') 
                  ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-10 mb-5">
                    <div class="flavor-card">
                        
                        <div class="cover-container">
                            <?php if (!empty($row['image_path_cover'])): ?>
                                <img src="uploads/products/<?php echo $row['image_path_cover']; ?>" class="cover-img" alt="Cover View">
                            <?php else: ?>
                                <div class="text-muted"><i class="bi bi-image h1"></i><br>Cover Image Pending</div>
                            <?php endif; ?>
                        </div>

                        <div class="row g-0 border-bottom">
                            <div class="col-6 sub-img-container border-end">
                                <img src="uploads/products/<?php echo $row['image_path']; ?>" class="sub-img" alt="Front View">
                            </div>
                            <div class="col-6 sub-img-container">
                                <img src="uploads/products/<?php echo $row['image_path_2']; ?>" class="sub-img" alt="Detail View">
                            </div>
                        </div>

                        <div class="card-details">
                            <small class="brand-label">MT KENYA RANGE</small>
                            <h2 class="flavor-title"><?php echo htmlspecialchars($row['flavor_name']); ?></h2>
                            
                            <p class="desc-text">
                                <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                            </p>
                            
                            <div class="mt-4">
                                <span class="badge-size"><?php echo htmlspecialchars($row['size_label']); ?></span>
                            </div>
                        </div>

                    </div>
                </div>
                <?php
            }
        } else {
            ?>
            <div class="col-12 text-center py-5">
                <div class="bg-white p-5 rounded-5 shadow-sm d-inline-block">
                    <i class="bi bi-droplet display-1 text-info opacity-25"></i>
                    <h3 class="mt-4 text-muted">Variations for <?php echo htmlspecialchars($category); ?> are being updated.</h3>
                    <p class="text-muted">coming soon.</p>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<footer class="py-5 text-center bg-white border-top">
    <div class="container">
        <p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> Rakula Agency Ltd. Authorized Mt Kenya Distributor.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>