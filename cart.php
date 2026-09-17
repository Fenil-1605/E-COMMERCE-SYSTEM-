<?php
require_once 'functions.php';
if (!isset($_SESSION['cart'])) $_SESSION['cart'] = [];
$action = $_POST['action'] ?? $_GET['action'] ?? '';
$id = (int)($_POST['id'] ?? $_GET['id'] ?? 0);

if ($action === 'add' && $id > 0) {
    $q=max(1,(int)($_POST['quantity'] ?? 1));
    $s=$pdo->prepare("SELECT stock_quantity,status FROM products WHERE id=?"); $s->execute([$id]); $p=$s->fetch();
    if($p && $p['status'] && $p['stock_quantity']>0) $_SESSION['cart'][$id]=min(($_SESSION['cart'][$id] ?? 0)+$q, (int)$p['stock_quantity']);
    $_SESSION['flash']=['type'=>'success','message'=>'Book added to your cart.'];
    redirect('cart.php');
}
if ($action === 'remove' && $id > 0) { unset($_SESSION['cart'][$id]); redirect('cart.php'); }
if ($action === 'update') {
    foreach (($_POST['qty'] ?? []) as $pid=>$qty) {
        $pid=(int)$pid; $qty=(int)$qty;
        $s=$pdo->prepare("SELECT stock_quantity FROM products WHERE id=?"); $s->execute([$pid]); $stock=(int)$s->fetchColumn();
        if($qty<=0) unset($_SESSION['cart'][$pid]); else $_SESSION['cart'][$pid]=min($qty,$stock);
    }
    $_SESSION['flash']=['type'=>'success','message'=>'Cart updated.'];
    redirect('cart.php');
}
$pageTitle='Shopping Cart';
$items=cartItems($pdo); $total=cartTotal($pdo);
require 'header.php';
?>
<h1 class="mb-4">Shopping Cart</h1>
<?php if(!$items): ?>
<div class="empty-state"><h3>Your cart is empty.</h3><p>Add some books to continue shopping.</p><a href="products.php" class="btn btn-dark">Browse Books</a></div>
<?php else: ?>
<form action="cart.php" method="post">
<input type="hidden" name="action" value="update">
<div class="table-responsive">
<table class="table align-middle">
<thead><tr><th>Book</th><th>Price</th><th style="width:140px">Quantity</th><th>Subtotal</th><th></th></tr></thead>
<tbody>
<?php foreach($items as $i): ?>
<tr>
<td><div class="d-flex align-items-center gap-3"><img class="cart-img" src="<?=e($i['image'])?>"><div><strong><?=e($i['name'])?></strong><div class="small text-muted"><?=e($i['category_name'])?></div></div></div></td>
<td>₹<?=number_format($i['final_price'],2)?></td>
<td><input class="form-control" type="number" min="1" max="<?=$i['stock_quantity']?>" name="qty[<?=$i['id']?>]" value="<?=$i['quantity']?>"></td>
<td><strong>₹<?=number_format($i['subtotal'],2)?></strong></td>
<td><a class="btn btn-sm btn-outline-danger" href="cart.php?action=remove&id=<?=$i['id']?>">Remove</a></td>
</tr>
<?php endforeach; ?>
</tbody>
</table>
</div>
<div class="d-flex justify-content-end"><button class="btn btn-outline-dark">Update Cart</button></div>
</form>
<div class="row justify-content-end mt-4"><div class="col-md-5"><div class="summary-box">
<h4>Cart Summary</h4><div class="d-flex justify-content-between"><span>Subtotal</span><strong>₹<?=number_format($total,2)?></strong></div><hr>
<div class="d-flex justify-content-between fs-5"><span>Total</span><strong>₹<?=number_format($total,2)?></strong></div>
<a href="checkout.php" class="btn btn-dark w-100 mt-3">Proceed to Checkout</a>
</div></div></div>
<?php endif; ?>
<?php require 'footer.php'; ?>
