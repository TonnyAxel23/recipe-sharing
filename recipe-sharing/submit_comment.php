<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST' || !isset($_POST['recipe_id'])) {
    header("Location: /index.php");
    exit;
}

// Validate input
if (empty($_POST['username']) || empty($_POST['comment'])) {
    redirectWithMessage("/recipe.php?id=" . $_POST['recipe_id'], 'danger', 'Both name and comment are required.');
}

// Insert comment
try {
    $stmt = $pdo->prepare("INSERT INTO comments (recipe_id, username, comment) VALUES (?, ?, ?)");
    $stmt->execute([
        sanitize($_POST['recipe_id']),
        sanitize($_POST['username']),
        sanitize($_POST['comment'])
    ]);
    
    redirectWithMessage("/recipe.php?id=" . $_POST['recipe_id'], 'success', 'Comment added successfully!');
} catch (PDOException $e) {
    redirectWithMessage("/recipe.php?id=" . $_POST['recipe_id'], 'danger', 'Error adding comment: ' . $e->getMessage());
}
?>