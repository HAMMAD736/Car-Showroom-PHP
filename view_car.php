<?php 
include 'db.php'; 

// 1. Check karein ke URL mein ID aayi hai ya nahi (e.g., view_car.php?id=5)
if(isset($_GET['id'])) {
    $id = $_GET['id'];
    
    // 2. Main Car ki details layen
    $sql = "SELECT * FROM cars WHERE id = $id";
    $result = $conn->query($sql);
    
    // Agar car mil gayi to data variable mein rakhein
    if($result->num_rows > 0) {
        $car = $result->fetch_assoc();
    } else {
        // Agar ID ghalat hai to Home page par bhej dein
        header("Location: index.php");
        exit();
    }
} else {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $car['model_name']; ?> - Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        
        /* Main Image Style */
        .main-img { 
            width: 100%; 
            height: 400px; 
            object-fit: cover; 
            border-radius: 10px; 
            box-shadow: 0 5px 15px rgba(0,0,0,0.1); 
            border: 1px solid #ddd;
        }

        /* Thumbnails Style */
        .thumb-img { 
            width: 100%; 
            height: 80px; 
            object-fit: cover; 
            border-radius: 5px; 
            cursor: pointer; 
            opacity: 0.7; 
            transition: 0.3s; 
            border: 2px solid transparent;
        }
        .thumb-img:hover { 
            opacity: 1; 
            border-color: #007bff; /* Blue border on hover */
        }
        
        .contact-box { background: white; padding: 25px; border-radius: 10px; box-shadow: 0 4px 10px rgba(0,0,0,0.05); }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-dark mb-4">
        <div class="container">
            <a class="navbar-brand" href="index.php">🏎️ Super Cars Showroom</a>
            <a href="index.php" class="btn btn-outline-light btn-sm">← Back to Home</a>
        </div>
    </nav>

    <div class="container mt-5">
        <div class="row">
            
            <div class="col-md-7">
                <img src="uploads/<?php echo $car['image_url']; ?>" class="main-img mb-3" id="mainImage">
                
                <div class="row g-2">
                    <div class="col-3">
                        <img src="uploads/<?php echo $car['image_url']; ?>" class="thumb-img" onclick="changeImage(this)">
                    </div>

                    <?php
                    // Ab Database se extra photos mangwate hain (car_images table se)
                    $sql_gallery = "SELECT * FROM car_images WHERE car_id = $id";
                    $result_gallery = $conn->query($sql_gallery);

                    if ($result_gallery->num_rows > 0) {
                        while($row_img = $result_gallery->fetch_assoc()) {
                            $galleryPath = "uploads/" . $row_img['image_path'];
                            // Sirf tab dikhaye agar file server par maujood ho
                            if(file_exists($galleryPath)){
                    ?>
                        <div class="col-3">
                            <img src="<?php echo $galleryPath; ?>" class="thumb-img" onclick="changeImage(this)">
                        </div>
                    <?php
                            }
                        }
                    }
                    ?>
                </div>
            </div>

            <div class="col-md-5">
                <h1 class="fw-bold"><?php echo $car['model_name']; ?></h1>
                <h2 class="text-success mb-3 fw-bold"><?php echo $car['price']; ?></h2>
                
                <p class="text-muted">
                    This car is in excellent condition. Engine, interior, and exterior are well maintained. 
                    Certified by Super Cars Showroom.
                </p>
                
                <ul class="list-group mb-4">
                    <li class="list-group-item">✔️ **Verified Seller**</li>
                    <li class="list-group-item">✔️ **Original Documents**</li>
                    <li class="list-group-item">✔️ **Biometric Available**</li>
                </ul>

                <div class="contact-box">
                    <h4>Interested? Contact Seller</h4>
                    <p class="small text-muted">Fill this form to chat on WhatsApp directly.</p>
                    
                    <form action="https://wa.me/923001234567" method="get" target="_blank">
                        <div class="mb-2">
                            <label>Your Name</label>
                            <input type="text" class="form-control" placeholder="Ali Khan" required>
                        </div>
                        
                        <div class="mb-3">
                            <label>Message</label>
                            <textarea name="text" class="form-control" rows="3">Hi, I am interested in your <?php echo $car['model_name']; ?> (Price: <?php echo $car['price']; ?>). Is it available?</textarea>
                        </div>

                        <button type="submit" class="btn btn-success w-100 fw-bold">
                            Chat on WhatsApp 💬
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <p class="mb-0">© 2026 Super Cars Showroom.</p>
        </div>
    </footer>

    <script>
        // Yeh function choti image ka source le kar badi image mein daal deta hai
        function changeImage(element) {
            var mainImg = document.getElementById('mainImage');
            mainImg.src = element.src;
        }
    </script>

</body>
</html>