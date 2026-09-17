<?php
$pageTitle = 'Categories';
require_once 'functions.php';
$categories = $pdo->query("SELECT * FROM categories WHERE status=1 ORDER BY name")->fetchAll();
require 'header.php';
?>
<h1 class="mb-2">Book Categories</h1>
<p class="text-muted mb-4">Choose a category to explore available books.</p>
<div class="row g-4">
<?php foreach ($categories as $c): ?>
  <div class="col-md-6 col-lg-4">
    <div class="category-large h-100">
      <img src="<?= e($c['image']) ?>" alt="<?= e($c['name']) ?>">
      <div class="p-4">
        <h3><?= e($c['name']) ?></h3>
        <p><?= e($c['description']) ?></p>
        <a href="products.php?category=<?= $c['id'] ?>" class="btn btn-dark">View Books</a>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php require 'footer.php'; ?>
