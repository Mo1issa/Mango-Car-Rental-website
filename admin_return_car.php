<?php
session_start();
include 'db.inc.php'; 

// Fetch returning cars function
function fetchReturningCars($pdo) {
    $stmt = $pdo->prepare("SELECT rentals.*, customers.name as customer_name, cars.make, cars.model, cars.type 
                           FROM rentals 
                           JOIN customers ON rentals.customer_id = customers.id 
                           JOIN cars ON rentals.car_id = cars.id 
                           WHERE rentals.state = 'returning'");
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Update car status function
function updateCarStatus($pdo, $car_id, $new_status, $new_location) {
    $stmt1 = $pdo->prepare("UPDATE cars SET state = :new_status WHERE id = :car_id");
    $stmt1->bindParam(':new_status', $new_status);
    $stmt1->bindParam(':car_id', $car_id);
    $stmt1->execute();

    $stmt2 = $pdo->prepare("UPDATE rentals SET return_location = :new_location, state = :new_status WHERE car_id = :car_id AND state = 'returning'");
    $stmt2->bindParam(':new_location', $new_location);
    $stmt2->bindParam(':new_status', $new_status);
    $stmt2->bindParam(':car_id', $car_id);
    $stmt2->execute();
}

// Ensure the database connection is established
$pdo = db_connect(); // Make sure this function is correctly defined in db.inc.php

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'];
    $new_status = $_POST['new_status'];
    $new_location = $_POST['new_location'];

    updateCarStatus($pdo, $car_id, $new_status, $new_location);
    echo "Car status updated.";
}

$returningCars = fetchReturningCars($pdo);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" type="x-icon" href="file.jpg">
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">
    <?php include 'header.php'; ?>

    <title>Return Car Management</title>
</head>
<body>
<div class="container">
        <nav class="main-nav">
            <ul>
                <li><a href="add_car.php" class="button">Add Car</a></li>
                <li><a href="view_cars.php" class="button">View Cars</a></li>
                <li><a href="view_rentals.php" class="button">View Rentals</a></li>
                <li><a href="add_location.php" class="button">Add location</a></li>
                <li><a href="admin_return_car.php" class="button">RETURN Cars</a></li>

            </ul>
        </nav>
        <main>
    <table>
        <thead>
            <tr>
                <th>Car Ref No</th>
                <th>Make</th>
                <th>Type</th>
                <th>Model</th>
                <th>Pickup Date</th>
                <th>Return Date</th>
                <th>Return Location</th>
                <th>Customer Name</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($returningCars as $car): ?>
                <tr>
                    <td><?php echo htmlspecialchars($car['car_id']); ?></td>
                    <td><?php echo htmlspecialchars($car['make']); ?></td>
                    <td><?php echo htmlspecialchars($car['type']); ?></td>
                    <td><?php echo htmlspecialchars($car['model']); ?></td>
                    <td><?php echo htmlspecialchars($car['start_date']); ?></td>
                    <td><?php echo htmlspecialchars($car['end_date']); ?></td>
                    <td><?php echo htmlspecialchars($car['return_location']); ?></td>
                    <td><?php echo htmlspecialchars($car['customer_name']); ?></td>
                    <td>
                        <form method="POST" action="admin_return_car.php">
                            <input type="hidden" name="car_id" value="<?php echo $car['car_id']; ?>">
                            <select name="new_status">
                                <option value="available">Available</option>
                                <option value="damaged">Damaged</option>
                                <option value="repair">Repair</option>
                            </select>
                            <input type="text" name="new_location" value="<?php echo htmlspecialchars($car['return_location']); ?>">
                            <button type="submit">Update</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
        </main>
</div>
</body>
<?php include 'footer.php'; ?>

</html>
