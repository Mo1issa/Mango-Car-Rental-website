<?php
session_start();

require 'db.inc.php';
$pdo = db_connect();

if (!isset($_GET['id'])) {
    header('Location: view_cars.php');
    exit;
}

$id = $_GET['id'];

// Fetch car details to get the photos
$stmt = $pdo->prepare("SELECT photo1, photo2, photo3 FROM cars WHERE id = :id");
$stmt->execute(['id' => $id]);
$car = $stmt->fetch();

if ($car) {
    // Delete the car record
    $stmt = $pdo->prepare("DELETE FROM cars WHERE id = :id");
    $stmt->execute(['id' => $id]);

    // Delete car images if they exist
    foreach (['photo1', 'photo2', 'photo3'] as $photo) {
        if (!empty($car[$photo])) {
            $filePath = 'images/' . $car[$photo];
            if (file_exists($filePath)) {
                unlink($filePath);
            }
        }
    }
}

header('Location: view_cars.php');
exit;
?>
