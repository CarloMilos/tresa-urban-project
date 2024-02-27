<?php
// Include database connection
include 'dbcon.php';

// Update 'validated' column in the database
$stmt_update_validated = $pdo->prepare("UPDATE post SET validated = 1 WHERE validated IS NULL");
$stmt_update_validated->execute();
?>