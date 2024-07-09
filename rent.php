<?php
// Ensure database connection is included
require_once 'db.inc.php';

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Initialize variables with form data if they are set
    $car_id = isset($_POST['car_id']) ? $_POST['car_id'] : '';
    $end_date = isset($_POST['end_date']) ? $_POST['end_date'] : '';
    $pickup_location = isset($_POST['pickup_location']) ? $_POST['pickup_location'] : '';
    $return_location = isset($_POST['return_location']) ? $_POST['return_location'] : '';
    $special_requirements = isset($_POST['special_requirements']) ? $_POST['special_requirements'] : '';
    $total_amount = isset($_POST['total_amount']) ? $_POST['total_amount'] : '';
    $pickup_location_id = isset($_POST['pickup_location_id']) ? $_POST['pickup_location_id'] : '';
    $return_location_id = isset($_POST['return_location_id']) ? $_POST['return_location_id'] : '';

    // Check if any required fields are empty and handle validation as needed
    if (empty($car_id) || empty($end_date) || empty($pickup_location) || empty($total_amount) || empty($pickup_location_id)) {
        echo "<h2>Please fill out all required fields.</h2>";
        exit; // Exit script if required fields are empty
    }

    // Proceed with database operations
    try {
        // Insert into rentals table
        $query = "INSERT INTO rentals (customer_id, car_id, start_date, end_date, pickup_location, return_location, special_requirements, total_amount, invoice_id, invoice_date, state, pickup_location_id, return_location_id)
                  VALUES (:customer_id, :car_id, CURDATE(), :end_date, :pickup_location, :return_location, :special_requirements, :total_amount, :invoice_id, CURDATE(), 'active', :pickup_location_id, :return_location_id)";

        $invoice_id = "INV" . uniqid(); // Generate a unique invoice ID (this is a placeholder)

        $stmt = $pdo->prepare($query);
        $stmt->bindParam(':customer_id', $_SESSION['user_id']); // Assuming you have stored user_id in session
        $stmt->bindParam(':car_id', $car_id);
        $stmt->bindParam(':end_date', $end_date);
        $stmt->bindParam(':pickup_location', $pickup_location);
        $stmt->bindParam(':return_location', $return_location);
        $stmt->bindParam(':special_requirements', $special_requirements);
        $stmt->bindParam(':total_amount', $total_amount);
        $stmt->bindParam(':invoice_id', $invoice_id);
        $stmt->bindParam(':pickup_location_id', $pickup_location_id);
        $stmt->bindParam(':return_location_id', $return_location_id);

        // Execute the statement
        if ($stmt->execute()) {
            // Rental successfully added
            echo "<h2>Rental successfully added!</h2>";
            echo "<p>Invoice ID: $invoice_id</p>";
            echo "<p>Total Amount: $total_amount</p>";
            echo "<p>End Date: $end_date</p>";
            echo "<p>Pickup Location: $pickup_location</p>";
            if (!empty($return_location)) {
                echo "<p>Return Location: $return_location</p>";
            }
        } else {
            // Error in insertion
            echo "<h2>Error occurred while renting the car. Please try again later.</h2>";
        }
    } catch (PDOException $e) {
        // Database error handling
        echo "<h2>Database Error: " . $e->getMessage() . "</h2>";
    }
} else {
    echo "<h2>Form submission method not allowed.</h2>";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rent a Car</title>
    <link rel="shortcut icon" type="x-icon" href="file.jpg">
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css">
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
    </header>
    <div class="container">
        <nav class="main-nav">
            <ul>
                <li><a href="search.php">Search a Car</a></li>
                <li><a href="view_rents.php">View Rents</a></li>
            </ul>
        </nav>
        <main>
        <?php include 'rent_car_form.php'; ?>
        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
