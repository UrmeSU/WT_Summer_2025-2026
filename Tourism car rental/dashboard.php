<?php
session_start();

if (!isset($_SESSION["customer_name"])) {
    header("Location: login.php");
    exit();
}

$customer_name = $_SESSION["customer_name"];

if (isset($_COOKIE["customer_name"])) {
    $customer_name = $_COOKIE["customer_name"];
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Dashboard</title>

    <link rel="stylesheet" href="style.css">
</head>

<body>

<div class="container">

    <h2>Choose Your Car, Start Your Adventure</h2>

    <div class="welcome">Welcome,<?php echo $customer_name; ?>!</div>


    <div class="booking-form">

        <form method="post" action="booking.php">

            <label><strong>Pick-up Location</strong></label><br>

            <select name="destination" required>

                <option value="">Select Destination</option>

                <option value="Sylhet">Sylhet</option>

                <option value="Coxs Bazar">Coxs Bazar</option>

                <option value="Bandarban">Bandarban</option>

                <option value="Rangamati">Rangamati</option>

            </select><br>


            <label><strong>Rental Date</strong></label><br>

            <input
                type="date"
                name="rental_date"
                required
            >
            <br>


            <h3>Available Cars</h3>


            <div class="cars">

                <div class="car">

                    <h3>🚗 Toyota Allion</h3>

                    <p>5 Seats, AC, 2 Bags</p>

                    <p class="price">4,000Tk / day</p>

                    <button
                        type="submit"
                        name="vehicle"
                        value="Toyota Allion"
                        class="select-btn"
                    >
                    SELECT
                    </button>

                </div>

                <div class="car">

                    <h3>🚗 Toyota Premio</h3>

                    <p>5 Seats, AC, 4 Bags</p>

                    <p class="price">6,000Tk / day</p>

                    <button
                        type="submit"
                        name="vehicle"
                        value="Toyota Premio"
                        class="select-btn"
                    >
                    SELECT
                    </button>

                </div>

                <div class="car">

                    <h3>🚐 Toyota Hiace</h3>

                    <p>10 Seats, AC, 6 Bags</p>

                    <p class="price">8,000Tk / day</p>

                    <button
                        type="submit"
                        name="vehicle"
                        value="Toyota Hiace"
                        class="select-btn"
                    >
                    SELECT
                    </button>
                </div>
            </div>
        </form>
    </div>
  <div style="text-align:center; margin-top:20px;">

        <a href="booking_history.php">View Booking History</a>

    </div><br>


    <div class="logout">

        <a href="logout.php">Logout</a>

    </div>

</div>
</body>
</html>