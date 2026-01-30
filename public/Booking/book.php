<?php


require "../../config/db.php";

$stmt = $conn->query("SELECT DISTINCT room_type FROM rooms");
$types = $stmt->fetchAll(PDO::FETCH_ASSOC);

$message = "";
$message_type = "";
if (isset($_GET['status']) && $_GET['status'] === 'success') {
    $message = "Booking confirmed successfully!";
    $message_type = "success";
}

?>
<?php include "../../includes/header.php"; ?>
<link rel="stylesheet" href="../../assets/css/booking.css">
<link rel="stylesheet" href="../../assets/css/header.css">
<link rel="stylesheet" href="../../assets/css/footer.css">


<main >
<section class="form-section">
    <h2>Book a Room</h2>

    <?php if ($message): ?>
    <p class="<?= ($message_type === 'success') ? 'success-msg' : 'error' ?>">
        <?= htmlspecialchars($message) ?>
    </p>
    <?php endif; ?>

    <form method="POST" action="process_booking.php" id="bookingForm">

        <label>Full Name</label>
        <input type="text" name="full_name" placeholder="enter your full name" required>

        <label>Email</label>
        <input type="email" name="email" placeholder="enter email" required>

        
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
