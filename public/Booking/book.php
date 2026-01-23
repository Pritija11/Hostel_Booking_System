<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}


$stmt = $conn->query("SELECT DISTINCT room_type FROM rooms");
$types = $stmt->fetchAll(PDO::FETCH_ASSOC);

$message = "";
?>
<?php include "../../includes/header.php"; ?>
<link rel="stylesheet" href="../../assets/css/booking.css">
<link rel="stylesheet" href="../../assets/css/header.css">
<link rel="stylesheet" href="../../assets/css/footer.css">


<main >
<section class="form-section">
    <h2>Book a Room</h2>

    <?php if ($message): ?>
        <p class="error"><?= htmlspecialchars($message) ?></p>
    <?php endif; ?>

    <form method="POST" action="process_booking.php" id="bookingForm">
        
        <label>Room Type</label>
        <select name="room_type" id="roomType" required>
            <option value="">Select Room Type</option>
            <option value="Single">Single Seater</option>
            <option value="Double">Double Seater</option>
            <option value="Triple">Triple Seater</option>
        </select>

        <label>Check-in Date</label>
        <input type="date" name="check_in" required>

        <label>Check-out Date</label>
        <input type="date" name="check_out" required>

        <p id="availability"></p>

        <button type="submit">Book Room</button>
    </form>
</section>
</main>

<script src="../../assets/js/booking.js"></script>
<?php include "../../includes/footer.php"; ?>
