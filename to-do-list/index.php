<?php
// Read tasks from the text file
$tasks = file_exists('tasks.txt') ? file('tasks.txt', FILE_IGNORE_NEW_LINES) : [];
?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>To-Do List (Enhanced UI)</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="app-container">
        <div class="todo-wrapper">
            <h1>My To-Do List</h1>
            <form class="add-task-form" action="add_task.php" method="POST">
                <input type="text" name="title" placeholder="Enter a new task" required>
                <button type="submit">Add</button>
            </form>
            <ul class="task-list">
                <?php foreach ($tasks as $index => $task): ?>
                    <li class="task-item">
                        <span><?php echo htmlspecialchars($task); ?></span>
                        <div class="task-actions">
                            <a class="edit-btn" href="update_task.php?id=<?php echo $index; ?>">✏️ Edit</a>
                            <a class="delete-btn" href="delete_task.php?id=<?php echo $index; ?>" onclick="return confirm('Are you sure?')">🗑️ Delete</a>
                        </div>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    </div>
</body>
</html>
