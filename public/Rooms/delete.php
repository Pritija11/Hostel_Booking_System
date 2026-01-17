<?php
require "../../config/db.php";
session_start();


if (!isset($_SESSION['user_id'])) {
    header("Location: ../../auth/login.php");
    exit();
}

// Validating ID
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: rooms.php");
    exit();
}

$room_id = (int) $_GET['id'];


$stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
$stmt->execute([$room_id]);


header("Location: rooms.php");
exit();
