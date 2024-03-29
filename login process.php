<?php
session_start();


$servername = "localhost";
$db_username = "root"; 
$db_password = ""; 
$dbname = "registration"; 

// Create connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get login credentials from the login form
$username = $_POST['username'];
$password = $_POST['password'];




$sql = "SELECT * FROM userregister WHERE Username = ? AND Password = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ss", $username, $password);
$stmt->execute();
$result = $stmt->get_result();



// Check if a user with the provided credentials exists
if ($result->num_rows > 0) {
    // User exists, set session variables and redirect to home page
    $row = $result->fetch_assoc();
    $_SESSION['user_id'] = $row['user_id']; 
    $_SESSION['username'] = $username;

    echo "User ID: " . $_SESSION['user_id'] . "<br>";
    echo "Username: " . $_SESSION['username'] . "<br>";
 
    header("Location: home.php");
    exit();
} else {
    
    echo "<script>alert('Incorrect username or password. Please try again.');</script>";
   
    echo "<script>window.location.href = 'login.php';</script>";
    exit();
}



$stmt->close();
$conn->close();
?>
