<?php
session_start();
include "config.php";

if (!isset($_SESSION['driver_id'])) {
    header("Location: driver_login.php");
    exit();
}

$driver_id = $_SESSION['driver_id'];
$msg = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $phone = $_POST['phone'];
    $license_no = $_POST['license_no'];

    $sql = "UPDATE driver SET username='$username', phone='$phone', license_no='$license_no' WHERE id='$driver_id'";
    if ($conn->query($sql) === TRUE) {
        $_SESSION['driver_name'] = $username;
        $msg = "Profile updated successfully!";
    }
}

$driver_res = $conn->query("SELECT * FROM driver WHERE id='$driver_id'");
$driver = $driver_res->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head><title>Manage Profile</title></head>
<body>
    <h2>Manage Driver Profile</h2>
    <a href="driver_dashboard.php">Back to Dashboard</a><br><br>
    
    <p style="color:green;"><?php echo $msg; ?></p>
    
    <form method="post">
        Username: <input type="text" name="username" value="<?php echo $driver['username']; ?>"><br><br>
        Email: <input type="email" value="<?php echo $driver['email']; ?>" disabled><br><br>
        Phone: <input type="text" name="phone" value="<?php echo $driver['phone']; ?>"><br><br>
        License No: <input type="text" name="license_no" value="<?php echo $driver['license_no']; ?>"><br><br>
        <input type="submit" value="Update Profile">
    </form>
</body>
</html>