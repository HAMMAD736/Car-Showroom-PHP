<?php
session_start();
include 'db.php';

if (isset($_POST['login'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    $sql = "SELECT * FROM admins WHERE username='$user'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($pass, $row['password'])) {
            $_SESSION['admin_logged_in'] = true;
            header("Location: admin.php"); // Sahi password par Admin page khulega
            exit();
        } else {
            echo "Ghalat Password!";
        }
    } else {
        echo "Username nahi mila.";
    }
}
?>

<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; text-align: center; padding: 50px;">
    <h2>Admin Login</h2>
    <form method="POST" style="display: inline-block; background: #ddd; padding: 20px; border-radius: 10px;">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        <button type="submit" name="login">Login</button>
        <br><br>
        <a href="register.php">Create New Account</a>
    </form>
</body>
</html>