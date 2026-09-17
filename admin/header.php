<?php require_once __DIR__ . '/../functions.php'; requireAdmin(); ?>
<!doctype html><html lang="en"><head><meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1">
<title><?=e($pageTitle??'Admin')?> | BookVerse</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"><link href="../assets/css/style.css" rel="stylesheet"></head>
<body class="admin-body">
<nav class="navbar navbar-dark bv-nav"><div class="container"><a class="navbar-brand fw-bold" href="dashboard.php">📚 BookVerse Admin</a><div><a class="btn btn-outline-light btn-sm me-2" href="../index.php">View Store</a><a class="btn btn-light btn-sm" href="logout.php">Logout</a></div></div></nav>
<div class="container-fluid"><div class="row"><aside class="col-md-3 col-lg-2 admin-side p-3">
<a href="dashboard.php">Dashboard</a><a href="users.php">Users</a><a href="categories.php">Categories</a><a href="products.php">Products</a><a href="orders.php">Orders</a><a href="messages.php">Messages</a>
</aside><section class="col-md-9 col-lg-10 p-4">
<?=flash()?>
