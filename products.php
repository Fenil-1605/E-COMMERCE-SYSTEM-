<?php
$pageTitle = 'Books';
require_once 'functions.php';
$search = trim($_GET['search'] ?? '');
$category = (int)($_GET['category'] ?? 0);

$sql = "SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON c.id=p.category_id WHERE p.status=1";
$params = [];
if ($search !== '') { $sql .= " AND (p.name LIKE ? OR p.description LIKE ?)"; $params[]="%$search%"; $params[]="%$search%"; }
if ($category > 0) { $sql .= " AND p.category_id=?"; $params[]=$category; }
$sql .= " ORDER BY p.created_at DESC";
$stmt = $pdo->prepare($sql); $stmt->execute($params); $products=$stmt->fetchAll();
$catName = '';
if ($category) {
  $s=$pdo->prepare("SELECT name FROM categories WHERE id=?"); $s->execute([$category]); $catName=$s->fetchColumn() ?: '';
}
require 'header.php';
?>
<div class="d-flex justify-content-between align-items-center mb-4">
  <div>
    <h1><?= $catName ? e($catName) : 'All Books' ?></h1>
    <?php if ($search): ?><p class="text-muted">Search results for “<?= e($search) ?>”</p><?php endif; ?>
  </div>
  <span class="text-muted"><?= count($products) ?> book(s)</span>
</div>
<div class="row g-4">
<?php if (!$products): ?>
  <div class="col-12"><div class="empty-state">No books found. Try another search.</div></div>
<?php endif; ?>
<?php foreach ($products as $p): ?>
  <div class="col-sm-6 col-lg-3">
    <div class="product-card h-100">
      <img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>">
      <div class="p-3">
        <small class="text-muted"><?= e($p['category_name']) ?></small>
        <h5><?= e($p['name']) ?></h5>
        <p class="small text-muted"><?= e(mb_strimwidth($p['description'],0,80,'...')) ?></p>
        <div class="price">₹<?= number_format(productPrice($p),2) ?> <?php if($p['discount']>0): ?><del>₹<?= number_format($p['price'],2) ?></del><?php endif; ?></div>
        <div class="d-grid gap-2 mt-3">
          <a href="product.php?id=<?= $p['id'] ?>" class="btn btn-dark">View Details</a>
          <?php if ($p['stock_quantity'] > 0): ?>
            <a href="cart.php?action=add&id=<?= $p['id'] ?>" class="btn btn-outline-dark">Add to Cart</a>
          <?php else: ?><button class="btn btn-secondary" disabled>Out of Stock</button><?php endif; ?>
        </div>
      </div>
    </div>
  </div>
<?php endforeach; ?>
</div>
<?php require 'footer.php'; ?>
