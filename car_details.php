<?php
session_start(); // Start the session

require 'db.inc.php';

$pdo = db_connect();

$car_id = $_GET['id'] ?? null;
if ($car_id) {
    $stmt = $pdo->prepare("SELECT * FROM cars WHERE id = :id");
    $stmt->execute(['id' => $car_id]);
    $car = $stmt->fetch();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $car_id = $_POST['car_id'] ?? '';
    $end_date = $_POST['end_date'] ?? '';
    $pickup_location = $_POST['pickup_location'] ?? '';
    $return_location = $_POST['return_location'] ?? '';
    $special_requirements = $_POST['special_requirements'] ?? '';
    $total_amount = $_POST['total_amount'] ?? '';
    $pickup_location_id = $_POST['pickup_location_id'] ?? '';
    $return_location_id = $_POST['return_location_id'] ?? '';

    if (empty($car_id) || empty($end_date) || empty($pickup_location) || empty($total_amount) || empty($pickup_location_id)) {
        echo "<h2>Please fill out all required fields.</h2>";
        exit;
    }

    // Fetch customer_id from session
    $customer_id = $_SESSION['user_id'] ?? null;

    if (!isset($_SESSION['user_role'])) {
        header('Location: login.php');
        exit;
    }

    try {
        $query = "INSERT INTO rentals (customer_id, car_id, start_date, end_date, pickup_location, return_location, special_requirements, total_amount, invoice_id, invoice_date, state, pickup_location_id, return_location_id)
                  VALUES (:customer_id, :car_id, CURDATE(), :end_date, :pickup_location, :return_location, :special_requirements, :total_amount, :invoice_id, CURDATE(), 'active', :pickup_location_id, :return_location_id)";

        $invoice_id = "INV" . uniqid();

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':customer_id', $customer_id);
        $stmt->bindParam(':car_id', $car_id);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':pickup_location', $pickup_location);
        $stmt->bindParam(':return_location', $return_location);
        $stmt->bindParam(':special_requirements', $special_requirements);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':invoice_id', $invoice_id);
        $stmt->bindParam(':pickup_location_id', $pickup_location_id);
        $stmt->bindParam(':return_location_id', $return_location_id);

        if ($stmt->execute()) {
            echo "<h2>Rental successfully added!</h2>";
            echo "<p>Invoice ID: $invoice_id</p>";
            echo "<p>Total Amount: $total_amount</p>";
            echo "<p>End Date: $end_date</p>";
            echo "<p>Pickup Location: $pickup_location</p>";
            if (!empty($return_location)) {
                echo "<p>Return Location: $return_location</p>";
            }
        } else {
            echo "<h2>Error occurred while renting the car. Please try again later.</h2>";
        }
    } catch (PDOException $e) {
        echo "<h2>Database Error: " . $e->getMessage() . "</h2>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details and Rent</title>
    <link rel="shortcut icon" type="x-icon" href="file.jpg">
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <main>
            <?php if ($car): ?>
                <div class="car-details">
                    <div class="car-photos">
                        <?php foreach (['photo1', 'photo2', 'photo3'] as $photo_field): ?>
                            <?php if (!empty($car[$photo_field])): ?>
                                <img src="images/<?= htmlspecialchars($car[$photo_field]) ?>" alt="Car Photo">
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <div class="car-info">
                        <ul>
                            <li>Reference Number: <?= htmlspecialchars($car['id']) ?></li>
                            <li>Model: <?= htmlspecialchars($car['model']) ?></li>
                            <li>Type: <?= htmlspecialchars($car['type']) ?></li>
                            <li>Make: <?= htmlspecialchars($car['make']) ?></li>
                            <li>Registration Year: <?= htmlspecialchars($car['registration_year']) ?></li>
                            <li>Color: <?= htmlspecialchars($car['color']) ?></li>
                            <li>Description: <?= htmlspecialchars($car['description']) ?></li>
                            <li>Price per Day: <?= htmlspecialchars($car['price_per_day']) ?></li>
                            <li>Capacity (People): <?= htmlspecialchars($car['capacity_people']) ?></li>
                            <li>Capacity (Suitcases): <?= htmlspecialchars($car['capacity_suitcases']) ?></li>
                            <li>Fuel Type: <?= htmlspecialchars($car['fuel_type']) ?></li>
                            <li>Average Consumption: <?= htmlspecialchars($car['avg_consumption']) ?> liters/100km</li>
                            <li>Horsepower: <?= htmlspecialchars($car['horsepower']) ?></li>
                            <li>Length: <?= htmlspecialchars($car['length']) ?> meters</li>
                            <li>Width: <?= htmlspecialchars($car['width']) ?> meters</li>
                            <li>Gear Type: <?= htmlspecialchars($car['gear_type']) ?></li>
                            <li>Conditions: <?= htmlspecialchars($car['conditions']) ?></li>
                        </ul>
                    </div>
                </div>
            <?php else: ?>
                <p>Car not found.</p>
            <?php endif; ?>

            <?php if ($car): ?>
                <div class="rent-form">
                    <h2>Rent This Car</h2>
                    <form method="post" action="">
                        <input type="hidden" name="car_id" value="<?= htmlspecialchars($car['id']) ?>">
                        <label for="end_date">End Date:</label>
                        <input type="date" name="end_date" id="end_date" required>

                        <label for="pickup_location">Pickup Location:</label>
                        <input type="text" name="pickup_location" id="pickup_location" required>

                        <label for="return_location">Return Location:</label>
                        <input type="text" name="return_location" id="return_location">

                        <label for="special_requirements">Special Requirements:</label>
                        <textarea name="special_requirements" id="special_requirements"></textarea>

                        <label for="total_amount">Total Amount:</label>
                        <input type="number" name="total_amount" id="total_amount" step="0.01" required>

                        <label for="pickup_location_id">Pickup Location ID:</label>
                        <input type="number" name="pickup_location_id" id="pickup_location_id" required>

                        <label for="return_location_id">Return Location ID:</label>
                        <input type="number" name="return_location_id" id="return_location_id">

                        <button type="submit">Rent This Car</button>
                    </form>
                </div>
            <?php endif; ?>
        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
