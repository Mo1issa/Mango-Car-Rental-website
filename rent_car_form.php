<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car</title>
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
        <main>
            <h2>Rent a Car</h2>
            <form action="rent_car.php" method="POST">
                <label for="car_id">Car ID:</label>
                <input type="text" id="car_id" name="car_id" required>

                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" required>

                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" required>

                <label for="pickup_location">Pickup Location:</label>
                <input type="text" id="pickup_location" name="pickup_location" required>

                <label for="return_location">Return Location:</label>
                <input type="text" id="return_location" name="return_location" required>

                <label for="special_requirements">Special Requirements:</label>
                <textarea id="special_requirements" name="special_requirements"></textarea>

                <label for="total_amount">Total Amount:</label>
                <input type="number" id="total_amount" name="total_amount" step="0.01" required>

                <label for="pickup_location_id">Pickup Location ID:</label>
                <input type="number" id="pickup_location_id" name="pickup_location_id" required>

                <label for="return_location_id">Return Location ID:</label>
                <input type="number" id="return_location_id" name="return_location_id" required>

                <button type="submit">Rent Car</button>
            </form>
        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
