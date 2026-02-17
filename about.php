<?php 
include 'db_config.php'; 

// 1. Fetch dynamic images from database
$about_res = mysqli_query($conn, "SELECT * FROM about_content");
$images = [];

// Initialize with default values in case database is empty
$images['main_org'] = 'default.jpg';
$images['office'] = 'default.jpg';
$images['fleet'] = 'default.jpg';
$images['location'] = 'default.jpg';

if ($about_res) {
    while($row = mysqli_fetch_assoc($about_res)) {
        $images[$row['section_key']] = $row['image_path'];
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us | Rakula Agency Limited</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --rakula-blue: #003399; --rakula-gold: #ffcc00; }
        body { font-family: 'Segoe UI', Roboto, sans-serif; background-color: #fcfcfc; }
        
        /* Navigation */
        .navbar { background-color: var(--rakula-blue); border-bottom: 3px solid var(--rakula-gold); }
        .nav-link { color: white !important; text-transform: uppercase; font-size: 0.9rem; margin: 0 10px; }
        
        /* Hero Section */
        header { 
            background: linear-gradient(rgba(0,51,153,0.85), rgba(0,51,153,0.85)), url('uploads/<?php echo $images['main_org']; ?>'); 
            background-size: cover; 
            background-position: center; 
            padding: 100px 0;
        }

        /* Content Styling */
        .reveal { opacity: 0; transform: translateY(30px); transition: 1s all ease; }
        .reveal.active { opacity: 1; transform: translateY(0); }
        .stat-card { border-left: 5px solid var(--rakula-blue); background: #fff; padding: 20px; border-radius: 0 10px 10px 0; box-shadow: 0 4px 6px rgba(0,0,0,0.05); }
        .img-hover:hover { transform: scale(1.02); transition: 0.3s; }
        .vision-box { border-top: 4px solid var(--rakula-gold); transition: 0.3s; }
        .vision-box:hover { background-color: #f0f4ff; }
        .office-section { border-left: 4px solid var(--rakula-gold); padding-left: 20px; }
        
        /* Map Styling */
        .map-container { position: relative; height: 400px; border-radius: 15px; overflow: hidden; box-shadow: 0 10px 30px rgba(0,0,0,0.1); }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="index.php">RAKULA AGENCY</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link active fw-bold" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link" href="contact.php">Contact Us</a></li>
            </ul>
        </div>
    </div>
</nav>

<header class="text-white text-center">
    <div class="container">
        <h1 class="display-4 fw-bold">Company Introduction</h1>
        <p class="lead">Established on 31st July, 2022</p>
    </div>
</header>

<div class="container my-5">
    <div class="row align-items-center reveal">
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="uploads/<?php echo $images['main_org']; ?>" class="img-fluid rounded-4 shadow img-hover" alt="Rakula Organization">
        </div>
        <div class="col-md-6">
            <h2 class="fw-bold text-primary mb-3">Who We Are</h2>
            <p class="text-muted fs-5">
                Rakula Ltd was established on <strong>31st July, 2022</strong>. Situated off Mombasa – Malindi road – Makutini stage, Mombasa County, we specialize in general trade across both retail and wholesale sectors within the region.
            </p>
            <p class="text-muted">
                With our dedicated fleet of <strong>six vehicles</strong>, we ensure our distribution and delivery processes are consistently easy, prompt, and reliable.
            </p>
            <div class="stat-card mt-4">
                <h4 class="mb-0 fw-bold text-primary">Regional Focus</h4>
                <small class="text-uppercase fw-bold text-muted">Mombasa County & Beyond</small>
            </div>
        </div>
    </div>

    <hr class="my-5">

    <div class="row align-items-center flex-row-reverse mb-5 reveal">
        <div class="col-md-6 mb-4 mb-md-0">
            <img src="uploads/<?php echo $images['office']; ?>" class="img-fluid rounded-4 shadow img-hover" alt="Our Offices">
        </div>
        <div class="col-md-6">
            <div class="office-section">
                <h2 class="fw-bold text-primary mb-3">Our Infrastructure</h2>
                <p class="text-muted">
                    Our administrative hub at Makutini Stage serves as the heartbeat of our operations. We maintain a modern office environment designed to facilitate seamless communication between our sales team, warehouse, and logistics department.
                </p>
                <p class="text-muted">
                    Equipped with robust inventory management systems and a dedicated customer service desk, our office ensures that every order is processed with precision.
                </p>
            </div>
        </div>
    </div>

    <div class="row g-4 text-center mb-5">
        <div class="col-md-4 reveal">
            <div class="p-4 shadow-sm bg-white h-100 rounded-3 vision-box">
                <i class="bi bi-eye-fill fs-1 text-primary"></i>
                <h4 class="fw-bold mt-3">Our Vision</h4>
                <p class="text-muted">To provide prompt and good services to our customers.</p>
            </div>
        </div>
        <div class="col-md-4 reveal">
            <div class="p-4 shadow-sm bg-white h-100 rounded-3 vision-box">
                <i class="bi bi-rocket-takeoff-fill fs-1 text-primary"></i>
                <h4 class="fw-bold mt-3">Our Mission</h4>
                <p class="text-muted">To grow and achieve market dominance by exceeding customer’s expectations and efficiencies in our service.</p>
            </div>
        </div>
        <div class="col-md-4 reveal">
            <div class="p-4 shadow-sm bg-white h-100 rounded-3 vision-box">
                <i class="bi bi-heart-fill fs-1 text-primary"></i>
                <h4 class="fw-bold mt-3">Our Values</h4>
                <p class="text-muted">Customers above everything else with excellence commitments and unquestionable integrity.</p>
            </div>
        </div>
    </div>

    <div class="row g-5 reveal">
        <div class="col-md-5">
            <div class="bg-light p-4 rounded-4 h-100">
                <h3 class="fw-bold text-primary mb-3">Strategic Partners</h3>
                <p class="text-muted small">Quality suppliers we work with:</p>
                <ul class="list-unstyled">
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Highlands Drinks Ltd</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Kevian Kenya Ltd</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Musty Distribution Ltd</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Bounty Ltd</li>
                    <li class="mb-2"><i class="bi bi-check-circle-fill text-success me-2"></i>Mount Kenya Diary Milk</li>
                </ul>
                <img src="uploads/<?php echo $images['fleet']; ?>" class="img-fluid rounded mt-3 shadow-sm" alt="Our Fleet">
                <p class="text-center mt-2 small text-muted">Logistics Fleet: 6 Vehicles</p>
            </div>
        </div>
        
        <div class="col-md-7">
            <h3 class="fw-bold text-primary mb-3"><i class="bi bi-geo-alt-fill me-2"></i>Find Us Here</h3>
            <p class="text-muted">Located at Makutini Stage, off the Mombasa – Malindi Road.</p>
            <div class="map-container">
    <iframe 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3979.805!2d39.684!3d-4.034!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1840128f6203cb99%3A0x13c5f9f0aef2af2e!2sMakutini%20Stage!5e0!3m2!1sen!2ske!4v1700000000000!5m2!1sen!2ske" 
        width="100%" 
        height="450" 
        style="border:0;" 
        allowfullscreen="" 
        loading="lazy" 
        referrerpolicy="no-referrer-when-downgrade">
    </iframe>
</div>
        </div>
    </div>
</div>

<footer class="bg-dark text-white py-5 mt-5">
    <div class="container text-center">
        <p class="mb-2"><strong>Rakula Agency Limited</strong></p>
        <p class="opacity-75 small mb-0">Situated off Mombasa – Malindi road – Makutini stage, Mombasa County.</p>
        <hr class="my-4 border-secondary">
        <p class="mb-0 text-muted">&copy; <?php echo date('Y'); ?> Rakula Agency. All Rights Reserved.</p>
    </div>
</footer>

<script>
function reveal() {
    var reveals = document.querySelectorAll(".reveal");
    for (var i = 0; i < reveals.length; i++) {
        var windowHeight = window.innerHeight;
        var elementTop = reveals[i].getBoundingClientRect().top;
        var elementVisible = 100;
        if (elementTop < windowHeight - elementVisible) {
            reveals[i].classList.add("active");
        }
    }
}
window.addEventListener("scroll", reveal);
reveal();
</script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>