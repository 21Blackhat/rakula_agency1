<?php 
include 'db_config.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get category from URL, default to 'Coca Cola' from handwritten notes
$category = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : 'Coca Cola';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Coastal Bottlers | <?php echo htmlspecialchars($category); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --coastal-red: #e41e26; /* Iconic beverage red */
            --coastal-dark: #1a1a1a;
            --coastal-silver: #f4f4f4;
            --predator-green: #00ff00; /* Accent for energy range */
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #fcfcfc; 
            color: #222;
        }
        
        /* Premium Brand Header */
        .category-header { 
            background: linear-gradient(135deg, var(--coastal-red) 0%, #b31419 100%); 
            color: white; 
            padding: 85px 0; 
            border-bottom: 6px solid var(--coastal-dark);
            position: relative;
        }

        /* Category Navigation Pills */
        .nav-scroller {
            overflow-x: auto;
            white-space: nowrap;
            padding: 15px 0;
            scrollbar-width: none;
        }
        .nav-scroller::-webkit-scrollbar { display: none; }
        
        .btn-cat {
            border-radius: 50px;
            padding: 12px 35px;
            font-weight: 700;
            transition: 0.3s all ease;
            border: 2px solid var(--coastal-red);
            color: var(--coastal-red);
            background: white;
            margin: 5px;
            text-decoration: none;
            display: inline-block;
        }

        .btn-cat:hover, .btn-cat.active {
            background: var(--coastal-red);
            color: white;
            box-shadow: 0 10px 25px rgba(228, 30, 38, 0.25);
            transform: translateY(-2px);
        }

        /* PREMIUM 3-IMAGE CARD UPGRADE (Kevian Style) */
        .flavor-card { 
            border: none; 
            transition: 0.4s cubic-bezier(0.165, 0.84, 0.44, 1); 
            background: white; 
            border-radius: 30px; 
            overflow: hidden; 
            margin-bottom: 50px; 
            box-shadow: 0 10px 40px rgba(0,0,0,0.04); 
        }
        
        .flavor-card:hover { 
            transform: translateY(-12px); 
            box-shadow: 0 25px 60px rgba(0,0,0,0.12); 
        }

        /* Top Large Cover Image */
        .cover-container { 
            background: #fff; 
            height: 420px; 
            width: 100%; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            padding: 30px;
            border-bottom: 1px solid #f0f0f0;
        }
        .cover-img { max-width: 100%; max-height: 100%; object-fit: contain; }
        
        /* Bottom Two Detail Images */
        .sub-img-container { 
            background: #fff; 
            padding: 30px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 300px;
        }

        .product-img { 
            max-height: 100%; 
            width: auto; 
            object-fit: contain;
            filter: drop-shadow(0 15px 20px rgba(0,0,0,0.1));
        }
        
        .card-details { 
            padding: 40px; 
            background: #fff;
            text-align: center;
        }

        .brand-label { 
            color: var(--coastal-red); 
            font-weight: 800; 
            text-transform: uppercase; 
            font-size: 0.8rem; 
            letter-spacing: 2.5px;
            display: block;
            margin-bottom: 10px;
        }

        .flavor-title { 
            color: var(--coastal-dark); 
            font-weight: 700; 
            font-size: 2.2rem;
        }

        .badge-size { 
            background: var(--coastal-dark); 
            color: white; 
            font-weight: 700; 
            padding: 12px 30px; 
            border-radius: 50px;
            font-size: 0.95rem;
            display: inline-block;
            margin-top: 20px;
        }

        .desc-text { color: #555; font-size: 1.05rem; line-height: 1.8; max-width: 800px; margin: 20px auto 0; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: var(--coastal-dark);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">RAKULA AGENCY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="coastal.php">Coastal Bottlers</a></li>
                <li class="nav-item"><a class="nav-link" href="azam.php">Azam Energy</a></li>
                <li class="nav-item"><a class="nav-link" href="mtkenya.php">Mt Kenya</a></li>
                <li class="nav-item"><a class="nav-link" href="kevian.php">Kevian Brands</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="category-header text-center">
    <div class="container">
        <span class="badge bg-white text-danger px-3 py-2 mb-3 rounded-pill fw-bold shadow-sm">REFRESHING MOMENTS</span>
        <h1 class="fw-bold display-3 mb-2"><?php echo htmlspecialchars($category); ?></h1>
        <p class="lead opacity-90 fw-light">Distributing Happiness via Coastal Bottlers & Rakula Agency</p>
    </div>
</header>

<div class="container my-5">
    <div class="nav-scroller mb-5 text-center">
        <?php 
        $coastal_cats = ['Coca Cola', 'Predator']; 
        foreach($coastal_cats as $cat_item):
            $active = (strcasecmp($category, $cat_item) == 0) ? 'active' : '';
            echo "<a href='?cat=" . urlencode($cat_item) . "' class='btn btn-cat $active'>$cat_item</a>";
        endforeach;
        ?>
    </div>

    <div class="row justify-content-center">
        <?php
        // Updated Query: Search brand name but also flavor/description for maximum results
        $query = "SELECT * FROM product_variations 
                  WHERE brand_name = '$category' 
                  OR flavor_name LIKE '%$category%' 
                  ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-10 mb-5">
                    <div class="flavor-card">
                        
                        <div class="cover-container">
                            <?php if (!empty($row['image_path_cover'])): ?>
                                <img src="uploads/products/<?php echo $row['image_path_cover']; ?>" class="cover-img" alt="Product Pack">
                            <?php else: ?>
                                <div class="text-muted text-center">
                                    <i class="bi bi-image display-4"></i><br>
                                    <small>Cover image pending for this variant</small>
                                </div>
                            <?php endif; ?>
                        </div>

                        <div class="row g-0 border-bottom">
                            <div class="col-6 sub-img-container border-end">
                                <img src="uploads/products/<?php echo $row['image_path']; ?>" class="product-img" alt="Primary View">
                            </div>
                            <div class="col-6 sub-img-container">
                                <img src="uploads/products/<?php echo $row['image_path_2']; ?>" class="product-img" alt="Alternate View">
                            </div>
                        </div>

                        <div class="card-details">
                            <small class="brand-label">COASTAL BOTTLERS RANGE</small>
                            <h2 class="flavor-title mb-0"><?php echo htmlspecialchars($row['flavor_name']); ?></h2>
                            
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
                    <i class="bi bi-cup-straw display-1 text-danger opacity-25"></i>
                    <h3 class="mt-4 text-muted">Refreshing variants for <?php echo htmlspecialchars($category); ?> are arriving soon.</h3>
                    <p class="text-muted">Please check your database for category matching.</p>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<footer class="py-5 bg-white border-top">
    <div class="container">
        <div class="row text-center mb-4">
            <div class="col-md-12">
                <h5 class="fw-bold mb-3">Rakula Ltd</h5>
                <p class="text-muted small mb-1">Established 31st July, 2022</p>
                <p class="text-muted small mb-3">Situated off Mombasa – Malindi road – Makutini stage</p>
                <div class="d-flex justify-content-center gap-4">
                    <span class="text-muted"><i class="bi bi-telephone-fill me-2"></i>0720864493</span>
                    <span class="text-muted"><i class="bi bi-envelope-fill me-2"></i>RakulaAgency@gmail.com</span>
                </div>
            </div>
        </div>
        <p class="mb-0 text-center text-muted small opacity-75">&copy; <?php echo date('Y'); ?> Rakula Agency Ltd. All Rights Reserved.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>