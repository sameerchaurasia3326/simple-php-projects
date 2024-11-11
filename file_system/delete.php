<?php
if (isset($_GET['file'])) {
    $file = urldecode($_GET['file']);
    $filePath = 'uploads/' . $file;

    if (file_exists($filePath)) {
        unlink($filePath);
        echo "File deleted successfully.";
    } else {
        echo "File not found.";
    }
}

header("Location: index.php");
exit();
?>
