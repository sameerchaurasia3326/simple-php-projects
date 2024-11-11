<?php
// Read tasks from the text file
$tasks = file_exists('tasks.txt') ? file('tasks.txt', FILE_IGNORE_NEW_LINES) : [];
$id = $_GET['id'];

if (isset($tasks[$id])) {
    // Remove the task and update the file
    unset($tasks[$id]);
    file_put_contents('tasks.txt', implode(PHP_EOL, $tasks) . PHP_EOL);
}

// Redirect back to the main page
header("Location: index.php");
exit();
?>
