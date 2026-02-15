<?php 
include 'db.php'; 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Super Cars Showroom</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body { background-color: #f8f9fa; }
        
        /* Card Styling & Hover Effect */
        .car-card { 
            transition: transform 0.3s ease, box-shadow 0.3s ease; 
            cursor: pointer; 
            text-decoration: none; 
            color: inherit; 
            border: none;
        }
        .car-card:hover { 
            transform: scale(1.03); 
            box-shadow: 0 10px 20px rgba(0,0,0,0.2); 
            z-index: 10;
        }
        .card-img-top { 
            height: 220px; 
            object-fit: cover; 
        }
        .price-tag {
            color: #28a745;
            font-weight: bold;
            font-size: 1.2rem;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-dark bg-dark mb-4 sticky-top">
        <div class="container">
            <a class="navbar-brand" href="index.php">🏎️ Super Cars Showroom</a>
            <a href="admin.php" class="btn btn-outline-light btn-sm">Admin Login</a>
        </div>
    </nav>

    <div class="container">
        
        <div class="row justify-content-center mb-5">
            <div class="col-md-6">
                <form action="" method="GET" class="input-group shadow-sm">
                    <input type="text" name="search" class="form-control" placeholder="Search car (e.g. Civic, Audi)..." 
                           value="<?php if(isset($_GET['search'])){echo $_GET['search']; } ?>">
                    <button type="submit" class="btn btn-primary">Search 🔎</button>
                    <?php if(isset($_GET['search'])): ?>
                        <a href="index.php" class="btn btn-secondary">Clear</a>
                    <?php endif; ?>
                </form>
            </div>
        </div>

        <h2 class="text-center mb-4">Latest Collection</h2>
        <div class="row">
            <?php
            // Search Logic
            if(isset($_GET['search'])) {
                $filtervalues = $_GET['search'];
                // LIKE command dhoondta hai milta julta naam
                $sql = "SELECT * FROM cars WHERE model_name LIKE '%$filtervalues%'";
            } else {
                // Agar search nahi kiya to sab dikhao
                $sql = "SELECT * FROM cars";
            }

            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $imagePath = "uploads/" . $row["image_url"];
                    // Agar image file nahi mili to placeholder lagayen
                    $checkImg = file_exists($imagePath) ? $imagePath : "https://via.placeholder.com/300x200?text=No+Image";
            ?>
                
                <div class="col-md-4 mb-4">
                    <a href="view_car.php?id=<?php echo $row['id']; ?>" class="card car-card h-100 shadow-sm">
                        <img src="<?php echo $checkImg; ?>" class="card-img-top" alt="Car Image">
                        <div class="card-body">
                            <h5 class="card-title fw-bold"><?php echo $row["model_name"]; ?></h5>
                            <p class="card-text text-muted small">Click to view details & contact seller.</p>
                            <p class="price-tag"><?php echo $row["price"]; ?></p>
                        </div>
                    </a>
                </div>

            <?php
                }
            } else {
                echo "<div class='col-12 text-center py-5'><h4 class='text-muted'>😞 No cars found matching your search.</h4></div>";
            }
            ?>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-3">
                    <h5 class="text-uppercase text-warning">Super Cars</h5>
                    <p class="small">We provide the best luxury cars in the city. Certified quality and best prices.</p>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="text-uppercase text-warning">Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="index.php" class="text-white text-decoration-none">Home</a></li>
                        <li><a href="admin.php" class="text-white text-decoration-none">Admin Login</a></li>
                    </ul>
                </div>
                <div class="col-md-4 mb-3">
                    <h5 class="text-uppercase text-warning">Contact Us</h5>
                    <p class="small">📍 Main Boulevard, Lahore<br>📞 +92 300 1234567</p>
                </div>
            </div>
            <hr>
            <p class="mb-0 small">© 2026 Super Cars Showroom. Developed by <strong>You</strong>.</p>
        </div>
    </footer>

</body>
</html>