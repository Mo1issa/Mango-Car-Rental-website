<?php
session_start();

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'manager') {
    header('Location: login.php');
    exit;
}

require 'db.inc.php';
$pdo = db_connect();

$stmt = $pdo->prepare("SELECT * FROM locations");
$stmt->execute();
$locations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Locations</title>
    <link rel="shortcut icon" type="x-icon" href="file.jpg">
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>View Locations</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Property Number</th>
                <th>Street Name</th>
                <th>City</th>
                <th>Postal Code</th>
                <th>Country</th>
                <th>Telephone</th>
            </tr>
            <?php foreach ($locations as $location): ?>
                <tr>
                    <td><?= htmlspecialchars($location['location_id']) ?></td>
                    <td><?= htmlspecialchars($location['name']) ?></td>
                    <td><?= htmlspecialchars($location['property_number']) ?></td>
                    <td><?= htmlspecialchars($location['street_name']) ?></td>
                    <td><?= htmlspecialchars($location['city']) ?></td>
                    <td><?= htmlspecialchars($location['postal_code']) ?></td>
                    <td><?= htmlspecialchars($location['country']) ?></td>
                    <td><?= htmlspecialchars($location['telephone']) ?></td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
