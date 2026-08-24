<?php
include "config.php";

$success = $error = "";

// --- ADD (Registration) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["register"])) {
    $username = $_POST["username"];
    $password = $_POST["password"];
    $email    = $_POST["email"];
    $address  = $_POST["address"];
    $dob      = $_POST["dob"];
    $gender   = $_POST["gender"];

    if (empty($username) || empty($password) || empty($email) || empty($address) || empty($dob) || empty($gender)) {
        $error = "Fill the form";
    } else {
        $sql = "INSERT INTO wt_k (username, password, email, address, dob, gender) 
                VALUES ('$username', '$password', '$email', '$address', '$dob', '$gender')";
        if ($conn->query($sql) === TRUE) {
            $success = "Registration Complete";
        } else {
            $error = "ERROR: " . $conn->error;
        }
    }
}

// --- DELETE (by username) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["delete"])) {
    $deleteName = $_POST["deleteName"];
    $sql = "DELETE FROM wt_k WHERE username='$deleteName'";
    if ($conn->query($sql) === TRUE) {
        $success = "User Deleted!";
    } else {
        $error = "ERROR: " . $conn->error;
    }
}

// --- UPDATE (email by username) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["update"])) {
    $updateName = $_POST["updateName"];
    $newEmail   = $_POST["newEmail"];
    $sql = "UPDATE wt_k SET email='$newEmail' WHERE username='$updateName'";
    if ($conn->query($sql) === TRUE) {
        $success = "Email Updated!";
    } else {
        $error = "ERROR: " . $conn->error;
    }
}

// --- SELECT (Show All Users) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["show"])) {
    $sql = "SELECT * FROM wt_k";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $success = "All Users:<br>";
        while($row = $result->fetch_assoc()) {
            $success .= "Username: ".$row["username"]." | Email: ".$row["email"]." | Address: ".$row["address"]." | DOB: ".$row["dob"]." | Gender: ".$row["gender"]."<br>";
        }
    } else {
        $error = "No users found!";
    }
}

// --- SEARCH (by username) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["search"])) {
    $searchName = $_POST["searchName"];
    $sql = "SELECT * FROM wt_k WHERE username='$searchName'";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $success = "User Found:<br>";
        while($row = $result->fetch_assoc()) {
            $success .= "Username: ".$row["username"]." | Email: ".$row["email"]." | Address: ".$row["address"]." | DOB: ".$row["dob"]." | Gender: ".$row["gender"]."<br>";
        }
    } else {
        $error = "No user found!";
    }
}

// --- SORT (by username ASC) ---
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["sort"])) {
    $sql = "SELECT * FROM wt_k ORDER BY username ASC";
    $result = $conn->query($sql);
    if ($result->num_rows > 0) {
        $success = "Sorted Users:<br>";
        while($row = $result->fetch_assoc()) {
            $success .= "Username: ".$row["username"]." | Email: ".$row["email"]." | Address: ".$row["address"]." | DOB: ".$row["dob"]." | Gender: ".$row["gender"]."<br>";
        }
    } else {
        $error = "No users found!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>User Registration</title>
</head>
<body>
    <h2>Register</h2>
    <form method="post" action="">
        Username: <input type="text" name="username"><br><br>
        Password: <input type="password" name="password"><br><br>
        Email: <input type="email" name="email"><br><br>
        Address: <input type="text" name="address"><br><br>
        Date of Birth: <input type="date" name="dob"><br><br>
        Gender: 
        <input type="radio" name="gender" value="Male"> Male
        <input type="radio" name="gender" value="Female"> Female
        <br><br>
        <input type="submit" name="register" value="Register">
    </form>

    <h2>Delete User</h2>
    <form method="post" action="">
        Username: <input type="text" name="deleteName"><br><br>
        <input type="submit" name="delete" value="Delete">
    </form>

    <h2>Update Email</h2>
    <form method="post" action="">
        Username: <input type="text" name="updateName"><br><br>
        New Email: <input type="email" name="newEmail"><br><br>
        <input type="submit" name="update" value="Update">
    </form>

    <h2>Show All Users (Select)</h2>
    <form method="post" action="">
        <input type="submit" name="show" value="Show All">
    </form>

    <h2>Search User</h2>
    <form method="post" action="">
        Username: <input type="text" name="searchName"><br><br>
        <input type="submit" name="search" value="Search">
    </form>

    <h2>Sort Users</h2>
    <form method="post" action="">
        <input type="submit" name="sort" value="Sort by Username">
    </form>

    <p style="color:green;"><?php echo $success; ?></p>
    <p style="color:red;"><?php echo $error; ?></p>
</body>
</html>
