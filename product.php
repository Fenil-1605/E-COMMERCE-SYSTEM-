<?php
require_once 'functions.php';
$id=(int)($_GET['id'] ?? 0);
$stmt=$pdo->prepare("SELECT p.*, c.name AS category_name FROM products p JOIN categories c ON c.id=p.category_id WHERE p.id=? AND p.status=1");
$stmt->execute([$id]); $p=$stmt->fetch();
if(!$p){ http_response_code(404); die('Product not found.'); }
$pageTitle=$p['name'];
require 'header.php';
?>
<div class="row g-5">
  <div class="col-md-5"><div class="detail-image"><img src="<?= e($p['image']) ?>" alt="<?= e($p['name']) ?>"></div></div>
  <div class="col-md-7">
    <span class="badge bg-secondary"><?= e($p['category_name']) ?></span>
    <h1 class="mt-2"><?= e($p['name']) ?></h1>
    <div class="price big">₹<?= number_format(productPrice($p),2) ?>
      <?php if($p['discount']>0): ?><del>₹<?= number_format($p['price'],2) ?></del><span class="discount">Save ₹<?= number_format($p['discount'],2) ?></span><?php endif; ?>
    </div>
    <p class="lead mt-4"><?= e($p['description']) ?></p>
    <div class="info-box mb-4"><strong>Available Stock:</strong> <?= (int)$p['stock_quantity'] ?></div>
    <h5>Specifications</h5><p><?= nl2br(e($p['specifications'])) ?></p>
    <?php if($p['stock_quantity']>0): ?>
    <form action="cart.php" method="post" class="row g-2 align-items-end">
      <input type="hidden" name="action" value="add">
      <input type="hidden" name="id" value="<?= $p['id'] ?>">
      <div class="col-auto"><label class="form-label">Quantity</label><input class="form-control" type="number" name="quantity" value="1" min="1" max="<?= $p['stock_quantity'] ?>"></div>
      <div class="col-auto"><button class="btn btn-dark btn-lg">Add to Cart</button></div>
    </form>
    <?php else: ?><button class="btn btn-secondary btn-lg" disabled>Out of Stock</button><?php endif; ?>
  </div>
</div>
<?php require 'footer.php'; ?>
