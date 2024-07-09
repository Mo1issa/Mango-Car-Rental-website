<?php
// cars_inquire.php
session_start();
if (!isset($_SESSION['user_role']) || $_SESSION['user_role'] != 'manager') {
    die("Unauthorized access");
}

require 'db.inc.php';

$conditions = [];
$params = [];
$types = '';

if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
    $conditions[] = '(r.start_date BETWEEN ? AND ? OR r.end_date BETWEEN ? AND ?)';
    $params[] = $_GET['from_date'];
    $params[] = $_GET['to_date'];
    $params[] = $_GET['from_date'];
    $params[] = $_GET['to_date'];
    $types .= 'ssss';
}

if (!empty($_GET['pickup_location_id'])) {
    $conditions[] = 'r.pickup_location_id = ?';
    $params[] = $_GET['pickup_location_id'];
    $types .= 'i';
}

if (!empty($_GET['return_date'])) {
    $conditions[] = 'r.end_date = ?';
    $params[] = $_GET['return_date'];
    $types .= 's';
}

if (!empty($_GET['return_location_id'])) {
    $conditions[] = 'r.return_location_id = ?';
    $params[] = $_GET['return_location_id'];
    $types .= 'i';
}

if (!empty($_GET['state'])) {
    $conditions[] = 'r.state = ?';
    $params[] = $_GET['state'];
    $types .= 's';
}

$sql = "SELECT c.id, c.type, c.model, c.description, c.photos, c.fuel_type, r.state 
        FROM cars c
        LEFT JOIN rentals r ON c.id = r.car_id 
        WHERE " . implode(' AND ', $conditions);

$stmt = $conn->prepare($sql);
if (!empty($conditions)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

echo "<table>";
echo "<tr><th>Car ID</th><th>Type</th><th>Model</th><th>Description</th><th>Photo</th><th>Fuel Type</th><th>Status</th></tr>";

while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>{$row['id']}</td>";
    echo "<td>{$row['type']}</td>";
    echo "<td>{$row['model']}</td>";
    echo "<td>{$row['description']}</td>";
    echo "<td><img src='{$row['photos']}' alt='Car Photo'></td>";
    echo "<td>{$row['fuel_type']}</td>";
    echo "<td>{$row['state']}</td>";
    echo "</tr>";
}

echo "</table>";

$stmt->close();
$conn->close();
?>
