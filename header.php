<?php require_once __DIR__ . '/functions.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?= e($pageTitle ?? SITE_NAME) ?> | BookVerse</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link href="assets/css/style.css" rel="stylesheet">
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-dark bv-nav sticky-top">
  <div class="container">
    <a class="navbar-brand fw-bold" href="index.php">📚 BookVerse</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="mainNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
        <li class="nav-item"><a class="nav-link" href="categories.php">Categories</a></li>
        <li class="nav-item"><a class="nav-link" href="products.php">Books</a></li>
        <li class="nav-item"><a class="nav-link" href="about.php">About</a></li>
        <li class="nav-item"><a class="nav-link" href="contact.php">Contact</a></li>
      </ul>
      <form class="d-flex me-3" action="products.php" method="get">
        <input class="form-control form-control-sm" name="search" placeholder="Search books..." value="<?= e($_GET['search'] ?? '') ?>">
      </form>
      <div class="d-flex align-items-center gap-2">
        <a class="btn btn-outline-light btn-sm" href="cart.php">🛒 Cart <span class="badge bg-light text-dark"><?= cartCount() ?></span></a>
        <?php if (isLoggedIn()): ?>
          <a class="btn btn-light btn-sm" href="profile.php">Hi, <?= e(explode(' ', $_SESSION['user_name'] ?? 'User')[0]) ?></a>
          <a class="btn btn-outline-light btn-sm" href="logout.php">Logout</a>
        <?php else: ?>
          <a class="btn btn-light btn-sm" href="login.php">Login</a>
        <?php endif; ?>
      </div>
    </div>
  </div>
</nav>
<main class="container py-4">
<?= flash() ?>
