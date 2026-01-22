<?php
session_start();
require "../../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit;
}

$user_id  = $_SESSION['user_id'];
$type     = $_POST['room_type'] ?? "";
$check_in = $_POST['check_in'] ?? "";
$check_out= $_POST['check_out'] ?? "";

if (!$type || !$check_in || !$check_out) {
    die("All fields required");
}


$stmt = $conn->prepare(
    "SELECT id FROM rooms 
     WHERE room_type = ? AND status = 'Available' 
     ORDER BY id ASC LIMIT 1"
);
$stmt->execute([$type]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$room) {
    die("Room not available");
}


$stmt = $conn->prepare(
    "INSERT INTO bookings (user_id, room_id, check_in, check_out)
     VALUES (?, ?, ?, ?)"
);
$stmt->execute([$user_id, $room['id'], $check_in, $check_out]);


$stmt = $conn->prepare(
    "UPDATE rooms SET status = 'Booked' WHERE id = ?"
);
$stmt->execute([$room['id']]);

header("Location: ../dashboard.php");
exit;
