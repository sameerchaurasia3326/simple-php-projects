<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>PHP File Upload System</title>
<link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <h1>File Upload System</h1>
        
        <!-- Upload Form -->
        <form action="upload.php" method="POST" enctype="multipart/form-data">
            <input type="file" name="file" required>
            <button type="submit">Upload</button>
        </form>
        
        <h2>Uploaded Files</h2>
        <ul>
            <?php
            $files = array_diff(scandir('uploads'), ['.', '..']);
            if (count($files) > 0):
                foreach ($files as $file):
            ?>
            <li>
                <a href="uploads/<?php echo $file; ?>" target="_blank"><?php echo $file; ?></a>
                <a href="delete.php?file=<?php echo urlencode($file); ?>" class="delete-btn" onclick="return confirm('Are you sure you want to delete this file?')">Delete</a>
            </li>
            <?php
                endforeach;
            else:
            ?>
            <li>No files uploaded yet.</li>
            <?php endif; ?>
        </ul>
    </div>
</body>
</html>
