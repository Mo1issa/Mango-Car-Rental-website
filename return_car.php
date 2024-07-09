<?php
session_start();
include 'db.inc.php'; // Ensure this file establishes the $pdo variable


// Check if the user_id is set in the session
if (!isset($_SESSION['user_id'])) {
    echo "User ID not found in session.";
    exit;
}

$customer_id = $_SESSION['user_id']; // Get customer_id from session

// Establish database connection
$pdo = db_connect(); // Make sure db_connect() is defined in db.inc.php and returns a PDO instance

// Fetch active rentals function
function fetchActiveRentals($pdo, $customer_id) {
    $stmt = $pdo->prepare("SELECT rentals.*, cars.make, cars.model, cars.type 
                           FROM rentals 
                           JOIN cars ON rentals.car_id = cars.id 
                           WHERE rentals.customer_id = :customer_id AND rentals.state = 'active'");
    $stmt->bindParam(':customer_id', $customer_id, PDO::PARAM_INT);
    $stmt->execute();
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

// Initiate car return function
function initiateCarReturn($pdo, $car_id, $return_location) {
    $stmt = $pdo->prepare("UPDATE rentals SET state = 'returning', return_location = :return_location WHERE car_id = :car_id AND customer_id = :customer_id");
    $stmt->bindParam(':return_location', $return_location, PDO::PARAM_STR);
    $stmt->bindParam(':car_id', $car_id, PDO::PARAM_INT);
    $stmt->bindParam(':customer_id', $_SESSION['user_id'], PDO::PARAM_INT); // Ensure the correct customer_id is used
    $stmt->execute();
}

// Handle form submission for car return
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $car_id = $_POST['car_id'];
    $return_location = $_POST['return_location'];

    initiateCarReturn($pdo, $car_id, $return_location);
    echo "Car return process initiated.";
}

$activeRentals = fetchActiveRentals($pdo, $customer_id);


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <?php include 'header.php'; ?>
    <title>Return Car</title>
</head>
<body>
<div class="container">
        <nav class="main-nav">
            <ul>
                <li><a href="search.php" class="button">Search a Car</a></li>
                <li><a href="view_rent.php" class="button">View Rents</a></li>
                <li><a href="return_car.php" class="button">Return Car</a></li>

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
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($activeRentals)): ?>
                <?php foreach ($activeRentals as $rental): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($rental['car_id']); ?></td>
                        <td><?php echo htmlspecialchars($rental['make']); ?></td>
                        <td><?php echo htmlspecialchars($rental['type']); ?></td>
                        <td><?php echo htmlspecialchars($rental['model']); ?></td>
                        <td><?php echo htmlspecialchars($rental['start_date']); ?></td>
                        <td><?php echo htmlspecialchars($rental['end_date']); ?></td>
                        <td><?php echo htmlspecialchars($rental['return_location']); ?></td>
                        <td>
                            <form method="POST" action="return_car.php">
                                <input type="hidden" name="car_id" value="<?php echo $rental['car_id']; ?>">
                                <input type="text" name="return_location" value="<?php echo htmlspecialchars($rental['pickup_location']); ?>">
                                <button type="submit">Return Car</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8">No active rentals found.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
        </main>
</div>
</body>
<?php include 'footer.php'; ?>
</html>
