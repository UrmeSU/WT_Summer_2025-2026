<?php
include "db.php";

$success = $error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST["name"];
    $email = $_POST["email"];
    $phone = $_POST["phone"];
    $password = $_POST["password"];

    if (empty($name) || empty($email) || empty($phone) || empty($password)) {
        $error = "Fill the form";
    } else {
        $sql = "INSERT INTO customer (name, email, phone, password) VALUES ('$name', '$email', '$phone', '$password')";
        
        if ($conn->query($sql) === TRUE) {
            echo "<script>
                    alert('Registration Complete');
                    window.location.href = 'login.php';
                  </script>";
        } else {
            $error = "ERROR: " . $conn->error;
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Customer Registration</title>
</head>
<body>
    <h2>Register</h2>
    <form method="post" action="">
        Name: <input type="text" name="name"><br><br>
        Email: <input type="email" name="email"><br><br>
        Phone: <input type="text" name="phone"><br><br>
        Password: <input type="password" name="password"><br><br>
        <input type="submit" value="Register">
    </form>

    <p style="color:red;"><?php echo $error; ?></p>
    <br>
    Already have an account? <a href="login.php">Login</a>
</body>
</html>