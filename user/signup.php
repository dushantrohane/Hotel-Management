<?php
require_once 'db_connect.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect post data
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password match
    if ($password !== $confirm_password) {
        die('Passwords do not match.');
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare SQL and bind parameters
    $stmt = $conn->prepare("INSERT INTO users (name, dob, email, contact, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $dob, $email, $contact, $hashed_password);

    // Execute the query
    if ($stmt->execute()) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
