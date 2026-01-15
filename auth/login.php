<?php
session_start(); 
require "../config/db.php";

$message = "";

// checking request method
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = trim($_POST["email"]);
    $password = $_POST["password"];

    // verifying if both email and password are entered
    if (!$email || !$password) {
        $message = "Please enter both email and password.";
    } else {
        // Fetch user from register table
        $stmt = $conn->prepare("SELECT * FROM register WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            // Store user info in session
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['first_name'] = $user['first_name'];
            $_SESSION['last_name'] = $user['last_name'];

            $message = "Login successful!";
            header("Location: ../public/dashboard.php"); // redirect to dashboard
            exit;
        } else {
            $message = "Invalid email or password.";
        }
    }
}
?>

<h2>Login Form</h2>
<form method="POST">
    <div class="form-group">
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" placeholder="Enter your Gmail" required>
    </div>
    <br>
    <div class="form-group">
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" placeholder="Enter your password" required>
    </div>
    <br>
    <button type="submit">Login</button>
</form>

<p><?= htmlspecialchars($message) ?></p>

