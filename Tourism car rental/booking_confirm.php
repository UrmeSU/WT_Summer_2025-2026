<?php
session_start();
include "db.php";

if (!isset($_SESSION["customer_name"])) {
    header("Location: login.php");
    exit();
}
if (
    !isset($_POST["destination"]) ||
    !isset($_POST["rental_date"]) ||
    !isset($_POST["vehicle"]) ||
    !isset($_POST["price"]) ||
    !isset($_POST["seats"]) ||
    !isset($_POST["ac"]) ||
    !isset($_POST["bags"])
) {
    header("Location: dashboard.php");
    exit();
}

$customer_name = $_SESSION["customer_name"];

$destination = $_POST["destination"];
$rental_date = $_POST["rental_date"];
$vehicle = $_POST["vehicle"];
$price = $_POST["price"];
$seats = $_POST["seats"];
$ac = $_POST["ac"];
$bags = $_POST["bags"];

$customer_sql = "SELECT phone FROM customer
                 WHERE name = '$customer_name'
                 LIMIT 1";

$customer_result = $conn->query($customer_sql);

if ($customer_result && $customer_result->num_rows > 0) {

    $customer_row = $customer_result->fetch_assoc();
    $customer_phone = $customer_row["phone"];

} else {

    $customer_phone = "";
}

$confirmation_code = "CR" . rand(10000, 99999);

$payment_method = "Cash";

$booking_status = "Confirmed";

$sql = "INSERT INTO booking
        (customer_name, destination, rental_date, vehicle_name,
         seats, ac, bags, price, payment_method,
         booking_status, confirmation_code)
        VALUES
        ('$customer_name',
         '$destination',
         '$rental_date',
         '$vehicle',
         '$seats',
         '$ac',
         '$bags',
         '$price',
         '$payment_method',
         '$booking_status',
         '$confirmation_code')";


if ($conn->query($sql) === TRUE) {
    $booking_id = $conn->insert_id;
    $driver_id = 1;

    $driver_booking_sql = "INSERT INTO driver_booking
                           (booking_id,
                            customer_name,
                            customer_phone,
                            destination,
                            trip_date,
                            confirm_code,
                            driver_id,
                            status)
                           VALUES
                           ('$booking_id',
                            '$customer_name',
                            '$customer_phone',
                            '$destination',
                            '$rental_date',
                            '$confirmation_code',
                            '$driver_id',
                            'Pending')";


    if ($conn->query($driver_booking_sql) === TRUE) {

        $success = true;

    } else {

        $success = false;
        $error = $conn->error;
    }

} else {

    $success = false;
    $error = $conn->error;
}

?>


<!DOCTYPE html>
<html>

<head>

    <title>Booking Confirmation</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>

<div class="container">

<?php if ($success) { ?>

    <div class="summary">

        <h2>Booking Confirmed!</h2>

        <p><strong>Customer:</strong><?php echo $customer_name; ?></p>
        <p><strong>Destination:</strong><?php echo $destination; ?></p>
        <p><strong>Rental Date:</strong><?php echo $rental_date; ?></p>

        <hr>

        <h3>Selected Vehicle</h3>

        <p><strong>Vehicle:</strong><?php echo $vehicle; ?></p>
        <p><strong>Seats:</strong><?php echo $seats; ?></p>
        <p><strong>AC:</strong><?php echo $ac; ?></p>
        <p><strong>Bags:</strong><?php echo $bags; ?></p>
        <p><strong>Price:</strong><?php echo $price; ?> / day</p>
        <p><strong>Payment Method:</strong>Cash</p>
        <p><strong>Booking Status:</strong>Confirmed</p>

        <hr>

        <h3>Confirmation Code:</h3>

        <h2><?php echo $confirmation_code; ?></h2>

        <p>Please keep this confirmation code for your booking.</p><br>

        <a href="booking_history.php">View Booking History</a><br><br>
        <a href="dashboard.php">Back to Dashboard</a>

    </div>

<?php } else { ?>

    <div class="summary">

        <h2>Booking Failed</h2>

        <p><?php echo $error; ?></p><br>

        <a href="dashboard.php">Back to Dashboard</a>
    </div>

<?php } ?>

</div>
</body>
</html>