<?php
include 'db_config.php';

// Handle Deletion
if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    mysqli_query($conn, "DELETE FROM products WHERE id = $id");
    header("Location: add_product.php");
}

// Handle Addition
if (isset($_POST['add_product'])) {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $price = $_POST['price'];
    $category = $_POST['category'];
    $image = $_FILES['image']['name'];
    $target = "uploads/" . basename($image);

    $sql = "INSERT INTO products (name, price, image, category) VALUES ('$name', '$price', '$image', '$category')";
    if (mysqli_query($conn, $sql)) {
        move_uploaded_file($_FILES['image']['tmp_name'], $target);
        echo "<script>alert('Product Added Successfully!');</script>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rakula Admin | Product Management</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

<div class="container py-5">
    <div class="row">
        <div class="col-lg-4">
            <div class="card shadow-sm border-0 mb-4">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Add New Drink</h5>
                    <form action="" method="POST" enctype="multipart/form-data" id="productForm">
                        <div class="mb-3">
                            <label class="form-label">Product Name</label>
                            <input type="text" name="name" class="form-control" placeholder="e.g. Highland Water" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Category</label>
                            <select name="category" class="form-select">
                                <option value="Milk">Milk</option>
                                <option value="Water">Water</option>
                                <option value="Drink">Other Drinks</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Price (KES)</label>
                            <input type="number" name="price" class="form-control" required>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Product Image</label>
                            <input type="file" name="image" class="form-control" id="imgInput" accept="image/*" required>
                            <img id="preview" class="mt-2 d-none" style="width: 100%; height: 150px; object-fit: contain;">
                        </div>
                        <button type="submit" name="add_product" class="btn btn-primary w-100">Upload Product</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-8">
            <div class="card shadow-sm border-0">
                <div class="card-body">
                    <h5 class="fw-bold mb-3">Existing Inventory</h5>
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead class="table-dark">
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $query = mysqli_query($conn, "SELECT * FROM products ORDER BY id DESC");
                                while ($row = mysqli_fetch_assoc($query)) {
                                    echo "<tr>
                                        <td><img src='uploads/{$row['image']}' width='50'></td>
                                        <td>{$row['name']}</td>
                                        <td>KES {$row['price']}</td>
                                        <td>
                                            <a href='?delete={$row['id']}' class='btn btn-sm btn-danger' onclick='return confirmDelete()'>Delete</a>
                                        </td>
                                    </tr>";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// JS for Image Preview
document.getElementById('imgInput').onchange = evt => {
    const [file] = document.getElementById('imgInput').files;
    if (file) {
        const preview = document.getElementById('preview');
        preview.src = URL.createObjectURL(file);
        preview.classList.remove('d-none');
    }
}

// JS for Delete Confirmation
function confirmDelete() {
    return confirm("Are you sure you want to remove this product?");
}
</script>
</body>
</html>