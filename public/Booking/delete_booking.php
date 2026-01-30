<?php
require "../../config/db.php";

// 1. Get the ID of the booking we want to delete from the URL
$id = $_GET['id'];

// 2. Fetch the room_id associated with this booking 
// (We need this so we know which room to make 'Available' again)
$stmt = $conn->prepare("SELECT room_id FROM bookings WHERE id = ?");
$stmt->execute([$id]);
$booking = $stmt->fetch();

if ($booking) {
    $room_id = $booking['room_id'];

    // 3. Delete the record from the bookings table
    $del = $conn->prepare("DELETE FROM bookings WHERE id = ?");
    $del->execute([$id]);

    // 4. Update the room status back to 'Available' 
    // This allows new guests to book this room again
    $upd = $conn->prepare("UPDATE rooms SET status = 'Available' WHERE id = ?");
    $upd->execute([$room_id]);
}

// 5. Send the admin back to the view page
header("Location: view_bookings.php");
exit;
?>