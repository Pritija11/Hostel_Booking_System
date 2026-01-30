<?php
require "../config/session.php";
require "../config/csrf.php";
require "../config/db.php";

verify_csrf();
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
    $email = trim($email);
    $password = $_POST["password"];

    if (!$email || !$password) {
        $message = "Please enter both email and password.";
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['role'] = $user['role'];
            header("Location: ../public/dashboard.php");
            exit;
        } else {
            $message = "Invalid email or password.";
        }
    }
}
?>

<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../assets/css/header.css">
<link rel="stylesheet" href="../assets/css/footer.css">
<link rel="stylesheet" href="../assets/css/login.css">

<main>
    <section class="login-section">
        <h2>Login</h2>

        <form method="POST" class="login-form">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <label>Email</label>
            <input type="email" name="email" placeholder="Enter your Gmail" required>

            <label>Password</label>
            <input type="password" name="password" placeholder="Enter your password" required>

            <button type="submit">Login</button>
        </form>

        <?php if ($message): ?>
            <p class="error"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>
    </section>
</main>

<?php include "../includes/footer.php"; ?>
