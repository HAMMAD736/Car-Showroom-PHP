<?php
include 'db.php'; // Aapka purana connection use hoga

$secret_code = "BOSS123"; // Yahan apna Secret Code badal sakte hain
$message = "";

if (isset($_POST['register'])) {
    $user = $_POST['username'];
    $pass = $_POST['password'];
    $code = $_POST['code'];

    if ($code === $secret_code) {
        // Password ko lock (hash) kar rahe hain security ke liye
        $hashed_password = password_hash($pass, PASSWORD_DEFAULT);
        
        $sql = "INSERT INTO admins (username, password) VALUES ('$user', '$hashed_password')";
        
        if ($conn->query($sql) === TRUE) {
            $message = "<p style='color:green;'>Account Ban Gaya! <a href='login.php'>Ab Login Karein</a></p>";
        } else {
            $message = "<p style='color:red;'>Error: Username pehle se maujood hai.</p>";
        }
    } else {
        $message = "<p style='color:red;'>Ghalat Secret Code!</p>";
    }
}
?>

<!DOCTYPE html>
<html>
<body style="font-family: sans-serif; text-align: center; padding: 50px;">
    <h2>Admin Registration</h2>
    <?php echo $message; ?>
    <form method="POST" style="display: inline-block; text-align: left; background: #eee; padding: 20px; border-radius: 10px;">
        Username: <input type="text" name="username" required><br><br>
        Password: <input type="password" name="password" required><br><br>
        Secret Code: <input type="text" name="code" required><br><br>
        <button type="submit" name="register">Register</button>
    </form>
</body>
</html>