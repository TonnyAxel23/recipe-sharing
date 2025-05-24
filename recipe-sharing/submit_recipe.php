<?php
require_once 'includes/config.php';
require_once 'includes/header.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    header("Location: /add_recipe.php");
    exit;
}

// Validate required fields
$required = ['title', 'description', 'ingredients', 'steps', 'category'];
$errors = [];

foreach ($required as $field) {
    if (empty($_POST[$field])) {
        $errors[] = ucfirst($field) . " is required.";
    }
}

if (!empty($errors)) {
    redirectWithMessage('/add_recipe.php', 'danger', implode('<br>', $errors));
}

// Handle file upload
$imagePath = null;
if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $imagePath = handleFileUpload($_FILES['image']);
    if (!$imagePath && $_FILES['image']['error'] !== UPLOAD_ERR_NO_FILE) {
        redirectWithMessage('/add_recipe.php', 'danger', 'Invalid file upload. Please upload an image (JPG, PNG, GIF) under 2MB.');
    }
}

// Insert recipe into database
try {
    $stmt = $pdo->prepare("INSERT INTO recipes (title, description, ingredients, steps, category, image_path) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        sanitize($_POST['title']),
        sanitize($_POST['description']),
        sanitize($_POST['ingredients']),
        sanitize($_POST['steps']),
        sanitize($_POST['category']),
        $imagePath
    ]);
    
    $recipeId = $pdo->lastInsertId();
    redirectWithMessage("/recipe.php?id=$recipeId", 'success', 'Recipe added successfully!');
} catch (PDOException $e) {
    redirectWithMessage('/add_recipe.php', 'danger', 'Database error: ' . $e->getMessage());
}
?>