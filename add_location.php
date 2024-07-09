<?php
session_start();


require 'db.inc.php';
$pdo = db_connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $stmt = $pdo->prepare("
        INSERT INTO locations (name, property_number, street_name, city, postal_code, country, telephone)
        VALUES (:name, :property_number, :street_name, :city, :postal_code, :country, :telephone)
    ");
    $stmt->execute([
        'name' => $_POST['name'],
        'property_number' => $_POST['property_number'],
        'street_name' => $_POST['street_name'],
        'city' => $_POST['city'],
        'postal_code' => $_POST['postal_code'],
        'country' => $_POST['country'],
        'telephone' => $_POST['telephone']
    ]);

    echo "Location added successfully.";
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Location</title>
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="x-icon" href="file.jpg">
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
        <h1>Add Location</h1>
        <form method="post" action="add_location.php">
            <label for="name">Name:</label>
            <input type="text" id="name" name="name" required>
            <label for="property_number">Property Number:</label>
            <input type="text" id="property_number" name="property_number" required>
            <label for="street_name">Street Name:</label>
            <input type="text" id="street_name" name="street_name" required>
            <label for="city">City:</label>
            <input type="text" id="city" name="city" required>
            <label for="postal_code">Postal Code:</label>
            <input type="text" id="postal_code" name="postal_code" required>
            <label for="country">Country:</label>
            <input type="text" id="country" name="country" required>
            <label for="telephone">Telephone:</label>
            <input type="text" id="telephone" name="telephone" required>
            <button type="submit">Add Location</button>
        </form>
    </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
