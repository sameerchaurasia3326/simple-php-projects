<?php
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);

    if (!empty($title)) {
        // Append the task to the file
        file_put_contents('tasks.txt', $title . PHP_EOL, FILE_APPEND);
    }

    // Redirect back to the main page
    header("Location: index.php");
    exit();
}
?>
