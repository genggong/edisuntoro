<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover">
<meta name="theme-color" content="#14532d">
<title><?= e($title ?? 'Buku C Pertanahan') ?> · Buku C Sidamulya</title>
<link rel="stylesheet" href="<?= BASE_URL ?>/assets/app.css">
</head>
<body>
<?php if (Auth::check()): ?>
<header class="topbar">
    <div class="brand">
        <strong>Buku C Pertanahan</strong>
        <span class="chip">Sidamulya · Wanasari · Brebes</span>
    </div>
    <a class="logout" href="<?= BASE_URL ?>/logout"><?= e(role_label(Auth::role())) ?> · Keluar</a>
</header>
<nav class="tabs">
    <a href="<?= BASE_URL ?>/" class="tab <?= $active === 'dashboard' ? 'on' : '' ?>">Beranda</a>
    <a href="<?= BASE_URL ?>/tanah" class="tab <?= $active === 'tanah' ? 'on' : '' ?>">Buku C</a>
    <a href="<?= BASE_URL ?>/statistik" class="tab <?= $active === 'statistik' ? 'on' : '' ?>">Rekap</a>
    <a href="<?= BASE_URL ?>/peta" class="tab <?= $active === 'peta' ? 'on' : '' ?>">Peta</a>
    <?php if (Auth::role() === 'admin'): ?>
    <a href="<?= BASE_URL ?>/pengguna" class="tab <?= $active === 'pengguna' ? 'on' : '' ?>">Pengguna</a>
    <?php endif; ?>
</nav>
<?php endif; ?>

<main class="content">
<?php if ($err = flash_get('error')): ?><div class="flash err"><?= e($err) ?></div><?php endif; ?>
<?php if ($ok = flash_get('ok')): ?><div class="flash ok"><?= e($ok) ?></div><?php endif; ?>
<?php require $view; ?>
</main>
<script src="<?= BASE_URL ?>/assets/app.js"></script>
</body>
</html>
