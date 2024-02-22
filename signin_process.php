<?php
// Database connection
$servername = "localhost";
$username = "id21088974_admin";
$password = "Isroil#1234";
$dbname = "id21088974_my_first_db";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Retrieve form data
$username_or_email = $_POST['username_or_email'];
$password = $_POST['password'];

// Check if the input is a valid email address
if (filter_var($username_or_email, FILTER_VALIDATE_EMAIL)) {
    $sql = "SELECT * FROM users WHERE email='$username_or_email'";
} else {
    $sql = "SELECT * FROM users WHERE username='$username_or_email'";
}

$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        // Start the session
        session_start();
        // Store user data in session variables
        $_SESSION['user_id'] = $row['user_id'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['email'] = $row['email'];
        // Redirect to main menu after successful signin
        header("Location: main_menu.php");
        exit();
    } else {
        echo "Incorrect password";
    }
} else {
    echo "User not found";
}

$conn->close();
?>
