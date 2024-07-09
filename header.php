<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
$user_role = $_SESSION['user_role'] ?? null;
if ($user_role === 'customer') {
    $home_page = 'customer_dashboerd.php';
} elseif ($user_role === 'manager') {
    $home_page = 'manager_dashboard.php';
} else {
    $home_page = 'index.php';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Details</title>
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
    <header>
        <figure>
            <img src="logo.png" alt="logo" width="140" height="100">
        </figure>
        <h1>Mango Car Rental</h1>
        <nav>
            <a href="<?php echo $home_page; ?>" class="button">Home Page</a>
            <a href="about.php" class="button">About Us</a>
            <a href="profile.php" class="button profile"><?php echo htmlspecialchars($_SESSION['name'] ?? 'Profile'); ?></a>
            <a href="shopping_basket.php" class="button">Shopping Basket</a>
            <?php if (isset($_SESSION['user_id'])): ?>
                <a href="logout.php" class="button logout">Logout</a>
            <?php else: ?>
                <a href="register_step1.php" class="button signup">Sign Up</a>
                <a href="login.php" class="button login">Login</a>
            <?php endif; ?>
        </nav>
    </header>
</body>
</html>
