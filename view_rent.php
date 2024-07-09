<?php
require 'Rental.php';
$rentals = Rental::getAllRentals();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <?php include 'header.php'; ?>
    <title>View Rented Cars</title>
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="x-icon" href="file.jpg">

</head>
<body>
    <header>
        <h1>View Rented Cars</h1>
    </header>
    <div class="container">
    <nav class="main-nav">
    <ul>
                <li><a href="search.php" class="button">Search a Car</a></li>
                <li><a href="view_rent.php" class="button">View Rents</a></li>
            </ul>
        </nav>
        <main>
        <table>
            <thead>
                <tr>
                    <th>Invoice ID</th>
                    <th>Invoice Date</th>
                    <th>Car Make</th>
                    <th>Car Model</th>
                    <th>Pick-up Date</th>
                    <th>Pick-up Location</th>
                    <th>Return Date</th>
                    <th>Return Location</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($rentals as $rental) : ?>
                    <?php $rental->display(); ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        </main>
    </div>
</body>
<?php include 'footer.php'; ?>
</html>
