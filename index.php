<?php
$pageTitle = 'Home';
require_once 'functions.php';
$categories = $pdo->query("SELECT * FROM categories WHERE status=1 ORDER BY id LIMIT 6")->fetchAll();
$products = $pdo->query("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON c.id=p.category_id WHERE p.status=1 ORDER BY p.id DESC LIMIT 8")->fetchAll();
require 'header.php';
?>
<section class="hero rounded-4 p-5 mb-5">
  <div class="row align-items-center">
    <div class="col-lg-7">
      <span class="badge bg-light text-dark mb-3">WELCOME TO BOOKVERSE</span>
      <h1 class="display-4 fw-bold">Find your next great read.</h1>
      <p class="lead">Explore fiction, technology, science, self-help and academic books at simple student-friendly prices.</p>
      <a href="products.php" class="btn btn-light btn-lg">Explore Books</a>
      <a href="categories.php" class="btn btn-outline-light btn-lg ms-2">Browse Categories</a>
    </div>
    <div class="col-lg-5 text-center hero-book">📖</div>
  </div>
</section>

<section class="mb-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>Featured Categories</h2><a href="categories.php">View all →</a>
  </div>
  <div class="row g-4">
  <?php foreach ($categories as $c): ?>
    <div class="col-6 col-md-4 col-lg-2">
      <a class="text-decoration-none" href="products.php?category=<?= $c['id'] ?>">
        <div class="category-card h-100">
          <img src="<?= e($c['image']) ?>" alt="<?= e($c['name']) ?>">
          <h6><?= e($c['name']) ?></h6>
        </div>
      </a>
    </div>
  <?php endforeach; ?>
  </div>
</section>

<section class="mb-5">
  <div class="d-flex justify-content-between align-items-center mb-3">
    <h2>New & Latest Books</h2><a href="products.php">View all →</a>
  </div>
  <div class="row g-4">
  <?php foreach ($products as $p): ?>
    <div class="col-sm-6 col-lg-3">
      <div class="product-card h-100">
        <img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>">
        <div class="p-3">
          <small class="text-muted"><?= e($p['category_name']) ?></small>
          <h5><?= e($p['name']) ?></h5>
          <div class="price">₹<?= number_format(productPrice($p), 2) ?>
            <?php if ($p['discount'] > 0): ?><del>₹<?= number_format($p['price'],2) ?></del><?php endif; ?>
          </div>
          <a class="btn btn-dark w-100 mt-3" href="product.php?id=<?= $p['id'] ?>">View Details</a>
        </div>
      </div>
    </div>
  <?php endforeach; ?>
  </div>
</section>

<section class="offer rounded-4 p-4 mb-4">
  <div class="row align-items-center">
    <div class="col-md-8"><h3>📚 Student Reading Week</h3><p class="mb-0">Selected books include automatic discounts. Cash on Delivery is available at checkout.</p></div>
    <div class="col-md-4 text-md-end mt-3 mt-md-0"><a href="products.php" class="btn btn-dark">Shop Offers</a></div>
  </div>
</section>
<?php require 'footer.php'; ?>
