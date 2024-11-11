<?php
// Read tasks from the text file
$tasks = file_exists('tasks.txt') ? file('tasks.txt', FILE_IGNORE_NEW_LINES) : [];
$id = $_GET['id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title']);

    if (!empty($title) && isset($tasks[$id])) {
        $tasks[$id] = $title;
        file_put_contents('tasks.txt', implode(PHP_EOL, $tasks) . PHP_EOL);
    }

    // Redirect back to the main page
    header("Location: index.php");
    exit();
}

$currentTask = isset($tasks[$id]) ? $tasks[$id] : '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Edit Task</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h2>Edit Task</h2>
        <form action="" method="POST">
            <input type="text" name="title" value="<?php echo htmlspecialchars($currentTask); ?>" required>
            <button type="submit">Update Task</button>
        </form>
    </div>
</body>
</html>
