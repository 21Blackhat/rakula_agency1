<?php
include 'db_config.php';

// Simple security check (Check if user is admin)
if ($_SESSION['role'] !== 'admin') { header("Location: index.php"); exit(); }

// Logic to update status
if (isset($_GET['update_id'])) {
    $id = $_GET['update_id'];
    $status = $_GET['status'];
    mysqli_query($conn, "UPDATE orders SET status='$status' WHERE id=$id");
    header("Location: admin_orders.php");
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard | Rakula Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container-fluid py-4">
        <h2 class="fw-bold mb-4">Incoming Orders</h2>
        
        <div class="card border-0 shadow-sm">
            <div class="table-responsive">
                <table class="table align-middle">
                    <thead class="table-dark">
                        <tr>
                            <th>Order ID</th>
                            <th>Customer</th>
                            <th>Contact</th>
                            <th>Location/Fee</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $orders = mysqli_query($conn, "SELECT * FROM orders ORDER BY created_at DESC");
                        while($row = mysqli_fetch_assoc($orders)):
                            $badge = ($row['status'] == 'Pending') ? 'bg-danger' : (($row['status'] == 'Delivered') ? 'bg-success' : 'bg-warning');
                        ?>
                        <tr>
                            <td>#<?php echo $row['id']; ?></td>
                            <td class="fw-bold"><?php echo $row['customer_name']; ?></td>
                            <td><a href="tel:<?php echo $row['phone']; ?>" class="btn btn-sm btn-outline-primary"><?php echo $row['phone']; ?></a></td>
                            <td><?php echo $row['location']; ?></td>
                            <td class="fw-bold text-primary">KES <?php echo number_format($row['total_amount'], 2); ?></td>
                            <td><span class="badge <?php echo $badge; ?>"><?php echo $row['status']; ?></span></td>
                            <td>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-secondary dropdown-toggle" data-bs-toggle="dropdown">Change Status</button>
                                    <ul class="dropdown-menu">
                                        <li><a class="dropdown-item" href="admin_orders.php?update_id=<?php echo $row['id']; ?>&status=Processing">Processing</a></li>
                                        <li><a class="dropdown-item" href="admin_orders.php?update_id=<?php echo $row['id']; ?>&status=Delivered">Delivered</a></li>
                                    </ul>
                                </div>
                            </td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>