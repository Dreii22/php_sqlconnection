<?php
include 'db.php';
include 'log_action.php';

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $password = $_POST['password'];
    $confirm = $_POST['confirm'];

    if ($password !== $confirm) {
        echo "<p style='color:red;'>Passwords do not match!</p>";
    } else {
        $hashed = password_hash($password, PASSWORD_DEFAULT);
        $check = $conn->query("SELECT * FROM auth_users WHERE email='$email' OR username='$username'");

        if ($check->num_rows > 0) {
            echo "<p style='color:red;'>User already exists!</p>";
        } else {
            $sql = "INSERT INTO auth_users (username, email, password) VALUES ('$username', '$email', '$hashed')";
            if ($conn->query($sql)) {
                // Log registration
                $user_id = $conn->insert_id;
                logAction($conn, $user_id, "User registered an account");

                echo "<p style='color:green;'>Registration successful! <a href='login.php'>Login here</a></p>";
            } else {
                echo "<p style='color:red;'>Error: " . $conn->error . "</p>";
            }
        }
    }
}
?>

<h2>Register</h2>
<form method="POST" action="">
    <input type="text" name="username" placeholder="Username" required><br><br>
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <input type="password" name="confirm" placeholder="Confirm Password" required><br><br>
    <input type="submit" name="register" value="Register">
</form>

<p>Already have an account? <a href="login.php">Login</a></p>
