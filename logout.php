<?php
session_start();
session_destroy(); // Saare sessions khatam
header("Location: login.php"); // Wapis login page par
exit();
?>