<?php
require "../../config/session.php";
require "../../config/db.php";

if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$stmt = $conn->query("SELECT * FROM rooms ");
$rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<?php include "../../includes/header.php"; ?>
<link rel="stylesheet" href="../../assets/css/rooms.css">
<link rel="stylesheet" href="../../assets/css/header.css">
<link rel="stylesheet" href="../../assets/css/footer.css">

<main>
    <section class="rooms-section">
        <h1>Manage Rooms</h1>

        <a href="add.php" class="btn-add">+ Add Room</a>

        <table class="rooms-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Room Type</th>
                    <th>Capacity</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>
            <?php if (count($rooms) > 0): ?>
                <?php foreach ($rooms as $room): ?>
                    <tr>
                        <td><?= htmlspecialchars($room['id']) ?></td>
        
                        <td><?= htmlspecialchars($room['room_type']) ?></td>
                        <td><?= htmlspecialchars($room['capacity']) ?></td>
                        
                        <td class="<?= strtolower(htmlspecialchars($room['status'])) ?>">
                            <?= htmlspecialchars($room['status']) ?>
                        </td>
                        
                        <td>
                            <a href="edit.php?id=<?= (int)($room['id']) ?>" class="btn edit">Edit</a>
                            <a href="delete.php?id=<?= (int)($room['id']) ?>" class="btn delete" onclick="return confirm('Are you sure?')">Delete</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="5">No rooms added yet.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </section>
</main>

<?php include "../../includes/footer.php"; ?>
