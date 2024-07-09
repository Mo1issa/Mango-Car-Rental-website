<?php
session_start();

require 'db.inc.php';
$pdo = db_connect();

if (!isset($_GET['id'])) {
    header('Location: view_cars.php');
    exit;
}

$id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM cars WHERE id = :id");
$stmt->execute(['id' => $id]);
$car = $stmt->fetch();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $photo1 = $_FILES['photo1']['name'];
    $photo2 = $_FILES['photo2']['name'];
    $photo3 = $_FILES['photo3']['name'];

    // Handle file upload
    if (!empty($photo1)) {
        move_uploaded_file($_FILES['photo1']['tmp_name'], "images/$photo1");
    } else {
        $photo1 = $car['photo1'];
    }
    if (!empty($photo2)) {
        move_uploaded_file($_FILES['photo2']['tmp_name'], "images/$photo2");
    } else {
        $photo2 = $car['photo2'];
    }
    if (!empty($photo3)) {
        move_uploaded_file($_FILES['photo3']['tmp_name'], "images/$photo3");
    } else {
        $photo3 = $car['photo3'];
    }

    $stmt = $pdo->prepare("
        UPDATE cars 
        SET model = :model, make = :make, type = :type, registration_year = :registration_year, description = :description, price_per_day = :price_per_day, capacity_people = :capacity_people, capacity_suitcases = :capacity_suitcases, color = :color, fuel_type = :fuel_type, avg_consumption = :avg_consumption, horsepower = :horsepower, length = :length, width = :width, gear_type = :gear_type, conditions = :conditions, photo1 = :photo1, photo2 = :photo2, photo3 = :photo3
        WHERE id = :id
    ");
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
        'photo1' => $photo1,
        'photo2' => $photo2,
        'photo3' => $photo3,
        'id' => $id
    ]);

    header('Location: view_cars.php');
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Car</title>
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php include 'header.php'; ?>
    <main>
        <h1>Edit Car</h1>
        <form method="post" action="edit_car.php?id=<?= htmlspecialchars($car['id']) ?>" enctype="multipart/form-data">
            <label for="model">Model:</label>
            <input type="text" id="model" name="model" value="<?= htmlspecialchars($car['model']) ?>" required>
            <label for="make">Make:</label>
            <input type="text" id="make" name="make" value="<?= htmlspecialchars($car['make']) ?>" required>
            <label for="type">Type:</label>
            <input type="text" id="type" name="type" value="<?= htmlspecialchars($car['type']) ?>" required>
            <label for="registration_year">Registration Year:</label>
            <input type="number" id="registration_year" name="registration_year" value="<?= htmlspecialchars($car['registration_year']) ?>" required>
            <label for="description">Description:</label>
            <textarea id="description" name="description" required><?= htmlspecialchars($car['description']) ?></textarea>
            <label for="price_per_day">Price per Day:</label>
            <input type="number" step="0.01" id="price_per_day" name="price_per_day" value="<?= htmlspecialchars($car['price_per_day']) ?>" required>
            <label for="capacity_people">Capacity (People):</label>
            <input type="number" id="capacity_people" name="capacity_people" value="<?= htmlspecialchars($car['capacity_people']) ?>" required>
            <label for="capacity_suitcases">Capacity (Suitcases):</label>
            <input type="number" id="capacity_suitcases" name="capacity_suitcases" value="<?= htmlspecialchars($car['capacity_suitcases']) ?>" required>
            <label for="color">Color:</label>
            <input type="text" id="color" name="color" value="<?= htmlspecialchars($car['color']) ?>" required>
            <label for="fuel_type">Fuel Type:</label>
            <input type="text" id="fuel_type" name="fuel_type" value="<?= htmlspecialchars($car['fuel_type']) ?>" required>
            <label for="avg_consumption">Average Consumption:</label>
            <input type="number" step="0.01" id="avg_consumption" name="avg_consumption" value="<?= htmlspecialchars($car['avg_consumption']) ?>" required>
            <label for="horsepower">Horsepower:</label>
            <input type="number" id="horsepower" name="horsepower" value="<?= htmlspecialchars($car['horsepower']) ?>" required>
            <label for="length">Length:</label>
            <input type="number" step="0.01" id="length" name="length" value="<?= htmlspecialchars($car['length']) ?>" required>
            <label for="width">Width:</label>
            <input type="number" step="0.01" id="width" name="width" value="<?= htmlspecialchars($car['width']) ?>" required>
            <label for="gear_type">Gear Type:</label>
            <input type="text" id="gear_type" name="gear_type" value="<?= htmlspecialchars($car['gear_type']) ?>" required>
            <label for="conditions">Conditions:</label>
            <textarea id="conditions" name="conditions"><?= htmlspecialchars($car['conditions']) ?></textarea>
            <label for="photo1">Photo 1:</label>
            <input type="file" id="photo1" name="photo1" accept="image/*">
            <label for="photo2">Photo 2:</label>
            <input type="file" id="photo2" name="photo2" accept="image/*">
            <label for="photo3">Photo 3:</label>
            <input type="file" id="photo3" name="photo3" accept="image/*">
            <button type="submit">Update Car</button>
        </form>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>
