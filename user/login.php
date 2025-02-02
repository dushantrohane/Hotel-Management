<?php
require_once 'db_connect.php'; // Include the database connection file

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect post data
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Prepare SQL and bind parameters
    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    // Verify the password
    if ($user && password_verify($password, $user['password'])) {
        echo "Login successful. Welcome back";
    } else {
        echo "Login failed. Invalid email or password.";
    }

    // Close statement
    $stmt->close();
}

// Close connection
$conn->close();
?>
