<?php
include "config.php";

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $license_no = $_POST["license_no"];

    if (empty($username) || empty($password) || empty($email) || empty($phone) || empty($license_no)) {
        $error = "Fill the form completely";
    } else {
        $sql = "INSERT INTO driver (username, password, email, phone, license_no) 
                VALUES ('$username', '$password', '$email', '$phone', '$license_no')";

        if ($conn->query($sql) === TRUE) {
            $success = "Registration Complete";
        } else {
            $error = "ERROR: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Driver Registration</title>
</head>
<body>
    <h2>Register Driver</h2>
    <form method="post" action="">
        Username: <input type="text" name="username"><br><br>
        Email: <input type="email" name="email"><br><br>
        Password: <input type="password" name="password"><br><br>
        Phone: <input type="text" name="phone"><br><br>
        License No: <input type="text" name="license_no"><br><br>
        <input type="submit" value="Register">
    </form>

    <p style="color:green;"><?php echo $success; ?></p>
    <p style="color:red;"><?php echo $error; ?></p>
    <p><a href="driver_login.php">Already registered? Login here</a></p>
</body>
</html>