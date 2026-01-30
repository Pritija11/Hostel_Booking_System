<?php
require "../../config/session.php";
require "../../config/csrf.php";
require "../../config/db.php";

if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
    header("Location: ../auth/login.php");
    exit();
}

$room_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;


if ($room_id <= 0) {
    header("Location: rooms.php");
    exit();
}



$message = "";


$stmt = $conn->prepare("SELECT * FROM rooms WHERE id = ?");
$stmt->execute([$room_id]);
$room = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$room) {
    die("Room not found.");
}


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    verify_csrf();

    $room_type = filter_input(INPUT_POST, 'room_type', FILTER_SANITIZE_SPECIAL_CHARS);
    $status    = filter_input(INPUT_POST, 'status', FILTER_SANITIZE_SPECIAL_CHARS);
    $capacity  = filter_input(INPUT_POST, 'capacity', FILTER_SANITIZE_NUMBER_INT);
    $room_type = trim($room_type);
    $status    = trim($status);
    $capacity  = trim($capacity);
    
    if (!$room_type || !$capacity || !$status || $capacity < 1) {
        $message = "Please enter valid values for all fields.";
    } else {
        
        $stmt = $conn->prepare("UPDATE rooms SET room_type = ?, capacity = ?, status = ? WHERE id = ?");
        if ($stmt->execute([$room_type, $capacity, $status, $room_id])) {
            header("Location: rooms.php");
            exit;
        } else {
            $message = "Error updating room.";
        }
    }
}
?>

<?php include "../../includes/header.php"; ?>
<link rel="stylesheet" href="../../assets/css/edit.css">
<link rel="stylesheet" href="../../assets/css/header.css">
<link rel="stylesheet" href="../../assets/css/footer.css">

<main>
    <section class="form-section">
        <h2>Update Room</h2>

        <form method="POST">
            <input type="hidden" name="csrf_token" value="<?= csrf_token() ?>">
            <div class="form-group">
                <label for="room_type">Room Type</label>
                <select id="room_type" name="room_type" required>
                    <option value="">Select Room Type</option>
                    <option value="Single" <?= $room['room_type']=='Single'?'selected':'' ?>>Single</option>
                    <option value="Double" <?= $room['room_type']=='Double'?'selected':'' ?>>Double</option>
                    <option value="Triple" <?= $room['room_type']=='Triple'?'selected':'' ?>>Triple</option>
                </select>
            </div><br>

            <div class="form-group">
                <label for="capacity">Capacity</label>
                <input type="number" id="capacity" name="capacity" min="1" value="<?= htmlspecialchars($room['capacity']) ?>" required>
            </div><br>

            <div class="form-group">
                <label for="status">Status</label>
                <select id="status" name="status" required>
                    <option value="">Select Status</option>
                    <option value="Available" <?= $room['status']=='Available'?'selected':'' ?>>Available</option>
                    <option value="Booked" <?= $room['status']=='Booked'?'selected':'' ?>>Booked</option>
                </select>
            </div><br>

            <button type="submit">Update Room</button>
        </form>

        <p id="msg"><?= htmlspecialchars($message) ?></p>
    </section>
</main>

<?php include "../../includes/footer.php"; ?>
