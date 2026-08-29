<?php
session_start();
include "config.php";

if (!isset($_SESSION['driver_id'])) {
    header("Location: driver_login.php");
    exit();
}

$driver_id = $_SESSION['driver_id'];

// Handle Service Update: Mark Ride as Completed
if (isset($_POST['complete_trip'])) {
    $booking_id = $_POST['booking_id'];
    $conn->query("UPDATE booking SET status='Completed' WHERE booking_id='$booking_id' AND driver_id='$driver_id'");
}

// Fetch Assigned Booking Notifications and Trip Details
$trips_sql = "SELECT * FROM booking WHERE driver_id = '$driver_id' ORDER BY booking_id DESC";
$trips_result = $conn->query($trips_sql);
?>

<!DOCTYPE html>
<html>
<head><title>Driver Dashboard</title></head>
<body>
    <h2>Welcome, <?php echo $_SESSION['driver_name']; ?></h2>
    <a href="driver_profile.php">Manage Profile</a> | <a href="logout.php">Logout</a>
    <hr>

    <h3>Booking Notifications & Trip History</h3>
    <table border="1" cellpadding="8" cellspacing="0">
        <tr>
            <th>Booking ID</th>
            <th>Customer Name</th>
            <th>Phone</th>
            <th>Destination</th>
            <th>Trip Date</th>
            <th>Confirm Code</th>
            <th>Status</th>
            <th>Action</th>
        </tr>
        <?php if ($trips_result && $trips_result->num_rows > 0): ?>
            <?php while ($row = $trips_result->fetch_assoc()): ?>
            <tr>
                <td>#<?php echo $row['booking_id']; ?></td>
                <td><?php echo $row['customer_name']; ?></td>
                <td><?php echo $row['customer_phone']; ?></td>
                <td><?php echo $row['destination']; ?></td>
                <td><?php echo $row['trip_date']; ?></td>
                <td><?php echo $row['confirm_code']; ?></td>
                <td><strong><?php echo $row['status']; ?></strong></td>
                <td>
                    <?php if ($row['status'] != 'Completed'): ?>
                        <form method="post">
                            <input type="hidden" name="booking_id" value="<?php echo $row['booking_id']; ?>">
                            <input type="submit" name="complete_trip" value="Mark as Completed">
                        </form>
                    <?php else: ?>
                        Trip Completed
                    <?php endif; ?>
                </td>
            </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr><td colspan="8">No assigned bookings found.</td></tr>
        <?php endif; ?>
    </table>
</body>
</html>