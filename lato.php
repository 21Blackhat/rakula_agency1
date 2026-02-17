<?php 
include 'db_config.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get category from URL, default to 'Fino'
$category = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : 'Fino';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lato Milk | <?php echo htmlspecialchars($category); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root { 
            --lato-blue: #0056b3; 
            --lato-light-blue: #eef6ff;
            --cream: #fdfdfd;
            --accent-gold: #fbc02d;
        }
        
        body { 
            font-family: 'Poppins', sans-serif; 
            background-color: #f4f7fa; 
            color: #2c3e50;
        }
        
        .category-header { 
            background: linear-gradient(135deg, var(--lato-blue) 0%, #003366 100%); 
            color: white; 
            padding: 80px 0; 
            border-bottom: 5px solid var(--accent-gold);
            position: relative;
        }
        
        .nav-scroller {
            overflow-x: auto;
            white-space: nowrap;
            padding: 15px 0;
            scrollbar-width: none;
        }
        .nav-scroller::-webkit-scrollbar { display: none; }
        
        .btn-cat {
            border-radius: 50px;
            padding: 12px 30px;
            font-weight: 600;
            transition: 0.3s;
            border: 2px solid var(--lato-blue);
            color: var(--lato-blue);
            background: white;
            margin: 5px;
            display: inline-block;
            text-decoration: none;
        }

        .btn-cat:hover, .btn-cat.active {
            background: var(--lato-blue);
            color: white;
            box-shadow: 0 5px 15px rgba(0, 86, 179, 0.3);
        }

        .flavor-card { 
            border: none; 
            transition: 0.4s ease; 
            background: white; 
            border-radius: 25px; 
            overflow: hidden; 
            margin-bottom: 40px; 
            box-shadow: 0 10px 30px rgba(0,0,0,0.05); 
        }
        
        .flavor-card:hover { 
            transform: translateY(-8px); 
            box-shadow: 0 20px 45px rgba(0,0,0,0.12); 
        }
        
        .img-container { 
            background: white; 
            padding: 30px; 
            display: flex; 
            align-items: center; 
            justify-content: center; 
            height: 320px;
        }

        .product-img { 
            max-height: 100%; 
            width: auto; 
            object-fit: contain; 
        }
        
        .card-details { padding: 30px; background: var(--cream); }
        .brand-label { color: var(--accent-gold); font-weight: 700; text-transform: uppercase; font-size: 0.8rem; letter-spacing: 1px; }
        .flavor-title { color: var(--lato-blue); font-weight: 700; }
        .badge-size { 
            background: var(--lato-light-blue); 
            color: var(--lato-blue); 
            font-weight: 700; 
            padding: 8px 20px; 
            border-radius: 12px;
        }

        .desc-text { color: #5a6c7d; font-size: 0.95rem; line-height: 1.7; }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: var(--lato-blue);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">RAKULA AGENCY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active" href="lato.php">Lato Milk</a></li>
                <li class="nav-item"><a class="nav-link" href="kevian.php">Kevian Brands</a></li>
                <li class="nav-item"><a class="nav-link" href="highland_drinks.php">Highland Brands</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="category-header text-center">
    <div class="container">
        <span class="badge bg-white text-primary px-3 py-2 mb-3 rounded-pill fw-bold">DAIRY EXCELLENCE</span>
        <h1 class="fw-bold display-3"><?php echo htmlspecialchars($category); ?></h1>
        <p class="lead opacity-75">Pure Quality Milk Distributed by Rakula Agency</p>
    </div>
</header>

<div class="container my-5">
    <div class="nav-scroller mb-5 text-center">
        <?php 
        $lato_cats = ['Fino', 'Vito', 'TBA', 'Flavoured'];
        foreach($lato_cats as $cat_item):
            $active = ($category == $cat_item) ? 'active' : '';
            echo "<a href='?cat=$cat_item' class='btn btn-cat $active'>$cat_item</a>";
        endforeach;
        ?>
    </div>

    <div class="row">
        <?php
        /** * UPDATED LOGIC:
         * We search for products where brand is 'Lato' 
         * AND the flavor or description contains the category (e.g., 'Fino')
         */
        $query = "SELECT * FROM product_variations 
                  WHERE brand_name = 'Lato' 
                  AND (flavor_name LIKE '%$category%' OR description LIKE '%$category%')
                  ORDER BY id DESC";
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-6">
                    <div class="flavor-card">
                        <div class="row g-0">
                            <div class="col-6 img-container border-end">
                                <img src="uploads/products/<?php echo $row['image_path']; ?>" class="product-img" alt="Primary Image">
                            </div>
                            <div class="col-6 img-container">
                                <img src="uploads/products/<?php echo $row['image_path_2']; ?>" class="product-img" alt="Secondary Image">
                            </div>
                        </div>
                        <div class="card-details text-center">
                            <div class="mb-2">
                                <small class="brand-label">LATO MILK</small>
                                <h3 class="flavor-title"><?php echo htmlspecialchars($row['flavor_name']); ?></h3>
                            </div>
                            <div class="mb-3">
                                <span class="badge-size"><?php echo htmlspecialchars($row['size_label']); ?></span>
                            </div>
                            <p class="desc-text mb-0">
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
                    <i class="bi bi-info-circle display-1 text-primary opacity-25"></i>
                    <h3 class="mt-3 text-muted">No "<?php echo htmlspecialchars($category); ?>" products uploaded yet.</h3>
                    <p>Make sure to include the word "<?php echo htmlspecialchars($category); ?>" in the Flavor Name when adding via Admin.</p>
                    <a href="lato.php" class="btn btn-primary rounded-pill mt-3">Refresh List</a>
                </div>
            </div>
            <?php
        }
        ?>
    </div>
</div>

<footer class="py-5 text-center bg-white border-top">
    <div class="container">
        <p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> Rakula Agency Ltd. Your Trusted Lato Milk Distributor.</p>
    </div>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>