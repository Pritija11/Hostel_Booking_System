<?php
require "../../config/session.php";
require "../../config/db.php";


if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}


$stmt = $conn->prepare("
    SELECT 
        bookings.id AS booking_id,
        bookings.full_name,
        rooms.room_type,
        rooms.capacity,
        bookings.check_in,
        bookings.check_out
    FROM bookings
    JOIN rooms ON bookings.room_id = rooms.id
    ORDER BY bookings.id DESC
");
$stmt->execute();
$bookings = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include "../../includes/header.php"; ?>
<link rel="stylesheet" href="../../assets/css/view_booking.css">
<link rel="stylesheet" href="../../assets/css/header.css">
<link rel="stylesheet" href="../../assets/css/footer.css">

<main class="page-wrapper">
    <section class="bookings-section">
        <h1>My Booked Rooms</h1>

        <table class="bookings-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Guest Name</th>
                    <th>Room Type</th>
                    <th>Capacity</th>
                    <th>Check-In</th>
                    <th>Check-Out</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($bookings): ?>
                    <?php foreach ($bookings as $b): ?>
                        <tr>
                            <td><?= htmlspecialchars($b['booking_id']) ?></td>
                            <td><?= htmlspecialchars($b['full_name']) ?></td>
                            <td><?= htmlspecialchars($b['room_type']) ?></td>
                            <td><?= htmlspecialchars($b['capacity']) ?></td>
                            <td><?= htmlspecialchars($b['check_in']) ?></td>
                            <td><?= htmlspecialchars($b['check_out']) ?></td>
                            <td>
                        <a href="delete_booking.php?id=<?= $b['booking_id'] ?>" 
                           class="btn-delete" 
                           onclick="return confirm('Delete this booking and make room available?')">
                           Delete
                        </a>
                    </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="5">No bookings found.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php include "../../includes/footer.php"; ?>
