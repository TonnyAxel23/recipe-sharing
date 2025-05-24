    </div> <!-- Close container div -->

    <footer class="bg-dark text-white py-4 mt-5">
        <div class="container">
            <div class="row">
                <div class="col-md-6">
                    <h5><i class="bi bi-journal-bookmark-fill"></i> RecipeShare</h5>
                    <p>Share your favorite recipes with the world!</p>
                </div>
                <div class="col-md-3">
                    <h5>Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="/index.php" class="text-white">Home</a></li>
                        <li><a href="/add_recipe.php" class="text-white">Add Recipe</a></li>
                    </ul>
                </div>
                <div class="col-md-3">
                    <h5>Contact</h5>
                    <ul class="list-unstyled">
                        <li><i class="bi bi-envelope"></i> info@recipeshare.com</li>
                    </ul>
                </div>
            </div>
            <hr>
            <div class="text-center">
                <p class="mb-0">&copy; <?php echo date('Y'); ?> Recipe Sharing Platform. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Enable Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        });

        // Image preview for recipe form
        document.getElementById('image').addEventListener('change', function(e) {
            const preview = document.getElementById('imagePreview');
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    if (!preview) {
                        const img = document.createElement('img');
                        img.id = 'imagePreview';
                        img.src = e.target.result;
                        img.alt = 'Preview';
                        img.className = 'img-thumbnail mt-2';
                        img.style.maxHeight = '200px';
                        document.querySelector('form').insertBefore(img, document.querySelector('button'));
                    } else {
                        preview.src = e.target.result;
                    }
                }
                reader.readAsDataURL(this.files[0]);
            } else if (preview) {
                preview.remove();
            }
        });
    </script>
</body>
</html>