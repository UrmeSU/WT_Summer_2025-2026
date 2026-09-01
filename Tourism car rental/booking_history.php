<?php
session_start();
include "db.php";

if (!isset($_SESSION["customer_name"])) {
    header("Location: login.php");
    exit();
}

$customer_name = $_SESSION["customer_name"];
if (isset($_POST["customer_done"])) {

    $booking_id = $_POST["booking_id"];

    $done_sql = "UPDATE driver_booking
                 SET customer_done = 1
                 WHERE booking_id = '$booking_id'
                 AND customer_name = '$customer_name'";

    $conn->query($done_sql);
}
$sql = "SELECT booking.*,
               driver_booking.driver_id,
               driver_booking.driver_done,
               driver_booking.customer_done,
               driver_booking.review,
               driver_booking.rating,
               driver.username AS driver_name,
               driver.phone AS driver_phone
        FROM booking
        LEFT JOIN driver_booking
        ON booking.confirmation_code = driver_booking.confirm_code
        LEFT JOIN driver
        ON driver_booking.driver_id = driver.id
        WHERE booking.customer_name = '$customer_name'
        ORDER BY booking.booking_id DESC";

$result = $conn->query($sql);

?>

<!DOCTYPE html>
<html>

<head>

    <title>Booking History</title>

    <link rel="stylesheet" href="style.css">

</head>

<body>
<div class="container">

    <h2>Booking History</h2>

    <p class="welcome">Welcome, <?php echo $customer_name; ?>!</p>

<?php

    if ($result && $result->num_rows > 0) {

        while ($row = $result->fetch_assoc()) {
    ?>
        <div class="summary">
    
            <h3>Booking #<?php echo $row["booking_id"]; ?></h3>

            <p><strong>Destination:</strong><?php echo $row["destination"]; ?></p>
            <p><strong>Rental Date:</strong><?php echo $row["rental_date"]; ?></p>
            <p><strong>Vehicle:</strong><?php echo $row["vehicle_name"]; ?></p>
            <p><strong>Seats:</strong><?php echo $row["seats"]; ?></p>
            <p><strong>AC:</strong><?php echo $row["ac"]; ?></p>
            <p><strong>Bags:</strong><?php echo $row["bags"]; ?></p>
            <p><strong>Price:</strong><?php echo $row["price"]; ?> / day</p>
            <p><strong>Payment:</strong><?php echo $row["payment_method"]; ?></p>
            <p><strong>Status:</strong><?php echo $row["booking_status"]; ?></p>
            <p><strong>Confirmation Code:</strong><?php echo $row["confirmation_code"]; ?></p>

            <hr>
 
            <h3>Driver Information</h3>
 
            <?php if (!empty($row["driver_name"])) { ?>

                <p><strong>Driver Name:</strong><?php echo $row["driver_name"]; ?></p>
                <p><strong>Driver Phone:</strong><?php echo $row["driver_phone"]; ?></p>
                <p><strong>Driver Status:</strong>

                    <?php

                    if ($row["driver_done"] == 1) {

                        echo "Completed";

                    } else {

                        echo "Pending";

                    }

                    ?>

                </p>
               <p><strong>Your Status:</strong>

                    <?php

                    if ($row["customer_done"] == 1) {

                        echo "Completed";

                    } else {

                        echo "Pending";

                    }
                    ?>
                </p>
                <br>
                <?php if ($row["customer_done"] == 0) { ?>
                    <form method="post">

                        <input
                            type="hidden"
                            name="booking_id"
                            value="<?php echo $row["booking_id"]; ?>"
                        >
                        <input
                            type="submit"
                            name="customer_done"
                            value="DONE"
                        >
                    </form>
                <?php } else { ?>

                <p><strong>Customer:</strong>Trip Completed</p>

                <?php } ?>

                <br>
                <?php if (
                    $row["driver_done"] == 1 &&
                    $row["customer_done"] == 1
                ) { ?>
                    <p><strong>Trip Status:</strong>Completed</p>

                    <?php if (
                        empty($row["review"]) &&
                        empty($row["rating"])
                    ) { ?>

                        <a href="review.php?booking_id=<?php echo $row["booking_id"]; ?>">

                            Give Review

                        </a>

                        <?php } else { ?>

                        <p><strong>Your Review:</strong><?php echo $row["review"]; ?></p>
                        <p><strong>Your Rating:</strong><?php echo $row["rating"]; ?>/5</p>

                    <?php } ?>
                <?php } ?>
            <?php } else { ?>
                <p><strong>Driver:</strong>Not assigned yet</p>

            <?php } ?>
        </div>
        <br>
    <?php

        }

    } else {

    ?>

        <div class="summary">

            <h3>No Booking Found</h3>

            <p>You have not made any booking yet.</p>

        </div>
   <?php

    }

    ?>
    <br>
    <div style="text-align:center;">

        <a href="dashboard.php">Back to Dashboard</a>

    </div>
    <br>
    <div class="logout">

        <a href="logout.php">Logout</a>

    </div>
</div>
</body>
</html>