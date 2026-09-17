<?php
require_once '../functions.php';
if(isAdmin()) redirect('dashboard.php');
$error='';
if($_SERVER['REQUEST_METHOD']==='POST'){
  $s=$pdo->prepare("SELECT * FROM admins WHERE email=? AND status=1");$s->execute([trim($_POST['email']??'')]);$a=$s->fetch();
  if($a && password_verify($_POST['password']??'',$a['password'])){session_regenerate_id(true);$_SESSION['admin_id']=$a['id'];$_SESSION['admin_name']=$a['name'];redirect('dashboard.php');}
  $error='Invalid admin credentials.';
}
?><!doctype html><html><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><title>Admin Login | BookVerse</title><link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="../assets/css/style.css" rel="stylesheet"></head>
<body class="admin-login"><div class="form-card admin-login-card"><div class="text-center fs-1">📚</div><h2 class="text-center">BookVerse Admin</h2><?php if($error):?><div class="alert alert-danger"><?=e($error)?></div><?php endif;?><form method="post"><label class="form-label">Email</label><input class="form-control mb-3" name="email" type="email" required><label class="form-label">Password</label><input class="form-control mb-3" name="password" type="password" required><button class="btn btn-dark w-100">Admin Login</button></form><p class="small text-muted mt-3 mb-0">Demo: admin@bookverse.com / admin123</p></div></body></html>
