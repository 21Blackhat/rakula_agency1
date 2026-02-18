<?php 
include 'db_config.php'; 

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get sub-category from URL, default to 'Afia'
// We use lowercase 'afia' to match your database screenshot precisely
$category = isset($_GET['cat']) ? mysqli_real_escape_string($conn, $_GET['cat']) : 'Afia';
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
            --kevian-green: #2e7d32; 
            --kevian-orange: #ff9800; 
            --soft-bg: #f4f6f9;
            --white: #ffffff;
        }
        
        body { font-family: 'Poppins', sans-serif; background-color: var(--soft-bg); color: #333; }
        
        .category-header { 
            background: linear-gradient(135deg, var(--kevian-green) 0%, #1b5e20 100%); 
            color: white; padding: 60px 0; border-bottom: 5px solid var(--kevian-orange);
            text-transform: uppercase; letter-spacing: 2px;
        }

        .btn-cat {
            border-radius: 50px; padding: 10px 25px; font-weight: 600; transition: 0.3s;
            border: 2px solid var(--kevian-green); color: var(--kevian-green);
            background: transparent; margin: 5px; text-decoration: none; display: inline-block;
        }
        .btn-cat:hover, .btn-cat.active {
            background: var(--kevian-green); color: white;
            box-shadow: 0 4px 12px rgba(46, 125, 50, 0.2);
        }

        .flavor-card { 
            border: none; transition: 0.3s; background: #fff; 
            border-radius: 20px; overflow: hidden; margin-bottom: 50px; 
            box-shadow: 0 4px 15px rgba(0,0,0,0.05); 
        }
        
        .cover-container { background: #ffffff; height: 450px; width: 100%; display: flex; align-items: center; justify-content: center; padding: 20px; border-bottom: 1px solid #f0f0f0; }
        .cover-img { max-width: 100%; max-height: 100%; object-fit: contain; }
        
        .sub-img-container { background: #ffffff; height: 250px; display: flex; align-items: center; justify-content: center; padding: 15px; }
        .sub-img { max-width: 100%; max-height: 100%; object-fit: contain; }
        
        .card-details { padding: 40px; text-align: center; }
        .brand-label { color: #666; font-weight: 700; text-transform: uppercase; font-size: 0.85rem; letter-spacing: 1px; display: block; margin-bottom: 10px; }
        .flavor-title { color: var(--kevian-green); font-weight: 700; font-size: 2.2rem; }
        .badge-size { 
            background: var(--kevian-orange); color: #fff; font-weight: 700; 
            padding: 8px 30px; border-radius: 50px; display: inline-block; margin-top: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top" style="background: var(--kevian-green);">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">RAKULA AGENCY</a>
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
        <h1 class="fw-bold display-4"><?php echo htmlspecialchars($category); ?></h1>
    </div>
</header>

<div class="container my-5">
    <div class="text-center mb-5">
        <?php 
        $kev_cats = ['Afya', 'Pick n Peel', 'Tetra', 'Energy Strawberry', 'Energy Classic', 'Energy Exotic', 'Energy Apple', 'Fantasy', 'Apple Ginger', 'Cola'];
        foreach($kev_cats as $cat_item):
            $active = (strcasecmp($category, $cat_item) == 0) ? 'active' : '';
            echo "<a href='?cat=$cat_item' class='btn btn-cat $active'>$cat_item</a>";
        endforeach;
        ?>
    </div>

    <div class="row justify-content-center">
        <?php
        // UPDATED QUERY: Brand is 'Kevian', sub-category is 'flavor_name'
        $query = "SELECT * FROM product_variations 
                  WHERE brand_name = 'Kevian' 
                  AND flavor_name LIKE '$category' 
                  ORDER BY id DESC";
        
        $result = mysqli_query($conn, $query);

        if(mysqli_num_rows($result) > 0) {
            while($row = mysqli_fetch_assoc($result)) {
                ?>
                <div class="col-lg-9 mb-5">
                    <div class="flavor-card">
                        
                        <div class="cover-container">
                            <?php if (!empty($row['image_path_cover'])): ?>
                                <img src="uploads/products/<?php echo $row['image_path_cover']; ?>" class="cover-img">
                            <?php else: ?>
                                <div class="text-muted"><i class="bi bi-image h1"></i><br>Cover Image Missing</div>
                            <?php endif; ?>
                        </div>

                        <div class="row g-0 border-bottom">
                            <div class="col-6 sub-img-container border-end">
                                <img src="uploads/products/<?php echo $row['image_path']; ?>" class="sub-img">
                            </div>
                            <div class="col-6 sub-img-container">
                                <img src="uploads/products/<?php echo $row['image_path_2']; ?>" class="sub-img">
                            </div>
                        </div>

                        <div class="card-details">
                            <small class="brand-label">KEVIAN KENYA</small>
                            <h2 class="flavor-title mb-3"><?php echo htmlspecialchars($row['flavor_name']); ?></h2>
                            <p class="desc-text text-muted"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                            <span class="badge-size"><?php echo htmlspecialchars($row['size_label']); ?></span>
                        </div>
                    </div>
                </div>
                <?php
            }
        } else {
            echo "<div class='text-center'><h3>No products found for " . htmlspecialchars($category) . "</h3></div>";
        }
        ?>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>