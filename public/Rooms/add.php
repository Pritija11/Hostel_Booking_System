<?php
session_start();
require "../../config/db.php";


if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

$message = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $room_type = trim($_POST['room_type']);
    $capacity  = trim($_POST['capacity']);

   
    if ($room_type === "" || $capacity === "") {
        $message = "All fields are required.";
    } elseif (!is_numeric($capacity) || $capacity < 1) {
        $message = "Capacity must be a valid number.";
    } else {
        $stmt = $conn->prepare(
            "INSERT INTO rooms (room_type, capacity) VALUES (?, ?)"
        );
        $stmt->execute([$room_type, $capacity]);

        header("Location: rooms.php");
        exit();
    }
}
?>

<?php include "../../includes/header.php"; ?>
<link rel="stylesheet" href="../../assets/css/add.css">
<link rel="stylesheet" href="../../assets/css/header.css">
<link rel="stylesheet" href="../../assets/css/footer.css">

<main >
    <section class="form-section">
        <h2>Add New Room</h2>

        <?php if ($message): ?>
            <p class="error"><?= htmlspecialchars($message) ?></p>
        <?php endif; ?>

        <form method="POST" class="room-form">
            <label>Room Type</label>
            <select name="room_type" required>
                <option value="">Select room type</option>
                <option value="Single">Single Seater</option>
                <option value="Double">Double Seater</option>
                <option value="Triple">Triple Seater</option>
            </select>

            <label>Capacity</label>
            <input type="number" name="capacity" placeholder="e.g. 1, 2, 3" required>

            <button type="submit">Add Room</button>
            <a href="rooms.php" class="back-btn">Cancel</a>
        </form>
    </section>
</main>

<?php include "../../includes/footer.php"; ?>
