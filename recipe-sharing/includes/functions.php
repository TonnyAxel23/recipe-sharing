<?php
/**
 * Sanitize input data
 */
function sanitize($data) {
    return htmlspecialchars(trim($data), ENT_QUOTES, 'UTF-8');
}

/**
 * Validate and handle file upload
 */
function handleFileUpload($file, $uploadDir = UPLOAD_DIR) {
    if ($file['error'] !== UPLOAD_ERR_OK) {
        return null;
    }

    // Validate file type
    $fileType = mime_content_type($file['tmp_name']);
    if (!in_array($fileType, ALLOWED_TYPES)) {
        return null;
    }

    // Validate file size
    if ($file['size'] > MAX_SIZE) {
        return null;
    }

    // Create upload directory if not exists
    if (!file_exists($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Generate unique filename
    $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
    $filename = uniqid() . '.' . $extension;
    $targetPath = $uploadDir . $filename;

    // Move uploaded file
    if (move_uploaded_file($file['tmp_name'], $targetPath)) {
        return $targetPath;
    }

    return null;
}

/**
 * Get all recipe categories
 */
function getCategories() {
    return [
        'Main Course',
        'Dessert',
        'Appetizer',
        'Salad',
        'Soup',
        'Drink',
        'Breakfast',
        'Snack'
    ];
}

/**
 * Redirect with flash message
 */
function redirectWithMessage($url, $type, $message) {
    $_SESSION['flash'] = [
        'type' => $type,
        'message' => $message
    ];
    header("Location: $url");
    exit;
}

/**
 * Display flash message if exists
 */
function displayFlashMessage() {
    if (isset($_SESSION['flash'])) {
        $type = $_SESSION['flash']['type'];
        $message = $_SESSION['flash']['message'];
        echo '<div class="alert alert-' . $type . ' alert-dismissible fade show">';
        echo $message;
        echo '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>';
        echo '</div>';
        unset($_SESSION['flash']);
    }
}
?>