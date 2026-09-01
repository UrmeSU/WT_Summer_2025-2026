<?php 
session_start(); 
include "db.php"; 
 
$error = ""; 
 
if ($_SERVER["REQUEST_METHOD"] == "POST") { 
 
    $user_input = trim($_POST["user_input"]); 
    $password = trim($_POST["password"]); 
 
    if (empty($user_input) || empty($password)) { 
 
        $error = "Fill the form"; 
 
    } else { 
 
        $sql = "SELECT * FROM customer  
                WHERE (email='$user_input' OR name='$user_input')  
                AND password='$password'"; 
 
        $result = $conn->query($sql); 
 
        if ($result && $result->num_rows > 0) { 
 
            $row = $result->fetch_assoc(); 
 
            // Create Session
            $_SESSION["customer_name"] = $row["name"]; 
 
            // Create Cookie
            setcookie("customer_name",$row["name"],time() + (86400 * 30),"/");
            header("Location: dashboard.php"); 
            exit(); 
 
        } else { 
 
            $error = "Invalid Username/Email or Password"; 
        } 
    } 
} 
?> 
 
<!DOCTYPE html> 
<html> 
<head> 
    <title>Sign in to Tourism Car Rental Portal</title> 
</head> 
 
<body> 
 
    <h2>Sign in to Tourism Car Rental Portal</h2> 
 
    <form method="post" action=""> 
 
        Username or Email: 
        <input type="text" name="user_input" required><br><br> 
 
        Password: 
        <input type="password" name="password" required><br><br> 
 
        <input type="submit" value="Login"> 
 
    </form> 
 
    <p style="color:red;"><?php echo $error; ?></p><br> 
 
    Don't have an account? 
    <a href="register.php">Sign up</a> 
 
</body> 
</html>