<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['customer_info'] = $_POST;
    header('Location: register_step2.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<?php include 'header.php'; ?>

    <title>Register Step 1</title>
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
    <form method="post" action="register_step1.php">
        <label>Name:</label>
        <input type="text" name="name" required><br>
        <label>Address:</label>
        <input type="text" name="address" required><br>
        <label>City:</label>
        <input type="text" name="city" required><br>
        <label>Country:</label>
        <input type="text" name="country" required><br>
        <label>Date of Birth:</label>
        <input type="date" name="dob" required><br>
        <label>ID Number:</label>
        <input type="text" name="id_number" required><br>
        <label>Email:</label>
        <input type="email" name="email" required><br>
        <label>Telephone:</label>
        <input type="text" name="telephone" required><br>
        <label>Credit Card Number:</label>
        <input type="text" name="credit_card_number" required><br>
        <label>Credit Card Expiry:</label>
        <input type="date" name="credit_card_expiry" required><br>
        <label>Credit Card Name:</label>
        <input type="text" name="credit_card_name" required><br>
        <label>Credit Card Bank:</label>
        <input type="text" name="credit_card_bank" required><br>
        <button type="submit">Next</button>
    </form>
        </main>
</div>
</body>
<?php include 'footer.php'; ?>

</html>
