<?php 
include 'db_config.php'; 

// Save logic
if (isset($_POST['save_about'])) {
    $text = mysqli_real_escape_string($conn, $_POST['about_text']);
    mysqli_query($conn, "UPDATE site_content SET content_value = '$text' WHERE content_key = 'about_text'");
    $msg = "About Us updated successfully!";
}

// Fetch current text
$res = mysqli_query($conn, "SELECT content_value FROM site_content WHERE content_key = 'about_text'");
$about_data = mysqli_fetch_assoc($res);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <title>Edit About Us | Rakula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="admin.php" class="btn btn-outline-secondary mb-4"><i class="bi bi-arrow-left"></i> Back to Dashboard</a>
        
        <div class="card border-0 shadow-sm p-4">
            <h3 class="fw-bold mb-4 text-primary">Edit "About Us" Content</h3>
            
            <?php if(isset($msg)): ?>
                <div class="alert alert-success"><?php echo $msg; ?></div>
            <?php endif; ?>

            <form action="" method="POST">
                <div class="mb-3">
                    <label class="form-label fw-bold">Company Story / Description</label>
                    <textarea name="about_text" class="form-control" rows="8"><?php echo $about_data['content_value']; ?></textarea>
                </div>
                <button type="submit" name="save_about" class="btn btn-primary px-5 rounded-pill fw-bold">Save Changes</button>
            </form>
        </div>
    </div>
</body>
</html>