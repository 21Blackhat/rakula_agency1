<?php 
include 'db_config.php'; 

// 1. SMART SESSION START
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// 2. ADMIN ACCESS SECURITY
if (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
    header("Location: login.php");
    exit();
}

// 3. Dashboard Visit Logic
if(!isset($_SESSION['has_visited_admin'])) {
    mysqli_query($conn, "UPDATE site_stats SET page_views = page_views + 1 WHERE id = 1");
    $_SESSION['has_visited_admin'] = true;
}

// --- HANDLE GALLERY ACTIVITY UPLOAD (NEW UPDATE) ---
if (isset($_POST['add_gallery_activity'])) {
    $label = mysqli_real_escape_string($conn, $_POST['activity_label']);
    $target_dir = "uploads/gallery/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0755, true); }
    
    $file_name = $_FILES["activity_file"]["name"];
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_images = ['jpg', 'jpeg', 'png', 'webp'];
    $allowed_videos = ['mp4', 'webm'];
    
    $type = "";
    if (in_array($ext, $allowed_images)) { $type = "image"; }
    elseif (in_array($ext, $allowed_videos)) { $type = "video"; }

    if ($type != "") {
        $new_name = "act_" . time() . "_" . rand(100, 999) . "." . $ext;
        if (move_uploaded_file($_FILES["activity_file"]["tmp_name"], $target_dir . $new_name)) {
            $db_path = "gallery/" . $new_name;
            mysqli_query($conn, "INSERT INTO gallery_activities (file_path, file_type, label) VALUES ('$db_path', '$type', '$label')");
            $msg = "Success: Gallery activity added!";
        }
    }
}

// --- HANDLE GALLERY DELETION (NEW UPDATE) ---
if (isset($_GET['delete_activity'])) {
    $id = (int)$_GET['delete_activity'];
    $res = mysqli_fetch_assoc(mysqli_query($conn, "SELECT file_path FROM gallery_activities WHERE id=$id"));
    if($res && file_exists("uploads/" . $res['file_path'])) { 
        unlink("uploads/" . $res['file_path']); 
    }
    mysqli_query($conn, "DELETE FROM gallery_activities WHERE id = $id");
    header("Location: admin.php?msg=ActivityDeleted");
    exit();
}

// --- HANDLE BANNER DELETION (NEW UPDATE) ---
if (isset($_GET['delete_banner'])) {
    $id = (int)$_GET['delete_banner'];
    $res = mysqli_fetch_assoc(mysqli_query($conn, "SELECT file_path FROM banner_assets WHERE id=$id"));
    if($res && file_exists("uploads/" . $res['file_path'])) { 
        unlink("uploads/" . $res['file_path']); 
    }
    mysqli_query($conn, "DELETE FROM banner_assets WHERE id = $id");
    header("Location: admin.php?msg=BannerDeleted");
    exit();
}

// --- HANDLE PARTNER LOGO DELETION (NEW UPDATE) ---
if (isset($_GET['delete_logo'])) {
    $id = (int)$_GET['delete_logo'];
    $res = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image_path FROM brand_logos WHERE id=$id"));
    if($res && file_exists("uploads/" . $res['image_path'])) { 
        unlink("uploads/" . $res['image_path']); 
    }
    mysqli_query($conn, "DELETE FROM brand_logos WHERE id = $id");
    header("Location: admin.php?msg=LogoDeleted");
    exit();
}

// --- HANDLE PRODUCT VARIATION UPLOAD (UPDATED FOR 2 IMAGES) ---
if (isset($_POST['add_product_variation'])) {
    $brand = mysqli_real_escape_string($conn, $_POST['brand_name']);
    $flavor = mysqli_real_escape_string($conn, $_POST['flavor_name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $size = mysqli_real_escape_string($conn, $_POST['size_label']);
    
    $price = 0; 
    $show_home = isset($_POST['show_on_home']) ? 1 : 0; 
    
    $sort_value = (float)$size;
    if (stripos($size, 'ml') !== false && $sort_value > 10) { $sort_value = $sort_value / 1000; }

    $upload_dir = 'uploads/products/';
    if (!is_dir($upload_dir)) { mkdir($upload_dir, 0755, true); }

    // Image 1 Logic (Primary)
    $img1_name = time() . "_1_" . basename($_FILES['product_image']['name']);
    move_uploaded_file($_FILES['product_image']['tmp_name'], $upload_dir . $img1_name);

    // Image 2 Logic (Secondary)
    $img2_name = time() . "_2_" . basename($_FILES['product_image_2']['name']);
    move_uploaded_file($_FILES['product_image_2']['tmp_name'], $upload_dir . $img2_name);

    $sql = "INSERT INTO product_variations (brand_name, flavor_name, description, size_label, sort_value, price, image_path, image_path_2, show_on_home) 
            VALUES ('$brand', '$flavor', '$description', '$size', '$sort_value', '$price', '$img1_name', '$img2_name', '$show_home')";
    
    if (mysqli_query($conn, $sql)) {
        $msg = "Success: Product variation added!";
    }
}

// 4. Handle Banner Upload (Images & Videos)
if (isset($_POST['add_banner_asset'])) {
    $target_dir = "uploads/banners/";
    if (!is_dir($target_dir)) { mkdir($target_dir, 0755, true); }
    $file_name = $_FILES["banner_file"]["name"];
    $ext = strtolower(pathinfo($file_name, PATHINFO_EXTENSION));
    $allowed_images = ['jpg', 'jpeg', 'png', 'webp'];
    $allowed_videos = ['mp4', 'webm'];
    
    $type = "";
    if (in_array($ext, $allowed_images)) { $type = "image"; }
    elseif (in_array($ext, $allowed_videos)) { $type = "video"; }

    if ($type != "") {
        $new_name = "hero_" . time() . "_" . rand(100, 999) . "." . $ext;
        if (move_uploaded_file($_FILES["banner_file"]["tmp_name"], $target_dir . $new_name)) {
            $db_path = "banners/" . $new_name;
            mysqli_query($conn, "INSERT INTO banner_assets (file_path, file_type) VALUES ('$db_path', '$type')");
            $msg = "Success: Banner added!";
        }
    }
}

// 5. Handle Brand Logo Upload
if (isset($_POST['add_brand'])) {
    $image_name = time() . "_" . basename($_FILES['brand_image']['name']);
    if (move_uploaded_file($_FILES['brand_image']['tmp_name'], "uploads/" . $image_name)) {
        $image_name = mysqli_real_escape_string($conn, $image_name);
        mysqli_query($conn, "INSERT INTO brand_logos (image_path) VALUES ('$image_name')");
        $msg = "Success: Logo added!";
    }
}

// 6. Handle About Page Image Updates
if (isset($_POST['update_about_image'])) {
    $section = mysqli_real_escape_string($conn, $_POST['section_key']);
    $target_dir = "uploads/";
    $file_name = "about_" . $section . "_" . time() . "_" . basename($_FILES["about_image"]["name"]);
    if (move_uploaded_file($_FILES["about_image"]["tmp_name"], $target_dir . $file_name)) {
        mysqli_query($conn, "UPDATE about_content SET image_path = '$file_name' WHERE section_key = '$section'");
        $msg = "Success: " . ucwords($section) . " image updated!";
    }
}

// 7. Handle Deletions (UPDATED TO REMOVE BOTH IMAGES)
if (isset($_GET['delete_variation'])) {
    $id = (int)$_GET['delete_variation'];
    $res = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image_path, image_path_2 FROM product_variations WHERE id=$id"));
    if($res) { 
        if(file_exists("uploads/products/" . $res['image_path'])) unlink("uploads/products/" . $res['image_path']); 
        if(!empty($res['image_path_2']) && file_exists("uploads/products/" . $res['image_path_2'])) unlink("uploads/products/" . $res['image_path_2']);
    }
    mysqli_query($conn, "DELETE FROM product_variations WHERE id = $id");
    header("Location: admin.php?msg=Deleted");
    exit();
}

// 8. Stats Fetching
$product_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as total FROM product_variations"))['total'] ?? 0;
$total_views = mysqli_fetch_assoc(mysqli_query($conn, "SELECT page_views FROM site_stats WHERE id = 1"))['page_views'] ?? 0;
$about_images = [];
$res_about = mysqli_query($conn, "SELECT * FROM about_content");
while($row = mysqli_fetch_assoc($res_about)) { $about_images[$row['section_key']] = $row['image_path']; }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Rakula | Admin Command Center</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    <style>
        :root { --rakula-blue: #003399; --soft-bg: #f4f7fe; }
        body { background-color: var(--soft-bg); font-family: 'Segoe UI', sans-serif; }
        .sidebar { background: var(--rakula-blue); min-height: 100vh; color: white; position: fixed; width: 260px; z-index: 1000; }
        .main-content { margin-left: 260px; padding: 30px; }
        .nav-link { color: rgba(255,255,255,0.7); transition: 0.3s; border-radius: 8px; margin-bottom: 5px; text-decoration: none; display: block; padding: 10px; }
        .nav-link:hover, .nav-link.active { color: white; background: rgba(255,255,255,0.1); }
        .admin-card { border: none; border-radius: 15px; background: white; padding: 25px; box-shadow: 0 4px 12px rgba(0,0,0,0.05); margin-bottom: 30px; }
        .product-img { width: 45px; height: 45px; object-fit: contain; border-radius: 8px; background: #f8f9fa; border: 1px solid #eee; margin-right: 4px; }
        .banner-preview { height: 80px; width: 120px; object-fit: cover; border-radius: 5px; }
        .section-header { font-family: 'Playfair Display', serif; color: var(--rakula-blue); border-left: 5px solid var(--rakula-blue); padding-left: 15px; }
        .about-preview { height: 100px; width: 100%; object-fit: cover; border-radius: 8px; }
        .preview-img { height: 60px; width: 60px; object-fit: cover; border-radius: 5px; }
        .logo-preview-box { position: relative; width: 60px; height: 40px; }
        .logo-preview-box img { width: 100%; height: 100%; object-fit: contain; border: 1px solid #eee; border-radius: 4px; }
        .delete-btn-overlay { position: absolute; top: -5px; right: -5px; background: red; color: white; border-radius: 50%; width: 18px; height: 18px; display: flex; align-items: center; justify-content: center; font-size: 12px; text-decoration: none; border: 1px solid white; }
    </style>
</head>
<body>

<div class="sidebar d-flex flex-column p-4">
    <h3 class="fw-bold mb-4 text-center">RAKULA ADMIN</h3>
    <hr>
    <nav class="nav flex-column">
        <a class="nav-link active" href="admin.php"><i class="bi bi-speedometer2 me-2"></i> Dashboard</a>
        <a class="nav-link" href="#inventory"><i class="bi bi-box-seam me-2"></i> Inventory</a>
        <a class="nav-link" href="#gallery-mgmt"><i class="bi bi-images me-2"></i> Gallery Activities</a>
        <a class="nav-link" href="#about-mgmt"><i class="bi bi-info-circle me-2"></i> About Page</a>
    </nav>
    <div class="mt-auto"><a href="logout.php" class="btn btn-outline-light w-100 rounded-pill">Logout</a></div>
</div>

<div class="main-content">
    <?php if(isset($msg)): ?>
        <div class="alert alert-success alert-dismissible fade show shadow-sm" role="alert">
            <i class="bi bi-check-circle-fill me-2"></i> <?php echo $msg; ?>
            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
        </div>
    <?php endif; ?>

    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="fw-bold section-header">Management Hub</h2>
        <span class="badge bg-primary p-2 px-3 shadow-sm">Live Views: <?php echo number_format($total_views); ?></span>
    </div>

    <div class="admin-card" id="gallery-mgmt">
        <h4 class="fw-bold mb-4 text-primary"><i class="bi bi-camera-reels me-2"></i>Gallery Activity Management</h4>
        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-5">
                <label class="form-label small fw-bold">Select File (Image or Video)</label>
                <input type="file" name="activity_file" class="form-control" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Operation Label</label>
                <select name="activity_label" class="form-select" required>
                    <option value="Logistics">Logistics</option>
                    <option value="Packaging">Packaging</option>
                    <option value="Staff Meet">Staff Meet</option>
                    <option value="Warehouse">Warehouse</option>
                    <option value="Distribution">Distribution</option>
                    <option value="Customer Service">Customer Service</option>
                </select>
            </div>
            <div class="col-md-3 d-flex align-items-end">
                <button type="submit" name="add_gallery_activity" class="btn btn-primary w-100 rounded-pill fw-bold shadow-sm">Upload to Gallery</button>
            </div>
        </form>

        <div class="table-responsive mt-4">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Preview</th><th>Label</th><th>Type</th><th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $acts = mysqli_query($conn, "SELECT * FROM gallery_activities ORDER BY id DESC");
                    while($a = mysqli_fetch_assoc($acts)):
                    ?>
                    <tr>
                        <td>
                            <?php if($a['file_type'] == 'video'): ?>
                                <i class="bi bi-play-circle-fill fs-3 text-primary"></i>
                            <?php else: ?>
                                <img src="uploads/<?php echo $a['file_path']; ?>" class="preview-img">
                            <?php endif; ?>
                        </td>
                        <td><span class="fw-bold"><?php echo $a['label']; ?></span></td>
                        <td><span class="badge bg-light text-dark border"><?php echo strtoupper($a['file_type']); ?></span></td>
                        <td class="text-end">
                            <a href="admin.php?delete_activity=<?php echo $a['id']; ?>" class="btn btn-sm btn-outline-danger px-3 rounded-pill" onclick="return confirm('Remove from gallery?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card" id="inventory">
        <h4 class="fw-bold mb-4 text-primary"><i class="bi bi-plus-circle me-2"></i>Add Brand Product Flavor</h4>
        <form action="" method="POST" enctype="multipart/form-data" class="row g-3">
            <div class="col-md-4">
                <label class="form-label small fw-bold">Category (Brand)</label>
                <select name="brand_name" class="form-select" required>
                    <option value="Club Soda">Club Soda</option>
                    <option value="Kevian">Kevian</option>
                    <option value="Mt Kenya">Mt Kenya</option>
                    <option value="Lato">Lato</option>
                    <option value="Azam">Azam</option>
                    <option value="Coastal Bottlers">Coastal Bottlers</option>
                    <option value="Cordials">Cordials</option>
                    <option value="Pure Water">Pure Water</option>
                    <option value="Bazu">Bazu</option>
                    <option value="Highland Drinks">Highland Drinks</option>
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Flavor Name</label>
                <input type="text" name="flavor_name" class="form-control" placeholder="e.g. Pineapple" required>
            </div>
            <div class="col-md-4">
                <label class="form-label small fw-bold">Size Label</label>
                <input type="text" name="size_label" class="form-control" placeholder="e.g. 500ml / 2L" required>
            </div>
            
            <div class="col-md-6">
                <label class="form-label small fw-bold">Primary Image (Solo Bottle shot)</label>
                <input type="file" name="product_image" class="form-control" required>
            </div>
            <div class="col-md-6">
                <label class="form-label small fw-bold">Secondary Image (Group/Box/Lifestyle)</label>
                <input type="file" name="product_image_2" class="form-control" required>
            </div>

            <div class="col-md-10">
                <label class="form-label small fw-bold">Flavor Description</label>
                <textarea name="description" class="form-control" rows="2" placeholder="Taste notes..." required></textarea>
            </div>
            <div class="col-md-2 d-flex align-items-end">
                <div class="form-check form-switch mb-3">
                    <input class="form-check-input" type="checkbox" name="show_on_home" id="homeSwitch" checked>
                    <label class="form-check-label small fw-bold" for="homeSwitch">On Home?</label>
                </div>
            </div>

            <div class="col-12 text-end">
                <button type="submit" name="add_product_variation" class="btn btn-primary px-5 rounded-pill fw-bold shadow">Save Variation</button>
            </div>
        </form>

        <hr class="my-5">

        <h4 class="fw-bold mb-4 section-header">Brand Inventory List</h4>
        <div class="table-responsive">
            <table class="table align-middle">
                <thead class="table-light">
                    <tr>
                        <th>Images</th><th>Category</th><th>Flavor</th><th>Size</th><th>Home Status</th><th class="text-end">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $vars = mysqli_query($conn, "SELECT * FROM product_variations ORDER BY id DESC");
                    while($row = mysqli_fetch_assoc($vars)):
                    ?>
                    <tr>
                        <td>
                            <img src="uploads/products/<?php echo $row['image_path']; ?>" class="product-img" title="Primary">
                            <?php if(!empty($row['image_path_2'])): ?>
                                <img src="uploads/products/<?php echo $row['image_path_2']; ?>" class="product-img" title="Secondary">
                            <?php endif; ?>
                        </td>
                        <td><span class="badge bg-primary"><?php echo $row['brand_name']; ?></span></td>
                        <td><span class="fw-bold"><?php echo $row['flavor_name']; ?></span></td>
                        <td><?php echo $row['size_label']; ?></td>
                        <td>
                            <?php if($row['show_on_home']): ?>
                                <span class="badge bg-success text-white"><i class="bi bi-eye-fill"></i> Visible</span>
                            <?php else: ?>
                                <span class="badge bg-secondary text-white"><i class="bi bi-eye-slash"></i> Hidden</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-end">
                            <a href="admin.php?delete_variation=<?php echo $row['id']; ?>" class="btn btn-sm btn-outline-danger px-3 rounded-pill" onclick="return confirm('Delete this variation and its images?')">Delete</a>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
    </div>

    <div class="admin-card" id="about-mgmt">
        <h5 class="fw-bold text-info mb-4"><i class="bi bi-pencil-square me-2"></i>Edit About Us Images</h5>
        <div class="row">
            <?php 
            $sections = ['main_org' => 'Organization', 'office' => 'Office', 'fleet' => 'Fleet', 'location' => 'Location'];
            foreach($sections as $key => $label): 
            ?>
            <div class="col-md-3 text-center mb-3">
                <label class="small fw-bold d-block mb-2 text-muted"><?php echo $label; ?></label>
                <img src="uploads/<?php echo !empty($about_images[$key]) ? $about_images[$key] : 'default.jpg'; ?>?t=<?php echo time(); ?>" class="about-preview mb-2 shadow-sm">
                <form action="" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="section_key" value="<?php echo $key; ?>">
                    <input type="file" name="about_image" class="form-control form-control-sm mb-2" required>
                    <button type="submit" name="update_about_image" class="btn btn-info btn-sm w-100 text-white shadow-sm">Update</button>
                </form>
            </div>
            <?php endforeach; ?>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="admin-card h-100">
                <h5 class="fw-bold text-primary mb-3"><i class="bi bi-play-btn me-2"></i>Home Page Banner</h5>
                <form action="" method="POST" enctype="multipart/form-data" class="mb-4">
                    <div class="input-group">
                        <input type="file" name="banner_file" class="form-control" required>
                        <button type="submit" name="add_banner_asset" class="btn btn-primary">Upload</button>
                    </div>
                </form>
                <div class="d-flex flex-wrap gap-2">
                    <?php
                    $banners = mysqli_query($conn, "SELECT * FROM banner_assets ORDER BY id DESC");
                    while($b = mysqli_fetch_assoc($banners)):
                    ?>
                    <div class="position-relative">
                        <?php if($b['file_type'] == 'video'): ?>
                             <div class="banner-preview bg-dark d-flex align-items-center justify-content-center">
                                <i class="bi bi-film text-white fs-3"></i>
                             </div>
                        <?php else: ?>
                            <img src="uploads/<?php echo $b['file_path']; ?>" class="banner-preview">
                        <?php endif; ?>
                        <a href="admin.php?delete_banner=<?php echo $b['id']; ?>" class="btn btn-danger btn-sm position-absolute top-0 end-0 p-0 px-1" onclick="return confirm('Delete this banner?')">×</a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="admin-card h-100">
                <h5 class="fw-bold text-success mb-3"><i class="bi bi-images me-2"></i>Partner Logos</h5>
                <form action="" method="POST" enctype="multipart/form-data" class="mb-3">
                    <div class="input-group">
                        <input type="file" name="brand_image" class="form-control form-control-sm" required>
                        <button type="submit" name="add_brand" class="btn btn-success btn-sm">Add</button>
                    </div>
                </form>
                <div class="d-flex flex-wrap gap-3">
                    <?php
                    $logos = mysqli_query($conn, "SELECT * FROM brand_logos ORDER BY id DESC");
                    while($l = mysqli_fetch_assoc($logos)):
                    ?>
                    <div class="logo-preview-box">
                        <img src="uploads/<?php echo $l['image_path']; ?>" alt="Logo">
                        <a href="admin.php?delete_logo=<?php echo $l['id']; ?>" class="delete-btn-overlay" onclick="return confirm('Delete this logo?')">×</a>
                    </div>
                    <?php endwhile; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>