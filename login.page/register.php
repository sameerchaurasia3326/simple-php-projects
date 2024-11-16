<?php
$servername = "localhost";
$dbname = "login_app";
$dbusername = "root";
$dbpassword = "root";
$port = 8889;

$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];

    if (empty($username) || empty($email) || empty($password)) {
        header("Location: index.php?message=All fields are required");
        exit();
    }

    $checkUserSql = "SELECT * FROM users WHERE username = ? OR email = ?";
    $stmt = $conn->prepare($checkUserSql);
    $stmt->bind_param("ss", $username, $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        header("Location: index.php?message=Username or email already exists");
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
    $otp = rand(100000, 999999); // Generate a 6-digit OTP

    $insertSql = "INSERT INTO users (username, email, password, otp) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($insertSql);
    $stmt->bind_param("ssss", $username, $email, $hashedPassword, $otp);

    if ($stmt->execute()) {
        // Send OTP to email
        include 'send_otp.php';
        sendOtp($email, $otp);
        header("Location: verify.php?email=" . urlencode($email));
    } else {
        header("Location: index.php?message=Registration failed: " . $stmt->error);
    }

    $stmt->close();
}
$conn->close();
?>
