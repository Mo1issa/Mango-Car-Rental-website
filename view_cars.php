<?php
session_start();

require 'db.inc.php';
$pdo = db_connect();

$stmt = $pdo->prepare("SELECT * FROM cars");
$stmt->execute();
$cars = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <title>View Cars</title>
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
        <h1>View Cars</h1>
        <table>
            <tr>
                <th>ID</th>
                <th>Model</th>
                <th>Make</th>
                <th>Type</th>
                <th>Registration Year</th>
                <th>Description</th>
                <th>Price per Day</th>
                <th>Capacity (People)</th>
                <th>Capacity (Suitcases)</th>
                <th>Color</th>
                <th>Fuel Type</th>
                <th>Average Consumption</th>
                <th>Horsepower</th>
                <th>Length</th>
                <th>Width</th>
                <th>Gear Type</th>
                <th>Conditions</th>
                <th>Photos</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($cars as $car): ?>
                <tr>
                    <td><?= htmlspecialchars($car['id']) ?></td>
                    <td><?= htmlspecialchars($car['model']) ?></td>
                    <td><?= htmlspecialchars($car['make']) ?></td>
                    <td><?= htmlspecialchars($car['type']) ?></td>
                    <td><?= htmlspecialchars($car['registration_year']) ?></td>
                    <td><?= htmlspecialchars($car['description']) ?></td>
                    <td><?= htmlspecialchars($car['price_per_day']) ?></td>
                    <td><?= htmlspecialchars($car['capacity_people']) ?></td>
                    <td><?= htmlspecialchars($car['capacity_suitcases']) ?></td>
                    <td><?= htmlspecialchars($car['color']) ?></td>
                    <td><?= htmlspecialchars($car['fuel_type']) ?></td>
                    <td><?= htmlspecialchars($car['avg_consumption']) ?></td>
                    <td><?= htmlspecialchars($car['horsepower']) ?></td>
                    <td><?= htmlspecialchars($car['length']) ?></td>
                    <td><?= htmlspecialchars($car['width']) ?></td>
                    <td><?= htmlspecialchars($car['gear_type']) ?></td>
                    <td><?= htmlspecialchars($car['conditions']) ?></td>
                    <td><img src="images/<?php echo htmlspecialchars(explode(',', $car['photo1'])[0]); ?>" alt="Car Photo" width="100px" height="80px"></td>

                    <td>
                        <a href="edit_car.php?id=<?= htmlspecialchars($car['id']) ?>">Edit</a>
                        <a href="delete_car.php?id=<?= htmlspecialchars($car['id']) ?>" onclick="return confirm('Are you sure you want to delete this car?');">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
