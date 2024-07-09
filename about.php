<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us</title>
    <link rel="shortcut icon" type="x-icon" href="file.jpg">
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
</head>
<body>
    <?php include 'header.php'; ?>
    <div class="container">
    <nav class="main-nav">
            <ul>
                <li><a href="search.php" class="button">Search a Car</a></li>
                <li><a href="view_rent.php" class="button">View Rents</a></li>
            </ul>
        </nav>
        <main>
            <h2>About Mango Car Rental</h2>
            <section class="about-content">
                <h3>Our Mission</h3>
                <p>At Mango Car Rental, our mission is to provide top-quality car rental services that cater to the needs of both locals and travelers. We aim to make car rental simple, affordable, and convenient for everyone.</p>
                
                <h3>Who We Are</h3>
                <p>Founded in 2020, Mango Car Rental has quickly become a leading car rental service provider. Our team is dedicated to offering a wide range of vehicles to meet the diverse needs of our customers, from compact cars to luxury SUVs.</p>
                
                <h3>Our Fleet</h3>
                <p>We take pride in maintaining a modern and diverse fleet of vehicles. Each car is regularly serviced and inspected to ensure the highest standards of safety and reliability.</p>
                
                <h3>Contact Us</h3>
                <p>If you have any questions or need assistance, feel free to reach out to our customer service team. We're here to help you 24/7.</p>
                <p>Email: support@mangocarrental.com<br>Phone: 123-456-7890</p>
            </section>
        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
