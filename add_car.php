<?php
session_start();
require 'db.inc.php';

$pdo = db_connect();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Handle file uploads
    $uploadDir = 'images/';
    $photo1 = $uploadDir . basename($_FILES['photo1']['name']);
    $photo2 = $uploadDir . basename($_FILES['photo2']['name']);
    $photo3 = $uploadDir . basename($_FILES['photo3']['name']);

    move_uploaded_file($_FILES['photo1']['tmp_name'], $photo1);
    move_uploaded_file($_FILES['photo2']['tmp_name'], $photo2);
    move_uploaded_file($_FILES['photo3']['tmp_name'], $photo3);

    // Prepare SQL statement
    $stmt = $pdo->prepare("
        INSERT INTO cars (model, make, type, registration_year, description, price_per_day, capacity_people, capacity_suitcases, color, fuel_type, avg_consumption, horsepower, length, width, gear_type, conditions, photo1, photo2, photo3)
        VALUES (:model, :make, :type, :registration_year, :description, :price_per_day, :capacity_people, :capacity_suitcases, :color, :fuel_type, :avg_consumption, :horsepower, :length, :width, :gear_type, :conditions, :photo1, :photo2, :photo3)
    ");

    // Execute statement
    $stmt->execute([
        'model' => $_POST['model'],
        'make' => $_POST['make'],
        'type' => $_POST['type'],
        'registration_year' => $_POST['registration_year'],
        'description' => $_POST['description'],
        'price_per_day' => $_POST['price_per_day'],
        'capacity_people' => $_POST['capacity_people'],
        'capacity_suitcases' => $_POST['capacity_suitcases'],
        'color' => $_POST['color'],
        'fuel_type' => $_POST['fuel_type'],
        'avg_consumption' => $_POST['avg_consumption'],
        'horsepower' => $_POST['horsepower'],
        'length' => $_POST['length'],
        'width' => $_POST['width'],
        'gear_type' => $_POST['gear_type'],
        'conditions' => $_POST['conditions'],
        'photo1' => basename($_FILES['photo1']['name']),
        'photo2' => basename($_FILES['photo2']['name']),
        'photo3' => basename($_FILES['photo3']['name'])
    ]);

    echo "Car added successfully.";
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Car</title>
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
        <h1>Add Car</h1>
        <form method="post" action="add_car.php" enctype="multipart/form-data">
            <label for="model">Model:</label>
            <input type="text" id="model" name="model" required>
            <label for="make">Make:</label>
            <input type="text" id="make" name="make" required>
            <label for="type">Type:</label>
            <input type="text" id="type" name="type" required>
            <label for="registration_year">Registration Year:</label>
            <input type="number" id="registration_year" name="registration_year" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required></textarea>
            <label for="price_per_day">Price per Day:</label>
            <input type="number" step="0.01" id="price_per_day" name="price_per_day" required>
            <label for="capacity_people">Capacity (People):</label>
            <input type="number" id="capacity_people" name="capacity_people" required>
            <label for="capacity_suitcases">Capacity (Suitcases):</label>
            <input type="number" id="capacity_suitcases" name="capacity_suitcases" required>
            <label for="color">Color:</label>
            <input type="text" id="color" name="color" required>
            <label for="fuel_type">Fuel Type:</label>
            <input type="text" id="fuel_type" name="fuel_type" required>
            <label for="avg_consumption">Average Consumption:</label>
            <input type="number" step="0.01" id="avg_consumption" name="avg_consumption" required>
            <label for="horsepower">Horsepower:</label>
            <input type="number" id="horsepower" name="horsepower" required>
            <label for="length">Length:</label>
            <input type="number" step="0.01" id="length" name="length" required>
            <label for="width">Width:</label>
            <input type="number" step="0.01" id="width" name="width" required>
            <label for="gear_type">Gear Type:</label>
            <input type="text" id="gear_type" name="gear_type" required>
            <label for="conditions">Conditions:</label>
            <textarea id="conditions" name="conditions"></textarea>
            <label for="photo1">Photo 1:</label>
            <input type="file" id="photo1" name="photo1" accept="image/*" required>
            <label for="photo2">Photo 2:</label>
            <input type="file" id="photo2" name="photo2" accept="image/*" required>
            <label for="photo3">Photo 3:</label>
            <input type="file" id="photo3" name="photo3" accept="image/*" required>
            <button type="submit">Add Car</button>
        </form>
    </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
