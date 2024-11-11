<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_FILES['file'])) {
    $uploadDir = 'uploads/';
    $fileName = basename($_FILES['file']['name']);
    $targetFilePath = $uploadDir . $fileName;
    $fileType = pathinfo($targetFilePath, PATHINFO_EXTENSION);

    // Allow specific file types
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif', 'pdf', 'txt', 'docx'];
    
    if (in_array(strtolower($fileType), $allowedTypes)) {
        if (move_uploaded_file($_FILES['file']['tmp_name'], $targetFilePath)) {
            echo "File uploaded successfully.";
        } else {
            echo "Error uploading the file.";
        }
    } else {
        echo "Invalid file type. Allowed types: " . implode(", ", $allowedTypes);
    }
}

header("Location: index.php");
exit();
?>
