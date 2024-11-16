<?php
$servername = "localhost";
$dbname = "login_app";
$dbusername = "root";
$dbpassword = "root";
$port = 8889;

// Start the PHP block immediately without any whitespace before it
$conn = new mysqli($servername, $dbusername, $dbpassword, $dbname, $port);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if POST request was made
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'];
    $otp = $_POST['otp'];

    // Prepare the SQL query to match the OTP
    $sql = "SELECT * FROM users WHERE email = ? AND otp = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $otp);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if OTP is correct
    if ($result->num_rows > 0) {
        // If OTP matches, update the user record to verify the email
        $updateSql = "UPDATE users SET is_verified = 1, otp = NULL WHERE email = ?";
        $stmt = $conn->prepare($updateSql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        
        // Redirect to the index page with a success message
        header("Location: index.php?message=Email verified successfully!");
        exit(); // Important to stop further execution
    } else {
        // If OTP is incorrect, redirect back to the verify page with an error message
        header("Location: verify.php?email=" . urlencode($email) . "&message=Invalid OTP");
        exit(); // Important to stop further execution
    }

    // Close prepared statements
    $stmt->close();
}
$conn->close();
?>
<?php
// Display any message passed in the query string
$message = isset($_GET['message']) ? $_GET['message'] : '';
$email = isset($_GET['email']) ? $_GET['email'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Verify OTP</title>
<link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <h2>Verify OTP</h2>
        
        <?php
        if ($message) {
            echo '<div id="message">' . htmlspecialchars($message) . '</div>';
        }
        ?>
        
        <form action="verify.php" method="POST">
            <input type="hidden" name="email" value="<?php echo htmlspecialchars($email); ?>">
            <input type="text" name="otp" placeholder="Enter OTP" required>
            <button type="submit">Verify</button>
        </form>
    </div>
</body>
</html>
