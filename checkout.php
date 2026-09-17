<?php
require_once 'functions.php';
requireLogin();
$items=cartItems($pdo); $total=cartTotal($pdo);
if(!$items){ redirect('cart.php'); }
$s=$pdo->prepare("SELECT * FROM users WHERE id=?"); $s->execute([$_SESSION['user_id']]); $user=$s->fetch();
if($_SERVER['REQUEST_METHOD']==='POST'){
    $required=['name','email','mobile','billing_address','shipping_address','city','state','pincode'];
    $errors=[];
    foreach($required as $f) if(trim($_POST[$f]??'')==='') $errors[]='Please fill all required fields.';
    if(!filter_var($_POST['email']??'',FILTER_VALIDATE_EMAIL)) $errors[]='Please enter a valid email.';
    if(!$errors){
        try{
            $pdo->beginTransaction();
            foreach($items as $i){
                $s=$pdo->prepare("SELECT stock_quantity,status FROM products WHERE id=? FOR UPDATE"); $s->execute([$i['id']]); $fresh=$s->fetch();
                if(!$fresh || !$fresh['status'] || $fresh['stock_quantity']<$i['quantity']) throw new Exception('Insufficient stock for '.$i['name']);
            }
            $s=$pdo->prepare("INSERT INTO orders(user_id,customer_name,email,mobile,billing_address,shipping_address,city,state,pincode,total_amount,payment_method) VALUES(?,?,?,?,?,?,?,?,?,?,?)");
            $s->execute([$_SESSION['user_id'],$_POST['name'],$_POST['email'],$_POST['mobile'],$_POST['billing_address'],$_POST['shipping_address'],$_POST['city'],$_POST['state'],$_POST['pincode'],$total,'Cash on Delivery']);
            $oid=$pdo->lastInsertId();
            foreach($items as $i){
                $s=$pdo->prepare("INSERT INTO order_items(order_id,product_id,product_name,price,quantity,subtotal) VALUES(?,?,?,?,?,?)");
                $s->execute([$oid,$i['id'],$i['name'],$i['final_price'],$i['quantity'],$i['subtotal']]);
                $s=$pdo->prepare("UPDATE products SET stock_quantity=stock_quantity-? WHERE id=?"); $s->execute([$i['quantity'],$i['id']]);
            }
            $pdo->commit(); $_SESSION['cart']=[]; redirect('payment.php?order='.$oid);
        }catch(Exception $e){ if($pdo->inTransaction())$pdo->rollBack(); $errors[]=$e->getMessage(); }
    }
}
require 'header.php';
?>
<h1 class="mb-4">Checkout</h1>
<?php if(!empty($errors)): ?><div class="alert alert-danger"><?=e(implode(' ',$errors))?></div><?php endif; ?>
<form method="post" class="row g-4">
<div class="col-lg-7"><div class="form-card">
<h4>Customer & Delivery Details</h4>
<div class="row g-3">
<div class="col-md-6"><label class="form-label">Customer Name *</label><input class="form-control" name="name" value="<?=e($_POST['name']??$user['name'])?>"></div>
<div class="col-md-6"><label class="form-label">Email *</label><input class="form-control" type="email" name="email" value="<?=e($_POST['email']??$user['email'])?>"></div>
<div class="col-md-6"><label class="form-label">Mobile Number *</label><input class="form-control" name="mobile" value="<?=e($_POST['mobile']??$user['mobile'])?>"></div>
<div class="col-12"><label class="form-label">Billing Address *</label><textarea class="form-control" name="billing_address" rows="2"><?=e($_POST['billing_address']??$user['address'])?></textarea></div>
<div class="col-12"><label class="form-label">Shipping Address *</label><textarea class="form-control" name="shipping_address" rows="2"><?=e($_POST['shipping_address']??$user['address'])?></textarea></div>
<div class="col-md-4"><label class="form-label">City *</label><input class="form-control" name="city" value="<?=e($_POST['city']??$user['city'])?>"></div>
<div class="col-md-4"><label class="form-label">State *</label><input class="form-control" name="state" value="<?=e($_POST['state']??$user['state'])?>"></div>
<div class="col-md-4"><label class="form-label">Pincode *</label><input class="form-control" name="pincode" value="<?=e($_POST['pincode']??$user['pincode'])?>"></div>
</div></div></div>
<div class="col-lg-5"><div class="summary-box"><h4>Order Summary</h4>
<?php foreach($items as $i): ?><div class="d-flex justify-content-between py-2"><span><?=e($i['name'])?> × <?=$i['quantity']?></span><strong>₹<?=number_format($i['subtotal'],2)?></strong></div><?php endforeach; ?>
<hr><div class="d-flex justify-content-between fs-5"><span>Total Amount</span><strong>₹<?=number_format($total,2)?></strong></div>
<div class="mt-3 p-3 border rounded"><strong>Payment Method</strong><br>💵 Cash on Delivery</div>
<button class="btn btn-dark w-100 mt-3">Place Order</button>
</div></div>
</form>
<?php require 'footer.php'; ?>
