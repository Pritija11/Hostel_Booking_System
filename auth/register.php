<?php
require "../config/db.php";
$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $first_name = trim($_POST["first_name"]);
    $last_name  = trim($_POST["last_name"]);
    $email      = trim($_POST["email"]);
    $phone      = trim($_POST["phone"]);
    $password   = $_POST["password"];


    if (!$first_name || !$last_name || !$email || !$phone || !$password) {
        $message = "All fields are required.";
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $message = "Invalid email format!";
    } elseif (substr($email, -10) !== "@gmail.com") {
        $message = "Email must end with @gmail.com!";
    }elseif (!preg_match("/^[0-9]{10}$/", $phone)) {
    $message = "Phone number must contain only digits (10-15 digits).";
    } elseif (strlen($password) < 6) {
        $message = "Password must be at least 6 characters.";

    } else {
        try {
            
            $stmt = $conn->prepare("SELECT id FROM register WHERE email = ?");
            $stmt->execute([$email]);
            if ($stmt->fetch()) {
                $message = "Email is already registered.";
            } else {
                
                $stmt = $conn->prepare("SELECT id FROM register WHERE phone = ?");
                $stmt->execute([$phone]);
                if ($stmt->fetch()) {
                    $message = "Phone number is already registered.";
                } else {
                    
                    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
                    $stmt = $conn->prepare("INSERT INTO register (first_name, last_name, email, phone, password) VALUES (?, ?, ?, ?, ?)");
                    $stmt->execute([$first_name, $last_name, $email, $phone, $hashedPassword]);

                    
                    header("Location: ../auth/login.php");
                    exit;
                }
            }
        } catch (PDOException $e) {
            $message = "Database error: " . $e->getMessage();
        }
    }
}
?>

<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../assets/css/header.css">
<link rel="stylesheet" href="../assets/css/footer.css">
<link rel="stylesheet" href="../assets/css/register.css">

<main>
    <section class="register-section">
        <h2>Register</h2>

        <?php if ($message): ?>
            <p class="error"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" class="register-form" action="">
            <label for="first_name">First Name</label>
            <input type="text" id="first_name" name="first_name" placeholder="Enter your first name" required>

            <label for="last_name">Last Name</label>
            <input type="text" id="last_name" name="last_name" placeholder="Enter your last name" required>

            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Enter your email" required>
            

            <label for="phone">Phone Number</label>
            <input type="text" id="phone" name="phone" placeholder="Enter your phone number" pattern="[0-9]{10}" required>
            

            <label for="password">Password</label>
            <input type="password" id="password" name="password" placeholder="Enter your password" required>
            
            <button type="submit">Register</button>
        </form>
    </section>
</main>

<?php include "../includes/footer.php"; ?>