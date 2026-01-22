<?php
require "../../config/db.php";

$type = $_GET['type'] ?? "";

$stmt = $conn->prepare(
    "SELECT COUNT(*) FROM rooms WHERE room_type = ? AND status = 'Available'"
);
$stmt->execute([$type]);
$count = $stmt->fetchColumn();

if ($count > 0) {
    echo "<span style='color:green;'>$count rooms available</span>";
} else {
    echo "<span style='color:red;'>No rooms available</span>";
}
