<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car Rental System</title>
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
            <h2>Car List</h2>
            <table>
                <thead>
                    <tr>
                        <th>Model</th>
                        <th>Make</th>
                        <th>Type</th>
                        <th>Registration Year</th>
                        <th>Description</th>
                        <th>Price per Day</th>
                        <th>Color</th>
                        <th>Fuel Type</th>
                        <th>Avg Consumption</th>
                        <th>Horsepower</th>
                        <th>Length</th>
                        <th>Width</th>
                        <th>Gear Type</th>
                        <th>Conditions</th>
                        <th>Photos</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                <?php
                require 'Car.php'; 

                $cars = Car::getAllCars();

                foreach ($cars as $car) {
                    switch ($car->getFuelType()) {
                        case 'Petrol':
                            $fuelTypeClass = 'fuel-type-petrol';
                            break;
                        case 'Diesel':
                            $fuelTypeClass = 'fuel-type-diesel';
                            break;
                        case 'Electric':
                            $fuelTypeClass = 'fuel-type-electric';
                            break;
                        case 'Hybrid':
                            $fuelTypeClass = 'fuel-type-hybrid';
                            break;
                        default:
                            $fuelTypeClass = '';
                    }

                    echo "<tr class='{$fuelTypeClass}'>";
                    echo "<td>{$car->getModel()}</td>";
                    echo "<td>{$car->getMake()}</td>";
                    echo "<td>{$car->getType()}</td>";
                    echo "<td>{$car->getRegistrationYear()}</td>";
                    echo "<td>{$car->getDescription()}</td>";
                    echo "<td>{$car->getPricePerDay()}</td>";
                    echo "<td>{$car->getColor()}</td>";
                    echo "<td>{$car->getFuelType()}</td>";
                    echo "<td>{$car->getAvgConsumption()} liters/100km</td>";
                    echo "<td>{$car->getHorsepower()}</td>";
                    echo "<td>{$car->getLength()} meters</td>";
                    echo "<td>{$car->getWidth()} meters</td>";
                    echo "<td>{$car->getGearType()}</td>";
                    echo "<td>{$car->getConditions()}</td>";
                    echo "<td>";
                    foreach ($car->getPhoto1() as $photo) {
                        echo "<img src='images/{$photo}' alt='{$car->getModel()}' style='width: 100px; height: auto; margin-right: 5px;'>";
                    }
                    echo "</td>";
                    echo "<td><a href='car_details.php?id=" . htmlspecialchars($car->getId()) . "' class='rent-button'>Rent-a-Car</a></td>";
                    echo "</tr>";
                }
                ?>
                </tbody>
            </table>
        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
