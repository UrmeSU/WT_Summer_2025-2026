<?php 
session_start(); 
include "db.php"; 
 
if (!isset($_SESSION["customer_name"])) { 
    header("Location: login.php"); 
    exit(); 
} 
 
$customer_name = $_SESSION["customer_name"]; 
 
$error = ""; 
$success = ""; 

if (!isset($_GET["booking_id"])) { 
    header("Location: booking_history.php"); 
    exit(); 
} 
 
$booking_id = $_GET["booking_id"]; 
 
$sql = "SELECT driver_booking.*, 
               driver.username AS driver_name 
        FROM driver_booking 
        LEFT JOIN driver 
        ON driver_booking.driver_id = driver.id 
        WHERE driver_booking.booking_id = '$booking_id' 
        AND driver_booking.customer_name = '$customer_name' 
        LIMIT 1"; 
 
$result = $conn->query($sql); 
 
 if (!$result || $result->num_rows == 0) { 
 
    $error = "Booking not found."; 
 
} else { 
 
    $row = $result->fetch_assoc(); 
 
    if ($row["driver_done"] != 1 || $row["customer_done"] != 1) { 
 
        $error = "You can give a review only after both Driver and Customer complete the trip."; 
 
    } 
 
    if ( 
        $_SERVER["REQUEST_METHOD"] == "POST" && 
        $row["driver_done"] == 1 && 
        $row["customer_done"] == 1 
    ) { 
 
        $rating = $_POST["rating"]; 
        $review = trim($_POST["review"]); 
 
        if (empty($rating) || empty($review)) { 
 
            $error = "Please give a rating and write a review."; 
 
        } elseif ($rating < 1 || $rating > 5) { 
 
            $error = "Rating must be between 1 and 5."; 
 
        } elseif (!empty($row["review"]) || !empty($row["rating"])) { 
 
            $error = "You have already submitted a review."; 
 
        } else { 
 
            $update_sql = "UPDATE driver_booking 
                           SET review = '$review', 
                               rating = '$rating' 
                           WHERE booking_id = '$booking_id' 
                           AND customer_name = '$customer_name'"; 
 
            if ($conn->query($update_sql) === TRUE) { 
 
                $success = "Review submitted successfully!"; 
 
            } else { 
 
                $error = "Error: " . $conn->error; 
 
            } 
        }  
    }  
} 
?> 
 
 <!DOCTYPE html> 
<html> 
 <head> 
 
    <title>Give Review</title> 
 
    <link rel="stylesheet" href="style.css"> 
 
</head> 
 
 <body> 
 
 <div class="container"> 
 
     <h2>Give Review</h2> 
 
     <?php if (!empty($error)) { ?> 
        <div class="summary"> 
 
            <p style="color:red;"> <?php echo $error; ?> </p> 
 </div> 
 
 <?php } ?> 
 
     <?php if (!empty($success)) { ?> 
 
        <div class="summary"> 
 
            <h3>Thank You!</h3> 
 
            <p style="color:green;"> <?php echo $success; ?> </p> <br> 
 
            <a href="booking_history.php"> Back to Booking History </a> 
 
        </div> 
 
     <?php } elseif ( 
        isset($row) && 
        $row["driver_done"] == 1 && 
        $row["customer_done"] == 1 && 
        empty($row["review"]) && 
        empty($row["rating"]) 
    ) { ?> 
 
        <div class="summary"> 
 
             <h3>Trip Completed</h3> 
 
             <p> <strong>Booking ID:</strong> #<?php echo $booking_id; ?> </p> 
             <p> <strong>Driver:</strong> <?php echo $row["driver_name"]; ?> </p> 
 
             <hr>  
 
            <form method="post"> 
 
                <label> <strong>Rating</strong> </label><br><br> 
 
                 <select name="rating" required> 
 
                    <option value=""> 
                        Select Rating 
                    </option> 
 
                    <option value="5"> 
                        5 - Excellent 
                    </option> 
 
                    <option value="4"> 
                        4 - Very Good 
                    </option> 
 
                    <option value="3"> 
                        3 - Good 
                    </option> 
 
                    <option value="2"> 
                        2 - Average 
                    </option> 
 
                    <option value="1"> 
                        1 - Poor 
                    </option> 
 
                </select> 
                 <br><br> 
 
                 <label> <strong>Your Review</strong> </label> <br><br> 
                 <textarea 
                    name="review" 
                    rows="5" 
                    cols="40" 
                    placeholder="Write your review here..." 
                    required 
                ></textarea> 
                 <br><br> 
 
                 <input 
                    type="submit" 
                    value="Submit Review" 
                > 
  
            </form> 
        </div> 
 
     <?php } ?> 
 
     <br> 
 
    <div style="text-align:center;"> 
 
        <a href="booking_history.php"> ← Back to Booking History </a> 
 </div> 
      <br> 
 
    <div class="logout"> 
 
        <a href="logout.php"> Logout </a> 
 
    </div> 
 </div> 
 </body> 
 </html>