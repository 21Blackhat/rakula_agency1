<?php 
include 'db_config.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get category from URL, default to 'Azam' from your handwritten notes
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
            --azam-purple: #4b0082; /* Deep energy purple */
            --azam-gold: #ffcc00;   /* Vibrant energy gold */
            --azam-dark: #2d004d;
            --soft-bg: #f8f0ff;
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: var(--soft-bg); 
            color: #333;
        }
        
        /* High-Energy Header */
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

        /* Category Navigation */
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

        /* Dual-Image Card Layout */
        .flavor-card { 
            border: none; 
            transition: 0.4s ease; 
            background: white; 
            border-radius: 25px; 
            overflow: hidden; 
            margin-bottom: 40px; 
            box-shadow: 0 12px 30px rgba(0,0,0,0.06); 
        }
        
        .flavor-card:hover { 
            transform: translateY(-10px); 
            box-shadow: 0 20px 40px rgba(75, 0, 130, 0.15); 
        }
        
        .img-container { 
            background: #fff; 
            padding: 30px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 340px;
            position: relative;
        }

        .product-img { 
            max-height: 100%; 
            width: auto; 
            object-fit: contain;
            filter: drop-shadow(0 10px 15px rgba(0,0,0,0.12));
        }
        
        .card-details { 
            padding: 30px; 
            border-top: 1px solid #f0f0f0;
        }

        .brand-label { 
            color: var(--azam-purple); 
            font-weight: 800; 
            text-transform: uppercase; 
            font-size: 0.8rem; 
            letter-spacing: 2px;
        }

        .flavor-title { 
            color: #1a1a1a; 
            font-weight: 700; 
            font-size: 1.6rem;
        }

        .badge-size { 
            background: var(--azam-gold); 
            color: var(--azam-dark); 
            font-weight: 800; 
            padding: 6px 16px; 
            border-radius: 8px;
            box-shadow: 0 4px 10px rgba(255, 204, 0, 0.3);
        }

        .desc-text { color: #666; font-size: 0.95rem; line-height: 1.7; margin-top: 15px; }
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
        $azam_cats = ['Azam', 'Apple Punch']; // Derived from your notes
        foreach($azam_cats as $cat_item):
            $active = ($category == $cat_item) ? 'active' : '';
            echo "<a href='?cat=" . urlencode($cat_item) . "' class='btn btn-cat $active'>$cat_item</a>";
        endforeach;
        ?>
    </div>

    <div class="row">
        <?php
        $query = "SELECT * FROM product_variations WHERE brand_name = '$category' ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-6">
                    <div class="flavor-card">
                        <div class="row g-0">
                            <div class="col-6 img-container border-end">
                                <img src="uploads/products/<?php echo $row['image_path']; ?>" class="product-img" alt="Azam Energy Front">
                            </div>
                            <div class="col-6 img-container">
                                <img src="uploads/products/<?php echo $row['image_path_2']; ?>" class="product-img" alt="Azam Range">
                            </div>
                        </div>
                        <div class="card-details">
                            <div class="d-flex justify-content-between align-items-start">
                                <div>
                                    <small class="brand-label">PREMIUM ENERGY</small>
                                    <h3 class="flavor-title mb-0"><?php echo htmlspecialchars($row['flavor_name']); ?></h3>
                                </div>
                                <span class="badge-size"><?php echo htmlspecialchars($row['size_label']); ?></span>
                            </div>
                            <p class="desc-text">
                                <i class="bi bi-lightning-charge-fill text-warning me-2"></i>
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
                <div class="bg-white p-5 rounded-5 shadow-sm d-inline-block">
                    <i class="bi bi-lightning-fill display-1 text-warning opacity-25"></i>
                    <h3 class="mt-4 text-muted">Loading energy... Variants for <?php echo htmlspecialchars($category); ?> coming soon!</h3>
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
                <p class="text-muted mb-1"><i class="bi bi-telephone-fill me-2"></i>0720864493</p> <p class="text-muted"><i class="bi bi-envelope-fill me-2"></i>RakulaAgency@gmail.com</p> </div>
        </div>
        <p class="mb-0 text-muted small">&copy; <?php echo date('Y'); ?> Rakula Agency Ltd. Authorized Azam Energy Distributor.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>