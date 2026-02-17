<?php 
include 'db_config.php'; 

// 1. SMART SESSION START
// This prevents the "Notice: session_start(): Ignoring..." error
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | Rakula Agency</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --rakula-blue: #003399; --rakula-gold: #ffcc00; --rakula-green: #2e7d32; }
        
        /* Top Contact Bar */
        .top-contact-bar { background-color: var(--rakula-green); color: white; padding: 10px 0; font-size: 0.85rem; }
        .top-contact-bar a { color: white; text-decoration: none; margin-left: 15px; }
        
        /* Header and Nav */
        .navbar { background-color: white; border-bottom: 3px solid var(--rakula-gold); }
        .navbar-brand { color: var(--rakula-blue) !important; font-weight: bold; }
        
        /* Contact Info Section */
        .contact-info-list { list-style: none; padding: 0; }
        .contact-info-list li { margin-bottom: 15px; display: flex; align-items: flex-start; }
        .contact-info-list i { color: var(--rakula-green); margin-right: 15px; font-size: 1.2rem; }
        
        /* Contact Form */
        .contact-form-container { background-color: #f8f9fa; padding: 30px; border-radius: 5px; }
        .btn-send { background-color: var(--rakula-gold); border: none; font-weight: bold; padding: 10px 30px; }
        
        /* Map Container */
        .map-container { height: 400px; width: 100%; filter: grayscale(10%); border: 1px solid #ddd; }
    </style>
</head>
<body>

<div class="top-contact-bar">
    <div class="container d-flex justify-content-between">
        <div>
            <a href="https://facebook.com"><i class="bi bi-facebook"></i></a>
            <a href="https://instagram.com"><i class="bi bi-instagram"></i></a>
            <a href="https://youtube.com"><i class="bi bi-youtube"></i></a>
        </div>
        <div>
            <span><i class="bi bi-phone"></i> +254 720 864 493</span>
            <a href="mailto:info@rakula.com"><i class="bi bi-envelope"></i> rakulaagenc@gmail.com</a>
        </div>
    </div>
</div>

<nav class="navbar navbar-expand-lg sticky-top">
    <div class="container">
        <a class="navbar-brand" href="index.php">RAKULA AGENCY</a>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="about.php">About Us</a></li>
                <li class="nav-item"><a class="nav-link active fw-bold" href="contact.php">Contact Us</a></li>
            </ul>
        </div>
    </div>
</nav>

<div class="container py-5">
    <h2 class="fw-bold mb-5">Contact Us</h2>
    
    <div class="row g-5">
        <div class="col-md-5">
            <h4 class="fw-bold mb-4">Rakula Agency Ltd</h4>
            <ul class="contact-info-list">
                <li><i class="bi bi-house-door-fill"></i> P.O. Box 86680, <br>Mombasa Kenya</li>
                <li><i class="bi bi-geo-alt-fill"></i> Makaburini, Mombasa</li>
                <li><i class="bi bi-telephone-fill"></i> +254 (0) 720864493</li>

                <li><i class="bi bi-envelope-fill"></i> rakulaagency@gmail.com</li>
            </ul>
        </div>

        <div class="col-md-7">
            <div class="contact-form-container">
                <form action="process_contact.php" method="POST">
                    <div class="mb-3">
                        <label class="form-label small text-muted">Name (required)</label>
                        <input type="text" name="name" class="form-control rounded-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Email (required)</label>
                        <input type="email" name="email" class="form-control rounded-0" required>
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Subject</label>
                        <input type="text" name="subject" class="form-control rounded-0">
                    </div>
                    <div class="mb-3">
                        <label class="form-label small text-muted">Message</label>
                        <textarea name="message" class="form-control rounded-0" rows="5"></textarea>
                    </div>
                    <button type="submit" class="btn btn-send rounded-0 text-uppercase">Send Email</button>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid p-0 mt-5">
    <iframe class="map-container" 
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15955.16244016024!2d36.7846067!3d-1.3032036!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x182f1a6bf7448667%3A0123456789abcdef!2sNgong%20Rd%2C%20Nairobi!5e0!3m2!1sen!2ske!4v1620000000000!5m2!1sen!2ske" 
        style="border:0;" allowfullscreen="" loading="lazy"></iframe>
</div>

<footer class="py-4 bg-light text-center border-top">
    <p class="text-muted small mb-0">© <?php echo date('Y'); ?> Rakula Agency. All Rights Reserved.</p>
</footer>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>