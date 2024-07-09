<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $_SESSION['account_info'] = $_POST;
    header('Location: register_step3.php');
    exit;
}
?>
<!DOCTYPE html>
<html>
<head>
<?php include 'header.php'; ?>

    <title>Register Step 2</title>
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
    <form method="post" action="register_step2.php">
        <label>Username:</label>
        <input type="text" name="username" required pattern=".{6,13}" title="6 to 13 characters"><br>
        <label>Password:</label>
        <input type="password" name="password" required pattern=".{8,12}" title="8 to 12 characters"><br>
        <label>Confirm Password:</label>
        <input type="password" name="confirm_password" required pattern=".{8,12}" title="8 to 12 characters"><br>
        <button type="submit">Next</button>
    </form>
        </main>
</div>
</body>
<?php include 'footer.php'; ?>

</html>
