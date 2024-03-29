<?php
session_start();
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $username = $_POST['username'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = $_POST['password'];

  


    $servername = "localhost";
    $db_username = "root";
    $db_password = "";
    $dbname = "registration"; 

    
    $conn = new mysqli($servername, $db_username, $db_password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Prepare SQL statement
    $sql = "INSERT INTO userregister (Username, Email, Phonenumber, Password) VALUES (?, ?, ?, ?)";

  
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $username, $email, $phone, $password);

    if ($stmt->execute() === TRUE) {

       
    $user_id = $stmt->insert_id;
    
    
    // Store the user ID in the session variable
    $_SESSION['user_id'] = $user_id;

  
        header("Location: login.php");
        exit; 
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>

