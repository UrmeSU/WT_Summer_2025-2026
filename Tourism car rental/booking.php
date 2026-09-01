<?php
session_start();

if (!isset($_SESSION["customer_name"])) {
    header("Location: login.php");
    exit();
}
if (
    !isset($_POST["destination"]) ||
    !isset($_POST["rental_date"]) ||
    !isset($_POST["vehicle"])
) {
    header("Location: dashboard.php");
    exit();
}
$customer_name = $_SESSION["customer_name"];

$destination = $_POST["destination"];
$rental_date = $_POST["rental_date"];
$vehicle = $_POST["vehicle"];
if ($vehicle == "Toyota Allion") {

    $price = 4000;
    $seats = 5;
    $ac = "Yes";
    $bags = 2;

} elseif ($vehicle == "Toyota Premio") {

    $price = 6000;
    $seats = 5;
    $ac = "Yes";
    $bags = 4;

} elseif ($vehicle == "Toyota Hiace") {

    $price = 8000;
    $seats = 10;
    $ac = "Yes";
    $bags = 6;

} else {

    header("Location: dashboard.php");
    exit();

}
?>

<!DOCTYPE html>
<html>

<head>

    <title>Booking Details</title>

    <link rel="stylesheet" href="style.css">

</head>
<body>

<div class="container">

    <h2>Booking Summary</h2>

    <div class="summary">

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
   
     <br>

     <form method="post" action="booking_confirm.php">


            <input
                type="hidden"
                name="destination"
                value="<?php echo $destination; ?>"
            >
            <input
                type="hidden"
                name="rental_date"
                value="<?php echo $rental_date; ?>"
            >
           <input
                type="hidden"
                name="vehicle"
                value="<?php echo $vehicle; ?>"
            >
            <input
                type="hidden"
                name="price"
                value="<?php echo $price; ?>"
            >
            <input
                type="hidden"
                name="seats"
                value="<?php echo $seats; ?>"
            >
            <input
                type="hidden"
                name="ac"
                value="<?php echo $ac; ?>"
            >
            <input
                type="hidden"
                name="bags"
                value="<?php echo $bags; ?>"
            >
            <button
                type="submit"
                class="confirm-btn"
            >
                CONFIRM BOOKING
            </button>
        </form>
        <br>
        <a href="dashboard.php">
            ← Back to Dashboard
        </a>
    </div>
</div>
</body>
</html>