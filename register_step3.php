<?php
session_start();
require 'db.inc.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pdo = db_connect();

    $customer_info = $_SESSION['customer_info'];
    $account_info = $_SESSION['account_info'];

    if ($account_info['password'] !== $account_info['confirm_password']) {
        die('Passwords do not match.');
    }

    $stmt = $pdo->prepare('INSERT INTO customers (name, address, city, country, dob, id_number, email, telephone, credit_card_number, credit_card_expiry, credit_card_name, credit_card_bank, username, password) VALUES (:name, :address, :city, :country, :dob, :id_number, :email, :telephone, :credit_card_number, :credit_card_expiry, :credit_card_name, :credit_card_bank, :username, :password)');

    $stmt->execute([
        'name' => $customer_info['name'],
        'address' => $customer_info['address'],
        'city' => $customer_info['city'],
        'country' => $customer_info['country'],
        'dob' => $customer_info['dob'],
        'id_number' => $customer_info['id_number'],
        'email' => $customer_info['email'],
        'telephone' => $customer_info['telephone'],
        'credit_card_number' => $customer_info['credit_card_number'],
        'credit_card_expiry' => $customer_info['credit_card_expiry'],
        'credit_card_name' => $customer_info['credit_card_name'],
        'credit_card_bank' => $customer_info['credit_card_bank'],
        'username' => $account_info['username'],
        'password' => password_hash($account_info['password'], PASSWORD_BCRYPT),
    ]);

    $customer_id = $pdo->lastInsertId();
    session_destroy();
    echo "Registration successful. Your customer ID is {$customer_id}. <a href='login.php'>Login here</a>.";
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<?php include 'header.php'; ?>

    <title>Register Step 3</title>
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="x-icon" href="file.jpg">

</head>
<body>
<div class="container">
        <nav class="main-nav">
        <ul>
                <li><a href="search.php" class="button">Search a Car</a></li>
                <li><a href="view_rent.php" class="button">View Rents</a></li>
            </ul>
        </nav>
        <main>
    <form method="post" action="register_step3.php">
        <h2>Confirm Your Details</h2>
        <p>Name: <?= htmlspecialchars($_SESSION['customer_info']['name']) ?></p>
        <p>Address: <?= htmlspecialchars($_SESSION['customer_info']['address']) ?></p>
        <p>City: <?= htmlspecialchars($_SESSION['customer_info']['city']) ?></p>
        <p>Country: <?= htmlspecialchars($_SESSION['customer_info']['country']) ?></p>
        <p>Date of Birth: <?= htmlspecialchars($_SESSION['customer_info']['dob']) ?></p>
        <p>ID Number: <?= htmlspecialchars($_SESSION['customer_info']['id_number']) ?></p>
        <p>Email: <?= htmlspecialchars($_SESSION['customer_info']['email']) ?></p>
        <p>Telephone: <?= htmlspecialchars($_SESSION['customer_info']['telephone']) ?></p>
        <p>Credit Card Number: <?= htmlspecialchars($_SESSION['customer_info']['credit_card_number']) ?></p>
        <p>Credit Card Expiry: <?= htmlspecialchars($_SESSION['customer_info']['credit_card_expiry']) ?></p>
        <p>Credit Card Name: <?= htmlspecialchars($_SESSION['customer_info']['credit_card_name']) ?></p>
        <p>Credit Card Bank: <?= htmlspecialchars($_SESSION['customer_info']['credit_card_bank']) ?></p>
        <p>Username: <?= htmlspecialchars($_SESSION['account_info']['username']) ?></p>
        <button type="submit">Confirm</button>
    </form>
        </main>
</div>
</body>
<?php include 'footer.php'; ?>

</html>
