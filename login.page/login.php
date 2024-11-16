<?php
header('Content-Type: application/json');
$data = json_decode(file_get_contents('php://input'), true);

$username = $data['username'];
$password = $data['password'];

// Database connection
$servername = "localhost";
$dbname = "login_app";
$dbusername = "root";
$dbpassword = "root"; // Use your MAMP default password if different

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname);

if ($conn->connect_error) {
    die(json_encode(['message' => 'Database connection failed']));
}

// Check if user exists
$sql = "SELECT * FROM users WHERE username = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $user = $result->fetch_assoc();
    if (password_verify($password, $user['password'])) {
        echo json_encode(['message' => 'Login successful']);
    } else {
        echo json_encode(['message' => 'Invalid password']);
    }
} else {
    echo json_encode(['message' => 'User not found']);
}

$stmt->close();
$conn->close();
?>
