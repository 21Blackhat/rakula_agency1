<?php 
include 'db_config.php'; 

// 1. SILENT SESSION START
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. UPDATE PAGE VIEWS 
if (isset($conn)) {
    mysqli_query($conn, "UPDATE site_stats SET page_views = page_views + 1 WHERE id = 1");
}

// 3. FETCH SITE CONTENT
$about_res = mysqli_query($conn, "SELECT content_value FROM site_content WHERE content_key = 'about_text'");
if ($about_res && mysqli_num_rows($about_res) > 0) {
    $about_row = mysqli_fetch_assoc($about_res);
    $about_text = $about_row['content_value'];
} else {
    $about_text = "Welcome to Rakula Agency, your premier provider of quality refreshments.";
}

$short_about = (strlen($about_text) > 250) ? substr($about_text, 0, 250) . "..." : $about_text;

// 4. COOKIE LOGIC
$show_cookie = !isset($_SESSION['cookie_consent_given']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rakula Agency | Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --primary-blue: #003399; --rakula-gold: #ffcc00; }
        body { font-family: 'Segoe UI', Roboto, sans-serif; overflow-x: hidden; background-color: #fcfcfc; }
        
        /* Navbar */
        .navbar { background-color: var(--primary-blue); padding: 15px 0; border-bottom: 3px solid var(--rakula-gold); }
        .nav-link { font-weight: 500; text-transform: uppercase; font-size: 0.85rem; margin: 0 5px; color: rgba(255,255,255,0.9) !important; }
        .nav-link:hover { color: var(--rakula-gold) !important; }
        
        /* Brand Slider */
        .brand-carousel img { height: 250px; width: 100%; object-fit: contain; background: #fff; padding: 20px; }
        .brand-section { background: #fff; padding: 60px 0; border-bottom: 1px solid #eee; }

        /* --- PEPSI STYLE PRODUCT CARDS --- */
        .pepsi-section { background-color: #000; color: white; padding: 80px 0; }
        .pepsi-card { background: transparent; border: none; text-align: center; }
        .pepsi-card img { 
            height: 300px; 
            object-fit: contain; 
            transition: transform 0.5s ease;
            filter: drop-shadow(0 10px 20px rgba(255,255,255,0.2));
        }
        .pepsi-card:hover img { transform: scale(1.1) rotate(5deg); }
        .pepsi-title { font-weight: 900; text-transform: uppercase; letter-spacing: 1px; margin-top: 20px; font-size: 1.2rem; }
        .btn-pepsi {
            background-color: #0000ff; color: white; border-radius: 50px; padding: 10px 30px;
            font-weight: 800; text-transform: uppercase; border: none; margin-top: 15px; transition: 0.3s;
        }
        .btn-pepsi:hover { background-color: #fff; color: #000; }

        /* --- COOKIE BANNER --- */
        #cookie-banner {
            position: fixed; bottom: 0; left: 0; right: 0; background: #2c3e50; color: white;
            padding: 20px; z-index: 9999; display: flex; align-items: center; justify-content: space-between;
            box-shadow: 0 -5px 15px rgba(0,0,0,0.3);
        }
        .cookie-content { font-size: 0.9rem; padding-right: 20px; }
        .cookie-btns .btn { margin-left: 10px; font-weight: 600; }
        .btn-consent { background-color: #2ecc71; color: white; border: none; }
        .btn-decline { background-color: #e74c3c; color: white; border: none; }
        .btn-manage { background: transparent; color: #fff; text-decoration: underline; border: none; }
        .close-cookie { color: #fff; cursor: pointer; font-size: 1.5rem; line-height: 1; margin-left: 15px; }

        /* Footer */
        .footer { background-color: #1b5e20; color: white; padding: 70px 0 30px; }
        .footer-line { border-top: 3px solid var(--rakula-gold); width: 50px; margin-bottom: 25px; }
        .footer a { color: #ccc; text-decoration: none; font-size: 0.9rem; transition: 0.2s; }
        .footer a:hover { color: white; padding-left: 5px; }

        /* 3D HERO ANIMATION */
        .hero-container { position: relative; height: 550px; overflow: hidden; background: #000; perspective: 1200px; }
        .hero-media { width: 100%; height: 100%; object-fit: cover; display: block; }
        .carousel-item.active .hero-media { animation: kenBurns3D 15s infinite alternate ease-in-out; }
        @keyframes kenBurns3D { 0% { transform: scale(1) translateZ(0); } 100% { transform: scale(1.1) translateZ(50px); } }

        /* 3D Indicators */
        .carousel-indicators [data-bs-target] {
            width: 12px; height: 12px; border-radius: 50%; background-color: var(--rakula-gold);
            border: 2px solid #fff; margin: 0 6px; opacity: 0.5; transition: all 0.3s ease;
        }
        .carousel-indicators .active { opacity: 1; transform: scale(1.3); background-color: #fff; }
        .brand-carousel .carousel-indicators { bottom: -40px; }
    </style>
</head>
<body>
<?php include 'theme_handler.php'; ?>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">RAKULA AGENCY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto align-items-center">
                <li class="nav-item"><a class="nav-link active" href="index.php">Home</a></li>
                
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="brandDrop" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        Explore Brands
                    </a>
                    <ul class="dropdown-menu border-0 shadow mt-3" aria-labelledby="brandDrop">
                        <li><a class="dropdown-item" href="Highland_drink.php">Highland Drinks</a></li>
                        <li><a class="dropdown-item" href="kevian.php">Kevian products</a></li>
                        <li><a class="dropdown-item" href="lato.php">Lato Milk</a></li>
                        <li><a class="dropdown-item" href="mtkenya.php">Mt Kenya</a></li>
                        <li><a class="dropdown-item" href="azam.php">Azam Energy Drink</a></li>
                        <li><a class="dropdown-item" href="coastal.php">Coastal Bottlers</a></li>
                        <li><a class="dropdown-item" href="bounty.php">Bounty Limited products</a></li>
                        <li><hr class="dropdown-divider"></li>
                        <li><a class="dropdown-item py-2" href="#brands">View All Brand Logos</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="gallery.php">GALLERY</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
                
                <?php if(isset($_SESSION['user_id'])): ?>
                    <li class="nav-item ms-3"><span class="nav-link text-warning fw-bold small">Hi, <?php echo htmlspecialchars($_SESSION['username']); ?></span></li>
                    <li class="nav-item"><a class="btn btn-outline-light btn-sm ms-2" href="logout.php">Logout</a></li>
                <?php else: ?>
                    <li class="nav-item ms-3"><a class="btn btn-warning btn-sm fw-bold px-3 text-dark" href="login.php">LOGIN</a></li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<div class="hero-container">
    <div id="heroCarousel" class="carousel slide carousel-fade" data-bs-ride="carousel" data-bs-pause="false">
        <div class="carousel-indicators">
            <?php
            $dot_res = mysqli_query($conn, "SELECT id FROM banner_assets");
            $dot_count = 0;
            if($dot_res && mysqli_num_rows($dot_res) > 0):
                while($dot = mysqli_fetch_assoc($dot_res)):
            ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="<?php echo $dot_count; ?>" class="<?php echo ($dot_count === 0) ? 'active' : ''; ?>"></button>
            <?php $dot_count++; endwhile; else: ?>
                <button type="button" data-bs-target="#heroCarousel" data-bs-slide-to="0" class="active"></button>
            <?php endif; ?>
        </div>
        <div class="carousel-inner h-100">
            <?php
            $banner_res = mysqli_query($conn, "SELECT * FROM banner_assets ORDER BY id DESC");
            $active = true;
            if($banner_res && mysqli_num_rows($banner_res) > 0):
                while($banner = mysqli_fetch_assoc($banner_res)):
            ?>
                <div class="carousel-item h-100 <?php echo $active ? 'active' : ''; ?>" data-bs-interval="<?php echo ($banner['file_type'] == 'video') ? '15000' : '5000'; ?>">
                    <?php if($banner['file_type'] == 'video'): ?>
                        <video class="hero-media" autoplay muted loop playsinline><source src="uploads/<?php echo $banner['file_path']; ?>" type="video/mp4"></video>
                    <?php else: ?>
                        <img src="uploads/<?php echo $banner['file_path']; ?>" class="hero-media" alt="Rakula Banner">
                    <?php endif; ?>
                </div>
            <?php $active = false; endwhile; else: ?>
                <div class="carousel-item h-100 active"><img src="uploads/org_hero.jpg" class="hero-media" alt="Default Banner"></div>
            <?php endif; ?>
        </div>
    </div>
</div>

<section class="py-5 bg-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-4" style="color: #333;">Welcome to Rakula Agency</h2>
        <div class="row justify-content-center">
            <div class="col-md-9">
                <p class="text-muted fs-5 leading-relaxed">
                    Rakula Ltd was established on <strong>31st July, 2022</strong>. 
                    Situated off Mombasa – Malindi road – Makutini stage, Mombasa County, 
                    we specialize in general trade across both retail and wholesale sectors within the region.
                </p>
                <a href="about.php" class="btn btn-outline-primary px-5 mt-3 rounded-0 fw-bold">DISCOVER MORE</a>
            </div>
        </div>
    </div>
</section>

<section class="brand-section" id="brands">
    <div class="container position-relative">
        <h4 class="text-center text-muted text-uppercase mb-5 fw-bold" style="letter-spacing: 2px;">Our Trusted Partners</h4>
        <div id="brandCarousel" class="carousel slide brand-carousel" data-bs-ride="carousel">
            <div class="carousel-indicators">
                <?php
                $brand_count_res = mysqli_query($conn, "SELECT id FROM brand_logos");
                $b_dot = 0;
                while($b_row = mysqli_fetch_assoc($brand_count_res)):
                ?>
                <button type="button" data-bs-target="#brandCarousel" data-bs-slide-to="<?php echo $b_dot; ?>" class="<?php echo ($b_dot === 0) ? 'active' : ''; ?> bg-dark"></button>
                <?php $b_dot++; endwhile; ?>
            </div>
            <div class="carousel-inner">
                <?php
                $brands = mysqli_query($conn, "SELECT * FROM brand_logos");
                $first = true;
                if($brands && mysqli_num_rows($brands) > 0):
                    while($b = mysqli_fetch_assoc($brands)):
                ?>
                    <div class="carousel-item <?php echo $first ? 'active' : ''; ?>">
                        <img src="uploads/<?php echo $b['image_path']; ?>" class="d-block mx-auto" alt="Brand Logo">
                    </div>
                <?php $first = false; endwhile; else: ?>
                    <div class="carousel-item active"><p class="text-center text-muted">No brands listed.</p></div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</section>

<section class="pepsi-section" id="products">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="display-5 fw-bold text-uppercase">Featured Inventory</h2>
            <p class="text-primary fw-bold">QUALITY REFRESHMENTS</p>
        </div>
        <div class="row g-4 justify-content-center">
            <?php
            $home_query = "SELECT * FROM product_variations WHERE show_on_home = 1 ORDER BY id DESC LIMIT 3";
            $home_result = mysqli_query($conn, $home_query);
            if($home_result && mysqli_num_rows($home_result) > 0):
                while($row = mysqli_fetch_assoc($home_result)):
            ?>
            <div class="col-md-4">
                <div class="pepsi-card">
                    <img src="uploads/products/<?php echo $row['image_path']; ?>" class="img-fluid" alt="Product">
                    <h4 class="pepsi-title"><?php echo htmlspecialchars($row['flavor_name']); ?></h4>
                    <p class="small text-white-50"><?php echo htmlspecialchars($row['brand_name']); ?> (<?php echo htmlspecialchars($row['size_label']); ?>)</p>
                    <a href="#=<?php echo urlencode($row['brand_name']); ?>" class="btn btn-pepsi">Find Out More</a>
                </div>
            </div>
            <?php endwhile; endif; ?>
        </div>
    </div>
</section>

<footer class="footer">
    <div class="container">
        <div class="row g-5">
            <div class="col-md-4">
                <h5 class="fw-bold text-uppercase mb-3">Reach Us</h5>
                <div class="footer-line"></div>
                <p class="mb-1 opacity-75">Rakula Agency Limited</p>
                <p class="mt-4 fw-bold text-warning"><i class="bi bi-telephone-fill me-2"></i> +254 720 864 493</p>
                <p><i class="bi bi-envelope-fill me-2"></i> rakulaagency@gmail.com</p>
                <div class="mt-4">
                    <a href="https://wa.me/254720864493" target="_blank" class="me-3 fs-4 text-success"><i class="bi bi-whatsapp"></i></a>
                    <a href="https://facebook.com/RakulaAgency" target="_blank" class="me-3 fs-4 text-primary"><i class="bi bi-facebook"></i></a>
                </div>
            </div>

            <div class="col-md-4">
                <h5 class="fw-bold text-uppercase mb-3">Quick Catalog</h5>
                <div class="footer-line"></div>
                <ul class="list-unstyled">
                    <?php 
                    $foot_brands = mysqli_query($conn, "SELECT DISTINCT brand_name FROM product_variations LIMIT 4");
                    if($foot_brands && mysqli_num_rows($foot_brands) > 0):
                        while($fb = mysqli_fetch_assoc($foot_brands)): 
                    ?>
                    <li><a href="brand_page.php?brand=<?php echo urlencode($fb['brand_name']); ?>"><?php echo htmlspecialchars($fb['brand_name']); ?> Products</a></li>
                    <?php endwhile; else: ?>
                    <li class="text-white-50 small">Explore our brands above.</li>
                    <?php endif; ?>
                </ul>
            </div>

            <div class="col-md-4 text-md-end">
                <h5 class="fw-bold text-uppercase mb-3">Portals</h5>
                <div class="footer-line ms-md-auto"></div>
                <ul class="list-unstyled">
                    <li><a href="login.php" class="btn btn-sm btn-outline-warning px-3"><i class="bi bi-shield-lock-fill me-2"></i>STAFF</a></li>
                </ul>
            </div>
        </div>
        <div class="text-center mt-5 pt-4 border-top border-white border-opacity-10">
            <p class="small opacity-50">© <?php echo date('Y'); ?> Rakula Agency. All Rights Reserved.</p>
        </div>
    </div>
</footer>

<?php 
$hide_banner = isset($_SESSION['user_id']) || isset($_SESSION['cookie_acknowledged']);
if (!$hide_banner): 
?>
<div id="cookie-banner">
    <div class="cookie-content">
        <strong>Your privacy is important to us.</strong><br>
        We use cookies to improve your experience and serve you tailored advertisements.
    </div>
    <div class="d-flex align-items-center">
        <div class="cookie-btns">
            <button class="btn btn-consent btn-sm" onclick="acceptCookies()">I consent to cookies</button>
            <button class="btn btn-decline btn-sm" onclick="acceptCookies()">Decline All</button>
        </div>
        <span class="close-cookie" onclick="acceptCookies()">&times;</span>
    </div>
</div>
<?php endif; ?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    function acceptCookies() {
        const banner = document.getElementById('cookie-banner');
        if(banner) {
            banner.style.display = 'none';
        }
        fetch('update_cookie_session.php');
    }
</script>
</body>
</html>