<?php
session_start();


require 'db.inc.php';
$pdo = db_connect();

$stmt = $pdo->prepare("
    SELECT rentals.*, customers.name AS customer_name, cars.model AS car_model
    FROM rentals
    JOIN customers ON rentals.customer_id = customers.id
    JOIN cars ON rentals.car_id = cars.id
");
$stmt->execute();
$rentals = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Rentals</title>
    <link rel="shortcut icon" type="x-icon" href="file.jpg">
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <nav class="main-nav">
        <ul>
                <li><a href="add_car.php" class="button">Add Car</a></li>
                <li><a href="view_cars.php" class="button">View Cars</a></li>
                <li><a href="view_rentals.php" class="button">View Rentals</a></li>
                <li><a href="add_location.php" class="button">Add location</a></li>
            </ul>
        </nav>
    <main>
        <h1>View Rentals</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Car</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Pickup Location</th>
                <th>Return Location</th>
                <th>Special Requirements</th>
                <th>Total Amount</th>
                <th>Invoice ID</th>
                <th>Invoice Date</th>
                <th>State</th>
                <th>Pickup Location ID</th>
                <th>Return Location ID</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($rentals as $rental): ?>
                <tr>
                    <td><?= htmlspecialchars($rental['id']) ?></td>
                    <td><?= htmlspecialchars($rental['customer_name']) ?></td>
                    <td><?= htmlspecialchars($rental['car_model']) ?></td>
                    <td><?= htmlspecialchars($rental['start_date']) ?></td>
                    <td><?= htmlspecialchars($rental['end_date']) ?></td>
                    <td><?= htmlspecialchars($rental['pickup_location']) ?></td>
                    <td><?= htmlspecialchars($rental['return_location']) ?></td>
                    <td><?= htmlspecialchars($rental['special_requirements']) ?></td>
                    <td><?= htmlspecialchars($rental['total_amount']) ?></td>
                    <td><?= htmlspecialchars($rental['invoice_id']) ?></td>
                    <td><?= htmlspecialchars($rental['invoice_date']) ?></td>
                    <td><?= htmlspecialchars($rental['state']) ?></td>
                    <td><?= htmlspecialchars($rental['pickup_location_id']) ?></td>
                    <td><?= htmlspecialchars($rental['return_location_id']) ?></td>
                    <td>
                        <a href="edit_car.php?id=<?= htmlspecialchars($rental['id']) ?>" class="Button">Edit</a>
                        <a href="delete_car.php?id=<?= htmlspecialchars($rental['id']) ?>" onclick="return confirm('Are you sure you want to delete this rental?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
