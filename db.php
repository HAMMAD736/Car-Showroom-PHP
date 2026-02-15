<?php
// Aapke InfinityFree Account ki details
$host = "localhost"; // YAHAN wo Host Name paste karein jo Control Panel mein mila tha
$user = "if0_41146940";            // Yeh aapka username hai (Screenshot se liya)
$pass = "YOUR PASSWORD HERE";             // Yeh aapka password hai (Screenshot se liya)
$dbname = "if0_41146940_showroom"; // Yeh aapka naya database name hai

$conn = new mysqli($host, $user, $pass, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>