<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#14532d">
<title><?= e($title ?? 'Buku C Pertanahan') ?> · Buku C Sidamulya</title>
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/app.css">
</head>
<body>
<?php if (Auth::check()): ?>
<nav class="navbar navbar-expand navbar-dark" style="background:linear-gradient(135deg,#14532d,#1f6d3c)">
  <div class="container-fluid px-3">
    <span class="navbar-brand fw-bold">📘 Buku C Pertanahan</span>
    <span class="navbar-text small text-white-50 d-none d-sm-inline">Sidamulya · Wanasari · Brebes</span>
    <span class="navbar-text ms-auto me-2 small text-white-50 d-none d-sm-inline"><?= e(role_label(Auth::role())) ?></span>
    <a href="<?= BASE_URL ?>/logout" class="btn btn-light btn-sm text-success fw-semibold">Keluar</a>
  </div>
</nav>
<ul class="nav nav-tabs justify-content-center bg-white border-bottom px-2 sticky-top">
  <li class="nav-item"><a class="nav-link <?= $active==='dashboard'?'active':'' ?>" href="<?= BASE_URL ?>/">Beranda</a></li>
  <li class="nav-item"><a class="nav-link <?= $active==='tanah'?'active':'' ?>" href="<?= BASE_URL ?>/tanah">Buku C</a></li>
  <li class="nav-item"><a class="nav-link <?= $active==='statistik'?'active':'' ?>" href="<?= BASE_URL ?>/statistik">Rekap</a></li>
  <li class="nav-item"><a class="nav-link <?= $active==='peta'?'active':'' ?>" href="<?= BASE_URL ?>/peta">Peta</a></li>
  <?php if (in_array(Auth::role(), ['admin','operator'], true)): ?>
  <li class="nav-item"><a class="nav-link <?= $active==='mutasi'?'active':'' ?>" href="<?= BASE_URL ?>/mutasi">Mutasi</a></li>
  <?php endif; ?>
  <li class="nav-item"><a class="nav-link <?= $active==='alur'?'active':'' ?>" href="<?= BASE_URL ?>/alur">Alur</a></li>
  <?php if (Auth::role()==='admin'): ?>
  <li class="nav-item"><a class="nav-link <?= $active==='pengguna'?'active':'' ?>" href="<?= BASE_URL ?>/pengguna">Pengguna</a></li>
  <?php endif; ?>
</ul>
<?php endif; ?>

<div class="container py-3">
<?php if ($err = flash_get('error')): ?><div class="alert alert-danger py-2"><?= e($err) ?></div><?php endif; ?>
<?php if ($ok = flash_get('ok')): ?><div class="alert alert-success py-2"><?= e($ok) ?></div><?php endif; ?>
<?php require $view; ?>
</div>
<script src="<?= BASE_URL ?>/assets/app.js"></script>
</body>
</html>
