<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST['title'];
    $author = $_POST['author'];
    $action = $_POST['action'];

    if ($action == 'may') {
        $title = strtoupper($title);
        $author = strtoupper($author);
    } else if ($action == 'min') {
        $title = strtolower($title);
        $author = strtolower($author);
    }
    
    echo "<h1>$title</h1>";
    echo "<h2>$author</h2>";
}
?>
