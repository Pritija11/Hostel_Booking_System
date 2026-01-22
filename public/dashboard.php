<?php
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}


$user_name = $_SESSION['full_name'] ?? 'User';
?>

<?php include "../includes/header.php"; ?>
<link rel="stylesheet" href="../assets/css/dashboard.css">

<section class="dashboard-section">
    <h1>Welcome, <?= htmlspecialchars($user_name) ?></h1>
    <p>Manage rooms and bookings from here</p>

    <div class="dashboard-cards">

        <a href="Rooms/rooms.php" class="dashboard-card">
            <i class="fas fa-bed"></i>
            <h3>Manage Rooms</h3>
            <p>Add, Edit, View or Delete rooms</p>
        </a>

        <a href="Booking/book.php" class="dashboard-card">
            <i class="fas fa-calendar-check"></i>
            <h3>Book Room</h3>
            <p>Reserve an available room quickly</p>
        </a>

        <a href="Booking/view_bookings.php" class="dashboard-card">
            <i class="fas fa-list"></i>
            <h3>View Bookings</h3>
            <p>Check all booked rooms and details</p>
        </a>

        <a href="Booking/search.php" class="dashboard-card">
            <i class="fas fa-search"></i>
            <h3>Search Rooms</h3>
            <p>Search rooms by type or availability</p>
        </a>

    </div>
</section>

<?php include "../includes/footer.php"; ?>
