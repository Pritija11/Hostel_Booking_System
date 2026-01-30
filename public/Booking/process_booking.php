<?php

require "../../config/db.php";

$full_name = filter_input(INPUT_POST, 'full_name', FILTER_SANITIZE_SPECIAL_CHARS);
$email     = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);

$type     = filter_input(INPUT_POST, 'room_type', FILTER_SANITIZE_SPECIAL_CHARS);
$check_in = filter_input(INPUT_POST, 'check_in', FILTER_SANITIZE_SPECIAL_CHARS);
$check_out= filter_input(INPUT_POST, 'check_out', FILTER_SANITIZE_SPECIAL_CHARS);

if (!$full_name || !$email || !$type || !$check_in || !$check_out) {
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
    "INSERT INTO bookings (full_name, email, room_id, check_in, check_out)
     VALUES (?,?, ?, ?, ?)"
);
$stmt->execute([$full_name, $email, $room['id'], $check_in, $check_out]);


$stmt = $conn->prepare(
    "UPDATE rooms SET status = 'Booked' WHERE id = ?"
);
$stmt->execute([$room['id']]);

header("Location: book.php?status=success");
exit;
