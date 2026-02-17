<?php include 'db_config.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <title>Site Activity | Rakula</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container py-5">
        <a href="admin.php" class="btn btn-outline-secondary mb-4">Back to Dashboard</a>
        
        <div class="row g-4">
            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4 text-center">
                    <h5 class="text-muted mb-3">Total Site Visits</h5>
                    <?php
                    $v = mysqli_fetch_assoc(mysqli_query($conn, "SELECT visit_count FROM site_stats WHERE id = 1"));
                    ?>
                    <h1 class="display-3 fw-bold text-primary"><?php echo $v['visit_count']; ?></h1>
                    <p class="text-muted">Unique sessions tracked</p>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card border-0 shadow-sm p-4">
                    <h5 class="fw-bold mb-3">Inventory Health</h5>
                    <ul class="list-group list-group-flush">
                        <?php
                        $in = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products WHERE stock_status='In Stock'"))['count'];
                        $out = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) as count FROM products WHERE stock_status='Out of Stock'"))['count'];
                        ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Items Available <span class="badge bg-success rounded-pill"><?php echo $in; ?></span>
                        </li>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            Out of Stock <span class="badge bg-danger rounded-pill"><?php echo $out; ?></span>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</body>
</html>