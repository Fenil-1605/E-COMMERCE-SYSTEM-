<?php
require_once 'functions.php'; requireLogin();
if($_SERVER['REQUEST_METHOD']==='POST'){
  $s=$pdo->prepare("UPDATE users SET name=?,mobile=?,address=?,city=?,state=?,pincode=? WHERE id=?");
  $s->execute([trim($_POST['name']),trim($_POST['mobile']),trim($_POST['address']),trim($_POST['city']),trim($_POST['state']),trim($_POST['pincode']),$_SESSION['user_id']]);
  $_SESSION['user_name']=trim($_POST['name']); $_SESSION['flash']=['type'=>'success','message'=>'Profile updated successfully.']; redirect('profile.php');
}
$s=$pdo->prepare("SELECT * FROM users WHERE id=?"); $s->execute([$_SESSION['user_id']]); $user=$s->fetch();
$pageTitle='My Profile'; require 'header.php';
?>
<h1>My Profile</h1>
<div class="row g-4 mt-1"><div class="col-lg-7"><div class="form-card"><form method="post" class="row g-3">
<div class="col-md-6"><label class="form-label">Name</label><input class="form-control" name="name" value="<?=e($user['name'])?>"></div>
<div class="col-md-6"><label class="form-label">Email</label><input class="form-control" value="<?=e($user['email'])?>" disabled></div>
<div class="col-md-6"><label class="form-label">Mobile</label><input class="form-control" name="mobile" value="<?=e($user['mobile'])?>"></div>
<div class="col-12"><label class="form-label">Address</label><textarea class="form-control" name="address"><?=e($user['address'])?></textarea></div>
<div class="col-md-4"><label class="form-label">City</label><input class="form-control" name="city" value="<?=e($user['city'])?>"></div>
<div class="col-md-4"><label class="form-label">State</label><input class="form-control" name="state" value="<?=e($user['state'])?>"></div>
<div class="col-md-4"><label class="form-label">Pincode</label><input class="form-control" name="pincode" value="<?=e($user['pincode'])?>"></div>
<div><button class="btn btn-dark">Update Profile</button></div>
</form></div></div>
<div class="col-lg-5"><div class="summary-box"><h4>Account</h4><a class="btn btn-outline-dark w-100 mb-2" href="orders.php">📦 My Orders</a><a class="btn btn-outline-dark w-100" href="cart.php">🛒 My Cart</a></div></div></div>
<?php require 'footer.php'; ?>
