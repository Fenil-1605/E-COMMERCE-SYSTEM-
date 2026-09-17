<?php
require_once '../functions.php'; requireAdmin(); $pageTitle='Dashboard';
$users=(int)$pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();$cats=(int)$pdo->query("SELECT COUNT(*) FROM categories")->fetchColumn();$products=(int)$pdo->query("SELECT COUNT(*) FROM products")->fetchColumn();$orders=(int)$pdo->query("SELECT COUNT(*) FROM orders")->fetchColumn();$sales=(float)$pdo->query("SELECT COALESCE(SUM(total_amount),0) FROM orders WHERE order_status<>'Cancelled'")->fetchColumn();
require 'header.php';
?>
<h1>Dashboard</h1><p class="text-muted">Welcome, <?=e($_SESSION['admin_name'])?>.</p>
<div class="row g-4">
<?php foreach([['Users',$users,'users.php'],['Categories',$cats,'categories.php'],['Products',$products,'products.php'],['Orders',$orders,'orders.php'],['Sales / Revenue','₹'.number_format($sales,2),'orders.php']] as $x):?>
<div class="col-sm-6 col-xl-3"><a class="stat-card" href="<?=$x[2]?>"><span><?=$x[0]?></span><strong><?=$x[1]?></strong></a></div>
<?php endforeach;?>
</div>
<div class="form-card mt-4"><h4>Quick Actions</h4><a class="btn btn-dark me-2" href="products.php?action=add">+ Add Product</a><a class="btn btn-outline-dark" href="categories.php?action=add">+ Add Category</a></div>
<?php require 'footer.php'; ?>
