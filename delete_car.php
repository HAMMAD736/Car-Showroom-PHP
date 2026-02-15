<?php
session_start();
include 'db.php';

// Check: Admin login hai ya nahi?
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // 1. Pehle Images ke naam pata karo taake unhein folder se uda sakein
    $sql = "SELECT * FROM cars WHERE id = $id";
    $result = $conn->query($sql);
    $car = $result->fetch_assoc();
    
    // Main Image Delete karo
    $mainPath = "uploads/" . $car['image_url'];
    if (file_exists($mainPath)) {
        unlink($mainPath); // 'unlink' file ko delete karta hai
    }

    // Gallery Images Delete karo (Loop mein)
    $sql_gallery = "SELECT * FROM car_images WHERE car_id = $id";
    $res_gallery = $conn->query($sql_gallery);
    while($row_img = $res_gallery->fetch_assoc()) {
        $galleryPath = "uploads/" . $row_img['image_path'];
        if (file_exists($galleryPath)) {
            unlink($galleryPath);
        }
    }

    // 2. Ab Database se record udao (Images Table se)
    $conn->query("DELETE FROM car_images WHERE car_id = $id");

    // 3. Main Car Table se udao
    $conn->query("DELETE FROM cars WHERE id = $id");

    // Wapis Admin page par bhej do
    header("Location: admin.php");
    exit();
}
?>