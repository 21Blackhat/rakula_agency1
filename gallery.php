<?php 
include 'db_config.php'; 

// FETCH DYNAMIC STAFF IMAGES
$settings_query = mysqli_query($conn, "SELECT * FROM site_settings");
$site = [];
while($row = mysqli_fetch_assoc($settings_query)) {
    $site[$row['setting_key']] = $row['setting_value'];
}

// Fallback logic to prevent "broken" images if DB is empty
$img_logistics = !empty($site['staff_logistics']) ? "uploads/".$site['staff_logistics'] : "assets/img/default-team.jpg";
$img_admin = !empty($site['staff_admin']) ? "uploads/".$site['staff_admin'] : "assets/img/default-team.jpg";
$img_distro = !empty($site['staff_distribution']) ? "uploads/".$site['staff_distribution'] : "assets/img/default-team.jpg";
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rakula | 3D Activity Gallery</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <style>
        :root { --rakula-blue: #003399; --gold: #FFC107; }
        body { background: #0a0a0a; color: white; overflow-x: hidden; font-family: 'Montserrat', sans-serif; }
        
        .gallery-container {
            perspective: 1200px;
            padding: 100px 0;
            background: radial-gradient(circle at center, #1a1a1a 0%, #000 100%);
        }

        .section-title {
            font-family: 'Playfair Display', serif;
            color: var(--gold);
            text-align: center;
            margin-bottom: 50px;
            text-transform: uppercase;
            letter-spacing: 5px;
        }

        .gallery-card {
            position: relative;
            height: 400px;
            transform-style: preserve-3d;
            transition: transform 0.8s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            cursor: pointer;
            border-radius: 20px;
            overflow: hidden;
        }

        .gallery-card:hover {
            transform: rotateY(10deg) rotateX(5deg) scale(1.05);
            box-shadow: 0 20px 50px rgba(0, 51, 153, 0.5);
        }

        .gallery-card img, .gallery-card video {
            width: 100%; height: 100%; object-fit: cover;
            filter: grayscale(40%); transition: 0.5s;
        }

        .gallery-card:hover img { filter: grayscale(0%); }

        .card-overlay {
            position: absolute; bottom: 0; left: 0; right: 0; padding: 20px;
            background: linear-gradient(transparent, rgba(0,0,0,0.9));
            transform: translateZ(30px);
        }

        .floating-label {
            position: absolute; top: 20px; right: 20px;
            background: var(--gold); color: black;
            padding: 5px 15px; border-radius: 50px;
            font-weight: bold; font-size: 0.8rem;
            box-shadow: 0 5px 15px rgba(255,193,7,0.4);
            z-index: 10;
        }

        .goal-orb {
            border: 2px solid var(--rakula-blue);
            border-radius: 50%; padding: 40px; text-align: center;
            transition: 0.4s; background: rgba(0, 51, 153, 0.1);
        }
        .goal-orb:hover { background: var(--rakula-blue); transform: translateY(-10px); }
    </style>
</head>
<body>

<div class="container py-5">
    <a href="index.php" class="btn btn-outline-warning rounded-pill mb-4">← Back to Home</a>
    
    <h1 class="section-title" data-aos="zoom-in">Daily Activities & Goals</h1>
    
    <div class="row g-4 gallery-container">
        <?php
        $activities = mysqli_query($conn, "SELECT * FROM gallery_activities ORDER BY id DESC LIMIT 12");
        if(mysqli_num_rows($activities) > 0):
            $i = 0;
            while($act = mysqli_fetch_assoc($activities)):
        ?>
        <div class="col-md-4" data-aos="fade-up" data-aos-delay="<?php echo $i * 100; ?>">
            <div class="gallery-card shadow">
                <span class="floating-label"><?php echo htmlspecialchars($act['label']); ?></span>
                
                <?php if($act['file_type'] == 'video'): ?>
                    <video src="uploads/<?php echo $act['file_path']; ?>" autoplay muted loop></video>
                <?php else: ?>
                    <img src="uploads/<?php echo $act['file_path']; ?>" alt="Activity">
                <?php endif; ?>
                
                <div class="card-overlay">
                    <h5 class="mb-0">Rakula Efficiency</h5>
                    <small class="opacity-75">Ensuring quality delivery every day.</small>
                </div>
            </div>
        </div>
        <?php $i++; endwhile; ?>
        <?php else: ?>
            <div class="col-12 text-center py-5">
                <p class="text-muted">No activities uploaded yet. Add them from the Admin Panel.</p>
            </div>
        <?php endif; ?>
    </div>

    <h2 class="section-title mt-5" data-aos="fade-right">Our Dedicated Staff</h2>
    <div class="row g-3">
        <div class="col-md-6" data-aos="flip-left">
            <div class="gallery-card" style="height: 300px;">
                <img src="<?php echo $img_logistics; ?>" alt="Logistics Team">
                <div class="card-overlay"><h4>Logistics Team</h4></div>
            </div>
        </div>
        
        <div class="col-md-3" data-aos="flip-up">
            <div class="gallery-card" style="height: 300px;">
                <img src="<?php echo $img_admin; ?>" alt="Support Admin">
                <div class="card-overlay"><h4>Support Admin</h4></div>
            </div>
        </div>
        
        <div class="col-md-3" data-aos="flip-right">
            <div class="gallery-card" style="height: 300px;">
                <img src="<?php echo $img_distro; ?>" alt="Distribution">
                <div class="card-overlay"><h4>Distribution Team</h4></div>
            </div>
        </div>
    </div>

    <div class="row mt-5 text-center">
        <div class="col-md-4 mb-4" data-aos="zoom-in">
            <div class="goal-orb shadow">
                <i class="bi bi-rocket-takeoff fs-1 text-warning"></i>
                <h4 class="mt-3">Expansion</h4>
                <p class="small">Reaching every corner of Mombasa by 2027.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="200">
            <div class="goal-orb shadow">
                <i class="bi bi-shield-check fs-1 text-warning"></i>
                <h4 class="mt-3">Quality Control</h4>
                <p class="small">100% genuine products directly from brands.</p>
            </div>
        </div>
        <div class="col-md-4 mb-4" data-aos="zoom-in" data-aos-delay="400">
            <div class="goal-orb shadow">
                <i class="bi bi-people-fill fs-1 text-warning"></i>
                <h4 class="mt-3">Staff Welfare</h4>
                <p class="small">Building a skilled and motivated local workforce.</p>
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script>
    AOS.init({ duration: 1000, once: true });
</script>
</body>
</html>