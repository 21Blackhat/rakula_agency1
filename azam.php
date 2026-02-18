<?php 
include 'db_config.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get category from URL, default to 'Azam'
$category = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : 'Azam';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Azam Energy | <?php echo htmlspecialchars($category); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --azam-purple: #4b0082; 
            --azam-gold: #ffcc00;   
            --azam-dark: #2d004d;
            --soft-bg: #f8f0ff;
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--soft-bg); 
            color: #333;
        }
        
        .category-header { 
            background: linear-gradient(135deg, var(--azam-purple) 0%, var(--azam-dark) 100%); 
            color: white; 
            padding: 80px 0; 
            border-bottom: 5px solid var(--azam-gold);
            position: relative;
            overflow: hidden;
        }
        
        .category-header::before {
            content: "ENERGY";
            position: absolute;
            font-size: 10rem;
            font-weight: 900;
            color: rgba(255, 255, 255, 0.03);
            top: -20px;
            right: -20px;
        }

        .nav-scroller {
            overflow-x: auto;
            white-space: nowrap;
            padding: 15px 0;
            scrollbar-width: none;
        }
        .nav-scroller::-webkit-scrollbar { display: none; }
        
        .btn-cat {
            border-radius: 12px;
            padding: 12px 35px;
            font-weight: 700;
            transition: 0.3s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            border: 2px solid var(--azam-purple);
            color: var(--azam-purple);
            background: white;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
            text-transform: uppercase;
        }

        .btn-cat:hover, .btn-cat.active {
            background: var(--azam-purple);
            color: var(--azam-gold);
            box-shadow: 0 10px 20px rgba(75, 0, 130, 0.2);
            transform: translateY(-3px);
        }

        /* PREMIUM 3-IMAGE CARD (Kevian Style Structure) */
        .flavor-card { 
            border: none; 
            transition: 0.4s ease; 
            background: white; 
            border-radius: 30px; 
            overflow: hidden; 
            margin-bottom: 50px; 
            box-shadow: 0 15px 35px rgba(0,0,0,0.06); 
        }
        
        .flavor-card:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 25px 50px rgba(75, 0, 130, 0.15); 
        }

        /* Full Width Cover */
        .cover-container { 
            background: #ffffff; 
            height: 400px; 
            width: 100%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 20px; 
            border-bottom: 1px solid #f0f0f0; 
        }
        .cover-img { max-width: 100%; max-height: 100%; object-fit: contain; }
        
        /* Side by Side sub-images */
        .sub-img-container { 
            background: white; 
            padding: 25px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 300px;
        }

        .product-img { 
            max-height: 100%; 
            width: auto; 
            object-fit: contain;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.1));
        }
        
        .card-details { padding: 40px; text-align: center; }
        .brand-label { color: var(--azam-purple); font-weight: 800; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 2px; }
        .flavor-title { color: #1a1a1a; font-weight: 700; font-size: 2.2rem; margin-top: 10px; }
        .badge-size { 
            background: var(--azam-gold); color: var(--azam-dark); font-weight: 800; 
            padding: 10px 30px; border-radius: 50px; display: inline-block; margin-top: 20px;
            box-shadow: 0 4px 12px rgba(255, 204, 0, 0.3);
        }

        .desc-text { color: #666; font-size: 1.05rem; line-height: 1.8; max-width: 800px; margin: 20px auto 0; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: var(--azam-dark);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">RAKULA AGENCY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="azam.php">Azam Energy</a></li>
                <li class="nav-item"><a class="nav-link" href="mtkenya.php">Mt Kenya</a></li>
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
        <p class="lead opacity-90 fw-light">Ignite Your Day with Azam Energy & Rakula Agency</p>
    </div>
</header>

<div class="container my-5">
    <div class="nav-scroller mb-5 text-center">
        <?php 
        $azam_cats = ['Azam', 'Apple Punch'];
        foreach($azam_cats as $cat_item):
            $active = (strcasecmp($category, $cat_item) == 0) ? 'active' : '';
            echo "<a href='?cat=" . urlencode($cat_item) . "' class='btn btn-cat $active'>$cat_item</a>";
        endforeach;
        ?>
    </div>

    <div class="row justify-content-center">
        <?php
        // Updated Query: Looks for category matches in flavor or description
        // This ensures the "Apple Punch" category finds its products
        $query = "SELECT * FROM product_variations 
                  WHERE (flavor_name LIKE '%$category%' OR description LIKE '%$category%') 
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
                                <img src="uploads/products/<?php echo $row['image_path']; ?>" class="product-img" alt="Front View">
                            </div>
                            <div class="col-6 sub-img-container">
                                <img src="uploads/products/<?php echo $row['image_path_2']; ?>" class="product-img" alt="Detail View">
                            </div>
                        </div>

                        <div class="card-details">
                            <small class="brand-label">PREMIUM ENERGY</small>
                            <h2 class="flavor-title"><?php echo htmlspecialchars($row['flavor_name']); ?></h2>
                            
                            <p class="desc-text">
                                <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
                                <?php echo nl2br(htmlspecialchars($row['description'])); ?>
                            </p>
                            
                            <div class="mt-2">
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
                    <i class="bi bi-lightning-fill display-1 text-warning opacity-25"></i>
                    <h3 class="mt-4 text-muted">Variants for <?php echo htmlspecialchars($category); ?> are being updated.</h3>
                    <p class="text-muted">Please check your Admin Hub to ensure images are uploaded.</p>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<footer class="py-5 bg-white border-top">
    <div class="container text-center">
        <div class="row mb-4">
            <div class="col-md-6 offset-md-3">
                <h5 class="fw-bold mb-3">Rakula Agency Ltd</h5>
                <p class="text-muted mb-1"><i class="bi bi-telephone-fill me-2"></i>0720864493</p> 
                <p class="text-muted"><i class="bi bi-envelope-fill me-2"></i>RakulaAgency@gmail.com</p> 
            </div>
        </div>
        <p class="mb-0 text-muted small">&copy; <?php echo date('Y'); ?> Rakula Agency Ltd. Authorized Azam Energy Distributor.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>