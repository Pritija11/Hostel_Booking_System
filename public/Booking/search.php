<?php

require "../../config/db.php";

$room_type     = filter_input(INPUT_GET, 'room_type', FILTER_SANITIZE_SPECIAL_CHARS);
$capacity = filter_input(INPUT_GET, 'capacity', FILTER_SANITIZE_NUMBER_INT);
$status   = filter_input(INPUT_GET, 'status', FILTER_SANITIZE_SPECIAL_CHARS);

$rooms = []; 

if (!empty($_GET['room_type']) || !empty($_GET['capacity']) || !empty($_GET['status'])) {
    $query = "SELECT * FROM rooms WHERE 1";
    $params = [];

    if (!empty($_GET['room_type'])) {
        $query .= " AND room_type = ?";
        $params[] = $_GET['room_type'];
    }

    if (!empty($_GET['capacity'])) {
        $query .= " AND capacity >= ?";
        $params[] = (int) $_GET['capacity'];
    }

    if (!empty($_GET['status'])) {
        $query .= " AND status = ?";
        $params[] = $_GET['status'];
    }

    $stmt = $conn->prepare($query);
    $stmt->execute($params);
    $rooms = $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>

<?php include "../../includes/header.php"; ?>
<link rel="stylesheet" href="../../assets/css/header.css">
<link rel="stylesheet" href="../../assets/css/footer.css">
<link rel="stylesheet" href="../../assets/css/search.css">

<main>
    <section class="search-section">
        <h1>Search Rooms</h1>
        
        <form method="GET" class="search-form">
            <select name="room_type">
                <option value="">Any Type</option>
                <option value="Single">Single</option>
                <option value="Double">Double</option>
                <option value="Triple">Triple</option>
            </select>

            <input type="number" name="capacity" placeholder=" minimum capacity">

            <select name="status">
                <option value="">Any Status</option>
                <option value="Available">Available</option>
                <option value="Booked">Booked</option>
            </select>

            <button type="submit">Search</button>
        </form>

        <?php if (!empty($_GET)): ?> 
            <div class="table-container">
                <table class="rooms-table">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Room Type</th>
                            <th>Capacity</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if (count($rooms) > 0): ?>
                        <?php foreach ($rooms as $room): ?>
                        <tr>
                            <td><?= htmlspecialchars($room['id']) ?></td>
                            <td><?= htmlspecialchars($room['room_type']) ?></td>
                            <td><?= htmlspecialchars($room['capacity']) ?></td>
                            <td class="<?= strtolower($room['status']) ?>">
                                <?= htmlspecialchars($room['status']) ?>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr>
                            <td colspan="4">No rooms found.</td>
                        </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
    </section>
</main>

<?php include "../../includes/footer.php"; ?>