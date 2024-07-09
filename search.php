<?php
require 'db.inc.php'; // Include your database connection file

$pdo = db_connect(); // Connect to the database

// Default search parameters
$default_start_date = date('Y-m-d');
$default_end_date = date('Y-m-d', strtotime('+3 days'));
$default_car_type = 'Sedan';
$default_pickup_location = 'Birzeit';
$default_min_price = 200;
$default_max_price = 1000;

// Retrieve search parameters from the request
$start_date = $_GET['start_date'] ?? $default_start_date;
$end_date = $_GET['end_date'] ?? $default_end_date;
$car_type = $_GET['car_type'] ?? $default_car_type;
$pickup_location = $_GET['pickup_location'] ?? $default_pickup_location;
$min_price = $_GET['min_price'] ?? $default_min_price;
$max_price = $_GET['max_price'] ?? $default_max_price;

// Build the SQL query to fetch available cars based on criteria
$query = "
    SELECT c.*, r.start_date AS pickup_date, r.end_date AS return_date
    FROM cars c
    LEFT JOIN rentals r ON c.id = r.car_id
    WHERE c.type = :car_type
    AND c.price_per_day BETWEEN :min_price AND :max_price
    AND (r.start_date IS NULL OR r.state = 'available' OR r.start_date > :end_date OR r.end_date < :start_date)
    AND (r.pickup_location IS NULL OR r.pickup_location = :pickup_location)
";
$params = [
    'car_type' => $car_type,
    'min_price' => $min_price,
    'max_price' => $max_price,
    'start_date' => $start_date,
    'end_date' => $end_date,
    'pickup_location' => $pickup_location,
];

// Prepare and execute the query using PDO
$stmt = $pdo->prepare($query);
$stmt->execute($params);
$cars = $stmt->fetchAll(PDO::FETCH_ASSOC);
?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Search a Car</title>
       <link rel="shortcut icon" type="x-icon" href="file.jpg">
 <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
    <header>
        <?php include 'header.php'; ?>
        <h1>Search a Car</h1>
    </header>
    <div class="container">
        <nav class="main-nav">
            <ul>
                <li><a href="search.php" class="button">Search a Car</a></li>
                <li><a href="view_rent.php" class="button">View Rents</a></li>
            </ul>
        </nav>
        <main>
            <h2>Search for Available Cars</h2>
            <form action="search.php" method="GET">
                <label for="start_date">Start Date:</label>
                <input type="date" id="start_date" name="start_date" value="<?php echo htmlspecialchars($start_date); ?>">
                <label for="end_date">End Date:</label>
                <input type="date" id="end_date" name="end_date" value="<?php echo htmlspecialchars($end_date); ?>">
                <label for="car_type">Car Type:</label>
                <select id="car_type" name="car_type">
                    <option value="Sedan" <?php echo ($car_type == 'Sedan') ? 'selected' : ''; ?>>Sedan</option>
                    <option value="SUV" <?php echo ($car_type == 'SUV') ? 'selected' : ''; ?>>SUV</option>
                    <option value="Estate" <?php echo ($car_type == 'Estate') ? 'selected' : ''; ?>>Estate</option>
                </select>
                <label for="pickup_location">Pick-Up Location:</label>
                <input type="text" id="pickup_location" name="pickup_location" value="<?php echo htmlspecialchars($pickup_location); ?>">
                <label for="min_price">Min Price:</label>
                <input type="number" id="min_price" name="min_price" value="<?php echo htmlspecialchars($min_price); ?>">
                <label for="max_price">Max Price:</label>
                <input type="number" id="max_price" name="max_price" value="<?php echo htmlspecialchars($max_price); ?>">
                <button type="submit">Search</button>
            </form>

            <?php
            // Hardcoded search results for demonstration
            $cars = [
                [
                    'id' => 2,
                    'price_per_day' => 150.00,
                    'type' => 'Sedan',
                    'fuel_type' => 'diesel',
                    'photo1' => 'gol1.jpg'
                ],
                [
                    'id' => 3,
                    'price_per_day' => 200.00,
                    'type' => 'Estate',
                    'fuel_type' => 'hybrid',
                    'photo1' => 'vol1.jpg'
                ],
                [
                    'id' => 6,
                    'price_per_day' => 180.00,
                    'type' => 'SUV',
                    'fuel_type' => 'diesel',
                    'photo1' => 'maz1.jpg'
                ]
            ];
            ?>

            <table>
                <thead>
                    <tr>
                        <th><button type="button" id="shortlist">Shortlist</button></th>
                        <th>Price Per Day</th>
                        <th>Car Type</th>
                        <th>Fuel Type</th>
                        <th>Photo</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($cars as $car): ?>
                        <tr>
                            <td><input type="checkbox" name="shortlist[]"></td>
                            <td>$<?php echo htmlspecialchars($car['price_per_day']); ?></td>
                            <td><?php echo htmlspecialchars($car['type']); ?></td>
                            <td class="<?php echo 'fuel-type-' . strtolower($car['fuel_type']); ?>"><?php echo htmlspecialchars($car['fuel_type']); ?></td>
                            <td><img src="images/<?php echo htmlspecialchars($car['photo1']); ?>" alt="Car Photo" width="100"></td>
                            <td><a href="car_details.php?id=<?php echo htmlspecialchars($car['id']); ?>">Rent</a></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
