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

        /* --- FULL IMAGE FIT (NO CROPPING) --- */
  /* --- PROFESSIONAL 3D CARD (PRESERVING YOUR WORKING LOGIC) --- */
.pepsi-section { 
    background-color: #000; 
    padding: 60px 0; 
    /* This ensures no gap between this and the next section */
    margin-bottom: 0; 
}

.pepsi-card { 
    background: rgba(255, 255, 255, 0.03); 
    border: 1px solid rgba(255, 255, 255, 0.1);
    border-radius: 15px;
    text-align: center; 
    position: relative;
    padding: 20px 15px;
    /* Keeps cards same height even if text varies */
    height: 100%; 
    transition: all 0.6s cubic-bezier(0.165, 0.84, 0.44, 1);
    transform-style: preserve-3d;
    overflow: visible;
    display: flex;
    flex-direction: column;
}

/* --- THE IMAGE FIX: REMOVING THE "MISMATCHED BACKGROUND" LOOK --- */
.pepsi-card img { 
    width: 100%;
    height: auto; 
    min-height: 250px;
    max-height: 500px; 
    object-fit: contain; 
    object-position: bottom center; 
    background-color: #ffffff; 
    padding: 5px; 
    transition: transform 0.5s ease;
}

/* For mobile, we shrink the height so it doesn't look stretched */
@media (max-width: 768px) {
    .pepsi-card img { height: 200px; }
}

/* --- PRESERVING YOUR LED & BUTTON LOGIC EXACTLY --- */
.pepsi-card::after {
    content: "";
    position: absolute;
    inset: -1px; 
    border-radius: 15px;
    padding: 2px; 
    background: linear-gradient(135deg, #ffcc00, #00f2ff, #003399, #ffcc00);
    background-size: 300% 300%;
    -webkit-mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    mask: linear-gradient(#fff 0 0) content-box, linear-gradient(#fff 0 0);
    -webkit-mask-composite: xor;
    mask-composite: exclude;
    opacity: 0;
    transition: opacity 0.4s ease;
    pointer-events: none; 
}

.btn-pepsi {
    position: relative; 
    z-index: 10;        
    background-color: #ffcc00; 
    color: #000 !important;
    border-radius: 50px;
    padding: 12px 35px;
    font-weight: 800;
    text-transform: uppercase;
    border: none;
    margin-top: auto; /* Pushes button to bottom of the card */
    display: inline-block; 
    text-decoration: none; 
    transition: all 0.3s ease;
    box-shadow: 0 4px 15px rgba(255, 204, 0, 0.3);
}

.btn-pepsi:hover {
    background-color: #003399; 
    color: #fff !important;
    transform: translateY(-3px) translateZ(70px); 
    box-shadow: 0 10px 25px rgba(0, 51, 153, 0.5);
}

.pepsi-card:hover {
    transform: perspective(1000px) rotateY(10deg) rotateX(5deg) translateY(-10px);
    background: rgba(255, 255, 255, 0.08);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.6);
}

.pepsi-card:hover::after {
    opacity: 1;
    animation: led-glow 4s linear infinite;
}

.pepsi-card:hover img { 
    transform: translateZ(60px) scale(1.1); 
    filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.5));
}

@keyframes led-glow {
    0% { background-position: 0% 50%; }
    50% { background-position: 100% 50%; }
    100% { background-position: 0% 50%; }
}
      /* Footer */
        .footer { background-color: #1b5e20; color: white; padding: 70px 0 30px; }
        .footer-line { border-top: 3px solid var(--rakula-gold); width: 50px; margin-bottom: 25px; }
        .footer a { color: #ccc; text-decoration: none; font-size: 0.9rem; transition: 0.2s; }
        .footer a:hover { color: white; padding-left: 5px; }

        /* 3D HERO ANIMATION */
        /* --- HERO ADAPTATION (FROM YOUR PROVIDED CODE) --- */
.hero-container { 
    position: relative; 
    height: auto;           /* Image defines the height, removing black gap */
    min-height: 400px;      /* Ensures visibility on empty states */
    overflow: hidden; 
    background: #fff;       /* Changed from black to white/transparent */
}

.hero-media { 
    width: 100%; 
    height: auto;           /* Prevents stretching */
    display: block; 
    object-fit: contain;    /* Shows whole image (horizontal or vertical) */
    background: #fff; 
}
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
        <div class="carousel-inner"> <?php
    $banner_res = mysqli_query($conn, "SELECT * FROM banner_assets ORDER BY id DESC");
    $active = true;
    if($banner_res && mysqli_num_rows($banner_res) > 0):
        while($banner = mysqli_fetch_assoc($banner_res)):
    ?>
        <div class="carousel-item <?php echo $active ? 'active' : ''; ?>"> <?php if($banner['file_type'] == 'video'): ?>
                <video class="hero-media w-100" autoplay muted loop playsinline>
                    <source src="uploads/<?php echo $banner['file_path']; ?>" type="video/mp4">
                </video>
            <?php else: ?>
                <img src="uploads/<?php echo $banner['file_path']; ?>" class="hero-media w-100" alt="Rakula Banner">
            <?php endif; ?>
        </div>
    <?php $active = false; endwhile; endif; ?>
</div>
    </div>
</div>

<section class="py-5 bg-white">
    <div class="container text-center">
        <h2 class="fw-bold mb-4" style="color: #333;">Welcome to Rakula Agency</h2>
        <div class="row justify-content-center">
            <div class="col-md-9">
                <p class="text-muted fs-5 leading-relaxed">
                    Rakula Ltd was established on <strong>16th August, 2016</strong>. 
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
                    // LOGIC FOR DYNAMIC BRAND TARGETING
                    $brand_lower = strtolower($row['brand_name']);
                    
                    if (strpos($brand_lower, 'highland') !== false) {
                        $target_link = "Highland_drink.php";
                    } elseif (strpos($brand_lower, 'lato') !== false) {
                        $target_link = "lato.php";
                    } elseif (strpos($brand_lower, 'safari') !== false || strpos($brand_lower, 'bounty') !== false) {
                        // This handles Safari Lemonade, Energy Booster, etc.
                        $target_link = "bounty.php";
                    } else {
                        $target_link = "Highland_drink.php?brand=" . urlencode($row['brand_name']);
                    }
            ?>
            <div class="col-md-4">
                <div class="pepsi-card">
                    <img src="uploads/products/<?php echo htmlspecialchars($row['image_path']); ?>" class="img-fluid" alt="Product">
                    <h4 class="pepsi-title"><?php echo htmlspecialchars($row['flavor_name']); ?></h4>
                    <p class="small text-white-50">
                        <?php echo htmlspecialchars($row['brand_name']); ?> 
                        <?php echo !empty($row['size_label']) ? "(".htmlspecialchars($row['size_label']).")" : ""; ?>
                    </p>
                    <a href="<?php echo $target_link; ?>" class="btn btn-pepsi">Find Out More</a>
                </div>
            </div>
            <?php 
                endwhile; 
            else: 
            ?>
                <div class="col-12 text-center">
                    <p class="text-muted">Stay tuned! Our featured refreshments are coming soon.</p>
                </div>
            <?php endif; ?>
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
                            // LOGIC FOR SPECIFIC FOOTER BRAND LINKS
                            $f_brand_lower = strtolower($fb['brand_name']);
                            if (strpos($f_brand_lower, 'highland') !== false) {
                                $f_link = "Highland_drink.php";
                            } elseif (strpos($f_brand_lower, 'lato') !== false) {
                                $f_link = "lato.php";
                            } else {
                                $f_link = "Highland_drink.php?brand=" . urlencode($fb['brand_name']);
                            }
                    ?>
                    <li><a href="<?php echo $f_link; ?>"><?php echo htmlspecialchars($fb['brand_name']); ?> Products</a></li>
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

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>