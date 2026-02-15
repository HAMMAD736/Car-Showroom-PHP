<?php
session_start();
include 'db.php';

// Login Check
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

$id = $_GET['id'];
$message = "";

// Agar 'Update' button dabaya gaya ho
if (isset($_POST['update'])) {
    $name = $_POST['model_name'];
    $price = $_POST['price'];

    $sql = "UPDATE cars SET model_name='$name', price='$price' WHERE id=$id";
    if ($conn->query($sql) === TRUE) {
        header("Location: admin.php"); // Kaam ho gaya, wapis jao
        exit();
    } else {
        $message = "Error updating record: " . $conn->error;
    }
}

// Purana data layen taake form mein dikha sakein
$sql = "SELECT * FROM cars WHERE id = $id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="bg-light">
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-header bg-warning">
                        <h4>Edit Car Details</h4>
                    </div>
                    <div class="card-body">
                        <form method="POST">
                            <div class="mb-3">
                                <label>Car Model</label>
                                <input type="text" name="model_name" class="form-control" value="<?php echo $row['model_name']; ?>" required>
                            </div>
                            <div class="mb-3">
                                <label>Price</label>
                                <input type="text" name="price" class="form-control" value="<?php echo $row['price']; ?>" required>
                            </div>
                            <button type="submit" name="update" class="btn btn-success w-100">Update Now</button>
                            <a href="admin.php" class="btn btn-secondary w-100 mt-2">Cancel</a>
                        </form>
                        <p class="text-danger mt-2"><?php echo $message; ?></p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>