<?php
require_once 'includes/config.php';
$pageTitle = "Recipe Sharing Platform";
require_once 'includes/header.php';

// Handle search
$search = isset($_GET['search']) ? '%' . $_GET['search'] . '%' : null;
$category = isset($_GET['category']) ? $_GET['category'] : null;

// Build query
$sql = "SELECT * FROM recipes WHERE 1=1";
$params = [];

if ($search) {
    $sql .= " AND (title LIKE :search OR description LIKE :search OR ingredients LIKE :search)";
    $params[':search'] = $search;
}

if ($category) {
    $sql .= " AND category = :category";
    $params[':category'] = $category;
}

$sql .= " ORDER BY created_at DESC";

$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$recipes = $stmt->fetchAll();
?>

<h1 class="mb-4">Recipes</h1>

<div class="row mb-4">
    <div class="col-md-6">
        <form method="GET" class="row g-2">
            <div class="col-md-8">
                <select name="category" class="form-select" onchange="this.form.submit()">
                    <option value="">All Categories</option>
                    <?php foreach (getCategories() as $cat): ?>
                        <option value="<?= $cat ?>" <?= $category === $cat ? 'selected' : '' ?>>
                            <?= $cat ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="col-md-4">
                <a href="/index.php" class="btn btn-outline-secondary w-100">Reset</a>
            </div>
        </form>
    </div>
</div>

<?php if (empty($recipes)): ?>
    <div class="alert alert-info">
        No recipes found. <a href="/add_recipe.php" class="alert-link">Add the first recipe!</a>
    </div>
<?php else: ?>
    <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
        <?php foreach ($recipes as $recipe): ?>
            <div class="col">
                <div class="card h-100">
                    <?php if ($recipe['image_path']): ?>
                        <img src="<?= $recipe['image_path'] ?>" class="card-img-top" alt="<?= sanitize($recipe['title']) ?>">
                    <?php else: ?>
                        <div class="card-img-top bg-secondary d-flex align-items-center justify-content-center" style="height: 200px;">
                            <i class="bi bi-image text-white" style="font-size: 3rem;"></i>
                        </div>
                    <?php endif; ?>
                    <div class="card-body">
                        <h5 class="card-title"><?= sanitize($recipe['title']) ?></h5>
                        <p class="card-text text-muted">
                            <small><?= date('M j, Y', strtotime($recipe['created_at'])) ?></small>
                        </p>
                        <p class="card-text"><?= substr(sanitize($recipe['description']), 0, 100) ?>...</p>
                        <span class="badge bg-primary"><?= sanitize($recipe['category']) ?></span>
                    </div>
                    <div class="card-footer bg-transparent">
                        <a href="/recipe.php?id=<?= $recipe['id'] ?>" class="btn btn-primary btn-sm">
                            View Recipe <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
<?php endif; ?>

<?php require_once 'includes/footer.php'; ?>