<?php
if (!isset($_GET['id'])) {
    header("Location: /index.php");
    exit;
}

require_once 'includes/config.php';
require_once 'includes/header.php';

$recipeId = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->execute([$recipeId]);
$recipe = $stmt->fetch();

if (!$recipe) {
    header("Location: /index.php");
    exit;
}

$pageTitle = $recipe['title'];
require_once 'includes/header.php';

// Get comments
$commentStmt = $pdo->prepare("SELECT * FROM comments WHERE recipe_id = ? ORDER BY created_at DESC");
$commentStmt->execute([$recipeId]);
$comments = $commentStmt->fetchAll();
?>

<div class="row">
    <div class="col-lg-8">
        <nav aria-label="breadcrumb" class="mb-4">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="/index.php">Home</a></li>
                <li class="breadcrumb-item active" aria-current="page"><?= sanitize($recipe['title']) ?></li>
            </ol>
        </nav>
        
        <h1 class="mb-3"><?= sanitize($recipe['title']) ?></h1>
        
        <div class="d-flex justify-content-between align-items-center mb-3">
            <span class="badge bg-primary"><?= sanitize($recipe['category']) ?></span>
            <small class="text-muted">Posted on <?= date('F j, Y', strtotime($recipe['created_at'])) ?></small>
        </div>
        
        <?php if ($recipe['image_path']): ?>
            <img src="<?= $recipe['image_path'] ?>" class="img-fluid rounded mb-4 recipe-image" alt="<?= sanitize($recipe['title']) ?>">
        <?php endif; ?>
        
        <div class="mb-5">
            <h3 class="border-bottom pb-2">Description</h3>
            <p class="lead"><?= nl2br(sanitize($recipe['description'])) ?></p>
        </div>
        
        <div class="row mb-5">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="h5 mb-0">Ingredients</h3>
                    </div>
                    <div class="card-body">
                        <ul class="list-group list-group-flush">
                            <?php
                            $ingredients = explode("\n", $recipe['ingredients']);
                            foreach ($ingredients as $ingredient):
                                if (trim($ingredient)):
                            ?>
                                <li class="list-group-item"><?= sanitize(trim($ingredient)) ?></li>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header bg-primary text-white">
                        <h3 class="h5 mb-0">Steps</h3>
                    </div>
                    <div class="card-body">
                        <ol class="list-group list-group-flush list-group-numbered">
                            <?php
                            $steps = explode("\n", $recipe['steps']);
                            foreach ($steps as $step):
                                if (trim($step)):
                            ?>
                                <li class="list-group-item"><?= sanitize(trim($step)) ?></li>
                            <?php
                                endif;
                            endforeach;
                            ?>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="mb-5">
            <h2 class="border-bottom pb-2">Comments</h2>
            
            <?php if (empty($comments)): ?>
                <div class="alert alert-info">
                    No comments yet. Be the first to comment!
                </div>
            <?php else: ?>
                <?php foreach ($comments as $comment): ?>
                    <div class="card mb-3 comment-card">
                        <div class="card-body">
                            <div class="d-flex justify-content-between">
                                <h5 class="card-title mb-1"><?= sanitize($comment['username']) ?></h5>
                                <small class="text-muted"><?= date('M j, Y g:i a', strtotime($comment['created_at'])) ?></small>
                            </div>
                            <p class="card-text mt-2"><?= nl2br(sanitize($comment['comment'])) ?></p>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php endif; ?>
            
            <div class="card mt-4">
                <div class="card-header bg-light">
                    <h3 class="h5 mb-0">Add a Comment</h3>
                </div>
                <div class="card-body">
                    <form action="/submit_comment.php" method="POST">
                        <input type="hidden" name="recipe_id" value="<?= $recipeId ?>">
                        <div class="mb-3">
                            <label for="username" class="form-label">Your Name *</label>
                            <input type="text" class="form-control" id="username" name="username" required>
                        </div>
                        <div class="mb-3">
                            <label for="comment" class="form-label">Your Comment *</label>
                            <textarea class="form-control" id="comment" name="comment" rows="3" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Submit Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<?php require_once 'includes/footer.php'; ?>
