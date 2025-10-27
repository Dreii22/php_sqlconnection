<?php
include 'db.php';
include 'log_action.php';
session_start();

if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, username, password FROM auth_users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();

        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];

            logAction($conn, $row['id'], "User logged in");

            header("Location: dashboard.php");
            exit;
        } else {
            logAction($conn, null, "Failed login attempt for email: $email");
            echo "<p style='color:red;'>Incorrect password!</p>";
        }
    } else {
        logAction($conn, null, "Login attempt with unknown email: $email");
        echo "<p style='color:red;'>No account found with that email!</p>";
    }

    $stmt->close();
}
?>

<h2>Login</h2>
<form method="POST" action="">
    <input type="email" name="email" placeholder="Email" required><br><br>
    <input type="password" name="password" placeholder="Password" required><br><br>
    <input type="submit" name="login" value="Login">
</form>

<p>Don’t have an account? <a href="register.php">Register</a></p>
