<?php
$pageTitle = "Add New Recipe";
require_once 'includes/header.php';
?>

<div class="row justify-content-center">
    <div class="col-lg-8">
        <h1 class="mb-4">Add New Recipe</h1>
        
        <form action="/submit_recipe.php" method="POST" enctype="multipart/form-data">
            <div class="mb-3">
                <label for="title" class="form-label">Recipe Title *</label>
                <input type="text" class="form-control" id="title" name="title" required>
            </div>
            
            <div class="mb-3">
                <label for="category" class="form-label">Category *</label>
                <select class="form-select" id="category" name="category" required>
                    <option value="">Select a category</option>
                    <?php foreach (getCategories() as $cat): ?>
                        <option value="<?= $cat ?>"><?= $cat ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            
            <div class="mb-3">
                <label for="description" class="form-label">Description *</label>
                <textarea class="form-control" id="description" name="description" rows="3" required></textarea>
            </div>
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="ingredients" class="form-label">Ingredients * <small class="text-muted">(one per line)</small></label>
                    <textarea class="form-control font-monospace" id="ingredients" name="ingredients" rows="8" required></textarea>
                </div>
                <div class="col-md-6 mb-3">
                    <label for="steps" class="form-label">Steps * <small class="text-muted">(one per line)</small></label>
                    <textarea class="form-control font-monospace" id="steps" name="steps" rows="8" required></textarea>
                </div>
            </div>
            
            <div class="mb-4">
                <label for="image" class="form-label">Recipe Image</label>
                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                <div class="form-text">Max file size: 2MB. Allowed types: JPG, PNG, GIF.</div>
            </div>
            
            <div class="d-grid gap-2 d-md-flex justify-content-md-end">
                <a href="/index.php" class="btn btn-outline-secondary me-md-2">Cancel</a>
                <button type="submit" class="btn btn-primary">Submit Recipe</button>
            </div>
        </form>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
