<?php
session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}
include 'db.php'; 
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">

    <nav class="navbar navbar-danger bg-danger navbar-dark mb-4">
        <div class="container">
            <span class="navbar-brand">🔒 Admin Panel</span>
            <div class="d-flex align-items-center">
                <a href="index.php" class="btn btn-light btn-sm me-2">View Website</a>
                <a href="logout.php" class="btn btn-warning btn-sm">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-primary text-white">
                        <h4>Add New Car & Gallery</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST" enctype="multipart/form-data">
                            
                            <div class="mb-3">
                                <label>Car Model Name</label>
                                <input type="text" name="model" class="form-control" placeholder="Toyota Civic 2024" required>
                            </div>
                            
                            <div class="mb-3">
                                <label>Price</label>
                                <input type="text" name="price" class="form-control" placeholder="PKR 5,000,000" required>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold">Main Photo (Thumbnail)</label>
                                <input type="file" name="main_image" class="form-control" required>
                            </div>

                            <div class="mb-3">
                                <label class="fw-bold">Gallery Photos (Select Multiple)</label>
                                <input type="file" name="gallery_images[]" class="form-control" multiple>
                                <small class="text-muted">Ctrl daba kar multiple photos select karein.</small>
                            </div>

                            <button type="submit" name="submit" class="btn btn-success w-100">Upload Car</button>
                        </form>

                        <?php
                        if (isset($_POST['submit'])) {
                            $model = $_POST['model'];
                            $price = $_POST['price'];

                            // 1. Upload Main Image
                            $mainImgName = $_FILES['main_image']['name'];
                            $targetMain = "uploads/" . basename($mainImgName);
                            move_uploaded_file($_FILES['main_image']['tmp_name'], $targetMain);

                            // 2. Insert Car Info
                            $sql = "INSERT INTO cars (model_name, price, image_url) VALUES ('$model', '$price', '$mainImgName')";
                            
                            if ($conn->query($sql) === TRUE) {
                                $last_car_id = $conn->insert_id; // Abhi jo car bani, uski ID pakdo

                                // 3. Upload Gallery Images (Loop)
                                $count = count($_FILES['gallery_images']['name']);
                                for ($i = 0; $i < $count; $i++) {
                                    $galleryName = $_FILES['gallery_images']['name'][$i];
                                    
                                    if($galleryName != "") { // Agar file select hui hai
                                        $targetGallery = "uploads/" . basename($galleryName);
                                        move_uploaded_file($_FILES['gallery_images']['tmp_name'][$i], $targetGallery);

                                        // Save to 'car_images' table
                                        $conn->query("INSERT INTO car_images (car_id, image_path) VALUES ('$last_car_id', '$galleryName')");
                                    }
                                }
                                echo "<div class='alert alert-success mt-3'>Car & Gallery Uploaded!</div>";
                            } else {
                                echo "<div class='alert alert-danger mt-3'>Error: " . $conn->error . "</div>";
                            }
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container mt-5 mb-5">
    <h3 class="text-center mb-4">Manage Inventory</h3>
    <table class="table table-bordered table-striped bg-white">
        <thead class="table-dark">
            <tr>
                <th>Photo</th>
                <th>Car Name</th>
                <th>Price</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php
            // Database se saari cars mangwayen
            $sql = "SELECT * FROM cars ORDER BY id DESC";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
            ?>
                <tr>
                    <td><img src="uploads/<?php echo $row['image_url']; ?>" width="80" height="50" style="object-fit:cover;"></td>
                    <td><?php echo $row['model_name']; ?></td>
                    <td class="text-success fw-bold"><?php echo $row['price']; ?></td>
                    <td>
                        <a href="edit_car.php?id=<?php echo $row['id']; ?>" class="btn btn-primary btn-sm">Edit Price ✏️</a>
                        
                        <a href="delete_car.php?id=<?php echo $row['id']; ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this car?');">Delete 🗑️</a>
                    </td>
                </tr>
            <?php
                }
            } else {
                echo "<tr><td colspan='4' class='text-center'>No cars found.</td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>
</body>
</html>