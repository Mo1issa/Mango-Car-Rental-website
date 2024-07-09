<?php
session_start();
if (!isset($_SESSION['user_role'])) {
    header('Location: login.php');
    exit;
}


require 'db.inc.php'; // Include your database connection file
$customer_id = $_SESSION['user_id'];
?>
<!DOCTYPE html>
<html>
<head>
    <?php include 'header.php'; ?>
    <title>Profile</title>
    <link href="styles.css?v=<?php echo time(); ?>" rel="stylesheet" type="text/css" />
    <link rel="shortcut icon" type="x-icon" href="file.jpg">
</head>
<body>
    <header>
        <h1>Your Profile</h1>
    </header>
    <div class="container">
        <nav class="main-nav">
            <ul>
                <li><a href="search.php" class="button">Search a Car</a></li>
                <li><a href="view_rent.php" class="button">View Rents</a></li>
            </ul>
        </nav>
        <main>
            <?php
            if ($_SERVER['REQUEST_METHOD'] == 'POST') {
                // Handle profile update
                $name = $_POST['name'];
                $address = $_POST['address'];
                $city = $_POST['city'];
                $country = $_POST['country'];
                $dob = $_POST['dob'];
                $id_number = $_POST['id_number'];
                $email = $_POST['email'];
                $telephone = $_POST['telephone'];
                $credit_card_number = $_POST['credit_card_number'];
                $credit_card_expiry = $_POST['credit_card_expiry'];
                $credit_card_name = $_POST['credit_card_name'];
                $credit_card_bank = $_POST['credit_card_bank'];
                $username = $_POST['username'];
                $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

                try {
                    $conn = db_connect();
                    $sql = "UPDATE customers SET 
                        name = :name, address = :address, city = :city, country = :country, dob = :dob, 
                        id_number = :id_number, email = :email, telephone = :telephone, credit_card_number = :credit_card_number, 
                        credit_card_expiry = :credit_card_expiry, credit_card_name = :credit_card_name, credit_card_bank = :credit_card_bank, 
                        username = :username, password = :password 
                        WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':name', $name);
                    $stmt->bindParam(':address', $address);
                    $stmt->bindParam(':city', $city);
                    $stmt->bindParam(':country', $country);
                    $stmt->bindParam(':dob', $dob);
                    $stmt->bindParam(':id_number', $id_number);
                    $stmt->bindParam(':email', $email);
                    $stmt->bindParam(':telephone', $telephone);
                    $stmt->bindParam(':credit_card_number', $credit_card_number);
                    $stmt->bindParam(':credit_card_expiry', $credit_card_expiry);
                    $stmt->bindParam(':credit_card_name', $credit_card_name);
                    $stmt->bindParam(':credit_card_bank', $credit_card_bank);
                    $stmt->bindParam(':username', $username);
                    $stmt->bindParam(':password', $password);
                    $stmt->bindParam(':id', $customer_id);

                    if ($stmt->execute()) {
                        echo "Profile updated successfully.";
                    } else {
                        echo "Error updating profile.";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }

                $conn = null;
            } else {
                try {
                    $conn = db_connect();
                    $sql = "SELECT * FROM customers WHERE id = :id";
                    $stmt = $conn->prepare($sql);
                    $stmt->bindParam(':id', $customer_id);
                    $stmt->execute();

                    if ($row = $stmt->fetch()) {
                        echo "<form method='post' action='profile.php'>";
                        echo "<label for='name'>Name:</label><input type='text' id='name' name='name' value='{$row['name']}'><br>";
                        echo "<label for='address'>Address:</label><input type='text' id='address' name='address' value='{$row['address']}'><br>";
                        echo "<label for='city'>City:</label><input type='text' id='city' name='city' value='{$row['city']}'><br>";
                        echo "<label for='country'>Country:</label><input type='text' id='country' name='country' value='{$row['country']}'><br>";
                        echo "<label for='dob'>Date of Birth:</label><input type='date' id='dob' name='dob' value='{$row['dob']}'><br>";
                        echo "<label for='id_number'>ID Number:</label><input type='text' id='id_number' name='id_number' value='{$row['id_number']}'><br>";
                        echo "<label for='email'>Email:</label><input type='email' id='email' name='email' value='{$row['email']}'><br>";
                        echo "<label for='telephone'>Telephone:</label><input type='text' id='telephone' name='telephone' value='{$row['telephone']}'><br>";
                        echo "<label for='credit_card_number'>Credit Card Number:</label><input type='text' id='credit_card_number' name='credit_card_number' value='{$row['credit_card_number']}'><br>";
                        echo "<label for='credit_card_expiry'>Credit Card Expiry:</label><input type='date' id='credit_card_expiry' name='credit_card_expiry' value='{$row['credit_card_expiry']}'><br>";
                        echo "<label for='credit_card_name'>Credit Card Name:</label><input type='text' id='credit_card_name' name='credit_card_name' value='{$row['credit_card_name']}'><br>";
                        echo "<label for='credit_card_bank'>Credit Card Bank:</label><input type='text' id='credit_card_bank' name='credit_card_bank' value='{$row['credit_card_bank']}'><br>";
                        echo "<label for='username'>Username:</label><input type='text' id='username' name='username' value='{$row['username']}'><br>";
                        echo "<label for='password'>Password:</label><input type='password' id='password' name='password' value=''><br>";
                        echo "<input type='submit' value='Update Profile'>";
                        echo "</form>";
                    } else {
                        echo "Profile not found.";
                    }
                } catch (PDOException $e) {
                    echo "Error: " . $e->getMessage();
                }

                $conn = null;
            }
            ?>
        </main>
    </div>
    <?php include 'footer.php'; ?>
</body>
</html>
