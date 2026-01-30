<?php
require "../../config/session.php";
require "../../config/db.php";


if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}


if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header("Location: rooms.php");
    exit();
}

$room_id = (int) $_GET['id'];


$stmt = $conn->prepare("DELETE FROM rooms WHERE id = ?");
$stmt->execute([$room_id]);


header("Location: rooms.php");
exit();
